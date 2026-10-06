# U-Sea

**Tagline:** From the Sea, Direct to You.

U-Sea adalah marketplace seafood sederhana yang menghubungkan nelayan dan UMKM seafood lokal dengan pelanggan. Proyek ini dibuat sebagai tugas pembelajaran Laravel untuk memahami alur **Route → Controller → Model → Database → View** dengan Laravel Blade.

---

## Fitur

- Halaman beranda dengan produk unggulan (featured products)
- Daftar produk dengan pencarian nama dan penjual, serta filter kategori
- Halaman detail produk
- Keranjang belanja berbasis session (tanpa model Cart)
- Checkout dengan validasi data pelanggan
- Pembuatan pesanan (`Order`) dan item pesanan (`OrderItem`) ke database
- Pengurangan stok produk setelah checkout berhasil
- Kosongkan keranjang setelah checkout berhasil
- Halaman konfirmasi pesanan dengan nomor pesanan `#USEA-00001`

---

## Teknologi yang Digunakan

- Laravel 12
- PHP 8.2+
- MySQL
- Blade templating engine
- Eloquent ORM
- HTML, CSS, dan Vanilla JavaScript
- Session bawaan Laravel untuk keranjang

---

## Konfigurasi Database

Pastikan MySQL sudah berjalan melalui XAMPP, lalu buat database:

```sql
CREATE DATABASE IF NOT EXISTS u_sea
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
```

Buka file `.env` di root project dan sesuaikan bagian database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u_sea
DB_USERNAME=root
DB_PASSWORD=
```

> Jika file `.env` belum ada, salin dari `.env.example`:
> ```bash
> copy .env.example .env
> ```

---

## Instalasi dan Menjalankan Project

1. **Install dependency PHP**

   ```bash
   composer install
   ```

2. **Generate application key**

   ```bash
   php artisan key:generate
   ```

3. **Jalankan migrasi dan seeder**

   ```bash
   php artisan migrate --seed
   ```

   Perintah ini akan membuat tabel `products`, `orders`, dan `order_items`, serta mengisi 8 produk dummy.

4. **Jalankan server lokal**

   ```bash
   php artisan serve
   ```

   Buka browser dan akses: `http://127.0.0.1:8000`

---

## Daftar Route

| Method | URI | Nama Route | Fungsi |
|--------|-----|------------|--------|
| GET | `/` | `home` | Halaman beranda |
| GET | `/products` | `products.index` | Daftar produk + pencarian/filter |
| GET | `/products/{product}` | `products.show` | Detail produk |
| GET | `/cart` | `cart.index` | Halaman keranjang |
| POST | `/cart/add/{product}` | `cart.add` | Tambah produk ke keranjang |
| PATCH | `/cart/update/{product}` | `cart.update` | Ubah jumlah produk di keranjang |
| DELETE | `/cart/remove/{product}` | `cart.remove` | Hapus produk dari keranjang |
| GET | `/checkout` | `checkout.index` | Halaman checkout |
| POST | `/checkout` | `checkout.store` | Simpan pesanan |
| GET | `/orders/{order}` | `orders.show` | Konfirmasi/detail pesanan |

---

## Alur MVC

1. **Route** (`routes/web.php`) menerima URL dan mengarahkannya ke method Controller yang sesuai.
2. **Controller** (`ProductController` / `OrderController`) menerima request, melakukan validasi, dan memanggil Model.
3. **Model** (`Product`, `Order`, `OrderItem`) berkomunikasi dengan database melalui Eloquent ORM.
4. **Database** menyimpan data produk, pesanan, dan item pesanan.
5. Controller mengirim data ke **View** (Blade) menggunakan `return view('nama_view', compact('data'))`.
6. **View** (`resources/views/...`) menampilkan data ke browser dengan sintaks Blade.

### Contoh Alur

- Pengguna mengakses `/products`.
- `ProductController@index` menjalankan query Eloquent untuk mengambil produk sesuai pencarian/filter.
- Hasil query dikirim ke `resources/views/products/index.blade.php`.
- Blade menampilkan daftar produk dalam grid responsif.

### Alur Checkout

1. Pengguna mengisi form checkout.
2. `OrderController@store` memvalidasi input.
3. Dilakukan pengecekan stok.
4. `DB::transaction()` menjalankan:
   - Membuat record `Order`.
   - Membuat record `OrderItem` untuk setiap produk di keranjang.
   - Mengurangi stok produk.
5. Keranjang dihapus dari session.
6. Pengguna diarahkan ke halaman konfirmasi `orders.show`.

---

## Struktur File Utama

```
app/
├── Http/Controllers/ProductController.php
├── Http/Controllers/OrderController.php
├── Models/Product.php
├── Models/Order.php
└── Models/OrderItem.php

database/
├── migrations/
│   ├── 2026_10_06_061248_create_products_table.php
│   ├── 2026_10_06_061249_create_orders_table.php
│   └── 2026_10_06_061250_create_order_items_table.php
└── seeders/
    ├── DatabaseSeeder.php
    └── ProductSeeder.php

resources/views/
├── layouts/app.blade.php
├── home.blade.php
├── products/
│   ├── index.blade.php
│   ├── show.blade.php
│   └── card.blade.php
├── cart.blade.php
├── checkout.blade.php
└── orders/
    └── show.blade.php

public/images/placeholder.svg
routes/web.php
.env
```

---

## Catatan

- Tidak menggunakan React, Vue, Next.js, Inertia, atau Livewire.
- Tidak ada fitur autentikasi atau pembayaran.
- Gambar produk menggunakan URL placeholder agar tetap berfungsi tanpa upload file.
- Keranjang disimpan di session Laravel, bukan di database.

Selamat belajar Laravel! 🌊
