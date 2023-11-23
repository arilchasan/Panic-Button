<?php

namespace Database\Seeders\Data;

use App\Models\Regencies;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = public_path('assets/file/regencies.csv');

        $data = array_map('str_getcsv', file($path));

        foreach ($data as $row) {
          if (count($row) >= 3) {
            Regencies::create([
                //'id' => $row[0],
                'id' => $row[0],
                'province_id' => $row[1],
                'name' => $row[2],

            ]);
          }
        }
    }
}
