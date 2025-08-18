<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Logis to insert the first categories.
        Category::create(['name' => 'Electronics']);
        Category::create(['name' => 'Books']);
        Category::create(['name' => 'Clothing']);
        Category::create(['name' => 'Home & Kitchen']);
        Category::create(['name' => 'Sports & Outdoors']);
        Category::create(['name' => 'Health & Beauty']);
        Category::create(['name' => 'Toys & Games']);
        Category::create(['name' => 'Automotive']);
        Category::create(['name' => 'Music']);
        Category::create(['name' => 'Movies & TV']);
        Category::create(['name' => 'Pet Supplies']);
        Category::create(['name' => 'Office Supplies']);
        Category::create(['name' => 'Garden & Outdoor']);
        Category::create(['name' => 'Baby Products']);
        Category::create(['name' => 'Tools & Home Improvement']);
        Category::create(['name' => 'Grocery & Gourmet Food']);
        Category::create(['name' => 'Arts & Crafts']);
        Category::create(['name' => 'Computers & Accessories']);
        Category::create(['name' => 'Jewelry']);
        Category::create(['name' => 'Video Games']);
        Category::create(['name' => 'Musical Instruments']);
        Category::create(['name' => 'Software']);
        Category::create(['name' => 'Luggage & Travel Gear']);
        Category::create(['name' => 'Handmade Products']);
        Category::create(['name' => 'Collectibles & Fine Art']);
        Category::create(['name' => 'Virtual Products']);
        Category::create(['name' => 'Seasonal Products']);
        Category::create(['name' => 'Miscellaneous']);
        Category::create(['name' => 'Specialty Foods']);
        Category::create(['name' => 'Subscription Services']);
        Category::create(['name' => 'Digital Products']);
        Category::create(['name' => 'Local Services']);
        Category::create(['name' => 'Online Courses']);
        Category::create(['name' => 'Event Tickets']);
        Category::create(['name' => 'Fitness Equipment']);
        Category::create(['name' => 'Camping & Hiking']);
        Category::create(['name' => 'Fishing & Hunting']);
        Category::create(['name' => 'Cycling']);
        Category::create(['name' => 'Photography']);
        Category::create(['name' => 'Travel Accessories']);
        Category::create(['name' => 'Smart Home Devices']);
    }
}
