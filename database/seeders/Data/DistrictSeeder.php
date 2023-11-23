<?php

namespace Database\Seeders\Data;

use App\Models\Districts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = public_path('assets/file/districts.csv');

        $data = array_map('str_getcsv', file($path));

        foreach ($data as $row) {
            if (count($row) >= 3) {
                Districts::create([
                    'id' => $row[0],
                    'regency_id' => $row[1],
                    'name' => $row[2],

                ]);
            }
        }
    }
}
