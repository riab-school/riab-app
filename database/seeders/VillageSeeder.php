<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Village;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = fopen(base_path("database/data-wilayah/villages.csv"), "r");

        $firstLine = true;
        while (($data = fgetcsv($file, 100000, ",")) !== FALSE) {
            if (!$firstLine) {
                Village::insert([
                    "id" => $data['0'],
                    "district_id" => $data['1'],
                    "name" => $data['2']
                ]);    
            }
            $firstLine = false;
        }

        fclose($file);  
    }
}
