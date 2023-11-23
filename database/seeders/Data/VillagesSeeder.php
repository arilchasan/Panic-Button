<?php

namespace Database\Seeders\Data;

use App\Models\Villages;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VillagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = public_path('assets/file/villages.csv');

        $data = array_map('str_getcsv', file($path));

        foreach ($data as $row) {
            if (count($row) >= 3) {
                Villages::create([
                    'id' => $row[0],
                    'district_id' => $row[1],
                    'name' => $row[2],

                ]);
            }
        }
    }
}
