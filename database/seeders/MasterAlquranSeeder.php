<?php

namespace Database\Seeders;

use App\Models\MasterAlquran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterAlquranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(base_path('database/data-alquran/master_alquran.json'));
        $data = json_decode($json, true);
        if (is_array($data)) {
            foreach ($data as $item) {
                MasterAlquran::create([
                    'nomor_surah'   => $item['nomor_surah'],
                    'nama_surah'    => $item['nama_surah'],
                    'total_ayat'    => $item['total_ayat'],
                ]);
            }
        } else {
            \Log::error('Failed to decode JSON data for Master Alquran.');
        }
    }
}
