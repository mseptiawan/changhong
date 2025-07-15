<p align="center"> <a href="https://laravel.com" target="_blank"> <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"> </a> </p>
Cara Instalasi Laravel Project
Ikuti langkah-langkah berikut untuk menjalankan proyek Laravel ini di komputer lokal Anda:

1. Jalankan XAMPP atau Software Web Server Sejenis
   Pastikan Apache dan MySQL telah aktif.

2. Clone atau Download Project Ini
   Letakkan folder project di dalam direktori htdocs (XAMPP) atau www sesuai konfigurasi server lokal Anda.

3. Install Dependensi Frontend
   Buka terminal, arahkan ke folder project, lalu jalankan:

npm install
npm run dev 4. Install Dependensi Backend
Buka terminal baru, arahkan ke folder project, lalu jalankan:
composer install 5. Buat dan Konfigurasikan File .env
Salin file .env.example menjadi .env:

cp .env.example .env
Lalu atur konfigurasi database Anda sesuai dengan database yang akan digunakan.

6. Generate Key Aplikasi
   php artisan key:generate
7. Migrasi dan Seed Database
   php artisan migrate --seed
8. Jalankan Server Laravel
   php artisan serve
9. Import Database (Jika Perlu)
   Jika Anda diberikan file .sql:

Buka phpMyAdmin melalui http://localhost/phpmyadmin

Buat database baru dengan nama sesuai .env

Import file .sql melalui tab Import

10. Login
    Setelah semuanya selesai, Anda bisa login menggunakan akun yang tersedia.

Dokumentasi Resmi
Untuk informasi lebih lanjut, kunjungi dokumentasi resmi Laravel di:
🔗 https://laravel.com/docs
