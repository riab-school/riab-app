<?php

namespace Database\Seeders;

use App\Models\MasterJuz;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterJuzSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(base_path('database/data-alquran/master_juz.json'));
        $data = json_decode($json, true);
        if (is_array($data)) {
            foreach ($data as $item) {
                MasterJuz::create([
                    'juz'           => $item['juz'],
                    'from_surah'    => $item['from_surah'],
                    'from_ayat'     => $item['from_ayat'],
                    'to_surah'      => $item['to_surah'],
                    'to_ayat'       => $item['to_ayat'],
                ]);
            }
        } else {
            \Log::error('Failed to decode JSON data for Master Alquran.');
        }
    }
}
