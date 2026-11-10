# U-Sea

**Tagline:** From the Sea, Direct to You.

U-Sea adalah marketplace seafood berbasis web yang menghubungkan nelayan dan UMKM seafood lokal dengan pelanggan. Proyek ini dibangun dengan Laravel menggunakan alur **Route → Controller → (Service) → Model → Database → View** dengan Blade.

---

## Daftar Isi

1. [Fitur](#fitur)
2. [Teknologi yang Digunakan](#teknologi-yang-digunakan)
3. [Kebutuhan Sistem](#kebutuhan-sistem)
4. [Instalasi](#instalasi)
5. [Konfigurasi Environment](#konfigurasi-environment)
6. [Database](#database)
7. [Menjalankan Aplikasi](#menjalankan-aplikasi)
8. [Menjalankan Pengujian](#menjalankan-pengujian)
9. [Daftar Route](#daftar-route)
10. [Arsitektur & Alur Program](#arsitektur--alur-program)
11. [Struktur Proyek](#struktur-proyek)
12. [Keamanan](#keamanan)
13. [Catatan](#catatan)

---

## Fitur

### Pelanggan (customer)
- Beranda: hero carousel (4 slide, otomatis), section **Promo Hari Ini**, produk dengan filter kategori (JavaScript), dan section nilai/keunggulan.
- Daftar produk dengan pencarian (nama, penjual, kategori), filter kategori, dan paginasi (12 per halaman).
- Detail produk dengan pilihan varian (berat/harga) dan penghitung klik produk.
- Keranjang belanja berbasis session: tambah, ubah jumlah, hapus.
- Checkout (wajib login) dengan validasi data pelanggan, pengecekan stok, dan gratis ongkir untuk subtotal ≥ Rp100.000 (di bawahnya ongkir Rp10.000).
- Invoice/konfirmasi pesanan dengan nomor `#USEA-00001` dan riwayat status pengiriman (tracking).
- Halaman **Pesanan Saya** dengan filter status.
- Registrasi, login, logout, lupa/reset password, verifikasi email (Laravel Breeze).
- Edit profil (nama, email, telepon, kota, alamat), ganti password, hapus akun.

### Penjual (Seller Center)
- Login penjual terpisah (`/seller/login`), kredensial dari `.env`.
- Dashboard penjual: statistik produk, pesanan, pelanggan, dan klik produk.
- CRUD produk (dengan upload gambar, promo/diskon, stok).
- CRUD kategori (kategori yang masih memiliki produk tidak dapat dihapus).

### Admin
- Dashboard admin (`/admin/dashboard`) untuk user dengan `role = admin`.

---

## Teknologi yang Digunakan

| Komponen | Teknologi | Kegunaan |
|---|---|---|
| Bahasa | PHP 8.2+ | Logika backend |
| Framework | Laravel 12 | Routing, MVC, validasi, session, ORM |
| Database | MySQL (XAMPP) | Penyimpanan data; SQLite in-memory untuk pengujian |
| ORM | Eloquent | Model & relasi database |
| Template | Blade | Tampilan (views & components) |
| Autentikasi | Laravel Breeze 2 | Login/registrasi/reset password pelanggan |
| Frontend | HTML, CSS kustom, Vanilla JavaScript | UI utama (carousel, filter, modal) |
| Frontend (Breeze) | Tailwind CSS 3, Alpine.js, Vite | Halaman bawaan Breeze (auth & profil) |
| Testing | PHPUnit 11 | Feature & unit test |
| Dev tools | Composer, NPM, Laravel Pint, Pail, Tinker | Dependency, code style, log, REPL |

---

## Kebutuhan Sistem

- PHP ≥ 8.2 (ekstensi: pdo_mysql, mbstring, openssl, fileinfo, sqlite3 untuk testing)
- Composer 2
- MySQL / MariaDB (mis. dari XAMPP)
- Node.js & NPM (hanya untuk build asset Breeze/Tailwind)

---

## Instalasi

```bash
# 1. Install dependency PHP
composer install

# 2. Buat file environment
copy .env.example .env        # Windows
# cp .env.example .env        # Linux/macOS

# 3. Generate application key (hanya untuk instalasi baru!)
php artisan key:generate

# 4. Install & build asset frontend (Breeze/Tailwind)
npm install
npm run build
```

> ⚠️ Jangan menjalankan `php artisan key:generate` pada instalasi yang sudah berisi data, karena akan mengganti `APP_KEY`.

---

## Konfigurasi Environment

Atur bagian berikut di file `.env`:

```env
APP_NAME=U-Sea
APP_URL=http://localhost/u-sea/public

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u_sea
DB_USERNAME=root
DB_PASSWORD=
```

### Akun Seller Center

Kredensial penjual **tidak disimpan di source code**. Isi di `.env` (file ini tidak di-commit ke Git):

```env
SELLER_USERNAME=nama_pengguna_penjual
SELLER_PASSWORD_HASH='$2y$12$....'   # gunakan tanda kutip tunggal
SELLER_NAME="Pesisir Rasa"
SELLER_LOCATION=Lamongan
```

Buat hash password dengan:

```bash
php artisan tinker --execute="echo bcrypt('password-anda');"
```

Setelah mengubah `.env`, jalankan `php artisan config:clear`.

### Email

Fitur reset password & verifikasi email memakai konfigurasi `MAIL_*`. Untuk pengembangan lokal dapat memakai `MAIL_MAILER=log` (email ditulis ke `storage/logs/laravel.log`).

---

## Database

1. Jalankan MySQL melalui XAMPP Control Panel, lalu buat database:

   ```sql
   CREATE DATABASE IF NOT EXISTS u_sea
     CHARACTER SET utf8mb4
     COLLATE utf8mb4_unicode_ci;
   ```

2. Jalankan migrasi dan seeder (instalasi baru):

   ```bash
   php artisan migrate --seed
   ```

   Seeder mengisi kategori (`CategorySeeder`), akun contoh admin & pelanggan (`UserSeeder`), dan 8 produk beserta varian (`ProductSeeder`).

### Tabel utama & relasi

| Tabel | Keterangan | Relasi |
|---|---|---|
| `users` | Pelanggan & admin (`role`: customer/admin/seller), profil | 1 user → banyak `orders` |
| `categories` | Kategori produk | 1 kategori → banyak `products` |
| `products` | Produk, harga, promo, stok, rating, klik | banyak `product_variants`, banyak `order_items` |
| `product_variants` | Varian berat dengan harga & stok sendiri | milik 1 `product` |
| `orders` | Header pesanan: data pelanggan, subtotal, ongkir, total, status | 1 order → banyak `order_items`, banyak `order_tracking_events` |
| `order_items` | Detail item pesanan (harga saat pembelian) | milik 1 `order`, 1 `product`, opsional 1 `product_variant` |
| `order_tracking_events` | Riwayat status pengiriman | milik 1 `order` |

---

## Menjalankan Aplikasi

**Opsi A — XAMPP (Apache):** letakkan proyek di `C:\xampp\htdocs\u-sea`, jalankan Apache & MySQL, lalu buka `http://localhost/u-sea/public`.

**Opsi B — Server bawaan Laravel:**

```bash
php artisan serve
```

Buka `http://127.0.0.1:8000`.

---

## Menjalankan Pengujian

```bash
php artisan test
```

Pengujian memakai SQLite in-memory (lihat `phpunit.xml`), sehingga **tidak menyentuh database MySQL**. Kredensial seller untuk test diatur di `tests/TestCase.php` (akun khusus test, bukan akun demo).

| File test | Cakupan |
|---|---|
| `tests/Feature/MarketplaceFlowTest.php` | Beranda, katalog, filter, detail, keranjang, checkout |
| `tests/Feature/CartCheckoutSecurityTest.php` | Validasi varian, harga dari database, stok & overselling |
| `tests/Feature/SellerAuthTest.php` | Login seller (hash, konfigurasi, session, logout) |
| `tests/Feature/SellerCategoryTest.php` | CRUD kategori seller |
| `tests/Feature/ControllerAvailabilityTest.php` | Ketersediaan halaman & proteksi route |
| `tests/Feature/Auth/*`, `ProfileTest.php` | Autentikasi & profil (Breeze) |

---

## Daftar Route

| Method | URI | Nama Route | Akses | Fungsi |
|---|---|---|---|---|
| GET | `/` | `home` | Publik | Beranda |
| GET | `/about` | `about` | Publik | Tentang U-Sea |
| GET | `/products` | `products.index` | Publik | Daftar produk + pencarian/filter |
| GET | `/products/{product}` | `products.show` | Publik | Detail produk |
| GET | `/cart` | `cart.index` | Publik | Keranjang |
| POST | `/cart/add/{product}` | `cart.add` | Publik | Tambah ke keranjang |
| PATCH | `/cart/update/{product}` | `cart.update` | Publik | Ubah jumlah |
| DELETE | `/cart/remove/{product}` | `cart.remove` | Publik | Hapus dari keranjang |
| GET/POST | `/checkout` | `checkout.index` / `checkout.store` | Login | Checkout & simpan pesanan |
| GET | `/orders/{order}` | `orders.show` | Login (pemilik/admin) | Invoice pesanan |
| GET | `/my-orders` | `orders.my` | Login | Riwayat pesanan |
| GET/PATCH/DELETE | `/profile` | `profile.*` | Login | Kelola profil |
| GET/POST | `/seller/login` | `seller.login*` | Publik | Login penjual |
| POST | `/seller/logout` | `seller.logout` | Penjual | Logout penjual |
| GET | `/seller/dashboard` | `seller.dashboard` | Penjual | Dashboard penjual |
| resource | `/seller/products` | `seller.products.*` | Penjual | CRUD produk |
| resource | `/seller/categories` | `seller.categories.*` | Penjual | CRUD kategori |
| GET | `/admin/dashboard` | `admin.dashboard` | Admin | Dashboard admin |

Route autentikasi Breeze (`/login`, `/register`, `/forgot-password`, dll.) ada di `routes/auth.php`. Daftar lengkap: `php artisan route:list`.

---

## Arsitektur & Alur Program

1. **Route** (`routes/web.php`) menerima URL dan mengarahkannya ke method Controller; middleware (`auth`, `seller.auth`, `admin`) membatasi akses.
2. **Controller** menerima request dan memvalidasi input (`$request->validate()`).
3. **Service** (`app/Services/CartService.php`) menyimpan logika bisnis keranjang yang dipakai bersama (harga terkini, ongkir, validasi varian).
4. **Model** (Eloquent) berkomunikasi dengan database dan mendefinisikan relasi.
5. **View** (Blade) menampilkan data ke browser.

### Struktur data keranjang (session)

```php
// key = product_id
session('cart') = [
    3 => ['name' => 'Fresh Tuna', 'quantity' => 2, 'variant_id' => 7, 'price' => 85000, ...],
];
```

Harga di session hanya untuk tampilan; total selalu dihitung ulang dari database oleh `CartService::summarize()`.

### Alur Checkout (`OrderController@store`)

1. Validasi input pelanggan.
2. Mulai `DB::transaction()`.
3. Ambil produk/varian dengan `lockForUpdate()` (mencegah dua checkout menjual stok yang sama).
4. Validasi varian milik produk dan stok mencukupi; jika gagal → `CheckoutException` → rollback.
5. Simpan `Order` dan `OrderItem` dengan **harga terkini dari database**.
6. Kurangi stok varian/produk, buat tracking event awal, commit.
7. Kosongkan keranjang, arahkan ke invoice `orders.show`.

---

## Struktur Proyek

```
app/
├── Exceptions/CheckoutException.php     # Error bisnis saat checkout (memicu rollback)
├── Http/
│   ├── Controllers/                     # Page, Product (katalog+keranjang), Order, Profile,
│   │                                    # SellerAuth, SellerDashboard, SellerProduct,
│   │                                    # SellerCategory, AdminDashboard, Auth/* (Breeze)
│   └── Middleware/                      # SellerAuth, Admin
├── Models/                              # User, Product, ProductVariant, Category,
│                                        # Order, OrderItem, OrderTrackingEvent, ProductCategory
└── Services/CartService.php             # Logika keranjang & perhitungan harga
config/seller.php                        # Konfigurasi akun Seller Center (dari .env)
database/
├── migrations/                          # Skema tabel
└── seeders/                             # Category, User, Product, DemoCustomerExperience
public/
├── css/home.css                         # Style khusus beranda (hero, promo)
└── images/products/                     # Gambar produk
resources/views/
├── layouts/app.blade.php                # Layout utama + CSS global
├── components/                          # navbar, footer, komponen Breeze
├── home.blade.php, about.blade.php, cart.blade.php, checkout.blade.php
├── products/  orders/  seller/  admin/  auth/  profile/
routes/
├── web.php                              # Route aplikasi
└── auth.php                             # Route autentikasi Breeze
tests/Feature/                           # Feature test (lihat tabel di atas)
DEPLOYMENT_CPANEL.md                     # Panduan deploy ke cPanel
```

---

## Keamanan

- **CSRF**: semua form POST/PATCH/DELETE memakai `@csrf`.
- **SQL Injection**: query memakai Eloquent/Query Builder dengan parameter binding.
- **XSS**: output Blade memakai `{{ }}` (auto-escape).
- **Password**: pelanggan memakai hashing bawaan Laravel (bcrypt); password penjual diverifikasi dengan `Hash::check` terhadap hash di `.env`.
- **Session fixation**: session ID diregenerasi setelah login penjual.
- **Otorisasi**: pelanggan hanya dapat melihat pesanan miliknya (admin dikecualikan).
- **Manipulasi harga**: `variant_id` divalidasi milik produk; total checkout dihitung dari database, bukan dari session.
- **Upload**: gambar divalidasi (`image|mimes:jpeg,png,jpg,gif,webp|max:2048`) dan disimpan dengan nama acak.
- **Rahasia**: `.env` tercantum di `.gitignore`; jangan commit kredensial.

---

## Catatan

- Tidak memakai React, Vue, Inertia, atau Livewire; UI utama memakai Blade + CSS + Vanilla JS.
- Belum ada integrasi payment gateway; pesanan dibuat dengan status `Pending`.
- Keranjang disimpan di session Laravel (bukan tabel database).
- Panduan deploy ke hosting cPanel: lihat `DEPLOYMENT_CPANEL.md`.

Selamat belajar Laravel! 🌊
