/**
 * Penangkap screenshot otomatis untuk docs/MANUAL.md
 *
 * Menjalankan aplikasi di peramban Chromium, menelusuri seluruh layar,
 * lalu menyimpan gambarnya ke docs/images/.
 *
 * Prasyarat: aplikasi hidup di BASE_URL dengan database berisi data seeder.
 * Lihat tools/README.md untuk langkah lengkapnya.
 *
 *   node tools/capture-screenshots.mjs
 */

import { chromium } from 'playwright';
import { mkdir, readdir } from 'node:fs/promises';
import { existsSync } from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const ROOT = path.resolve(path.dirname(fileURLToPath(import.meta.url)), '..');
const OUT_DIR = path.join(ROOT, 'docs', 'images');

const BASE_URL = process.env.BASE_URL ?? 'http://127.0.0.1:8000';

/**
 * Chromium bawaan Playwright tidak selalu tersedia (mis. di kontainer yang
 * sudah menyediakan peramban sendiri). Setel CHROMIUM_PATH bila perlu.
 */
const CHROMIUM_PATH = process.env.CHROMIUM_PATH ?? null;

const VIEWPORT = { width: 1440, height: 900 };

let captured = 0;

/* ------------------------------------------------------------------ util */

/** Simpan tangkapan seluruh halaman. */
async function shot(page, name) {
    await page.screenshot({ path: path.join(OUT_DIR, `${name}.png`), fullPage: true });
    captured++;
    console.log(`  ✓ ${name}.png`);
}

/**
 * Simpan tangkapan satu elemen saja.
 *
 * Memotret elemen membuat Playwright menggulirkannya ke tampilan, dan
 * ApexCharts menanggapi perubahan itu dengan menggambar ulang grafik dari
 * kosong. Tanpa jeda setelah menggulir, grafik terpotret separuh jadi.
 */
async function shotOf(page, selector, name, nth = 0) {
    const el = page.locator(selector).nth(nth);
    await el.waitFor({ state: 'visible', timeout: 15000 });

    // Ukur posisi elemen relatif terhadap seluruh dokumen, lalu potong dari
    // tangkapan halaman penuh. Memotret elemen secara langsung membuatnya
    // digulir ke tampilan, dan ApexCharts menggambar ulang saat itu sehingga
    // sebagian grafik (khususnya diagram lingkaran) hilang dari hasil.
    const box = await el.evaluate((node) => {
        const r = node.getBoundingClientRect();
        return {
            x: r.left + window.scrollX,
            y: r.top + window.scrollY,
            width: r.width,
            height: r.height,
        };
    });
    if (!box.width || !box.height) throw new Error(`Elemen "${selector}" tidak punya ukuran`);

    await page.screenshot({ path: path.join(OUT_DIR, `${name}.png`), fullPage: true, clip: box });
    captured++;
    console.log(`  ✓ ${name}.png`);
}

/** Buka halaman dan tunggu sampai tenang. */
async function open(page, urlPath) {
    const res = await page.goto(`${BASE_URL}${urlPath}`, { waitUntil: 'networkidle', timeout: 60000 });
    if (!res || res.status() >= 400) {
        throw new Error(`Gagal membuka ${urlPath} — HTTP ${res ? res.status() : 'tanpa respons'}`);
    }
    // Laravel menampilkan halaman galat Ignition dengan struktur khas ini.
    if (await page.locator('.exception, .ignition').count()) {
        throw new Error(`Halaman ${urlPath} menampilkan galat aplikasi`);
    }
    await page.waitForTimeout(400);
}

/**
 * Memilih nilai pada select2. Select2 menyembunyikan <select> aslinya,
 * sehingga selectOption() biasa tidak berpengaruh pada tampilan.
 */
async function pickSelect2(page, selectId, optionIndex = 1) {
    await page.locator(`#${selectId}`).evaluate((el, idx) => {
        const opt = el.options[idx];
        if (!opt) throw new Error(`Opsi ke-${idx} tidak ada pada #${el.id}`);
        el.value = opt.value;
        // jQuery diperlukan agar select2 dan handler halaman ikut bereaksi
        window.jQuery(el).trigger('change');
    }, optionIndex);
    await page.waitForTimeout(700);
}

