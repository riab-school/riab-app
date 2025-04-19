<?php

namespace Database\Seeders;

use App\Models\MasterGenerationList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenerationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Make until number 35
        for ($i = 1; $i <= 35; $i++) {
            MasterGenerationList::create([
                'number'      => $i,
                'name'        => "Leting $i",
                'logo'        => NULL,
                'description' => NULL,
                'year'        => 1996 + $i,
            ]);
        }
    }
}
