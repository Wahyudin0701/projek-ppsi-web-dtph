<p align="center">
  <img src="public/images/logo_muarojambi.png" alt="Logo Muaro Jambi" width="120" />
</p>

<h1 align="center">Portal Pelayanan DTPH Kabupaten Muaro Jambi</h1>

<p align="center">
  <strong>Sistem Informasi Pengajuan Bantuan Alsintan & Program Bantuan Pertanian Berbasis Web</strong><br>
  <em>Dinas Tanaman Pangan dan Hortikultura (DTPH) Kabupaten Muaro Jambi</em>
</p>

---

## 📖 Deskripsi Sistem

**Portal DTPH** adalah sistem terpadu yang dirancang khusus untuk mendigitalisasi proses pelayanan publik di lingkungan Dinas Tanaman Pangan dan Hortikultura (DTPH) Kabupaten Muaro Jambi. Fokus utama aplikasi ini adalah mengelola siklus **Pengajuan Proposal Bantuan Alat dan Mesin Pertanian (Alsintan)** serta **Program Bantuan Benih/Pupuk** dari Kelompok Tani, mulai dari tahap penyerahan dokumen, survei lapangan (CPCL), hingga persetujuan Kepala Dinas, dan penerbitan Berita Acara Serah Terima (BAST).

Sistem ini memastikan transparansi, rekam jejak yang dapat diaudit, kemudahan birokrasi, serta keamanan verifikasi dokumen menggunakan sistem **Tanda Tangan Elektronik (TTE)**.

## ✨ Fitur Utama

- **Sistem Pengajuan Mandiri (Self-Service Portal)**: Kelompok Tani dapat mendaftar, melengkapi profil poktan, mengunggah SK Pengukuhan, dan memantau status pengajuan proposal secara *real-time* dari rumah.
- **Workflow Persetujuan Bertingkat (Hierarchical Approval)**: Proposal melewati verifikasi berjenjang mulai dari Admin, disposisi oleh Pimpinan, penugasan Tim Survei oleh Kepala Bidang (Kabid), hingga persetujuan akhir (SK).
- **Tanda Tangan Elektronik (TTE) Tersertifikasi**: Fitur penandatanganan dokumen BAST dan SK secara digital yang aman, meminimalisir penggunaan kertas (Paperless).
- **Sistem Disposisi & Survei (CPCL)**: Pimpinan dapat mendisposisikan proposal masuk ke bidang terkait (PSP, TP, atau Hortikultura). Kabid kemudian membentuk tim survei dan mencatat hasil survei secara digital.
- **Manajemen Inventaris Alsintan**: Melacak dan memonitor stok ketersediaan berbagai macam Alat dan Mesin Pertanian.
- **Activity Log & Audit Trail**: Merekam setiap tindakan (Siapa melakukan apa, pada jam berapa) untuk memastikan transparansi dan pertanggungjawaban data.

## 👥 Hak Akses & Aktor (Roles)

Sistem ini didukung oleh *Spatie Permission* dengan beberapa tingkatan aktor:

1. **Kelompok Tani (Petani)**: Pihak pemohon. Dapat membuat proposal, memantau *tracking* status, dan mengunduh BAST.
2. **Admin DTPH**: Pintu gerbang pertama. Memverifikasi pendaftaran akun Kelompok Tani dan memeriksa kelengkapan administrasi proposal yang baru masuk.
3. **Pimpinan (Kepala Dinas)**: Pemegang kebijakan tertinggi. Mendisposisikan proposal ke bidang yang tepat dan memberikan Keputusan Akhir (Persetujuan/Penolakan).
4. **Kepala Bidang (Kabid PSP, TP, Hortikultura)**: Menerima disposisi pimpinan, menunjuk tim survei, mengevaluasi hasil survei (CPCL), dan merekomendasikan proposal ke Pimpinan.
5. **Super Admin**: Akses penuh ke seluruh konfigurasi sistem, kelola Roles, Permissions, dan manajemen *User*.
6. **Masyarakat Umum**: Untuk fitur pengaduan publik atau informasi umum dinas.

## 🛠️ Stack Teknologi

- **Framework Backend**: [Laravel 11.x](https://laravel.com/) (PHP 8.2)
- **Database**: MySQL / MariaDB
- **Frontend / Styling**: TailwindCSS (direkomendasikan) / Bootstrap (tergantung implementasi *views* bawaan), Alpine.js / Vanilla JavaScript
- **Manajemen Hak Akses**: Spatie Laravel Permission
- **Pencatatan Aktivitas**: Spatie Laravel Activitylog
- **Server Produksi**: cPanel / Linux VPS Server

## 🚀 Panduan Instalasi (Development Lokal)

Jika Anda ingin menjalankan atau mengembangkan sistem ini di komputer lokal (localhost), ikuti langkah-langkah berikut:

### 1. Kebutuhan Sistem
- **PHP** >= 8.2
- **Composer** (untuk manajemen package PHP)
- **Node.js & NPM** (untuk kompilasi aset frontend)
- **Database MySQL** (XAMPP / Laragon)

### 2. Langkah Instalasi

1. **Clone / Download Repository**
   Buka terminal Anda dan *clone* repositori ini, lalu masuk ke foldernya:
   ```bash
   git clone <url-repo-anda>
   cd Projek_DTPH
   ```

2. **Install Dependensi Composer**
   ```bash
   composer install
   ```

3. **Install Dependensi Frontend (NPM)**
   ```bash
   npm install
   npm run build
   ```

4. **Konfigurasi Environment**
   Salin file konfigurasi bawaan dan ubah sesuaikan koneksi database Anda:
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` di teks editor, lalu ubah blok database menjadi:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_anda
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Migrasi dan Seeding Database**
   Perintah ini akan membangun struktur tabel dasar beserta data penting seperti akun Admin dan Pimpinan:
   ```bash
   php artisan migrate:fresh --seed
   ```

7. **Hubungkan Folder Storage (Penting untuk Gambar/PDF)**
   ```bash
   php artisan storage:link
   ```

8. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```
   Buka browser Anda dan kunjungi `http://localhost:8000`.

## 📜 Daftar Akun Seeder (Testing)

Jika Anda baru saja menjalankan perintah seeding di atas, sistem akan membuat beberapa akun *default* (Kata Sandi untuk semuanya adalah: **`password`**):

- **Super Admin**: `superadmin@dtph.com`
- **Admin**: `admin@dtph.com`
- **Pimpinan**: `pimpinan@dtph.go.id`
- **Kabid PSP**: `kabid.psp@dtph.go.id`
- **Kabid Tanaman Pangan**: `kabid.tp@dtph.go.id`
- **Kabid Hortikultura**: `kabid.hortikultura@dtph.com`

## 🔒 Catatan Keamanan Produksi (Hosting cPanel)

Ketika mempublikasikan aplikasi ini di *shared hosting* cPanel:
1. Pastikan Anda mengubah variabel `APP_ENV=production` dan `APP_DEBUG=false` di file `.env`.
2. Gunakan *driver log* `LOG_CHANNEL=daily` untuk mencegah pembengkakan memori server.
3. Pisahkan antara file *core* Laravel dengan *public asset* untuk menghindari kebocoran sistem. File *index.php* harus diatur agar membaca direktori inti Laravel dengan benar.

---

<p align="center">
  Dibuat dengan ❤️ untuk kemajuan Pertanian Kabupaten Muaro Jambi.
</p>
