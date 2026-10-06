<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $products = [
            [
                'name' => 'Fresh Tuna',
                'description' => 'Tuna segar tangkap hari ini dari laut Madura. Daging merah padat dan cocok untuk sashimi atau pepes.',
                'price' => 85000,
                'stock' => 25,
                'category' => 'Fresh Seafood',
                'image' => 'https://placehold.co/600x400/0ea5e9/ffffff?text=Fresh+Tuna',
                'seller_name' => 'Nelayan Sejahtera',
                'location' => 'Madura',
            ],
            [
                'name' => 'Fresh Shrimp',
                'description' => 'Udang putih segar ukuran sedang, cocok untuk tumis, bakar, atau sup seafood.',
                'price' => 65000,
                'stock' => 40,
                'category' => 'Fresh Seafood',
                'image' => 'https://placehold.co/600x400/0284c7/ffffff?text=Fresh+Shrimp',
                'seller_name' => 'Laut Makmur',
                'location' => 'Surabaya',
            ],
            [
                'name' => 'Fresh Snapper',
                'description' => 'Ikan kakap merah segar dengan daging lembut. Ideal untuk goreng, kukus, atau bakar.',
                'price' => 70000,
                'stock' => 20,
                'category' => 'Fresh Seafood',
                'image' => 'https://placehold.co/600x400/0369a1/ffffff?text=Fresh+Snapper',
                'seller_name' => 'Pesisir Rasa',
                'location' => 'Lamongan',
            ],
            [
                'name' => 'Fresh Squid',
                'description' => 'Cumi segar kondisi bersih, siap olah untuk calamari, tumis hitam, atau bakar.',
                'price' => 55000,
                'stock' => 35,
                'category' => 'Fresh Seafood',
                'image' => 'https://placehold.co/600x400/075985/ffffff?text=Fresh+Squid',
                'seller_name' => 'Bahari Food',
                'location' => 'Gresik',
            ],
            [
                'name' => 'Smoked Milkfish',
                'description' => 'Bandeng asap khas Pesisir dengan bumbu tradisional, siap santap setelah dipanaskan.',
                'price' => 45000,
                'stock' => 50,
                'category' => 'Processed Seafood',
                'image' => 'https://placehold.co/600x400/0d9488/ffffff?text=Smoked+Milkfish',
                'seller_name' => 'Dapur Pesisir',
                'location' => 'Sidoarjo',
            ],
            [
                'name' => 'Fish Floss',
                'description' => 'Abon ikan lembut dengan rasa gurih manis, tanpa pengawet buatan. Cocok untuk lauk praktis.',
                'price' => 38000,
                'stock' => 60,
                'category' => 'Processed Seafood',
                'image' => 'https://placehold.co/600x400/14b8a6/ffffff?text=Fish+Floss',
                'seller_name' => 'UMKM Bahari',
                'location' => 'Pasuruan',
            ],
            [
                'name' => 'Seafood Crackers',
                'description' => 'Kerupuk seafood renyah berbahan ikan dan udang pilihan, camilan khas nelayan.',
                'price' => 25000,
                'stock' => 80,
                'category' => 'Processed Seafood',
                'image' => 'https://placehold.co/600x400/2dd4bf/0f172a?text=Seafood+Crackers',
                'seller_name' => 'Laut Makmur',
                'location' => 'Surabaya',
            ],
            [
                'name' => 'Spicy Squid Sambal',
                'description' => 'Sambal cumi pedas gurih dengan minyak kelapa pilihan. Tahan lama dan praktis.',
                'price' => 32000,
                'stock' => 45,
                'category' => 'Processed Seafood',
                'image' => 'https://placehold.co/600x400/f97316/ffffff?text=Spicy+Squid+Sambal',
                'seller_name' => 'Pesisir Rasa',
                'location' => 'Lamongan',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
