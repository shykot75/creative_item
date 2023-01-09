<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            ['category_name' => 'Fashion'],
            ['category_name' => 'Electronics'],
            ['category_name' => 'Home Appliance'],
            ['category_name' => 'Beauty and Cosmatics'],
            ['category_name' => 'Kitchen Items'],
        ]);
    }
}
