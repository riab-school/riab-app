<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Roles::create([
            'name'  => 'Guru',
            'slug'  => 'guru',
        ]);
        Roles::create([
            'name'  => 'Ustad',
            'slug'  => 'ustad',
        ]);
        Roles::create([
            'name'  => 'Ustazah',
            'slug'  => 'ustazah',
        ]);
        Roles::create([
            'name'  => 'Staff Sekolah',
            'slug'  => 'staff-sekolah',
        ]);
        Roles::create([
            'name'  => 'Tata Usaha',
            'slug'  => 'tata-usaha',
        ]);
        Roles::create([
            'name'  => 'Staff Yayasan',
            'slug'  => 'staff-yayasan',
        ]);
        Roles::create([
            'name'  => 'Staff Kesehatan',
            'slug'  => 'staff-kesehatan',
        ]);
        Roles::create([
            'name'  => 'Kepala Sekolah',
            'slug'  => 'kepala-sekolah',
        ]);
        Roles::create([
            'name'  => 'Wakil Kepala Sekolah',
            'slug'  => 'wakil-kepala-sekolah',
        ]);
        Roles::create([
            'name'  => 'Bendahara',
            'slug'  => 'bendahara',
        ]);
        Roles::create([
            'name'  => 'Keamanan',
            'slug'  => 'keamanan',
        ]);
    }
}
