# Panduan Deployment U-Sea ke cPanel (Shared Hosting)

Panduan ini disiapkan untuk memindahkan project Laravel **U-Sea** ke hosting cPanel agar dapat diakses publik. Panduan ini **tidak** melakukan deployment otomatis dan **tidak** menyertakan credential/APP_KEY palsu. Lakukan upload dan konfigurasi hosting secara manual setelah Anda meninjau hasil audit project.

## 1. Ringkasan audit kesiapan (lokal)

| Item | Status / temuan |
|---|---|
| Framework | Laravel `12.69.3` (`php artisan --version`) |
| PHP requirement project | `^8.2` (`composer.json`) |
| PHP lokal saat audit | PHP `8.2.12` (CLI) |
| Web server cPanel | **Harus PHP 8.2+** dengan ekstensi Laravel umum: `mbstring`, `openssl`, `pdo`, `pdo_mysql`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, `curl` (sesuaikan dengan kebutuhan package). |
| Database config | Mendukung MySQL/MariaDB via `.env` (`DB_CONNECTION=mysql`). Default config aman; **jangan hardcode credential**. |
| `.env` | `.env` di-ignore (`.gitignore`), `.env.example` tersedia. **Jangan upload `.env` lokal ke folder publik**; buat `.env` production di server. |
| Storage/filesystem | Upload produk seller saat ini disimpan ke `public/images/products/` (web-accessible). Link `public/storage` → `storage/app/public` dikonfigurasi (`config/filesystems.php`), tetapi `public/storage` belum ada di lokal; jalankan `php artisan storage:link` di server jika diperlukan. |
| Public directory | `public/index.php` standar Laravel, `public/.htaccess` ada (rewrite ke front controller, proteksi index). |
| Asset compilation | Vite config ada (`resources/css/app.css`, `resources/js/app.js`), `public/build/` (manifest+assets) ada di lokal tetapi **di-ignore git** (`/public/build`). Untuk cPanel tanpa Node, **upload hasil build** (`public/build`) atau build sebelum upload. UI utama juga memakai inline CSS/layout Blade; tetap pastikan asset yang direferensikan ada. |
| Routing/URL | Tidak ditemukan hardcode `localhost/127.0.0.1` di `app/` dan `resources/views/`. URL bergantung pada `APP_URL`/helper Laravel — set `APP_URL` production dengan benar. |
| Session/cache/queue | Ada migrasi `sessions`, `cache`, `jobs` (Laravel default). `.env.example` memakai `database`; di shared hosting bisa tetap `database` **setelah migrasi aman**, atau gunakan `SESSION_DRIVER=file`, `CACHE_STORE=file`, `QUEUE_CONNECTION=sync` bila lebih sederhana. |
| Permissions | Server perlu tulis ke `storage/` dan `bootstrap/cache/`. |
| Local dev config | Jangan hapus konfigurasi lokal, jangan ganti `APP_KEY` lokal, jangan `migrate:fresh`/`db:wipe`. |

## 2. Struktur folder yang disarankan di cPanel

**Opsi A (direkomendasikan, jika bisa menaruh file di luar web root):**
```text
/home/USERNAME/
  u-sea-app/                 # SELURUH project Laravel (di luar public_html)
    app/
    bootstrap/
    config/
    database/
    resources/
    routes/
    storage/
    vendor/
    artisan
    composer.json
    composer.lock
    .env                     # .env production (BUKAN di dalam folder yang bisa diakses web langsung)
  public_html/               # web root domain/subdomain
    (isi dari folder public/ U-Sea, atau subdomain root yang menunjuk ke public)
```
Lalu sesuaikan `public_html/index.php` agar menunjuk ke `u-sea-app` (lihat bagian 4).

**Opsi B (umum di cPanel, jika tidak bisa di luar public_html):**
```text
/home/USERNAME/u-sea-app/    # project Laravel
/home/USERNAME/public_html/  # isi dari public/
```
Pastikan `.env`, `app/`, `config/`, `vendor/`, `storage/` **tidak** berada di dalam `public_html`. Lindungi dengan `.htaccess`/permission bila struktur memaksa; Opsi A lebih aman.

