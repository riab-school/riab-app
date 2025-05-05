<?php

namespace Database\Seeders;

use App\Models\MasterMenu;
use App\Models\MasterMenuChildren;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menu1 = MasterMenu::create([
            'title'     => 'Manage Users',
            'icon'      => 'fas fa-user',
            'order'     => 1,
            'level'     => 'admin',
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu1->id,
            'title'     => 'List Users',
            'route'     => 'admin/manage-users/list',
            'order'     => 1,
            'is_active' => true
        ]);

        $menu2 = MasterMenu::create([
            'title'     => 'Manage Menu & Permissions',
            'icon'      => 'fas fa-list',
            'order'     => 2,
            'level'     => 'admin',
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu2->id,
            'title'     => 'List Menu',
            'route'     => 'admin/manage-menu/list',
            'order'     => 1,
            'is_active' => true
        ]);

        $menu3 = MasterMenu::create([
            'title'     => 'Whatsapp Instance',
            'icon'      => 'fab fa-whatsapp',
            'order'     => 3,
            'level'     => 'admin',
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu3->id,
            'title'     => 'Manage Instance',
            'route'     => 'admin/whatsapp-instance/manage',
            'order'     => 1,
            'is_active' => true
        ]);

        $menu4 = MasterMenu::create([
            'title'     => 'App Config',
            'icon'      => 'fas fa-cog',
            'order'     => 4,
            'level'     => 'admin',
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu4->id,
            'title'     => 'Manage Config',
            'route'     => 'admin/app-configs/manage',
            'order'     => 1,
            'is_active' => true
        ]);

        $menu5 = MasterMenu::create([
            'title'     => 'App Log',
            'icon'      => 'fas fa-list-alt',
            'order'     => 5,
            'level'     => 'admin',
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu5->id,
            'title'     => 'List Log',
            'route'     => 'admin/app-logs/list',
            'order'     => 1,
            'is_active' => true
        ]);

        $menu6 = MasterMenu::create([
            'title'     => 'Import & Export',
            'icon'      => 'fas fa-upload',
            'order'     => 6,
            'level'     => 'admin',
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu6->id,
            'title'     => 'Import',
            'route'     => 'admin/import-export/import',
            'order'     => 1,
            'is_active' => true
        ]);
        
        MasterMenuChildren::create([
            'menu_id'   => $menu6->id,
            'title'     => 'Export',
            'route'     => 'admin/import-export/export',
            'order'     => 2,
            'is_active' => true
        ]);
    }
}
