<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Province;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = fopen(base_path("database/data-wilayah/provinces.csv"), "r");

        $firstLine = true;
        while (($data = fgetcsv($file, 0, ",")) !== FALSE) {
            if (!$firstLine) {
                Province::insert([
                    "id" => $data['0'],
                    "name" => $data['1']
                ]);    
            }
            $firstLine = false;
        }
   
        fclose($file);  
    }
}
