<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\District;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = fopen(base_path("database/data-wilayah/districts.csv"), "r");

        $firstLine = true;
        while (($data = fgetcsv($file, 0, ",")) !== FALSE) {
            if (!$firstLine) {
                District::insert([
                    "id" => $data['0'],
                    "city_id" => $data['1'],
                    "name" => $data['2'],
                ]);
            }
            $firstLine = false;
        }

        fclose($file);
    }
}
