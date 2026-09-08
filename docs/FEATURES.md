<div align="center">

# 📋 Daftar Fitur

### Monitoring System — Vehicle Repair Shop

</div>

| | |
|---|---|
| **Versi Dokumen** | 1.0 |
| **Tanggal** | 7 September 2026 |
| **Basis Kode** | Branch `claude/readme-update-design-y5ctm0` |
| **Dokumen Terkait** | [SRS](SRS.md) · [Flowmap](FLOWMAP.md) · [Panduan Instalasi](../README.md#-instalasi) |

> 📌 Dokumen ini adalah **sumber kebenaran tunggal untuk status fitur**. Setiap baris tertaut ke kode nyata dan ke nomor kebutuhan pada [SRS](SRS.md), sehingga dapat sekaligus dipakai sebagai *backlog* pengembangan.

---

## 📊 Ringkasan Cakupan

| Status | Arti | Jumlah |
|:---:|---|---:|
| ✅ | **Selesai** — berfungsi sesuai spesifikasi | **57** |
| ⚠️ | **Sebagian** — berfungsi namun ada cacat atau keterbatasan | **4** |
| ❌ | **Belum** — direncanakan, belum ada di kode | **12** |
| | **Total fitur terdefinisi** | **73** |

```
Terimplementasi (✅ + ⚠️)  █████████████████████████████░░░░░  83,6 %
Selesai penuh (✅)         ███████████████████████████░░░░░░░  78,1 %
```

**Keterangan status**

| Lambang | Makna |
|:---:|---|
| ✅ | Fitur berjalan dan sesuai perilaku yang didokumentasikan |
| ⚠️ | Fitur berjalan tetapi memiliki cacat yang tercatat di [Lampiran B SRS](SRS.md#lampiran-b--catatan-implementasi--temuan) |
| ❌ | Fitur belum dibangun; tercatat di [Lampiran A SRS](SRS.md#lampiran-a--kebutuhan-belum-terimplementasi) |

---

## 📊 Modul 1 — Dashboard & Analitik

Halaman utama sistem. Menyajikan enam indikator operasional bengkel yang seluruhnya memperbarui diri secara otomatis melalui WebSocket.

| No | Fitur | Deskripsi | Route | Controller@method | SRS | Status |
|---:|---|---|---|---|---|:---:|
| 1.1 | **Kartu status servis** | Empat kartu berisi jumlah servis: mobil dikerjakan, mobil selesai, motor dikerjakan, motor selesai | `GET /getDataStatus` | `DashboardController@getDataStatus` | `SRS-F-101` | ✅ |
| 1.2 | **Kartu dapat diklik** | Klik kartu membuka daftar servis yang sudah tersaring sesuai kartu | `GET /repair?car_progress=1` | `RepairController@index` | `SRS-F-102` | ✅ |
| 1.3 | **Diagram lingkaran antrean** | Proporsi keempat kombinasi status–jenis kendaraan | — (dirender di server) | `DashboardController@index` | `SRS-F-103` | ✅ |
| 1.4 | **Grafik batang tren servis** | Jumlah servis selesai per tanggal untuk 7 tanggal terakhir, dipisah mobil dan motor | `GET /getCompleteRepairs` | `DashboardController@getCompleteRepairs` | `SRS-F-104` | ✅ |
| 1.5 | **Gauge efisiensi mekanik** | Skor efisiensi per mekanik = (servis selesai ÷ total jam) × 100 | `GET /getMechanicEfficient` | `DashboardController@getMechanicEfficient` | `SRS-F-105` | ⚠️ |
| 1.6 | **Grafik rata-rata waktu** | Rata-rata jam pengerjaan mobil dibanding motor | `GET /getAverageTime` | `DashboardController@getAverageTime` | `SRS-F-106` | ✅ |
| 1.7 | **Grafik pendapatan total** | Total pendapatan harian untuk 30 tanggal pembayaran terakhir | `GET /getRevenueData` | `DashboardController@getRevenueData` | `SRS-F-107` | ✅ |
| 1.8 | **Grafik pendapatan per divisi** | Pendapatan dipisahkan menurut jenis kendaraan | `GET /getRevenueData` | `DashboardController@getRevenueData` | `SRS-F-107` | ⚠️ |
| 1.9 | **Penyesuaian warna tema** | Palet warna grafik mengikuti mode terang atau gelap | — | `resources/views/home.blade.php` | `SRS-F-108` | ✅ |

> ✅ **Koreksi penting.** Fitur 1.5–1.8 sempat **tidak pernah tampil sama sekali** karena galat JavaScript yang menghentikan skrip dashboard di tengah jalan ([B-7](SRS.md#lampiran-b--catatan-implementasi--temuan)). Versi awal dokumen ini menyatakan keempatnya berfungsi — keliru, karena disimpulkan dari pembacaan kode tanpa menjalankan aplikasi. Bug tersebut kini sudah diperbaiki dan status di bawah sudah terverifikasi di aplikasi yang berjalan.
>
> ⚠️ **1.5** berpotensi menghasilkan `INF`/`NAN` bila mekanik belum punya jam kerja tercatat ([B-2](SRS.md#lampiran-b--catatan-implementasi--temuan)).
> ⚠️ **1.8** saat ini menampilkan angka yang sama dengan 1.7 karena penjumlahannya belum tersaring jenis kendaraan ([B-1](SRS.md#lampiran-b--catatan-implementasi--temuan)).

---

## 👥 Modul 2 — Manajemen Pelanggan

| No | Fitur | Deskripsi | Route | Controller@method | SRS | Status |
|---:|---|---|---|---|---|:---:|
| 2.1 | **Daftar pelanggan** | Tabel seluruh pelanggan dengan pencarian dan paginasi | `GET /customer` | `CustomerController@index` | `SRS-F-201` | ✅ |
| 2.2 | **Tambah pelanggan** | Menyimpan nama, surel, dan nomor telepon | `GET,POST /customer/create` | `CustomerController@create`, `@store` | `SRS-F-202` | ✅ |
| 2.3 | **Detail pelanggan** | Identitas pelanggan beserta daftar kendaraan miliknya | `GET /customer/{id}` | `CustomerController@show` | `SRS-F-203` | ✅ |
| 2.4 | **Ubah pelanggan** | Memutakhirkan data pelanggan | `PUT /customer/{id}` | `CustomerController@update` | `SRS-F-204` | ✅ |
| 2.5 | **Hapus pelanggan** | Dibatalkan bila pelanggan masih memiliki kendaraan terdaftar | `DELETE /customer/{id}` | `CustomerController@destroy` | `SRS-F-205` | ✅ |

---

## 🚙 Modul 3 — Manajemen Kendaraan

Kendaraan tidak berdiri sendiri sebagai menu, melainkan dikelola dari halaman detail pelanggan.

| No | Fitur | Deskripsi | Route | Controller@method | SRS | Status |
|---:|---|---|---|---|---|:---:|
| 3.1 | **Tambah kendaraan** | Formulir dibuka dari detail pelanggan; menyimpan model, warna, jenis, nomor pelat | `GET,POST /vehicle/create` | `VehicleController@create`, `@store` | `SRS-F-301` | ✅ |
| 3.2 | **Detail kendaraan** | Atribut kendaraan beserta pemiliknya | `GET /vehicle/{id}` | `VehicleController@show` | `SRS-F-302` | ✅ |
| 3.3 | **Ubah kendaraan** | Memutakhirkan atribut kendaraan | `PUT /vehicle/{id}` | `VehicleController@update` | `SRS-F-303` | ✅ |
| 3.4 | **Hapus kendaraan** | Dibatalkan bila kendaraan memiliki riwayat servis | `DELETE /vehicle/{id}` | `VehicleController@destroy` | `SRS-F-304` | ✅ |
| 3.5 | **Pencarian kendaraan per pelanggan** | Endpoint JSON untuk pilihan bertingkat pada formulir servis | `GET /vehicles` | `VehicleController@getVehicleByCustomer` | `SRS-F-305` | ✅ |

---

## 🧑‍🔧 Modul 4 — Manajemen Mekanik

| No | Fitur | Deskripsi | Route | Controller@method | SRS | Status |
|---:|---|---|---|---|---|:---:|
| 4.1 | **Daftar mekanik** | Tabel seluruh mekanik | `GET /mechanic` | `MechanicsController@index` | `SRS-F-401` | ✅ |
| 4.2 | **Tambah mekanik** | Menyimpan nama, surel, dan bidang keahlian | `GET,POST /mechanic/create` | `MechanicsController@create`, `@store` | `SRS-F-402` | ✅ |
| 4.3 | **Detail mekanik** | Profil satu mekanik | `GET /mechanic/{id}` | `MechanicsController@show` | `SRS-F-403` | ✅ |
| 4.4 | **Ubah mekanik** | Memutakhirkan data mekanik | `PUT /mechanic/{id}` | `MechanicsController@update` | `SRS-F-404` | ✅ |
| 4.5 | **Hapus mekanik** | Dibatalkan bila mekanik masih tertaut data servis | `DELETE /mechanic/{id}` | `MechanicsController@destroy` | `SRS-F-405` | ✅ |

---

## 🔩 Modul 5 — Manajemen Sparepart

| No | Fitur | Deskripsi | Route | Controller@method | SRS | Status |
|---:|---|---|---|---|---|:---:|
| 5.1 | **Daftar sparepart** | Tabel berisi nama, jenis, stok, dan harga satuan | `GET /part` | `PartController@index` | `SRS-F-501` | ✅ |
| 5.2 | **Tambah sparepart** | Menyimpan nama, jenis, stok awal, dan harga | `GET,POST /part/create` | `PartController@create`, `@store` | `SRS-F-502` | ✅ |
| 5.3 | **Detail sparepart** | Atribut satu sparepart | `GET /part/{id}` | `PartController@show` | `SRS-F-503` | ✅ |
| 5.4 | **Ubah sparepart** | Memutakhirkan atribut termasuk penyesuaian stok manual | `PUT /part/{id}` | `PartController@update` | `SRS-F-504` | ✅ |
| 5.5 | **Hapus sparepart** | Dibatalkan bila sparepart pernah dipakai pada pembayaran | `DELETE /part/{id}` | `PartController@destroy` | `SRS-F-505` | ✅ |
| 5.6 | **Penyaringan sparepart otomatis** | Formulir pembayaran hanya menawarkan sparepart berstok > 0 dan sejenis dengan kendaraan | — | `PaymentController@create`, `RepairController@show` | `SRS-F-506` | ✅ |

---

## 🛠️ Modul 6 — Manajemen Servis

Modul inti sistem. Setiap perubahan di sini memicu siaran WebSocket ke seluruh dashboard.

| No | Fitur | Deskripsi | Route | Controller@method | SRS | Status |
|---:|---|---|---|---|---|:---:|
| 6.1 | **Daftar servis** | Tabel seluruh pekerjaan servis | `GET /repair` | `RepairController@index` | `SRS-F-601` | ✅ |
| 6.2 | **Penyaringan daftar servis** | Empat penyaring lewat parameter kueri: `car_progress`, `car_complete`, `motor_progress`, `motor_complete` | `GET /repair?...` | `RepairController@index` | `SRS-F-601` | ✅ |
| 6.3 | **Tambah servis** | Pemilihan kendaraan bertingkat setelah pelanggan; status awal *In Progress* | `GET,POST /repair/create` | `RepairController@create`, `@store` | `SRS-F-602` | ✅ |
| 6.4 | **Siaran saat servis dibuat** | Menyiarkan `RealTimeMessage('status')` sehingga dashboard ikut berubah | — | `RepairController@store` | `SRS-F-801` | ✅ |
| 6.5 | **Detail servis** | Rincian servis, formulir penyuntingan, dan bagian pembayaran | `GET /repair/{id}` | `RepairController@show` | `SRS-F-603` | ✅ |
| 6.6 | **Ubah servis & status** | Memutakhirkan jam mulai, jam selesai, dan status menjadi *Complete* | `PUT /repair/{id}` | `RepairController@update` | `SRS-F-604` | ✅ |
| 6.7 | **Siaran saat servis diubah** | Menyiarkan `RealTimeMessage('status')` setelah perubahan tersimpan | — | `RepairController@update` | `SRS-F-801` | ✅ |
| 6.8 | **Hapus servis** | Dibatalkan bila servis sudah memiliki pembayaran | `DELETE /repair/{id}` | `RepairController@destroy` | `SRS-F-605` | ✅ |
| 6.9 | **Perhitungan lama pengerjaan** | `process_time` dihitung otomatis dari selisih jam mulai dan jam selesai | — | `Repair::getProcessTimeAttribute` | `SRS-F-106` | ✅ |

---

## 🧾 Modul 7 — Pembayaran

| No | Fitur | Deskripsi | Route | Controller@method | SRS | Status |
|---:|---|---|---|---|---|:---:|
| 7.1 | **Formulir pembayaran** | Dibuka dari detail servis; menyiapkan sparepart yang bersesuaian dan batas tanggal minimum | `GET /payment/create` | `PaymentController@create` | `SRS-F-701` | ⚠️ |
| 7.2 | **Simpan pembayaran** | Satu baris biaya jasa + N baris sparepart, seluruhnya dalam satu transaksi basis data | `POST /payment` | `PaymentController@store` | `SRS-F-702` | ✅ |
| 7.3 | **Pengurangan stok otomatis** | Stok sparepart berkurang sebesar kuantitas terpakai saat pembayaran disimpan | — | `PaymentController@store` | `SRS-F-702` | ✅ |
| 7.4 | **Normalisasi nilai rupiah** | Format `Rp 1.500.000` dinormalisasi menjadi bilangan bulat sebelum disimpan | — | `PaymentController@store`, `@update` | `SRS-F-702` | ✅ |
| 7.5 | **Ubah pembayaran** | Menambah, mengubah, dan menghapus baris rincian setelah pembayaran tersimpan | `PUT /payment/{id}` | `PaymentController@update` | `SRS-F-703` | ✅ |
| 7.6 | **Pengembalian stok** | Stok dikembalikan ketika baris sparepart dihapus dari rincian | — | `PaymentController@update` | `SRS-F-703` | ✅ |
| 7.7 | **Validasi kuantitas terhadap stok** | Kuantitas melebihi stok atau bernilai negatif ditolak dengan pesan galat | — | `PaymentController@update` | `SRS-F-703` | ✅ |
| 7.8 | **Pembayaran tampil di detail servis** | Rincian pembayaran dapat disunting langsung dari halaman servis | `GET /repair/{id}` | `resources/views/repairs/show.blade.php` | `SRS-F-704` | ✅ |
| 7.9 | **Pembatalan otomatis saat galat** | Kegagalan apa pun memicu `rollback` sehingga stok dan pembayaran tetap konsisten | — | `PaymentController@store`, `@update` | `SRS-NF-06` | ✅ |

> ⚠️ **7.1** menampilkan label kendaraan tanpa nama karena memakai atribut yang tidak ada pada model ([B-3](SRS.md#lampiran-b--catatan-implementasi--temuan)).
> ℹ️ Route `payment.index`, `payment.show`, `payment.edit`, dan `payment.destroy` terdaftar namun method-nya masih kosong ([B-4](SRS.md#lampiran-b--catatan-implementasi--temuan)).

---

## ⚡ Modul 8 — Notifikasi Real-Time

| No | Fitur | Deskripsi | Berkas | SRS | Status |
|---:|---|---|---|---|:---:|
| 8.1 | **Event siaran** | `RealTimeMessage` mengimplementasikan `ShouldBroadcast` pada kanal publik `events` | `app/Events/RealTimeMessage.php` | `SRS-F-801` | ✅ |
| 8.2 | **Otorisasi kanal** | Kanal `events` bersifat publik; otorisasi selalu mengizinkan | `routes/channels.php` | `SRS-F-801` | ✅ |
| 8.3 | **Pendengar sisi klien** | `Echo.channel('events').listen(...)` memicu `getData()` saat menerima pesan `status` | `resources/views/home.blade.php` | `SRS-F-802` | ✅ |
| 8.4 | **Pembaruan indikator status** | `getData()` meminta ulang `GET /getDataStatus`, lalu kartu status dan diagram lingkaran tergambar ulang | `resources/views/home.blade.php` | `SRS-F-802` | ⚠️ |
| 8.5 | **Dashboard pemantau WebSocket** | Halaman bawaan paket untuk memantau koneksi dan lalu lintas siaran | `/laravel-websockets` | — | ✅ |

> ⚠️ **8.4** hanya mencakup dua dari enam indikator. Grafik tren, pendapatan, efisiensi mekanik, dan rata-rata waktu tidak ikut diperbarui secara real-time meski ikut terpengaruh oleh peristiwa yang sama ([B-6](SRS.md#lampiran-b--catatan-implementasi--temuan)).

---

## 🧩 Fitur Lintas Modul

| No | Fitur | Deskripsi | Sumber | Status |
|---:|---|---|---|:---:|
| 9.1 | **Notifikasi SweetAlert** | Umpan balik keberhasilan dan kegagalan pada setiap aksi | `realrashid/sweet-alert` | ✅ |
| 9.2 | **Tabel DataTables** | Pencarian, pengurutan, dan paginasi pada seluruh tabel data | DataTables v1.13.1 | ✅ |
| 9.3 | **Mode terang & gelap** | Termasuk penyesuaian warna seluruh grafik | Tema Metronic + `KTThemeMode` | ✅ |
| 9.4 | **Proteksi hapus berbasis relasi** | Penghapusan yang melanggar relasi dibatalkan dan dilaporkan sebagai pesan yang mudah dipahami | Seluruh controller, method `destroy` | ✅ |
| 9.5 | **Seeder berbasis Excel** | Data awal tujuh tabel diimpor dari `public/data/*.xlsx` | `database/seeders/*`, `app/Imports/*` | ✅ |
| 9.6 | **Format tanggal lokal Indonesia** | Tanggal ditampilkan sebagai `7 September 2026` | `Repair::getDateRepairAttribute`, `Payment::getDatePaymentAttribute` | ✅ |
| 9.7 | **Antarmuka responsif** | Mengikuti sistem grid Bootstrap 5 | Tema Metronic | ✅ |
| 9.8 | **Perlindungan CSRF** | Seluruh formulir dilindungi token CSRF | Middleware bawaan Laravel | ✅ |

---

## ❌ Belum Tersedia

Cerminan dari [Lampiran A SRS](SRS.md#lampiran-a--kebutuhan-belum-terimplementasi), disusun menurut prioritas.

### 🔴 Prioritas Tinggi

| No | Fitur | Mengapa penting | SRS |
|---:|---|---|---|
| 10.1 | **Autentikasi pengguna** | Seluruh data operasional dan keuangan bengkel kini terbuka bagi siapa pun yang tahu alamat halaman | `SRS-F-F01` |
| 10.2 | **Otorisasi berbasis peran** | Kasir tidak seharusnya dapat mengubah data induk; mekanik cukup memutakhirkan status pekerjaannya | `SRS-F-F02` |
| 10.3 | **Validasi masukan sisi server** | Data tidak valid dapat tersimpan dan merusak seluruh perhitungan dashboard | `SRS-F-F03` |
| 10.4 | **Jejak audit** | Penyesuaian stok dan pembayaran belum dapat ditelusuri pelakunya | `SRS-F-F04` |

### 🟡 Prioritas Menengah

| No | Fitur | Manfaat | SRS |
|---:|---|---|---|
| 10.5 | **Ekspor laporan Excel/PDF** | Rekap bulanan siap cetak; pustakanya sudah tersedia | `SRS-F-F05` |
| 10.6 | **Peringatan stok menipis** | Mencegah kehabisan stok di tengah pengerjaan | `SRS-F-F06` |
| 10.7 | **Penyaring rentang tanggal dashboard** | Periode kini terkunci pada 7 dan 30 hari terakhir | `SRS-F-F07` |
| 10.8 | **Cetak nota pembayaran** | Pelanggan memerlukan bukti pembayaran tercetak | `SRS-F-F08` |
| 10.9 | **Penjadwalan & antrean servis** | Pemerataan beban kerja mekanik; FullCalendar sudah tersedia di tema | `SRS-F-F09` |

### 🟢 Prioritas Rendah

| No | Fitur | Manfaat | SRS |
|---:|---|---|---|
| 10.10 | **Pemberitahuan pelanggan** | WhatsApp atau surel saat servis selesai | `SRS-F-F10` |
| 10.11 | **Riwayat servis per kendaraan** | Memudahkan penelusuran kerusakan berulang | `SRS-F-F11` |
| 10.12 | **Manajemen multi-cabang** | Diperlukan bila bengkel berkembang | `SRS-F-F12` |

---

## 🔧 Utang Teknis

Bukan fitur yang hilang, melainkan cacat pada fitur yang sudah ada. Rincian lengkap pada [Lampiran B SRS](SRS.md#lampiran-b--catatan-implementasi--temuan).

| Kode | Ringkasan | Berkas | Dampak |
|---|---|---|:---:|
| [B-1](SRS.md#lampiran-b--catatan-implementasi--temuan) | Pendapatan per divisi belum tersaring jenis kendaraan | `DashboardController@getRevenueData` | 🔴 |
| [B-2](SRS.md#lampiran-b--catatan-implementasi--temuan) | Pembagian dengan nol pada efisiensi mekanik | `DashboardController@getMechanicEfficient` | 🟠 |
| [B-3](SRS.md#lampiran-b--catatan-implementasi--temuan) | Label kendaraan kosong pada formulir pembayaran | `PaymentController@create` | 🟡 |
| [B-4](SRS.md#lampiran-b--catatan-implementasi--temuan) | Empat method pembayaran masih kosong | `PaymentController` | 🟡 |
| [B-5](SRS.md#lampiran-b--catatan-implementasi--temuan) | Event debug tertinggal di daftar pelanggan | `CustomerController@index` | 🟡 |
| [B-6](SRS.md#lampiran-b--catatan-implementasi--temuan) | Pembaruan real-time hanya mencakup 2 dari 6 indikator | `resources/views/home.blade.php` | 🟠 |
| [B-7](SRS.md#lampiran-b--catatan-implementasi--temuan) | ~~Tiga grafik dashboard tidak pernah tampil~~ — **sudah diperbaiki** | `resources/views/home.blade.php` | ✅ |
| — | Kueri di dalam perulangan pada endpoint dashboard | `DashboardController` | 🟠 |
| — | Belum ada pengujian otomatis yang bermakna | `tests/` | 🟠 |

---

<div align="center">

**— Akhir Dokumen —**

[⬆️ Kembali ke atas](#-daftar-fitur) · [📘 SRS](SRS.md) · [🗺️ Flowmap](FLOWMAP.md)

</div>
