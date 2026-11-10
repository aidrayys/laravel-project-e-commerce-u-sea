<?php

/*
|--------------------------------------------------------------------------
| Seller Center (akun demo penjual)
|--------------------------------------------------------------------------
| Kredensial penjual TIDAK disimpan di source code. Atur di file .env:
|   SELLER_USERNAME=...
|   SELLER_PASSWORD_HASH='$2y$12$...'   (gunakan tanda kutip tunggal)
| Buat hash dengan: php artisan tinker --execute="echo bcrypt('password');"
*/

return [
    'username' => env('SELLER_USERNAME'),
    'password_hash' => env('SELLER_PASSWORD_HASH'),
    'name' => env('SELLER_NAME', 'Pesisir Rasa'),
    'location' => env('SELLER_LOCATION', 'Lamongan'),
];
