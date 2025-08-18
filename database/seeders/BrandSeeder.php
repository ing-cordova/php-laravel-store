<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Logic to insert the first brands.
        Brand::create(['name' => 'Samsung']);
        Brand::create(['name' => 'Apple']);
        Brand::create(['name' => 'Sony']);
        Brand::create(['name' => 'LG']);
        Brand::create(['name' => 'Dell']);
        Brand::create(['name' => 'HP']);
        Brand::create(['name' => 'Lenovo']);
        Brand::create(['name' => 'Microsoft']);
        Brand::create(['name' => 'Google']);
        Brand::create(['name' => 'Amazon']);
        Brand::create(['name' => 'Nokia']);
        Brand::create(['name' => 'Motorola']);
        Brand::create(['name' => 'Canon']);
        Brand::create(['name' => 'Nikon']);
        Brand::create(['name' => 'Fujifilm']);
        Brand::create(['name' => 'Panasonic']);
        Brand::create(['name' => 'Bose']);
        Brand::create(['name' => 'JBL']);
        Brand::create(['name' => 'Philips']);
        Brand::create(['name' => 'Siemens']);
        Brand::create(['name' => 'Asus']);
        Brand::create(['name' => 'Acer']);
        Brand::create(['name' => 'Razer']);
        Brand::create(['name' => 'Logitech']);  
        Brand::create(['name' => 'Corsair']);
        Brand::create(['name' => 'HyperX']);
        Brand::create(['name' => 'SteelSeries']);
        Brand::create(['name' => 'Xiaomi']);
    }
}