**Opsi C (subdomain/addon domain document root):**
Atur Document Root subdomain/addon domain langsung ke folder `.../u-sea-app/public` (jika cPanel mengizinkan). Ini paling sederhana dan aman untuk Laravel.

## 3. Persiapan sebelum upload

1. **Backup lokal** (file project + database lokal). Jangan hapus database lokal.
2. Pastikan **APP_KEY lokal tidak diubah** tanpa alasan.
3. **Build asset** (jika ingin UI/Vite konsisten):
   ```bash
   npm ci
   npm run build
   ```
   Lalu sertakan folder `public/build/` saat upload (meski di-ignore git).
4. Bersihkan cache lokal yang tidak perlu di-upload (opsional, aman):
   ```bash
   php artisan optimize:clear
   ```
5. Siapkan daftar file/folder yang **tidak** di-upload atau ditangani khusus:
   - Jangan upload `.env` lokal.
   - `node_modules/` tidak perlu di server produksi.
   - `vendor/` bisa di-upload jika versi PHP/OS kompatibel, atau jalankan `composer install --no-dev` di server.
   - `tests/` boleh ada, tapi tidak wajib di produksi.
   - Folder development IDE/cache (`.idea`, `.vscode`, dll.) tidak perlu.

## 4. Upload project

1. Upload source project ke lokasi yang dipilih (File Manager cPanel / FTP / Git deploy jika tersedia).
2. Letakkan **isi folder `public/`** ke document root web (`public_html` atau document root subdomain), **atau** arahkan document root ke `.../public`.
3. Jika memakai Opsi A/B (memisahkan `public`), edit `index.php` di document root agar path benar. Contoh pola (sesuaikan `USERNAME` dan nama folder aktual; **jangan pakai path palsu tanpa menyesuaikan server**):
   ```php
   // Contoh penyesuaian path — SESUAIKAN dengan lokasi nyata di server Anda
   require __DIR__.'/../u-sea-app/vendor/autoload.php';
   $app = require_once __DIR__.'/../u-sea-app/bootstrap/app.php';
   ```
   File referensi lokal: `public/index.php` (standar Laravel, saat ini relatif `__DIR__.'/../...'`).
4. Pastikan `public/.htaccess` ikut ter-upload (berisi rewrite ke `index.php`). Di cPanel/Apache, mod_rewrite biasanya aktif.

## 5. Konfigurasi database MySQL cPanel

1. Buat database MySQL/MariaDB dan user database di cPanel (MySQL® Databases). **Gunakan credential asli dari cPanel Anda**; jangan isi credential palsu ke `.env` production.
2. Beri user hak akses ke database.
3. Catat: host (sering `localhost` di cPanel, tapi bisa berbeda), nama DB, username, password, port (umumnya `3306`).

## 6. Konfigurasi `.env` production (di server)

Buat file `.env` di root project Laravel **di server** (di luar document root). Contoh nilai yang harus disesuaikan (**placeholder, bukan credential asli**):

```dotenv
APP_NAME="U-Sea"
APP_ENV=production
APP_KEY=base64:... # gunakan key production yang valid; jangan mengubah sembarangan setelah data terenkripsi/terkait tersimpan
APP_DEBUG=false
APP_URL=https://domain-anda.example

APP_LOCALE=id
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=id_ID

LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=warning

DB_CONNECTION=mysql
DB_HOST=localhost            # atau host MySQL dari cPanel
DB_PORT=3306
DB_DATABASE=cpaneluser_usea  # placeholder
DB_USERNAME=cpaneluser_usea  # placeholder
DB_PASSWORD=********         # placeholder

SESSION_DRIVER=file          # aman/sederhana di shared hosting; atau database jika tabel sessions sudah dimigrasi
SESSION_LIFETIME=120
SESSION_ENCRYPT=false

CACHE_STORE=file             # atau database jika tabel cache tersedia
QUEUE_CONNECTION=sync        # hindari worker queue di shared hosting kecuali sudah dikonfigurasi

FILESYSTEM_DISK=local
MAIL_MAILER=log              # ganti ke SMTP produksi bila siap (credential asli dari penyedia mail)
```

