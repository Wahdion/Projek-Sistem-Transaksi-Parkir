# Sistem Transaksi Parkir - UKK 2026

Selamat datang di repositori **Sistem Transaksi Parkir Berbasis Web**. Projek ini dikembangkan sebagai bagian dari **Uji Kompetensi Keahlian (UKK) Tahun 2026** di **SMK Negeri 1 Sukawati**.

Aplikasi ini dirancang untuk mendigitalisasi proses pencatatan kendaraan masuk dan keluar, serta penghitungan biaya parkir secara otomatis dan akurat.

---

## 🚀 Fitur Utama
- **Dashboard Statis:** Ringkasan data kendaraan yang sedang parkir dan total pendapatan.
- **Manajemen Transaksi:** Pencatatan kendaraan masuk, keluar, dan durasi parkir.
- **Kategorisasi Kendaraan:** Pengaturan tarif berbeda untuk motor, mobil, atau truk.
- **Cetak Struk:** Fitur cetak bukti parkir (opsional/sesuaikan).
- **Laporan:** Riwayat transaksi parkir harian atau bulanan.
- **Auth System:** Login untuk admin dan petugas lapangan.

## 🛠️ Tech Stack
- **Framework:** [Laravel 11/12](https://laravel.com)
- **Styling:** [Tailwind CSS](https://tailwindcss.com)
- **Database:** MySQL
- **Icons:** Heroicons / FontAwesome

## 💻 Cara Instalasi

1. **Clone repositori ini:**
   ```bash
   git clone https://github.com
   cd nama-repo
   ```

2. **Instal dependencies PHP:**
   ```bash
   composer install
   ```

3. **Instal dependencies Frontend:**
   ```bash
   npm install && npm run dev
   ```

4. **Konfigurasi Environment:**
   Salin file `.env.example` menjadi `.env` dan sesuaikan pengaturan databasenya.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Migrate & Seed Database:**
   ```bash
   php artisan migrate --seed
   ```

6. **Jalankan Aplikasi:**
   ```bash
   php artisan serve
   ```

---

## 🎓 Identitas Pengembang
- **Nama:** I Gusti Made Dion Garitna Arya Putra
- **Jurusan:** Rekayasa Perangkat Lunak (RPL)
- **Sekolah:** SMK Negeri 1 Sukawati

---
*Projek ini dibuat untuk memenuhi tugas akhir UKK 2026. © 2026.*
