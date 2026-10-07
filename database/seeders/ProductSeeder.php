<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
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
                'original_price' => 100000,
                'discount_percentage' => 15,
                'is_promo' => true,
                'stock' => 25,
                'category' => 'Fresh Seafood',
                'image' => 'images/products/fresh-tuna.jpg',
                'seller_name' => 'Nelayan Sejahtera',
                'location' => 'Madura',
                'rating' => 4.9,
                'variants' => [
                    ['weight' => '250g', 'price' => 45000, 'original_price' => 53000, 'discount_percentage' => 15, 'stock' => 30],
                    ['weight' => '500g', 'price' => 85000, 'original_price' => 100000, 'discount_percentage' => 15, 'stock' => 25],
                    ['weight' => '1kg', 'price' => 160000, 'original_price' => 188000, 'discount_percentage' => 15, 'stock' => 15],
                ],
            ],
            [
                'name' => 'Fresh Shrimp',
                'description' => 'Udang putih segar ukuran sedang, cocok untuk tumis, bakar, atau sup seafood.',
                'price' => 65000,
                'original_price' => 75000,
                'discount_percentage' => 13,
                'is_promo' => true,
                'stock' => 40,
                'category' => 'Fresh Seafood',
                'image' => 'images/products/fresh-shrimp.jpg',
                'seller_name' => 'Laut Makmur',
                'location' => 'Surabaya',
                'rating' => 4.7,
                'variants' => [
                    ['weight' => '250g', 'price' => 35000, 'original_price' => 40000, 'discount_percentage' => 13, 'stock' => 45],
                    ['weight' => '500g', 'price' => 65000, 'original_price' => 75000, 'discount_percentage' => 13, 'stock' => 40],
                    ['weight' => '1kg', 'price' => 120000, 'original_price' => 138000, 'discount_percentage' => 13, 'stock' => 20],
                ],
            ],
            [
                'name' => 'Fresh Snapper',
                'description' => 'Ikan kakap merah segar dengan daging lembut. Ideal untuk goreng, kukus, atau bakar.',
                'price' => 70000,
                'original_price' => 80000,
                'discount_percentage' => 12,
                'is_promo' => true,
                'stock' => 20,
                'category' => 'Fresh Seafood',
                'image' => 'images/products/fresh-snapper.jpg',
                'seller_name' => 'Pesisir Rasa',
                'location' => 'Lamongan',
                'rating' => 4.8,
                'variants' => [
                    ['weight' => '500g', 'price' => 70000, 'original_price' => 80000, 'discount_percentage' => 12, 'stock' => 20],
                    ['weight' => '1kg', 'price' => 130000, 'original_price' => 148000, 'discount_percentage' => 12, 'stock' => 12],
                ],
            ],
            [
                'name' => 'Fresh Squid',
                'description' => 'Cumi segar kondisi bersih, siap olah untuk calamari, tumis hitam, atau bakar.',
                'price' => 75000,
                'original_price' => 85000,
                'discount_percentage' => 12,
                'is_promo' => true,
                'stock' => 35,
                'category' => 'Fresh Seafood',
                'image' => 'images/products/fresh-squid.jpg',
                'seller_name' => 'Bahari Food',
                'location' => 'Gresik',
                'rating' => 4.6,
                'variants' => [
                    ['weight' => '250g', 'price' => 40000, 'original_price' => 45000, 'discount_percentage' => 12, 'stock' => 40],
                    ['weight' => '500g', 'price' => 75000, 'original_price' => 85000, 'discount_percentage' => 12, 'stock' => 35],
                    ['weight' => '1kg', 'price' => 140000, 'original_price' => 159000, 'discount_percentage' => 12, 'stock' => 18],
                ],
            ],
            [
                'name' => 'Smoked Milkfish',
                'description' => 'Bandeng asap khas Pesisir dengan bumbu tradisional, siap santap setelah dipanaskan.',
                'price' => 80000,
                'original_price' => 95000,
                'discount_percentage' => 16,
                'is_promo' => true,
                'stock' => 50,
                'category' => 'Processed Seafood',
                'image' => 'images/products/smoked-milkfish.jpg',
                'seller_name' => 'Dapur Pesisir',
                'location' => 'Sidoarjo',
                'rating' => 4.9,
                'variants' => [
                    ['weight' => '250g', 'price' => 45000, 'original_price' => 54000, 'discount_percentage' => 16, 'stock' => 55],
                    ['weight' => '500g', 'price' => 80000, 'original_price' => 95000, 'discount_percentage' => 16, 'stock' => 50],
                ],
            ],
            [
                'name' => 'Fish Floss',
                'description' => 'Abon ikan lembut dengan rasa gurih manis, tanpa pengawet buatan. Cocok untuk lauk praktis.',
                'price' => 25000,
                'original_price' => 30000,
                'discount_percentage' => 17,
                'is_promo' => true,
                'stock' => 60,
                'category' => 'Processed Seafood',
                'image' => 'images/products/fish-floss.jpg',
                'seller_name' => 'UMKM Bahari',
                'location' => 'Pasuruan',
                'rating' => 4.5,
                'variants' => [
                    ['weight' => '100g', 'price' => 25000, 'original_price' => 30000, 'discount_percentage' => 17, 'stock' => 60],
                    ['weight' => '250g', 'price' => 55000, 'original_price' => 66000, 'discount_percentage' => 17, 'stock' => 35],
                ],
            ],
            [
                'name' => 'Seafood Crackers',
                'description' => 'Kerupuk seafood renyah berbahan ikan dan udang pilihan, camilan khas nelayan.',
                'price' => 30000,
                'original_price' => 38000,
                'discount_percentage' => 21,
                'is_promo' => true,
                'stock' => 80,
                'category' => 'Processed Seafood',
                'image' => 'images/products/seafood-crackers.jpg',
                'seller_name' => 'Laut Makmur',
                'location' => 'Surabaya',
                'rating' => 4.7,
                'variants' => [
                    ['weight' => '200g', 'price' => 30000, 'original_price' => 38000, 'discount_percentage' => 21, 'stock' => 80],
                    ['weight' => '500g', 'price' => 65000, 'original_price' => 82000, 'discount_percentage' => 21, 'stock' => 45],
                ],
            ],
            [
                'name' => 'Spicy Squid Sambal',
                'description' => 'Sambal cumi pedas gurih dengan minyak kelapa pilihan. Tahan lama dan praktis.',
                'price' => 35000,
                'original_price' => 42000,
                'discount_percentage' => 17,
                'is_promo' => true,
                'stock' => 45,
                'category' => 'Processed Seafood',
                'image' => 'images/products/spicy-squid-sambal.jpg',
                'seller_name' => 'Pesisir Rasa',
                'location' => 'Lamongan',
                'rating' => 4.8,
                'variants' => [
                    ['weight' => '150g', 'price' => 35000, 'original_price' => 42000, 'discount_percentage' => 17, 'stock' => 45],
                    ['weight' => '300g', 'price' => 60000, 'original_price' => 72000, 'discount_percentage' => 17, 'stock' => 28],
                ],
            ],
        ];

        foreach ($products as $productData) {
            $variants = $productData['variants'] ?? [];
            unset($productData['variants']);

            $product = Product::updateOrCreate(
                ['name' => $productData['name']],
                $productData
            );

            foreach ($variants as $variantData) {
                ProductVariant::updateOrCreate(
                    ['product_id' => $product->id, 'weight' => $variantData['weight']],
                    $variantData
                );
            }
        }
    }
}
