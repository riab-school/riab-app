<?php

namespace Database\Seeders;

use App\Models\MasterMenu;
use App\Models\MasterMenuChildren;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuList1 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menu1 = MasterMenu::where([
            'title'     => 'Master Student'
        ])->first();

        MasterMenuChildren::create([
            'menu_id'   => $menu1->id,
            'title'     => 'Rekam / Cetak KTS',
            'route'     => 'staff/master-student/kts',
            'order'     => 3,
            'is_active' => true
        ]);
    }
}
