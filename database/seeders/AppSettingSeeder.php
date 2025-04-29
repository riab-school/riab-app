<?php

namespace Database\Seeders;

use App\Models\AppSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        AppSettings::create([
            'key' => 'APP_NAME',
            'value' => 'SIAKAD',
            'default_value' => 'SIAKAD',
        ]);

        AppSettings::create([
            'key' => 'APP_LOGO_DARK',
            'value' => 'assets/images/logo-dark.png',
            'default_value' => 'assets/images/logo-dark.png',
            'is_file'   => 1,
        ]);

        AppSettings::create([
            'key' => 'APP_LOGO_LIGHT',
            'value' => 'assets/images/logo-white.png',
            'default_value' => 'assets/images/logo-white.png',
            'is_file'   => 1,
        ]);

        AppSettings::create([
            'key' => 'SCHOOL_NAME',
            'value' => 'Ruhul Islam Anak Bangsa',
            'default_value' => 'Ruhul Islam Anak Bangsa',
        ]);

        AppSettings::create([
            'key' => 'SCHOOL_SHORT_NAME',
            'value' => 'RIAB',
            'default_value' => 'RIAB',
        ]);

        AppSettings::create([
            'key' => 'SCHOOL_ADDRESS',
            'value' => 'Jl. Pintu Air, Desa Gue Gajah, Kecamatan Darul Imarah, Kabupaten Aceh Besar, Aceh',
            'default_value' => 'Jl. Pintu Air, Desa Gue Gajah, Kecamatan Darul Imarah, Kabupaten Aceh Besar, Aceh',
        ]);

        AppSettings::create([
            'key' => 'SCHOOL_NSM',
            'value' => '131211060001',
            'default_value' => '131211060001',
        ]);

        AppSettings::create([
            'key' => 'SCHOOL_NPSN',
            'value' => '10114244',
            'default_value' => '10114244',
        ]);

        AppSettings::create([
            'key' => 'SCHOOL_EMAIL',
            'value' => NULL,
            'default_value' => NULL,
        ]);

        AppSettings::create([
            'key' => 'SCHOOL_PHONE',
            'value' => NULL,
            'default_value' => NULL,
        ]);

        AppSettings::create([
            'key' => 'SCHOOL_AKREDITASI',
            'value' => 'A',
            'default_value' => 'A',
        ]);

        AppSettings::create([
            'key' => 'SCHOOL_CATEGORY',
            'value' => 'Dayah / Madrasah Aliyah',
            'default_value' => 'Dayah / Madrasah Aliyah',
        ]);

        AppSettings::create([
            'key' => 'SCHOOL_LOGO',
            'value' => 'assets/images/logo.png',
            'default_value' => 'assets/images/logo.png',
            'is_file'   => 1,
        ]);

        AppSettings::create([
            'key' => 'SCHOOL_ICON',
            'value' => 'assets/images/favicon.ico',
            'default_value' => 'assets/images/favicon.ico',
            'is_file'   => 1,
        ]);

        AppSettings::create([
            'key' => 'WHATSAPP_SERVER',
            'value' => 'http://202.10.42.178:9999',
            'default_value' => 'http://202.10.42.178:9999',
        ]);

        AppSettings::create([
            'key' => 'WHATSAPP_TOKEN',
            'value' => 'Ruhul@Islam@1997',
            'default_value' => 'Ruhul@Islam@1997',
        ]);

        AppSettings::create([
            'key' => 'QURAN_API_URL',
            'value' => 'http://202.10.42.178:3000',
            'default_value' => 'http://202.10.42.178:3000',
        ]);

        AppSettings::create([
            'key' => 'SCHOOL_WEBSITE',
            'value' => 'https://ruhulislam.com',
            'default_value' => 'https://ruhulislam.com',
        ]);

    }
}
