<?php

namespace Database\Seeders;

use App\Models\Subcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $Subcategories = [
            ['id' => 1,'category_id'=>1, 'name' => 'zif twil'],
            ['id' => 2,'category_id'=>1, 'name' => 'zif 9sir'],
        ];
        foreach ($Subcategories as $Subcategory) {
            Subcategory::create($Subcategory);
        }
    }
}
