<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // Default password: password
            'role' => 'admin',
        ]);

        // Create regular users
        User::factory()->count(5)->create(['role' => 'user']);

        // Seed other entities
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            DealSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
