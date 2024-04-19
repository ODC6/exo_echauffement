<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Dish;
use App\Models\Reviews;
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
        // User::factory(10)->create();

        Reviews::factory()->count(10)->create();
        User::factory()->count(10)->create();
        Dish::factory()->count(10)->create();
        Category::factory()->count(10)->create();
    }
}
