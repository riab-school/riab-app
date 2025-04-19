<?php

namespace Database\Seeders;

use App\Models\MasterTahunAjaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TahunAjaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MasterTahunAjaran::create([
            'tahun_ajaran'  => '2017',
            'is_active'     => false
        ]);

        MasterTahunAjaran::create([
            'tahun_ajaran'  => '2018',
            'is_active'     => false
        ]);

        MasterTahunAjaran::create([
            'tahun_ajaran'  => '2019',
            'is_active'     => false
        ]);

        MasterTahunAjaran::create([
            'tahun_ajaran'  => '2020',
            'is_active'     => false
        ]);

        MasterTahunAjaran::create([
            'tahun_ajaran'  => '2021',
            'is_active'     => false
        ]);

        MasterTahunAjaran::create([
            'tahun_ajaran'  => '2022',
            'is_active'     => false
        ]);

        MasterTahunAjaran::create([
            'tahun_ajaran'  => '2023',
            'is_active'     => false
        ]);

        MasterTahunAjaran::create([
            'tahun_ajaran'  => '2024',
            'is_active'     => false
        ]);

        MasterTahunAjaran::create([
            'tahun_ajaran'  => '2025',
            'is_active'     => false
        ]);
    }
}
