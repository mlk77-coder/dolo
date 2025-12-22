<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        
        for ($i = 0; $i < 10; $i++) {
            $order = Order::factory()->create([
                'user_id' => $users->random()->id,
            ]);

            // Create 1-4 items per order
            $itemCount = rand(1, 4);
            $total = 0;

            for ($j = 0; $j < $itemCount; $j++) {
                $product = Product::inRandomOrder()->first();
                $quantity = rand(1, 3);
                $price = $product->discount_price ?? $product->price;
                $subtotal = $quantity * $price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }

            // Update order total
            $order->update(['total' => $total]);
        }
    }
}
