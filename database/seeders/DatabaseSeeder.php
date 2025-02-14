<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // $this->call([
            
        //     CategorySeeder::class,
        //     SubcategorySeeder::class,
        //     ProductSeeder::class,
        //     InventorySeeder::class,
        //     VariantSeeder::class,
        // ]);
        User::insert([
            'name' => 'lmhayeb',
            'email' => 'lmhayeb@gmail.com',
            'password' => Hash::make('lmhayeb@gmail.com'),
            'role' => 'admin',
        ]);

    }
}
