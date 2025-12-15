<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Espresso'],
            ['name' => 'Latte'],
            ['name' => 'Cappuccino'],
            ['name' => 'Frappuccino'],
            ['name' => 'Tea'],
            ['name' => 'Pastry'], // Example non-drink category
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}