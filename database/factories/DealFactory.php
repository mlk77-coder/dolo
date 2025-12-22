<?php

namespace Database\Factories;

use App\Models\Deal;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories.Factory<\App\Models\Deal>
 */
class DealFactory extends Factory
{
    protected $model = Deal::class;

    public function definition(): array
    {
        $original = $this->faker->randomFloat(2, 50, 500);
        $discounted = $original * $this->faker->randomFloat(2, 0.5, 0.9);
        $percentage = $original > 0 ? round((($original - $discounted) / $original) * 100, 2) : 0;

        return [
            'merchant_id' => null,
            'category_id' => Category::factory(),
            'title_ar' => 'عرض ' . $this->faker->words(2, true),
            'title_en' => $this->faker->catchPhrase(),
            'original_price' => $original,
            'discounted_price' => $discounted,
            'discount_percentage' => $percentage,
            'description' => $this->faker->paragraph(),
            'city' => $this->faker->city(),
            'start_date' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'end_date' => $this->faker->dateTimeBetween('+1 week', '+2 months'),
            'status' => $this->faker->randomElement(['draft', 'active', 'inactive']),
            'featured' => $this->faker->boolean(30),
        ];
    }
}

