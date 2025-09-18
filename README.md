# SIPEKA - Sistem Penilaian Kinerja Pegawai


## 📌 Tentang Proyek

**SIPEKA** (Sistem Penilaian Kinerja Pegawai) adalah aplikasi web yang dirancang untuk mengelola dan mengotomatiskan proses penilaian pegawai teladan dan ketua tim teladan di lingkungan perusahaan. Aplikasi ini dibangun untuk menggantikan metode manual (seperti Google Forms atau Excel), menyediakan alur kerja yang terstruktur, aman, dan transparan.

Proyek ini dibangun menggunakan **Laravel 12** dan **Tailwind CSS**, dengan fokus pada arsitektur multi-peran dan proses bisnis yang dapat disesuaikan.

---

## ✨ Fitur Utama

Aplikasi ini membagi fungsionalitas berdasarkan empat peran utama:

### 👤 Admin (Super User)
- **Manajemen User:** CRUD penuh untuk semua akun pengguna (`Admin`, `Kepala BPS`, `Bagian Umum`, `Pegawai`).
- **Manajemen Periode:** Mengatur periode penilaian (misal: Triwulan IV 2025) dan mengontrol statusnya (`Active`, `Finished`, `Published`).
- **Manajemen Konten Penilaian:**
  - Mengelola pertanyaan untuk penilaian rekan kerja (Peer-to-Peer).
  - Mengelola kriteria untuk evaluasi oleh Kepala BPS (terpisah untuk Pegawai & Ketua Tim).
  - Mengelola kriteria untuk penilaian disiplin.
- **Generate Tugas:** Membuat tugas penilaian "siapa menilai siapa" secara otomatis untuk satu periode.

### 👑 Kepala BPS (Decision Maker)
- **Evaluasi Kinerja:** Memberikan penilaian strategis berbasis kriteria kepada semua Pegawai dan Ketua Tim.
- **Rekapitulasi & Publikasi:** Mereview hasil akhir yang sudah dikalkulasi, mempublikasikan hasil secara resmi, dan mengunggah dokumen SK/Sertifikat.
- **Penilaian Rekan:** Berpartisipasi dalam menilai sesama Kepala BPS (jika dikonfigurasi).

### 📋 Bagian Umum (Data Administrator)
- **Input Nilai SKP:** Memasukkan nilai SKP bulanan untuk semua pegawai.
- **Input Nilai Disiplin:** Memasukkan nilai kedisiplinan berdasarkan kriteria yang telah ditentukan.
- **Manajemen Kriteria Disiplin:** Mengelola daftar kriteria disiplin.

### 👥 Pegawai (Partisipan)
- **Penilaian Rekan Kerja:** Memberikan penilaian (skala 1-10) kepada rekan kerja dan/atau ketua tim yang ditugaskan.
- **Melihat Progres:** Memantau tugas penilaian mana yang sudah dan belum diselesaikan.
- **Melihat Hasil Akhir:** Mengakses halaman peringkat resmi (Podium 3 Besar) setelah dipublikasikan.
- **Unduh Dokumen:** Mengunduh file SK dan Sertifikat yang relevan.
- **Profil Pengguna:** Mengelola data diri dan foto profil.

---

## 🚀 Teknologi yang Digunakan

- **Backend:** Laravel 12
- **Frontend:** Blade, Tailwind CSS, Alpine.js, Flowbite
- **Database:** MySQL
- **Manajemen Peran:** `spatie/laravel-permission`
- **Ekspor Excel:** `maatwebsite/excel`

---

## ⚙️ Instalasi & Setup Lokal

Untuk menjalankan proyek ini di lingkungan lokal, ikuti langkah-langkah berikut:

1.  **Clone repository:**
    ```bash
    git clone https://github.com/nama-anda/nama-repo.git
    cd nama-repo
    ```

2.  **Install dependensi PHP:**
    ```bash
    composer install
    ```

3.  **Install dependensi JavaScript:**
    ```bash
    npm install
    ```

4.  **Setup Environment:**
    - Salin `.env.example` menjadi `.env`.
      ```bash
      cp .env.example .env
      ```
    - Buat *application key* baru.
      ```bash
      php artisan key:generate
      ```
    - Konfigurasi koneksi database Anda di dalam file `.env`.

5.  **Jalankan Migrasi & Seeder:**
    Perintah ini akan membuat semua tabel database dan mengisi data awal (role dan user admin default).
    ```bash
    php artisan migrate:fresh --seed
    ```

6.  **Buat Symbolic Link untuk Storage:**
    ```bash
    php artisan storage:link
    ```

7.  **Jalankan Server:**
    - Buka dua terminal.
    - Di terminal pertama, jalankan Vite (compiler frontend):
      ```bash
      npm run dev
      ```
    - Di terminal kedua, jalankan server PHP:
      ```bash
      php artisan serve
      ```

8.  **Akses Aplikasi:**
    Buka browser dan kunjungi `http://127.0.0.1:8000`.

---

## 🔑 Akun Default

Setelah menjalankan `migrate:fresh --seed`, Anda bisa login menggunakan akun berikut:

-   **Role:** Admin
-   **Email:** `admin@perusahaan.com`
-   **Password:** `password123`

---

## 🎨 Palet Warna

Aplikasi ini menggunakan palet warna kustom yang didefinisikan di `tailwind.config.js`:
-   **Primary (Biru):** `#36A4E1` (`brand-blue`)
-   **Accent (Oren):** `#F28F25` (`brand-orange`)
-   **Success (Hijau):** `#74B848` (`brand-green`)
