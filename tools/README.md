# 🛠️ Tools

Perkakas pendukung dokumentasi.

---

## 📸 `capture-screenshots.mjs`

Menangkap seluruh screenshot untuk [`docs/MANUAL.md`](../docs/MANUAL.md) secara otomatis: membuka aplikasi di Chromium, menelusuri ±24 layar, lalu menyimpan gambarnya ke `docs/images/`.

### Prasyarat

1. **Dependensi terpasang**

   ```bash
   composer install
   npm install
   ```

2. **Aset frontend sudah dibangun** — layout memakai `@vite`, sehingga tanpa langkah ini tampilan akan rusak

   ```bash
   npm run build
   ```

3. **Database terisi data contoh**

   ```bash
   php artisan migrate --seed
   ```

4. **Aplikasi berjalan** di `http://127.0.0.1:8000`

   ```bash
   php artisan serve
   ```

### Menjalankan

```bash
npm run capture:docs
```

atau langsung:

```bash
node tools/capture-screenshots.mjs
```

### Variabel Lingkungan

| Variabel | Bawaan | Kegunaan |
|---|---|---|
| `BASE_URL` | `http://127.0.0.1:8000` | Alamat aplikasi yang akan dipotret |
| `CHROMIUM_PATH` | *(kosong)* | Jalur Chromium khusus. Kosongkan agar memakai peramban bawaan Playwright. Berguna pada kontainer yang sudah menyediakan Chromium sendiri |

Contoh:

```bash
BASE_URL=http://localhost:8080 npm run capture:docs
```

### Yang Perlu Diketahui

- **Penangkapan gagal bila ada galat JavaScript di halaman.** Ini disengaja: screenshot dari halaman yang bermasalah tidak dapat dipercaya. Perbaiki dulu galatnya, baru jalankan ulang. Perilaku inilah yang dulu menemukan bug grafik dashboard yang tak tampil.
- **Mode terang dikunci** lewat `localStorage`, sehingga hasilnya konsisten apa pun pengaturan tema di mesin Anda.
- **ID sumber daya dicari otomatis** dari halaman daftar — script tidak akan patah bila urutan data seeder berubah.
- **Permintaan ke CDN dipenuhi dengan konten kosong** (jQuery, DataTables, font) karena bundel lokal tema sudah menyediakannya. Dengan begitu script tetap jalan di jaringan tanpa akses keluar.
- Gambar disimpan dengan `deviceScaleFactor: 2` agar tajam. Bila ukuran repo menjadi masalah, turunkan nilainya menjadi `1` di dalam script.

### Bila Memakai SQLite

Aplikasi ini dirancang untuk MySQL. Bila Anda menjalankannya di atas SQLite untuk keperluan penangkapan layar, kolom tanggal akan menyimpan komponen jam dari berkas Excel (`2023-01-18 00:00:00`) sehingga isian bertipe tanggal tampil kosong di peramban. Normalkan lebih dulu:

```sql
UPDATE repairs  SET repair_date  = substr(repair_date, 1, 10);
UPDATE payments SET payment_date = substr(payment_date, 1, 10);
```

MySQL memangkasnya sendiri, jadi langkah ini tidak diperlukan di sana.

### Setelah Menjalankan

Periksa hasilnya, lalu **cocokkan kembali teks manual dengan gambar barunya** — bila tata letak berubah, penjelasan di [`docs/MANUAL.md`](../docs/MANUAL.md) mungkin perlu ikut disesuaikan.
