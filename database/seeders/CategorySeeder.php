<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name_en' => 'Electronics',
                'name_ar' => 'إلكترونيات',
                'slug' => 'electronics',
                'description' => 'Electronic devices and gadgets',
            ],
            [
                'name_en' => 'Clothing',
                'name_ar' => 'ملابس',
                'slug' => 'clothing',
                'description' => 'Fashion and apparel',
            ],
            [
                'name_en' => 'Home & Garden',
                'name_ar' => 'المنزل والحديقة',
                'slug' => 'home-garden',
                'description' => 'Home improvement and garden supplies',
            ],
            [
                'name_en' => 'Sports & Outdoors',
                'name_ar' => 'الرياضة والهواء الطلق',
                'slug' => 'sports-outdoors',
                'description' => 'Sports equipment and outdoor gear',
            ],
            [
                'name_en' => 'Food & Beverages',
                'name_ar' => 'طعام ومشروبات',
                'slug' => 'food-beverages',
                'description' => 'Food and beverage deals',
            ],
            [
                'name_en' => 'Beauty & Personal Care',
                'name_ar' => 'الجمال والعناية الشخصية',
                'slug' => 'beauty-personal-care',
                'description' => 'Beauty and personal care products',
            ],
            [
                'name_en' => 'Travel & Tourism',
                'name_ar' => 'السفر والسياحة',
                'slug' => 'travel-tourism',
                'description' => 'Travel packages and tourism deals',
            ],
            [
                'name_en' => 'Entertainment',
                'name_ar' => 'ترفيه',
                'slug' => 'entertainment',
                'description' => 'Entertainment and leisure activities',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
