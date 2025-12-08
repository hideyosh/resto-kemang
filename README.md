# Resto Kemang - Laravel Application

Website restoran **Resto Kemang** yang telah dikonversi menjadi aplikasi Laravel dengan fitur lengkap.

##  Daftar Fitur

-  Homepage dengan presentasi restoran
-  Menu management (Sushi, Ramen, Wagyu, Drinks)
-  Sistem keranjang belanja (Shopping Cart)
-  Checkout pemesanan
-  Booking meja restoran
-  API RESTful untuk integrasi
-  Database SQLite
-  Interface responsif dengan Tailwind CSS

##  Setup & Installation

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & NPM (opsional, untuk build frontend)

### Instalasi

1. **Clone atau akses proyek:**
\\\ash
cd c:\Users\sudar\Downloads\resto-kemang-laravel
\\\

2. **Install dependencies:**
\\\ash
composer install
\\\

3. **Setup environment file:**
\\\ash
copy .env.example .env
php artisan key:generate
\\\

4. **Jalankan migrations:**
\\\ash
php artisan migrate
\\\

5. **Seed database dengan data menu:**
\\\ash
php artisan db:seed --class=MenuSeeder
\\\

6. **Jalankan development server:**
\\\ash
php artisan serve
\\\

Aplikasi akan berjalan di: **http://localhost:8000**

##  Struktur Folder

Lengkap dengan Models, Controllers, Migrations, Routes, dan Views.

##  API Endpoints

### Menu API
- \GET /api/menu\ - Dapatkan semua menu items
- \POST /api/menu\ - Buat menu item baru
- \GET /api/menu/{id}\ - Dapatkan detail menu item

### Order API
- \POST /api/orders\ - Buat pemesanan baru
- \GET /api/orders/{id}\ - Dapatkan detail pemesanan
- \GET /api/orders\ - Dapatkan semua pemesanan
- \PUT /api/orders/{id}\ - Update status pemesanan

### Reservation API
- \POST /api/reservations\ - Buat booking meja baru
- \GET /api/reservations/{id}\ - Dapatkan detail booking
- \GET /api/reservations\ - Dapatkan semua bookings
- \PUT /api/reservations/{id}\ - Update booking
- \DELETE /api/reservations/{id}\ - Hapus booking

##  Routes Web

- \GET /\ - Homepage
- \GET /menu\ - Halaman menu
- \GET /order/create\ - Halaman checkout
- \GET /reservation\ - Halaman booking meja

##  Technologies Used

- **Laravel 12** - PHP Framework
- **Tailwind CSS** - Styling
- **SQLite** - Database
- **Blade** - Template Engine
- **RESTful API** - JSON API

##  Status Database

 Database sudah di-setup dengan:
- 3 tables (menu_items, orders, table_reservations)
- 8 menu items default data
- Proper relationships dan validations

##  Team (Kelompok 6)

- Aditya Nur Lintang (4523210003)
- Athalla Safriali (4523210022)
- Alip Khoeril Akbar (4523210009)
- Andra Teguh (4523210017)
- Waode Fairuzh Ramadhani Somandeno (4523210111)
- Atika Dian Azzahra (4523210024)

---

**Aplikasi siap digunakan! **

Untuk menjalankan server:
\\\ash
cd c:\Users\sudar\Downloads\resto-kemang-laravel
php artisan serve
\\\

Buka browser ke: **http://localhost:8000**
