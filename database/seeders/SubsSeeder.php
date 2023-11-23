<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subscription::create([
            'subscription_name' => 'Bulanan',
            'price_installation' => 50000,
            'maintenance_price' => 50000,
            'day' => '30',
        ]);
    }
}
