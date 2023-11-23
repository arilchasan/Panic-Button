<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(AdminSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SubsSeeder::class);
        $this->call(ContactSeeder::class);
        $this->call(\Database\Seeders\Data\ProvinceSeeder::class);
        $this->call(\Database\Seeders\Data\RegenciesSeeder::class);
        $this->call(\Database\Seeders\Data\DistrictSeeder::class);
        $this->call(\Database\Seeders\Data\VillagesSeeder::class);
    }
}