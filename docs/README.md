<div align="center">

# 📚 Dokumentasi Proyek

### Monitoring System — Vehicle Repair Shop

Kumpulan dokumen spesifikasi dan perancangan sistem.

</div>

---

## 📖 Daftar Dokumen

| Dokumen | Isi | Ditujukan untuk |
|---|---|---|
| 📘 **[SRS.md](SRS.md)** | *Software Requirement Specification* format IEEE 830 — kebutuhan fungsional bernomor, kebutuhan non-fungsional, kamus data, serta lampiran roadmap dan catatan temuan | Pengembang · Penguji · Dosen pembimbing |
| 📋 **[FEATURES.md](FEATURES.md)** | Daftar seluruh fitur berikut statusnya, tertaut ke kode dan nomor kebutuhan SRS | Semua pemangku kepentingan |
| 🗺️ **[FLOWMAP.md](FLOWMAP.md)** | Tujuh diagram alur proses bisnis dan alur sistem dalam notasi Mermaid | Pengembang · Analis |
| 📖 **[MANUAL.md](MANUAL.md)** | Manual penggunaan bergambar — 24 tangkapan layar aplikasi yang berjalan, disertai penjelasan tiap kolom dan tombol | Petugas bengkel · Pelatihan operator baru |

> Untuk cara memasang dan menjalankan aplikasi, lihat [README utama](../README.md).

---

## 🧭 Mulai dari Mana?

| Kebutuhan Anda | Bacalah |
|---|---|
| 🧑‍💼 Saya operator, ingin belajar memakai aplikasinya | **[MANUAL.md](MANUAL.md)** |
| 🆕 Baru mengenal proyek ini | [README utama](../README.md) → [FEATURES.md](FEATURES.md) |
| 🔍 Ingin tahu fitur apa saja yang sudah jalan | [FEATURES.md](FEATURES.md#-ringkasan-cakupan) |
| 🧩 Ingin memahami alur proses bisnis | [FLOWMAP.md](FLOWMAP.md#1--flowmap-sistem-keseluruhan) |
| 🗄️ Ingin memahami struktur data | [SRS.md § 3.4](SRS.md#34-kebutuhan-data) |
| 🐛 Mencari pekerjaan yang perlu dibereskan | [FEATURES.md § Utang Teknis](FEATURES.md#-utang-teknis) · [SRS Lampiran B](SRS.md#lampiran-b--catatan-implementasi--temuan) |
| 🚀 Merencanakan pengembangan berikutnya | [SRS Lampiran A](SRS.md#lampiran-a--kebutuhan-belum-terimplementasi) |

---

## 🔖 Versi Dokumen

| Dokumen | Versi | Tanggal | Basis Kode |
|---|:---:|---|---|
| `SRS.md` | 1.0 | 7 September 2026 | Branch `claude/readme-update-design-y5ctm0` |
| `FEATURES.md` | 1.0 | 7 September 2026 | Branch `claude/readme-update-design-y5ctm0` |
| `FLOWMAP.md` | 1.0 | 7 September 2026 | Branch `claude/readme-update-design-y5ctm0` |
| `MANUAL.md` | 1.0 | 7 September 2026 | Branch `main` |

Seluruh dokumen ditulis berdasarkan pembacaan kode secara langsung dan mendokumentasikan sistem **apa adanya (*as-is*)**. Kebutuhan yang belum dibangun dipisahkan secara tegas ke dalam lampiran, sehingga dokumen tidak menjanjikan kemampuan yang tidak dimiliki sistem.

---

## 🔧 Panduan Pemeliharaan

Dokumentasi yang tidak diperbarui lebih menyesatkan daripada tidak ada dokumentasi. Perbarui berkas berikut setiap kali melakukan perubahan:

| Bila Anda… | Perbarui |
|---|---|
| ➕ Menambah route atau controller baru | Tambahkan baris pada [FEATURES.md](FEATURES.md) dan kebutuhan bernomor baru pada [SRS.md § 3.2](SRS.md#32-kebutuhan-fungsional) |
| 🔄 Mengubah alur proses | Perbarui diagram terkait pada [FLOWMAP.md](FLOWMAP.md) |
| 🗄️ Mengubah skema basis data | Perbarui kamus data pada [SRS.md § 3.4](SRS.md#34-kebutuhan-data) dan ERD pada [README utama](../README.md#-skema-database) |
| ✅ Menyelesaikan fitur dari daftar roadmap | Pindahkan dari [SRS Lampiran A](SRS.md#lampiran-a--kebutuhan-belum-terimplementasi) ke bab utama, dan ubah statusnya pada [FEATURES.md](FEATURES.md) |
| 🐛 Memperbaiki temuan di Lampiran B | Hapus butirnya dari [SRS Lampiran B](SRS.md#lampiran-b--catatan-implementasi--temuan) dan dari tabel [Utang Teknis](FEATURES.md#-utang-teknis), lalu ubah status fiturnya dari ⚠️ menjadi ✅ |
| 🖼️ Mengubah tampilan antarmuka | Jalankan ulang `npm run capture:docs` untuk memperbarui seluruh screenshot, lalu periksa apakah teks [MANUAL.md](MANUAL.md) masih cocok dengan gambar barunya |
| 📌 Merilis versi dokumen baru | Naikkan nomor versi pada tabel di atas dan pada kepala tiap dokumen |

**Konvensi penomoran kebutuhan**

| Pola | Arti |
|---|---|
| `SRS-F-1xx` … `SRS-F-9xx` | Kebutuhan fungsional, dikelompokkan per modul |
| `SRS-NF-xx` | Kebutuhan non-fungsional |
| `SRS-F-Fxx` | Kebutuhan **F**utur — belum terimplementasi |
| `BT-xx` | Batasan sistem |
| `B-x` | Catatan temuan implementasi |

---

<div align="center">

[⬅️ Kembali ke README utama](../README.md)

</div>
