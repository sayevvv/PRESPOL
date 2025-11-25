# PRESPOL – Platform Pencatatan Prestasi Mahasiswa POLINEMA

## Daftar Isi
- [Gambaran Umum](#gambaran-umum)
- [Fitur Utama](#fitur-utama)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Struktur Proyek](#struktur-proyek)
- [Peran dan Modul Aplikasi](#peran-dan-modul-aplikasi)
- [Prasyarat Sistem](#prasyarat-sistem)
- [Instalasi & Konfigurasi](#instalasi--konfigurasi)
- [Pengelolaan File & Media](#pengelolaan-file--media)
- [Alur Data Prestasi](#alur-data-prestasi)
- [Ekspor Data](#ekspor-data)
- [Keamanan & Praktik Baik](#keamanan--praktik-baik)
- [Troubleshooting](#troubleshooting)
- [Kontribusi & Roadmap](#kontribusi--roadmap)

## Gambaran Umum
PRESPOL (Prestasi Polinema) adalah platform internal untuk mendata, memvalidasi, dan mempublikasikan prestasi mahasiswa Politeknik Negeri Malang. Aplikasi ini menyediakan landing page publik (`indexLead.php`) dan portal autentikasi (`src/`) untuk mahasiswa, admin jurusan, serta ketua jurusan dalam mengelola proses pengajuan hingga pelaporan prestasi. Data disimpan pada Microsoft SQL Server dan sebagian besar interaksi dilakukan melalui view/stored procedure yang sudah didefinisikan di sisi basis data.

## Fitur Utama
- **Multi-peran**: Mahasiswa, Admin, dan Kajur memiliki dashboard, menu, serta batasan akses masing-masing (lihat `src/classes/*.php`).
- **Input Prestasi**: Form `src/inputPrestasi.php` + handler `src/InputProses.php` mendukung unggah bukti (foto, flyer, sertifikat, surat tugas, arsip karya) dengan validasi ukuran & MIME type.
- **Validasi Berlapis**: Admin meninjau pengajuan (view `vw_PrestasiPending`) sebelum diteruskan ke Kajur untuk keputusan akhir (`daftarPengajuan.php`, `detailPengajuan.php`).
- **Leaderboard & Statistik**: Halaman beranda menampilkan poin total, jumlah prestasi, peringkat mahasiswa berdasarkan view `leaderboard_view`.
- **Riwayat & Detail**: Mahasiswa dapat menelusuri histori pengajuan (`historiPengajuan.php`) dan detail prestasi (`detailPrestasi.php`).
- **Ekspor Excel**: Modul `src/eksporData.php` memanfaatkan `PhpOffice\PhpSpreadsheet` untuk mengekspor data terfilter (kategori, jurusan, periode) ke XLSX.
- **Landing Page Interaktif**: `indexLead.php` + `src/script.js` menghadirkan animasi GSAP, tab interaktif, dan highlight leaderboard publik.

## Teknologi yang Digunakan
| Lapisan | Teknologi |
| --- | --- |
| Backend | PHP 8.x, ekstensi `sqlsrv` (Microsoft Drivers for PHP for SQL Server) |
| Frontend | Tailwind CSS (CDN), Font Awesome, GSAP, Intersection Observer API |
| Database | Microsoft SQL Server (contoh nama DB: `PrespolTest` di `src/config/Database.php`) |
| Library PHP | `phpoffice/phpspreadsheet` (lokasi vendor: `src/classes/vendor`) |
| Storage | Sistem file untuk bukti prestasi (`src/upload`) & arsip (`src/archive`) |

## Struktur Proyek
```
PRESPOL/
├── indexLead.php           # Landing page publik
├── README.md               # Dokumentasi (file ini)
└── src/
    ├── classes/            # Kelas domain (User, Admin, Kajur, Mahasiswa, Auth, CSRF)
    │   ├── vendor/         # Dependensi Composer (PhpSpreadsheet)
    │   └── composer.json   # Definisi dependensi PHP
    ├── config/Database.php # Wrapper koneksi SQL Server (sqlsrv)
    ├── *.php               # Halaman fitur (login, profil, input, daftar, detail, ekspor, dll)
    ├── script.js           # Animasi halaman & tab interaktif
    ├── img/                # Asset antarmuka
    ├── upload/             # Folder unggah bukti prestasi & foto profil
    └── archive/            # Salinan arsip bukti (read-only)
```

## Peran dan Modul Aplikasi
- **Mahasiswa (`Mahasiswa.php`)**
  - Mengisi profil, mengirim prestasi, memantau status pending/diterima/ditolak.
  - Melihat leaderboard pribadi serta total poin.
- **Admin (`Admin.php`)**
  - Memverifikasi kelengkapan dokumen dan memutuskan lanjut/tolak.
  - Mengunduh data, memantau daftar prestasi terlayani, dan mengelola validasi harian.
- **Kajur (`Kajur.php`)**
  - Tahap validasi akhir, menilai prestasi lintas jurusan, dan mengekspor laporan.
- **Auth & Proteksi**
  - `Auth.php` menangani login (password hashing `password_hash`/`password_verify`).
  - `CSRFToken.php` siap dipakai untuk pengamanan form apabila diperlukan.

## Prasyarat Sistem
- PHP 8.1+ dengan ekstensi `sqlsrv`, `openssl`, `mbstring`, `fileinfo` aktif.
- Microsoft SQL Server 2019+ (atau Azure SQL) dengan kredensial akses.
- Composer 2.x untuk mengelola dependensi PHP.
- Web server (Apache/Nginx) atau PHP built-in server.
- Hak tulis pada direktori `src/upload` dan `src/profile` untuk proses unggah.

## Instalasi & Konfigurasi
1. **Klon repositori**
   ```powershell
   git clone https://github.com/sayevvv/PRESPOL.git
   cd PRESPOL
   ```
2. **Instal dependensi PHP** (vendor berada di `src/classes`)
   ```powershell
   composer install --working-dir=src/classes
   ```
3. **Salin & sesuaikan konfigurasi basis data**
   - Edit `src/config/Database.php` sesuai host, instance, database, serta kredensial `sqlsrv_connect` Anda.
   - Gunakan variabel lingkungan atau mekanisme rahasia lain sebelum deploy produksi.
4. **Siapkan basis data**
   - Buat database (contoh: `PrespolTest`).
   - Impor struktur tabel, view (mis. `vw_daftar_prestasi`, `vw_PrestasiPending`, `leaderboard_view`), dan stored procedure (mis. `sp_InsertPrestasiPending`).
   - Sesuaikan nama view/procedure di kode bila berbeda.
5. **Konfigurasi hak akses folder unggah**
   - Pastikan `src/upload/**` dan `src/profile/**` dapat ditulisi user web server.
   - File `src/increment_counter.txt` serta `src/profile_increment_counter.txt` harus writable untuk penamaan file unik.
6. **Jalankan server pengembangan**
   ```powershell
   php -S localhost:8000 -t src
   ```
   Akses portal internal di `http://localhost:8000/login.php` dan landing page di `http://localhost:8000/../indexLead.php` (atau atur virtual host agar root mengarah ke `src/`).

## Pengelolaan File & Media
- Direktori utama unggahan berada di `src/upload/prestasi/*` dan `src/upload/profile/*`.
- `InputProses.php` membatasi ukuran file (default 5 MB untuk gambar/PDF, 75 MB untuk karya video) dan memvalidasi MIME type.
- Penamaan file mengikuti pola `<nim>_<jenis>_<increment>.<ext>`. File counter tersimpan di `increment_counter.txt` untuk menghindari tabrakan nama.
- Folder `src/archive/*` dapat digunakan untuk menyimpan arsip final yang tidak boleh ditimpa.

## Alur Data Prestasi
1. **Mahasiswa mengisi form** `inputPrestasi.php` dan mengunggah bukti.
2. **Handler** `InputProses.php` menyimpan file ke disk, memanggil stored procedure `sp_InsertPrestasiPending`, dan menandai status `pending`.
3. **Admin meninjau** pengajuan di `daftarPengajuan.php`/`detailPengajuan.php`, memperbarui status melalui stored procedure validasi.
4. **Kajur memutuskan** final (disetujui/ditolak) di modul yang sama.
5. **Data terverifikasi** muncul di `daftarPrestasi.php`, leaderboard, dan dapat diekspor lewat `eksporData.php`.

## Ekspor Data
- Halaman `eksporData.php` hanya dapat diakses Admin/Kajur.
- Parameter URL: `export_type` (`all` atau `recent` 30 hari), `kategori`, `jurusan`.
- `Admin::eksporData()` dan `Kajur::eksporData()` memanfaatkan `PhpSpreadsheet` untuk membuat file Excel dengan header otomatis, styling, dan filter kolom.
- Pastikan ekstensi `zip`/`zlib` aktif agar PhpSpreadsheet dapat menulis file XLSX.

## Keamanan & Praktik Baik
- Password sudah di-hash menggunakan `password_hash` (lihat `Auth.php`).
- Token CSRF tersedia (`CSRFToken.php`) – pastikan disisipkan pada setiap form kritikal sebelum produksi.
- Validasi file upload mencakup ekstensi, MIME, serta batas ukuran – tetap disarankan memindai file di sisi server.
- Aktifkan HTTPS pada server publik dan sembunyikan struktur folder `src` melalui konfigurasi web server.
- Simpan kredensial basis data di variabel lingkungan/secret manager; jangan commit data sensitif.

## Troubleshooting
| Gejala | Solusi |
| --- | --- |
| `sqlsrv_connect(): Unable to connect` | Pastikan Microsoft SQL Server Drivers for PHP terpasang dan `sqlsrv` diaktifkan di `php.ini`. Cek host/instance pada `Database.php`. |
| File upload gagal dengan pesan batas ukuran | Tingkatkan `upload_max_filesize` dan `post_max_size` di `php.ini`, lalu sesuaikan limit di `InputProses.php` bila diperlukan. |
| Spreadsheet tidak terunduh | Pastikan dependensi PhpSpreadsheet terpasang, folder `src/classes/vendor` terbaca, dan modul `zip` aktif. |
| Aset tidak muncul saat menjalankan built-in server | Gunakan opsi `-t src` atau atur VirtualHost agar document root mengarah ke folder `src`. |
| Counter file tidak bertambah | Pastikan file `increment_counter.txt` memiliki izin tulis. Hapus cache OPcache jika menggunakan server produksi. |

## Kontribusi & Roadmap
- Dokumentasikan skema database (diagram ERD, view, prosedur) agar onboarding developer lebih cepat.
- Tambahkan pengujian otomatis (PHPUnit) untuk logika kritikal seperti `InputProses.php` dan `Auth.php`.
- Implementasikan notifikasi (email/WhatsApp) ketika status pengajuan berubah.
- Pertimbangkan pemisahan lapisan API sehingga frontend dapat dikembangkan ulang dengan framework modern (React/Vue) tanpa mengubah backend terverifikasi.

Selamat berkontribusi! Jika menemukan bug atau ingin menambahkan fitur, silakan buat issue/pull request di repositori ini.
