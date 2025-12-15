<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       \App\Models\User::create([
        'name' => 'Store Admin',
        'email' => 'admin@coffee.com',
        'password' => bcrypt('Admin123'),
        'is_admin' => true,
    ]);
    }
}
