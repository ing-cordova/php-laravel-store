<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrderStatus;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderStatus::create(['status' => 'PENDING']);
        OrderStatus::create(['status' => 'PROCESSING']);
        OrderStatus::create(['status' => 'PAID']);
        OrderStatus::create(['status' => 'SHIPPED']);
        OrderStatus::create(['status' => 'DELIVERED']);
        OrderStatus::create(['status' => 'COMPLETED']);
        OrderStatus::create(['status' => 'CANCELLED']);
    }
}