/**
 * Ambil ID sumber daya pertama dari tabel daftar.
 *
 * Halaman daftar juga memuat tautan tanpa ID numerik (tombol "Add" menuju
 * /<sumber>/create, tautan breadcrumb), jadi seluruh tautan dikumpulkan lalu
 * disaring — mengambil yang pertama saja akan salah sasaran.
 */
async function firstIdFrom(page, listPath, hrefPrefix) {
    await open(page, listPath);
    const hrefs = await page.locator(`a[href*="${hrefPrefix}/"]`).evaluateAll((els) =>
        els.map((e) => e.getAttribute('href')),
    );
    const re = new RegExp(`${hrefPrefix}/(\\d+)`);
    const id = hrefs.map((h) => h?.match(re)?.[1]).find(Boolean);
    if (!id) throw new Error(`Tidak menemukan ID pada ${listPath} (prefix "${hrefPrefix}")`);
    return id;
}

/**
 * Kumpulkan seluruh ID servis dari halaman daftar.
 *
 * DataTables hanya menyimpan baris halaman aktif di DOM (10 baris), sehingga
 * paginasi dimatikan sementara lebih dulu agar seluruh ID terbaca.
 */
async function allRepairIds(page) {
    await open(page, '/repair');
    await page.evaluate(() => {
        const t = window.jQuery?.fn?.DataTable?.isDataTable('#table')
            ? window.jQuery('#table').DataTable()
            : null;
        if (t) t.page.len(-1).draw();
    });
    await page.waitForTimeout(800);

    const hrefs = await page.locator('a[href*="repair/"]').evaluateAll((els) =>
        els.map((e) => e.getAttribute('href')),
    );
    const ids = [...new Set(hrefs.map((h) => h?.match(/repair\/(\d+)/)?.[1]).filter(Boolean))];
    if (!ids.length) throw new Error('Tidak menemukan satu pun ID servis pada /repair');
    return ids;
}

/**
 * Cari satu servis yang sudah punya pembayaran dan satu yang belum.
 *
 * Penandanya diambil dari repairs/show.blade.php: tombol "Payment" hanya
 * dirender ketika servis belum memiliki pembayaran. Pemindaian dilakukan dari
 * kedua ujung daftar karena data seeder cenderung mengelompokkan keduanya.
 */
async function findRepairSamples(page, ids, maxVisits = 24) {
    const order = [];
    for (let i = 0; i < ids.length && order.length < maxVisits; i++) {
        order.push(ids[i]);
        const tail = ids[ids.length - 1 - i];
        if (tail && tail !== ids[i]) order.push(tail);
    }

    let withPayment = null;
    let withoutPayment = null;

    for (const id of order) {
        if (withPayment && withoutPayment) break;
        await open(page, `/repair/${id}`);
        const canPay = await page.locator('a[href*="payment/create"]').count();
        if (canPay && !withoutPayment) withoutPayment = id;
        if (!canPay && !withPayment) withPayment = id;
    }

    if (!withPayment && !withoutPayment) {
        throw new Error('Tidak menemukan contoh servis untuk bab pembayaran');
    }
    return { withPayment, withoutPayment };
}

/* ------------------------------------------------------------------ main */

