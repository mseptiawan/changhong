<p align="center"> <a href="https://laravel.com" target="_blank"> <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"> </a> </p>
Cara Instalasi Laravel Project
Ikuti langkah-langkah berikut untuk menjalankan proyek Laravel ini di komputer lokal Anda:

1. Jalankan XAMPP atau Software Web Server Sejenis
   Pastikan Apache dan MySQL dalam keadaan aktif.

2. Clone atau Download Project
   Letakkan folder project di dalam direktori htdocs (untuk XAMPP) atau www sesuai konfigurasi server lokal Anda.

3. Install Dependensi Frontend
   Buka terminal, arahkan ke folder project, lalu jalankan perintah berikut:
   npm install
   npm run dev
4. Install Dependensi Backend
   Buka terminal baru dan arahkan ke folder project, kemudian jalankan:
   composer install
5. Buat dan Konfigurasikan File .env
   Salin file .env.example menjadi .env:
   cp .env.example .env
   Lalu atur konfigurasi database Anda sesuai dengan database lokal yang digunakan, contohnya:
   DB_DATABASE=nama_database
   DB_USERNAME=root
   DB_PASSWORD=
6. Generate Key Aplikasi
   Jalankan perintah:
   php artisan key:generate
7. Migrasi dan Seed Database
   Jalankan:
   php artisan migrate --seed
8. Jalankan Server Laravel
   Jalankan:
   php artisan serve
   Akses aplikasi melalui:
   🔗 http://localhost:8000
9. Import Database (Jika Diperlukan)
   Jika Anda diberikan file .sql:
   Buka phpMyAdmin melalui: http://localhost/phpmyadmin
   Buat database baru sesuai nama di .env
   Pilih tab Import dan unggah file .sql yang diberikan
10. Login
    Gunakan salah satu akun berikut untuk masuk ke aplikasi:
    Email Peran Kata Sandi
    admin@gmail.com Admin password
    manager@gmail.com Manager password
    SPG01 SPG password

📚 Dokumentasi Resmi
Untuk informasi lebih lanjut, kunjungi dokumentasi resmi Laravel di:
🔗 https://laravel.com/docs