**Catatan penting:**
- `APP_DEBUG=false` wajib di production.
- `APP_ENV=production` dan `APP_URL` harus domain HTTPS production.
- **Jangan mengekspos `.env` ke public**. Pastikan `.env` tidak berada di `public_html`.
- **Jangan mengubah `APP_KEY`** tanpa alasan yang jelas; perubahan dapat merusak data terenkripsi/sesi lama.
- Jika menggunakan `SESSION_DRIVER/CACHE_STORE/QUEUE_CONNECTION=database`, pastikan tabel terkait ada (migrasi `sessions`, `cache`, `jobs` tersedia di project).

## 7. Composer install (server)

Jika server memiliki SSH/Terminal dan Composer dengan PHP 8.2+:
```bash
cd /home/USERNAME/u-sea-app
composer install --no-dev --optimize-autoloader
```

Jika tidak ada SSH/Composer: upload folder `vendor/` yang dihasilkan dari environment kompatibel (PHP 8.2+, dependensi sama), dengan risiko kompatibilitas — metode SSH/Composer di server lebih aman.

## 8. Storage link, permission, dan folder runtime

```bash
php artisan storage:link
```
(Jika symlink tidak diizinkan, buat solusi manual sesuai kebijakan hosting, atau pastikan file public yang dibutuhkan tersedia.)

Pastikan permission tulis (umum di cPanel: 755 folder, 644 file; `storage`/`bootstrap/cache` harus writable oleh PHP):
```text
storage/            (writable, recursive)
bootstrap/cache/    (writable)
```

## 9. Migration production yang aman

**Jalankan hanya jika database production memang siap dan sudah di-backup.**
```bash
php artisan migrate --force
```
- **Jangan** `migrate:fresh`, **jangan** `db:wipe`.
- Migration klik produk yang ditambahkan: `2026_11_06_000001_add_click_to_products_table.php` (defensif/backfill `clicks`→`click`). Tetap verifikasi schema setelah migrate.

## 10. Optimize commands (production)

```bash
php artisan config:cache
php artisan route:cache   # opsional; pastikan tidak ada route closure bermasalah
php artisan view:cache
php artisan optimize
```
Jika ada perubahan `.env`/config setelah cache: `php artisan optimize:clear` lalu cache ulang.

## 11. Checklist pengujian setelah deployment

- [ ] `https://domain` membuka homepage tanpa error 500.
- [ ] Aset CSS/JS/gambar termuat (cek Network/Console browser).
- [ ] Login/register customer berfungsi (Breeze routes).
- [ ] Product listing (`/products`) dan filter/search tampil.
- [ ] **Klik produk dari homepage/listing membuka detail** (`/products/{id}`) dan **klik bertambah 1 per kunjungan detail** (cek dashboard/statistik/DB); listing tidak menambah klik.
- [ ] Add to cart, update/remove cart, checkout, order creation, order detail, my orders.
- [ ] Seller login/dashboard/CRUD produk & kategori (sesuai kredensial/logic existing).
- [ ] Admin login/authorization/dashboard statistik (users/products/categories/clicks/orders/sales).
- [ ] Upload gambar produk (folder `public/images/products` writable) dan tampilan gambar.
- [ ] `APP_DEBUG=false`, tidak ada stack trace sensitif.
- [ ] `.env` tidak bisa diakses via URL.
- [ ] HTTPS aktif; `APP_URL` dan session/cookie sesuai domain.
- [ ] Jalankan cek log: `storage/logs/laravel.log` jika ada error.

## 12. Batasan penting

- Tidak ada deployment otomatis dalam panduan ini.
- Tidak ada credential/APP_KEY palsu yang dimasukkan ke project.
- Database lokal tidak dihapus; tidak ada operasi destruktif.
- Website **belum dapat diklaim online** sampai Anda benar-benar upload, konfigurasi, migrate aman, dan menguji di domain publik.
