# Sistem Informasi Arsip Digital

Sistem informasi arsip digital dengan **automatic retention rules** dan **alur persetujuan terstruktur**

Sistem ini menentukan masa retensi arsip secara otomatis dari kategori dan jenis dokumen, menghubungkan status retensi dengan status persetujuan, dan menyediakan portal publik untuk arsip yang telah disetujui.

## Daftar Isi

- [Fitur](#fitur)
- [Peran dan Hak Akses](#peran-dan-hak-akses)
- [Alur Kerja](#alur-kerja)
- [Aturan Retensi](#aturan-retensi)
- [Teknologi](#teknologi)
- [Kebutuhan Sistem](#kebutuhan-sistem)
- [Instalasi](#instalasi)
- [Konfigurasi](#konfigurasi)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Penjadwal Retensi](#penjadwal-retensi)
- [Struktur Proyek](#struktur-proyek)
- [Struktur Basis Data](#struktur-basis-data)
- [Pengujian](#pengujian)
- [Pemecahan Masalah](#pemecahan-masalah)
- [Batasan](#batasan)
- [Lisensi](#lisensi)

## Fitur

**Pengelolaan arsip**
- Tambah, ubah, dan hapus arsip (soft delete) beserta unggah dokumen PDF.
- Metadata arsip: judul, nomor dokumen, tanggal surat, jenis dokumen, sifat surat, kategori, OPD, tahun, dan deskripsi.
- Pratinjau dan unduh dokumen, dengan nama file diambil dari judul arsip.

**Retensi otomatis**
- Masa retensi dan tindakan akhir (musnah atau permanen) dicocokkan otomatis dari kombinasi kategori dan jenis dokumen.
- Tanggal akhir retensi dihitung dari tanggal surat ditambah masa retensi.
- Status retensi (aktif, inaktif, permanen) disinkronkan dengan status persetujuan.

**Alur persetujuan**
- Arsip dari petugas berstatus menunggu, lalu disetujui atau ditolak oleh `super_admin`.
- Penolakan wajib disertai catatan.
- Petugas dapat merevisi arsip yang ditolak. Setelah disimpan, arsip kembali menunggu dan catatan penolakan dihapus.
- Arsip yang diunggah `super_admin` langsung berstatus disetujui.

**Pemantauan terjadwal**
- Arsip aktif yang masa retensinya berakhir diubah menjadi inaktif.
- Notifikasi dikirim ke `super_admin` untuk arsip yang retensinya berakhir dalam 3 bulan.

**Portal publik**
- Pencarian dan penelusuran arsip yang telah disetujui.
- Arsip dengan sifat rahasia memerlukan token akses.

**Keterlacakan**
- Log aktivitas atas perubahan data arsip.

## Peran dan Hak Akses

| Fitur | Petugas | Super Admin | Masyarakat umum |
|---|---|---|---|
| Unggah arsip | Ya, berstatus menunggu | Ya, langsung disetujui | Tidak |
| Lihat arsip di panel admin | Milik sendiri | Semua | Tidak |
| Ubah arsip | Milik sendiri | Semua | Tidak |
| Hapus arsip | Milik sendiri | Semua | Tidak |
| Setujui atau tolak arsip | Tidak | Ya | Tidak |
| Notifikasi retensi | Tidak | Ya | Tidak |
| Cari dan lihat arsip di portal | Ya | Ya | Hanya arsip disetujui |
| Unduh arsip rahasia | Dengan token | Dengan token | Dengan token |

## Alur Kerja

### Status persetujuan dan status retensi

| Kejadian | `approval_status` | `retention_status` |
|---|---|---|
| Petugas mengunggah arsip | `pending` | `inaktif` |
| Super admin mengunggah arsip | `approved` | `aktif` |
| Super admin menyetujui | `approved` | `aktif` |
| Super admin menolak (dengan catatan) | `rejected` | `inaktif` |
| Petugas merevisi arsip yang ditolak | `pending` | `inaktif` |
| Masa retensi berakhir (penjadwal) | tidak berubah | `aktif` menjadi `inaktif` |

Status `permanen` tidak diubah oleh sinkronisasi status persetujuan.

### Setelah masa retensi berakhir

Sistem hanya mengubah status menjadi inaktif dan mengirim pengingat. Sistem tidak memusnahkan arsip dan tidak memindahkannya menjadi arsip permanen. Tindak lanjut tindakan akhir dilakukan oleh `super_admin` di luar sistem sesuai prosedur instansi.

Arsip berstatus inaktif tetap tampil di portal publik selama `approval_status`-nya `approved`.

## Aturan Retensi

Aturan disimpan di tabel `retention_rules` (225 kombinasi: 15 kategori x 15 jenis dokumen), dengan kolom `retention_years` dan `final_action`. Saat arsip dibuat, `ArchiveObserver` mencocokkan kategori dan jenis dokumen arsip dengan aturan tersebut, lalu mengisi `retention_years`, `final_action`, dan `retention_end_date`.

Aturan mengacu pada Peraturan ANRI Nomor 8 Tahun 2022 sebagai pedoman umum dan disesuaikan dengan kebijakan instansi. Daftar ini bukan JRA resmi instansi.

## Teknologi

| Komponen | Teknologi |
|---|---|
| Bahasa | PHP 8.2 |
| Framework | Laravel 12 |
| Panel admin | Filament 5 |
| Peran dan izin | Spatie Laravel Permission |
| Log aktivitas | Spatie Laravel Activitylog |
| Basis data | MySQL |
| Aset front-end | Vite, Tailwind CSS |

## Kebutuhan Sistem

- PHP 8.2 atau lebih baru dengan ekstensi yang dibutuhkan Laravel (mbstring, openssl, pdo_mysql, fileinfo, dan lainnya)
- Composer
- Node.js dan npm
- MySQL

## Instalasi

```bash
git clone https://github.com/USERNAME/NAMA-REPO.git
cd NAMA-REPO

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Buat basis data kosong di MySQL, atur `.env` (lihat bagian Konfigurasi), lalu:

```bash
php artisan migrate --seed
php artisan storage:link
npm run build
```

## Konfigurasi

Atur nilai berikut di `.env`:

```env
APP_NAME="Sistem Arsip Digital"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=user
DB_PASSWORD=password

# Token untuk mengakses dokumen berklasifikasi rahasia di portal publik
ARSIP_RAHASIA_TOKEN=isi_token_anda
```

Jangan commit file `.env`. Ganti `ARSIP_RAHASIA_TOKEN` dengan nilai yang kuat dan unik untuk setiap lingkungan.

## Menjalankan Aplikasi

```bash
php artisan serve
```

- Portal publik: `http://localhost:8000`
- Panel admin: `http://localhost:8000/admin`

Untuk pengembangan front-end:

```bash
npm run dev
```

Akun awal dibuat oleh seeder: [isi email akun `super_admin` dari seeder; jangan tuliskan password asli di repositori].

## Penjadwal Retensi

Pengecekan retensi dan pengingat dijalankan harian lewat penjadwal Laravel (`routes/console.php`).

Pengembangan:

```bash
php artisan schedule:work
```

Server, tambahkan satu entri cron:

```cron
* * * * * cd /path/ke/proyek && php artisan schedule:run >> /dev/null 2>&1
```

Dua tugas yang berjalan:

| Tugas | Fungsi |
|---|---|
| `CheckArchiveRetention` | Mengubah arsip aktif yang `retention_end_date`-nya sudah lewat menjadi inaktif |
| `CheckRetentionReminder` | Mengirim notifikasi ke `super_admin` untuk arsip aktif yang berakhir dalam 3 bulan |

## Struktur Proyek

Bagian yang relevan dengan fitur utama:

```
app/
├── Console/Commands/
│   ├── CheckArchiveRetention.php
│   └── CheckRetentionReminder.php
├── Filament/Resources/Archives/
│   ├── ArchiveResource.php
│   └── Pages/                      # daftar arsip, disetujui, ditolak, persetujuan, edit
├── Http/Controllers/
│   └── PublicArchiveController.php # portal publik
├── Models/
│   ├── Archive.php
│   └── RetentionRule.php
└── Observers/
    └── ArchiveObserver.php         # penentuan retensi dan sinkronisasi status
routes/
└── console.php                     # jadwal harian
```

## Struktur Basis Data

Tabel utama:

| Tabel | Fungsi |
|---|---|
| `users` | Data pengguna |
| `archives` | Metadata arsip, status persetujuan, status dan masa retensi, lokasi file |
| `retention_rules` | Aturan retensi per kategori dan jenis dokumen |

Peran dan izin dikelola tabel Spatie: `roles`, `permissions`, `model_has_roles`, `model_has_permissions`, dan `role_has_permissions`. Peran pengguna tidak disimpan di kolom pada tabel `users`.

Kolom penting di `archives`:

| Kolom | Keterangan |
|---|---|
| `approval_status` | `pending`, `approved`, atau `rejected` |
| `rejection_note` | Catatan penolakan |
| `retention_years` | Masa retensi (tahun), dari `retention_rules` |
| `retention_end_date` | Tanggal surat ditambah masa retensi |
| `retention_status` | `aktif`, `inaktif`, atau `permanen` |
| `final_action` | Tindakan akhir: musnah atau permanen |

## Pengujian

Pengujian fungsional dilakukan dengan Black Box Testing. Skenario uji mencakup:

- Penentuan `retention_years` dan `retention_end_date` dari kombinasi kategori dan jenis dokumen.
- Perubahan status retensi mengikuti perubahan status persetujuan.
- Penolakan tanpa catatan ditolak oleh sistem.
- Pembatasan hak akses petugas dan `super_admin`.

Menjalankan uji otomatis bawaan Laravel (bila tersedia di proyek):

```bash
php artisan test
```

## Pemecahan Masalah

| Masalah | Penanganan |
|---|---|
| File arsip tidak bisa dibuka atau gambar tidak tampil | Jalankan `php artisan storage:link` |
| Tampilan tanpa gaya | Jalankan `npm run build` (atau `npm run dev`) |
| Perubahan `.env` tidak terbaca | Jalankan `php artisan config:clear` |
| Status retensi tidak berubah otomatis | Pastikan `schedule:work` atau cron berjalan |
| Aturan retensi tidak terisi saat unggah arsip | Pastikan seeder `retention_rules` sudah dijalankan |

## Batasan

- Hanya mengelola dokumen yang sudah berbentuk digital (PDF). Digitalisasi dokumen fisik tidak dicakup.
- Alur persetujuan dibatasi pada dua peran: `super_admin` dan `petugas`.
- Pemusnahan arsip dan pemindahan menjadi arsip permanen tidak dikelola sistem.
- Aturan retensi mengikuti kombinasi kategori dan jenis dokumen yang ditetapkan, bukan analisis regulasi otomatis.

## Lisensi

[Tentukan lisensi, atau hapus bagian ini bila repositori bersifat privat.]
