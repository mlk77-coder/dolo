<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(3, true);
        $price = $this->faker->randomFloat(2, 10, 1000);
        $hasDiscount = $this->faker->boolean(30);
        
        return [
            'category_id' => Category::factory(),
            'name' => ucwords($name),
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1000, 9999),
            'description' => $this->faker->paragraph(),
            'sku' => 'SKU-' . strtoupper(Str::random(8)),
            'price' => $price,
            'discount_price' => $hasDiscount ? $this->faker->randomFloat(2, $price * 0.5, $price * 0.9) : null,
            'stock' => $this->faker->numberBetween(0, 100),
            'image' => 'products/product-' . $this->faker->numberBetween(1, 5) . '.jpg',
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
