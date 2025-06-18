☕ Aplikasi Presensi Karyawan - Omah Kopi Mrisen
Sebuah aplikasi web modern untuk mengelola sistem kehadiran karyawan secara digital menggunakan teknologi QR Code.

📋 Sekilas Proyek
Status Proyek

Teknologi Utama

Database

✅ Selesai

Laravel 10, Tailwind CSS

MySQL

✨ Fitur Utama
Manajemen Karyawan (CRUD): Tambah, lihat, ubah, dan hapus data karyawan dengan mudah.

Generator QR Code: Membuat QR Code unik secara otomatis untuk setiap karyawan sebagai identitas digital.

Presensi via QR Code: Halaman pemindaian interaktif untuk proses absensi masuk (clock-in) dan pulang (clock-out) yang cepat dan akurat.

Dashboard Admin: Tampilan ringkasan aktivitas presensi harian secara real-time, memberikan gambaran cepat kondisi operasional.

Administrasi Kehadiran: Fitur fleksibel bagi admin untuk mencatat status khusus seperti izin, sakit, atau alpha.

Sistem Pelaporan: Laporan kehadiran harian dan bulanan yang dinamis dengan fitur filter berdasarkan periode dan individu.

Autentikasi Aman: Sistem login yang aman untuk admin menggunakan Laravel Breeze.

Desain Responsif: Tampilan yang dapat diakses dengan baik di berbagai ukuran perangkat, dari desktop hingga mobile.

🖼️ Tampilan Aplikasi
Anda bisa menambahkan screenshot aplikasi Anda di sini. Unggah gambar ke GitHub atau Imgur, lalu ganti link di bawah.

🛠️ Teknologi yang Digunakan
Kategori

Teknologi

Backend

Laravel 10, PHP 8.1

Frontend

Tailwind CSS, Blade, JavaScript (ES6)

Database

MySQL

Dependensi

simplesoftwareio/simple-qrcode, html5-qrcode

🚀 Cara Instalasi di Lokal (Bahasa Indonesia)
Berikut adalah langkah-langkah untuk menjalankan proyek ini di komputer lokal Anda.

Hal yang harus dipersiapkan:
Git

Composer

PHP v8.1 atau lebih baru

Web Server (XAMPP, Laragon, dll.)

Langkah-langkah Instalasi:
Clone repositori ini
Buka terminal atau CMD, lalu jalankan perintah:

git clone https://github.com/tugelanboto19/aplikasi-presensi-omah-kopi.git

Masuk ke folder proyek

cd aplikasi-presensi-omah-kopi

Install semua package PHP

composer install

Salin file .env

# Untuk Windows
copy .env.example .env

# Untuk MacOS / Linux
cp .env.example .env

Konfigurasi Database

Buka file .env yang baru saja Anda buat.

Sesuaikan bagian koneksi database sesuai dengan pengaturan Anda:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_absensi_omahkopi  // Ganti dengan nama database Anda
DB_USERNAME=root                // Ganti dengan username DB Anda
DB_PASSWORD=                    // Ganti dengan password DB Anda

Buat database baru di phpMyAdmin (atau sejenisnya) dengan nama yang sama seperti yang Anda tulis di DB_DATABASE.

Jalankan Perintah Artisan
Jalankan perintah ini satu per satu:

# Membuat application key
php artisan key:generate

# Menjalankan migrasi untuk membuat struktur tabel
php artisan migrate

# Menjalankan server pengembangan
php artisan serve

Catatan: Proyek ini belum memiliki seeder (data awal). Anda perlu mendaftarkan akun admin dan karyawan baru secara manual setelah instalasi.

Selesai!
Buka browser Anda dan akses alamat: http://localhost:8000/. Anda bisa mulai dengan mendaftarkan akun admin baru dari halaman registrasi.

🇬🇧 How to Install (English)
Follow these steps to get a local copy up and running.

Prerequisites:
Git

Composer

PHP v8.1+

A web server environment (XAMPP, Laragon, etc.)

Installation Steps:
Clone the repository

git clone https://github.com/tugelanboto19/aplikasi-presensi-omah-kopi.git

Navigate to the project directory

cd aplikasi-presensi-omah-kopi

Install PHP dependencies

composer install

Create your environment file

# For Windows
copy .env.example .env

# For MacOS / Linux
cp .env.example .env

Configure the database

Open the .env file.

Update the database connection details to match your local setup (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

Create a new database with the name you specified in DB_DATABASE.

Run Artisan Commands
Execute these commands sequentially:

php artisan key:generate
php artisan migrate
php artisan serve

Note: This project does not yet have a database seeder. You will need to register a new admin account and add employee data manually after installation.

Done!
Open your browser and go to http://localhost:8000/. You can start by registering a new admin account.

📜 Lisensi
Proyek ini menggunakan lisensi MIT license.
