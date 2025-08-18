<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Logic to seed products into the database
        Product::create(['name' => 'Smartphone', 'category_id' => 1, 'brand_id' => 1, 'price' => 699.99]);
        Product::create(['name' => 'Laptop', 'category_id' => 1, 'brand_id' => 2, 'price' => 1299.99]);
        Product::create(['name' => 'Novel', 'category_id' => 2, 'brand_id' => 3, 'price' => 19.99]);
    }
}
