<div align="center">

# 🗺️ Flowmap Sistem

### Monitoring System — Vehicle Repair Shop

</div>

| | |
|---|---|
| **Versi Dokumen** | 1.0 |
| **Tanggal** | 7 September 2026 |
| **Basis Kode** | Branch `claude/readme-update-design-y5ctm0` |
| **Notasi** | Mermaid — dirender otomatis oleh GitHub |
| **Dokumen Terkait** | [SRS](SRS.md) · [Daftar Fitur](FEATURES.md) |

> 📌 Seluruh diagram menggambarkan **alur yang benar-benar berjalan di kode**, bukan rancangan ideal. Setiap simpul proses menyebut controller atau berkas yang menanganinya.

---

## 📑 Daftar Diagram

| # | Diagram | Cakupan |
|---:|---|---|
| 1 | [Flowmap Sistem Keseluruhan](#1--flowmap-sistem-keseluruhan) | Alur lengkap dari kendaraan masuk hingga nota selesai |
| 2 | [Pendaftaran Pelanggan & Kendaraan](#2--pendaftaran-pelanggan--kendaraan) | Pencatatan data induk pelanggan |
| 3 | [Siklus Hidup Servis](#3--siklus-hidup-servis) | Pencatatan hingga penyelesaian pekerjaan servis |
| 4 | [Status Servis](#4--status-servis) | Perubahan keadaan `status` pada tabel `repairs` |
| 5 | [Proses Pembayaran & Stok](#5--proses-pembayaran--stok) | Penyusunan nota dan penyesuaian stok sparepart |
| 6 | [Notifikasi Real-Time](#6--notifikasi-real-time) | Perjalanan siaran dari controller ke grafik |
| 7 | [Aliran Data Dashboard](#7--aliran-data-dashboard) | Enam endpoint JSON menuju komponen grafiknya |

---

## 1 · 🏁 Flowmap Sistem Keseluruhan

Diagram lajur (*swimlane*) yang memetakan seluruh proses bisnis bengkel. Perhatikan bahwa **Pelanggan dan Mekanik tidak berinteraksi langsung dengan sistem** — seluruh pencatatan dilakukan oleh Admin, sesuai batasan **BT-01** pada [SRS](SRS.md#24-batasan).

```mermaid
flowchart TB
    subgraph PEL["🙋 Pelanggan"]
        P1["Datang membawa kendaraan"]
        P2["Menyampaikan keluhan"]
        P9["Menerima kendaraan<br/>dan membayar"]
    end

    subgraph ADM["🧑‍💼 Admin / Front Office"]
        A1{"Pelanggan<br/>sudah terdaftar?"}
        A2["Catat pelanggan baru"]
        A3{"Kendaraan<br/>sudah terdaftar?"}
        A4["Catat kendaraan baru"]
        A5["Buat data servis<br/>pilih mekanik"]
        A6["Catat jam mulai pengerjaan"]
        A7["Catat jam selesai<br/>ubah status ke Complete"]
        A8["Susun nota pembayaran"]
    end

    subgraph SIS["⚙️ Sistem"]
        S1[("Simpan ke basis data")]
        S2["Siarkan RealTimeMessage"]
        S3["Perbarui dashboard<br/>semua klien"]
        S4["Kurangi stok sparepart"]
        S5["Simpan nota + rincian"]
    end

    subgraph MEK["🧑‍🔧 Mekanik"]
        M1["Kerjakan perbaikan"]
        M2["Laporkan pekerjaan selesai"]
    end

    P1 --> P2 --> A1
    A1 -->|"Belum"| A2 --> A3
    A1 -->|"Sudah"| A3
    A3 -->|"Belum"| A4 --> A5
    A3 -->|"Sudah"| A5
    A5 --> S1 --> S2 --> S3
    A5 --> A6 --> M1 --> M2 --> A7
    A7 --> S2
    A7 --> A8 --> S5 --> S4
    S5 --> P9
```

**Berkas terkait:** `CustomerController` · `VehicleController` · `RepairController` · `PaymentController`

---

## 2 · 👥 Pendaftaran Pelanggan & Kendaraan

Kendaraan **tidak memiliki menu tersendiri**. Formulir penambahan kendaraan hanya dapat dibuka dari halaman detail pelanggan, sehingga `customer_id` selalu terisi.

```mermaid
flowchart TD
    START(["Mulai"]) --> M1["Buka menu Customer Data"]
    M1 --> L1["Tampilkan daftar pelanggan<br/>CustomerController@index"]
    L1 --> D1{"Pelanggan sudah ada?"}

    D1 -->|"Belum"| C1["Klik Add Customer<br/>CustomerController@create"]
    C1 --> C2["/ Isi nama, surel, telepon /"]
    C2 --> C3["Simpan pelanggan<br/>CustomerController@store"]
    C3 --> DB1[("customers")]
    DB1 --> V1

    D1 -->|"Sudah"| V1["Buka detail pelanggan<br/>CustomerController@show"]
    V1 --> D2{"Kendaraan sudah terdaftar?"}
    D2 -->|"Sudah"| END(["Selesai"])

    D2 -->|"Belum"| K1["Klik Add Vehicle<br/>VehicleController@create"]
    K1 --> K2["/ Isi model, warna, jenis, nomor pelat /"]
    K2 --> K3["Simpan kendaraan<br/>VehicleController@store"]
    K3 --> DB2[("vehicles")]
    DB2 --> K4["Kembali ke detail pelanggan<br/>dengan notifikasi sukses"]
    K4 --> END
```

**Berkas terkait:** `app/Http/Controllers/CustomerController.php` · `app/Http/Controllers/VehicleController.php` · `resources/views/customers/`

---

## 3 · 🛠️ Siklus Hidup Servis

Inilah alur yang memicu pembaruan dashboard. Perhatikan bahwa **`event(new RealTimeMessage('status'))` dipanggil dua kali**: saat servis dibuat dan saat servis diperbarui.

```mermaid
flowchart TD
    START(["Mulai"]) --> R1["Buka menu Repair Data<br/>RepairController@index"]
    R1 --> R2["Klik Add Repair<br/>RepairController@create"]
    R2 --> R3["/ Pilih pelanggan /"]
    R3 --> R4["Muat kendaraan milik pelanggan<br/>VehicleController@getVehicleByCustomer"]
    R4 --> R5["/ Pilih kendaraan, mekanik,<br/>keluhan, tanggal servis /"]
    R5 --> R6["Simpan servis<br/>RepairController@store"]
    R6 --> DB1[("repairs<br/>status = 1 In Progress")]
    DB1 --> EV1["Siarkan RealTimeMessage status"]
    EV1 --> DSH1["Kartu status semua klien<br/>diperbarui seketika"]

    DB1 --> R7["Buka detail servis<br/>RepairController@show"]
    R7 --> R8["/ Isi jam mulai saat pengerjaan dimulai /"]
    R8 --> R9["Simpan perubahan<br/>RepairController@update"]
    R9 --> EV2["Siarkan RealTimeMessage status"]

    R9 --> D1{"Pekerjaan sudah selesai?"}
    D1 -->|"Belum"| R7
    D1 -->|"Sudah"| R10["/ Isi jam selesai<br/>ubah status ke Complete /"]
    R10 --> R11["Simpan perubahan<br/>RepairController@update"]
    R11 --> DB2[("repairs<br/>status = 2 Complete")]
    DB2 --> EV3["Siarkan RealTimeMessage status"]
    EV3 --> DSH2["Kartu status dan diagram lingkaran<br/>tergambar ulang"]
    DB2 --> PAY["Lanjut ke proses pembayaran<br/>lihat Diagram 5"]
    PAY --> END(["Selesai"])
```

**Berkas terkait:** `app/Http/Controllers/RepairController.php` · `resources/views/repairs/`

---

## 4 · 🔄 Status Servis

Kolom `repairs.status` hanya mengenal dua nilai. Sistem **tidak mengunci** perubahan status, sehingga servis yang telanjur ditandai selesai masih dapat dikembalikan ke *In Progress* melalui formulir yang sama.

```mermaid
stateDiagram-v2
    [*] --> InProgress : Servis dibuat<br/>RepairController@store

    InProgress : 🔧 In Progress (status = 1)
    InProgress : Nilai bawaan pada migrasi
    InProgress : start_time boleh masih kosong

    Complete : ✅ Complete (status = 2)
    Complete : end_time terisi
    Complete : process_time dapat dihitung

    InProgress --> Complete : Admin mengubah status<br/>RepairController@update
    Complete --> InProgress : Koreksi oleh Admin<br/>tidak dibatasi sistem

    Complete --> [*] : Nota pembayaran dibuat

    note right of Complete
        Hanya servis berstatus Complete
        yang diperhitungkan pada grafik
        tren dan rata-rata waktu.
        Perhitungan rata-rata waktu
        mensyaratkan start_time dan
        end_time terisi keduanya.
    end note
```

**Berkas terkait:** `database/migrations/2023_12_15_160448_create_repairs_table.php` · `app/Models/Repair.php`

---

## 5 · 🧾 Proses Pembayaran & Stok

Alur paling rumit dalam sistem. Seluruh langkah berjalan **di dalam satu transaksi basis data** — kegagalan pada langkah mana pun mengembalikan seluruh perubahan, termasuk stok sparepart.

### 5.1 Pembuatan Nota Baru

```mermaid
flowchart TD
    START(["Dari halaman detail servis"]) --> B1["Klik tombol Payment<br/>PaymentController@create"]
    B1 --> B2["Muat sparepart yang layak<br/>stock lebih dari 0 dan jenis sesuai kendaraan"]
    B2 --> B3["/ Isi jam mulai, jam selesai,<br/>tanggal bayar, biaya jasa /"]
    B3 --> B4["/ Tambah baris sparepart<br/>part, kuantitas, catatan /"]
    B4 --> B5["Kirim formulir<br/>PaymentController@store"]

    B5 --> T1["🔒 DB::beginTransaction"]
    T1 --> T2["Normalisasi nilai rupiah<br/>hapus Rp dan pemisah ribuan"]
    T2 --> T3["Perbarui jam mulai dan selesai servis"]
    T3 --> T4["Simpan Payment"]
    T4 --> T5["Simpan rincian biaya jasa<br/>note = service cost, part_id kosong"]
    T5 --> T6{"Masih ada baris sparepart?"}
    T6 -->|"Ya"| T7["Simpan rincian sparepart"]
    T7 --> T8["Kurangi Part.stock<br/>sebesar kuantitas terpakai"]
    T8 --> T6
    T6 -->|"Tidak"| T9{"Seluruh langkah berhasil?"}

    T9 -->|"Ya"| OK["✅ DB::commit"]
    OK --> OK2["Alihkan ke detail servis<br/>dengan notifikasi sukses"]
    T9 -->|"Tidak"| NG["❌ DB::rollback"]
    NG --> NG2["Kembali ke formulir<br/>dengan pesan galat"]

    OK2 --> END(["Selesai"])
    NG2 --> B3
```

### 5.2 Perubahan Nota — Termasuk Pengembalian Stok

Bagian yang paling mudah keliru dipahami: ketika sebuah baris sparepart **dihapus** dari nota, stoknya **dikembalikan** terlebih dahulu sebelum baris rinciannya dihapus.

```mermaid
flowchart TD
    START(["Bagian Payment Data<br/>pada halaman detail servis"]) --> U1["Ubah rincian lalu simpan<br/>PaymentController@update"]
    U1 --> T1["🔒 DB::beginTransaction"]
    T1 --> U2["Perbarui Payment dan rincian biaya jasa"]

    U2 --> U3["Kumpulkan detail_id<br/>yang masih ada di formulir"]
    U3 --> U4{"Ada rincian lama<br/>yang tidak lagi terdaftar?"}
    U4 -->|"Ya"| U5["♻️ Kembalikan stok<br/>Part.stock + quantity"]
    U5 --> U6["Hapus baris rincian"]
    U6 --> U4
    U4 -->|"Tidak"| U7{"Proses baris berikutnya"}

    U7 -->|"Baris baru"| U8["Stok acuan = Part.stock"]
    U7 -->|"Baris lama, part sama"| U9["Stok acuan = Part.stock + kuantitas lama"]
    U7 -->|"Baris lama, part berbeda"| U10["Stok acuan = Part.stock"]

    U8 --> V1{"Kuantitas melebihi stok acuan?"}
    U9 --> V1
    U10 --> V1

    V1 -->|"Ya"| E1["❌ Tolak: jumlah melebihi stok tersedia"]
    V1 -->|"Tidak"| V2{"Kuantitas kurang dari 0?"}
    V2 -->|"Ya"| E2["❌ Tolak: jumlah tidak boleh negatif"]
    V2 -->|"Tidak"| U11["Part.stock = stok acuan dikurangi kuantitas"]
    U11 --> U12["Simpan rincian pembayaran"]
    U12 --> U13{"Masih ada baris lain?"}
    U13 -->|"Ya"| U7
    U13 -->|"Tidak"| OK["✅ DB::commit"]

    E1 --> NG["❌ DB::rollback"]
    E2 --> NG
    OK --> END(["Alihkan ke detail servis"])
    NG --> END2(["Kembali dengan pesan galat"])
```

**Berkas terkait:** `app/Http/Controllers/PaymentController.php` · `resources/views/repairs/payment.blade.php` · `resources/views/repairs/show.blade.php`

---

## 6 · ⚡ Notifikasi Real-Time

Perjalanan satu siaran dari controller hingga grafik tergambar ulang. Diagram ini menjelaskan mengapa **tiga proses** harus berjalan bersamaan seperti disebut pada [panduan menjalankan](../README.md#️-menjalankan-project).

```mermaid
sequenceDiagram
    autonumber
    actor Admin as 🧑‍💼 Admin
    participant BR1 as 🖥️ Browser A
    participant LAR as ⚙️ Laravel
    participant WS as 📡 Server WebSocket :6001
    participant BR2 as 🖥️ Browser B (dashboard)

    Note over BR2,WS: Saat halaman dimuat, Echo berlangganan kanal "events"
    BR2->>WS: subscribe channel "events"
    WS-->>BR2: subscription_succeeded

    Admin->>BR1: Ubah status servis menjadi Complete
    BR1->>LAR: PUT /repair/{id}
    LAR->>LAR: RepairController@update menyimpan data
    LAR->>LAR: event(new RealTimeMessage('status'))
    LAR->>WS: Siarkan ke kanal "events"
    WS-->>BR2: RealTimeMessage {message: "status"}

    BR2->>BR2: Listener memeriksa message == "status"
    BR2->>BR2: Panggil getData()
    BR2->>LAR: GET /getDataStatus
    LAR-->>BR2: [car_ongoing, car_complete, motor_ongoing, motor_complete]
    BR2->>BR2: chart_pie.updateSeries() dan 4 gauge kartu status

    Note over BR2: Hanya kartu status dan diagram lingkaran<br/>yang tergambar ulang
    LAR-->>BR1: Alihkan ke detail servis + notifikasi sukses
```

**Berkas terkait:** `app/Events/RealTimeMessage.php` · `routes/channels.php` · `resources/js/bootstrap.js` · `resources/views/home.blade.php`

> ⚠️ Bila server WebSocket tidak dijalankan, seluruh alur di atas terputus pada langkah siaran. Dashboard tetap tampil normal, tetapi hanya memperbarui diri saat halaman disegarkan secara manual.

> ⚠️ **Cakupan pembaruan terbatas.** `getData()` hanya meminta ulang `GET /getDataStatus`. Grafik tren servis, pendapatan, efisiensi mekanik, dan rata-rata waktu **tidak ikut diperbarui** meski ikut terpengaruh oleh peristiwa yang sama — lihat [Lampiran B-6 pada SRS](SRS.md#lampiran-b--catatan-implementasi--temuan).

---

## 7 · 📊 Aliran Data Dashboard

Pemetaan enam endpoint JSON menuju komponen grafik yang dilayaninya. Sebagian data dirender langsung di server saat halaman dimuat, sisanya diambil lewat AJAX.

```mermaid
flowchart LR
    subgraph DB["🗄️ Basis Data"]
        T1[("repairs")]
        T2[("vehicles")]
        T3[("payments")]
        T4[("mechanics")]
    end

    subgraph EP["⚙️ Endpoint DashboardController"]
        E1["getDataStatus"]
        E2["getCompleteRepairs"]
        E3["getAverageTime"]
        E4["getRevenueData"]
        E5["getMechanicEfficient"]
        E6["index — render awal"]
    end

    subgraph UI["📊 Komponen Grafik pada home.blade.php"]
        C1["4 gauge kartu status<br/>#car_ongoing #car_complete<br/>#motor_ongoing #motor_complete"]
        C2["Diagram lingkaran<br/>#pie_chart"]
        C3["Grafik batang tren<br/>#bar_chart"]
        C4["Grafik area pendapatan total<br/>#revenue_chart"]
        C5["Grafik area per divisi<br/>#area_chart"]
        C6["Gauge efisiensi mekanik<br/>#mechanic_chart"]
        C7["Grafik batang rata-rata waktu<br/>#average_chart"]
    end

    T1 --> E1
    T2 --> E1
    E1 --> C1

    T1 --> E6
    E6 --> C2

    T1 --> E2
    T2 --> E2
    E2 --> C3

    T3 --> E4
    E4 --> C4
    E4 --> C5

    T1 --> E5
    T4 --> E5
    E5 --> C6

    T1 --> E3
    T2 --> E3
    E3 --> C7

    EV["📡 RealTimeMessage"] ==>|"getData() — satu-satunya<br/>endpoint yang dimuat ulang"| E1
    EV -.->|"tidak dipanggil ulang<br/>lihat Lampiran B-6"| E2
    EV -.-> E3
    EV -.-> E4
```

**Berkas terkait:** `app/Http/Controllers/DashboardController.php` · `routes/web.php` · `resources/views/home.blade.php`

> ⚠️ Grafik `#area_chart` (pendapatan per divisi) saat ini menampilkan angka yang sama dengan `#revenue_chart` karena penjumlahannya belum tersaring jenis kendaraan — lihat [Lampiran B-1 pada SRS](SRS.md#lampiran-b--catatan-implementasi--temuan).

---

<div align="center">

**— Akhir Dokumen —**

[⬆️ Kembali ke atas](#️-flowmap-sistem) · [📘 SRS](SRS.md) · [📋 Daftar Fitur](FEATURES.md)

</div>
