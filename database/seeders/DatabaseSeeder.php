<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AppSettingSeeder::class,
            AdminMenuSeeder::class,
            StaffMenuSeeder::class,
            RoleSeeder::class,
            TahunAjaranSeeder::class,
            GenerationSeeder::class,
            ProvinceSeeder::class,
            CitySeeder::class,
            DistrictSeeder::class,
            VillageSeeder::class,
            MenuList1::class,
        ]);
    }
}