async function main() {
    await mkdir(OUT_DIR, { recursive: true });

    if (CHROMIUM_PATH && !existsSync(CHROMIUM_PATH)) {
        throw new Error(`CHROMIUM_PATH menunjuk berkas yang tidak ada: ${CHROMIUM_PATH}`);
    }

    const browser = await chromium.launch({
        ...(CHROMIUM_PATH ? { executablePath: CHROMIUM_PATH } : {}),
        args: ['--no-sandbox', '--disable-dev-shm-usage'],
    });

    const ctx = await browser.newContext({
        viewport: VIEWPORT,
        deviceScaleFactor: 2,
        colorScheme: 'light',
        locale: 'id-ID',
    });

    // Tema Metronic membaca pilihan mode dari localStorage, bukan media query,
    // sehingga colorScheme saja tidak cukup untuk mengunci mode terang.
    await ctx.addInitScript(() => {
        try {
            localStorage.setItem('kt_theme_mode_value', 'light');
            localStorage.setItem('kt_theme_mode_menu', 'light');
        } catch { /* localStorage bisa diblokir; abaikan */ }
    });

    // Halaman memuat jQuery, DataTables, dan font dari CDN. Keduanya juga
    // tersedia di bundel lokal tema, sehingga permintaan CDN dipenuhi dengan
    // respons kosong agar screenshot tidak mengandung sumber daya gagal —
    // berguna pada jaringan terbatas atau lingkungan tanpa akses keluar.
    await ctx.route('**://code.jquery.com/**', (r) =>
        r.fulfill({ status: 200, contentType: 'application/javascript', body: '' }));
    await ctx.route('**://cdn.datatables.net/**', (r) =>
        r.fulfill({
            status: 200,
            contentType: r.request().url().endsWith('.css') ? 'text/css' : 'application/javascript',
            body: '',
        }));
    await ctx.route('**://fonts.bunny.net/**', (r) =>
        r.fulfill({ status: 200, contentType: 'text/css', body: '' }));

    const page = await ctx.newPage();
    page.setDefaultTimeout(30000);

    // Jaring pengaman: galat JavaScript apa pun menggagalkan penangkapan.
    // Tanpa ini, halaman yang rusak akan menghasilkan screenshot kosong yang
    // lolos begitu saja — persis cara bug grafik dashboard dulu tak terdeteksi.
    const pageErrors = [];
    page.on('pageerror', (err) => pageErrors.push(err.message));

    console.log(`\nMenangkap layar dari ${BASE_URL}\n`);

    /* -------------------------------------------------- 1. Dashboard */
    console.log('Dashboard');

    /** Muat dashboard dan tunggu keenam grafik selesai digambar. */
    async function openDashboard(p) {
        await open(p, '/');
        // ApexCharts menggambar setelah AJAX selesai; tanpa menunggu ini
        // dashboard akan terpotret dalam keadaan kosong.
        for (const sel of ['#pie_chart', '#bar_chart', '#revenue_chart',
                           '#area_chart', '#mechanic_chart', '#average_chart']) {
            await p.waitForSelector(`${sel} .apexcharts-canvas`, { timeout: 30000 });
        }
        await p.waitForTimeout(1500); // beri jeda animasi ApexCharts
    }

    await openDashboard(page);

    await shot(page, '01-dashboard');

    // Mengambil tangkapan halaman penuh mengubah tinggi viewport, dan
    // ApexCharts menggambar ulang saat itu — diagram lingkaran ikut menciut
    // dan tidak pulih. Karena itu dashboard dimuat ulang sebelum tiap
    // potongan, agar setiap grafik dipotret dalam keadaan baru dirender.
    const dashboardRows = [
        ['02-dashboard-kartu-status', 0],
        ['03-dashboard-grafik-servis', 1],
        ['04-dashboard-grafik-pendapatan', 2],
        ['05-dashboard-mekanik-waktu', 3],
        ['06-dashboard-tabel-stok', 4],
    ];
    for (const [name, idx] of dashboardRows) {
        await openDashboard(page);
        await shotOf(page, '#kt_content .container > .row', name, idx);
    }

    await openDashboard(page);
    await shotOf(page, '#kt_app_sidebar', '07-sidebar-menu');

    /* -------------------------------------------------- 2. Pelanggan */
    console.log('Pelanggan');
    await open(page, '/customer');
    await shot(page, '08-pelanggan-daftar');

    await open(page, '/customer/create');
    await page.fill('input[name="name"]', 'Budi Santoso');
    await page.fill('input[name="email"]', 'budi.santoso@contoh.id');
    await page.fill('input[name="phone_number"]', '081234567890');
    await shot(page, '09-pelanggan-tambah');

    const customerId = await firstIdFrom(page, '/customer', 'customer');
    await open(page, `/customer/${customerId}`);
    await shot(page, '10-pelanggan-detail');

    /* -------------------------------------------------- 3. Kendaraan */
    console.log('Kendaraan');
    await open(page, `/vehicle/create?customer_id=${customerId}`);
    await page.fill('input[name="model"]', 'Toyota Avanza 2021');
    await page.fill('input[name="color"]', 'Silver');
    await page.fill('input[name="plat_number"]', 'N 1234 AB');
    await shot(page, '11-kendaraan-tambah');

    const vehicleId = await firstIdFrom(page, `/customer/${customerId}`, 'vehicle');
    await open(page, `/vehicle/${vehicleId}`);
    await shot(page, '12-kendaraan-detail');

    /* -------------------------------------------------- 4. Mekanik */
    console.log('Mekanik');
    await open(page, '/mechanic');
    await shot(page, '13-mekanik-daftar');

    await open(page, '/mechanic/create');
    await page.fill('input[name="name"]', 'Agus Prasetyo');
    await page.fill('input[name="email"]', 'agus.prasetyo@contoh.id');
    await page.fill('textarea[name="expertise"], input[name="expertise"]', 'Mesin dan kelistrikan mobil');
    await shot(page, '14-mekanik-tambah');

    const mechanicId = await firstIdFrom(page, '/mechanic', 'mechanic');
    await open(page, `/mechanic/${mechanicId}`);
    await shot(page, '15-mekanik-detail');

    /* -------------------------------------------------- 5. Sparepart */
    console.log('Sparepart');
    await open(page, '/part');
    await shot(page, '16-sparepart-daftar');

    await open(page, '/part/create');
    await page.fill('input[name="name"]', 'Kampas Rem Depan');
    await page.fill('input[name="stock"]', '25');
    await page.fill('input[name="price"]', '175000');
    await shot(page, '17-sparepart-tambah');

    const partId = await firstIdFrom(page, '/part', 'part');
    await open(page, `/part/${partId}`);
    await shot(page, '18-sparepart-detail');

    /* -------------------------------------------------- 6. Servis */
    console.log('Servis');
    await open(page, '/repair');
    await shot(page, '19-servis-daftar');

    await open(page, '/repair?car_progress=1');
    await shot(page, '20-servis-daftar-tersaring');

    await open(page, '/repair/create');
    await pickSelect2(page, 'customer_id', 1);
    await pickSelect2(page, 'mechanic_id', 1);
    await page.fill('input[name="repair_date"]', '2026-09-07');
    await page.fill('textarea[name="issue"]', 'Rem berdecit dan pedal terasa dalam saat diinjak.');
    await shot(page, '21-servis-tambah');

    const repairIds = await allRepairIds(page);
    const { withPayment, withoutPayment } = await findRepairSamples(page, repairIds);

    // Layar detail polos memakai servis yang belum ditagih, sehingga tombol
    // "Payment" ikut terlihat. Servis yang sudah ditagih dipotret terpisah
    // pada bab pembayaran — dua layar ini harus berbeda.
    await open(page, `/repair/${withoutPayment ?? repairIds[0]}`);
    await shot(page, '22-servis-detail');

    /* -------------------------------------------------- 7. Pembayaran */
    console.log('Pembayaran');

    if (!withoutPayment) throw new Error('Semua servis sudah punya pembayaran — formulir tidak bisa dipotret');
    await open(page, `/payment/create?repair_id=${withoutPayment}`);
    await page.fill('#payment_date', '2026-09-07');
    await page.fill('#service_amount', '250000');
    // Rincian sparepart memakai formrepeater; baris pertama sudah tersedia.
    await pickSelect2(page, 'part_id', 1).catch(() => {});
    await page.fill('input[name="note"]', 'Penggantian kampas rem depan').catch(() => {});
    await shot(page, '23-pembayaran-formulir');

    if (!withPayment) throw new Error('Tidak ada servis dengan pembayaran untuk dipotret');
    await open(page, `/repair/${withPayment}`);
    await shot(page, '24-pembayaran-pada-detail-servis');

    await browser.close();

    if (pageErrors.length) {
        const unik = [...new Set(pageErrors)];
        throw new Error(
            `Terjadi ${pageErrors.length} galat JavaScript di halaman:\n  - ${unik.join('\n  - ')}\n` +
            'Perbaiki dulu galatnya; screenshot dari halaman yang bermasalah tidak dapat dipercaya.',
        );
    }

    const files = (await readdir(OUT_DIR)).filter((f) => f.endsWith('.png'));
    console.log(`\nSelesai — ${captured} tangkapan disimpan ke docs/images/ (total ${files.length} berkas PNG)\n`);
}

main().catch((err) => {
    console.error(`\n✖ Penangkapan gagal: ${err.message}\n`);
    process.exit(1);
});
