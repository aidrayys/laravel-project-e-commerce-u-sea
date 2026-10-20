<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoCustomerExperienceSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the seeder.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $demoEmail = 'customer.demo@usea.test';

            $user = User::updateOrCreate(
                ['email' => $demoEmail],
                [
                    'name' => 'Caca Demo',
                    'role' => 'customer',
                    'phone' => '081234567890',
                    'address' => 'Jl. Contoh No. 10, Surabaya',
                    'city' => 'Surabaya',
                    'password' => Hash::make('UseaDemo123!'),
                ]
            );

            $products = Product::inRandomOrder()->limit(3)->get();
            if ($products->count() < 3) {
                $this->command->warn('Not enough products to create demo orders.');
                return;
            }

            $demoOrders = [
                [
                    'order_number_prefix' => 'DEMO-SHIPPED',
                    'status' => 'Shipped',
                    'created_at' => Carbon::now()->subDays(3),
                    'product_index' => 0,
                    'quantity' => 2,
                ],
                [
                    'order_number_prefix' => 'DEMO-COMPLETED',
                    'status' => 'Completed',
                    'created_at' => Carbon::now()->subDays(10),
                    'product_index' => 1,
                    'quantity' => 1,
                ],
                [
                    'order_number_prefix' => 'DEMO-PROCESSING',
                    'status' => 'Processing',
                    'created_at' => Carbon::now()->subDays(1),
                    'product_index' => 2,
                    'quantity' => 3,
                ],
            ];

            foreach ($demoOrders as $demoOrder) {
                $product = $products[$demoOrder['product_index']];
                $price = $product->price;
                $quantity = $demoOrder['quantity'];
                $subtotal = $price * $quantity;
                $shipping = $subtotal >= 100000 ? 0 : 10000;
                $total = $subtotal + $shipping;

                // Use a stable demo identifier so the seeder stays idempotent
                $order = Order::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'customer_email' => $demoEmail,
                        'status' => $demoOrder['status'],
                    ],
                    [
                        'customer_name' => $user->name,
                        'customer_phone' => $user->phone,
                        'address' => $user->address,
                        'city' => $user->city,
                        'subtotal' => $subtotal,
                        'shipping' => $shipping,
                        'discount_total' => 0,
                        'total' => $total,
                        'created_at' => $demoOrder['created_at'],
                        'updated_at' => $demoOrder['created_at'],
                    ]
                );

                // Refresh order items
                $order->orderItems()->delete();
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'weight' => $product->variants->first()?->weight,
                    'price' => $price,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ]);

                // Generate tracking events
                $order->generateTrackingEvents($demoOrder['created_at']);
            }
        });

        $this->command->info('Demo customer experience seeded successfully.');
    }
}
