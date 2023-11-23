<?php

namespace Database\Seeders\Data;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = public_path('assets/file/provinces.csv');

        $data = array_map('str_getcsv', file($path));

        foreach ($data as $row) {
            if (count($row) >= 2) {
                Province::create([
                    'id' => $row[0],
                    'name' => $row[1],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]);
            }
        }
    }
}
