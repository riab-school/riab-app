<?php

namespace Database\Seeders;

use App\Models\AdminDetail;
use App\Models\MasterMenu;
use App\Models\MasterMenuChildren;
use App\Models\MasterTahunAjaran;
use App\Models\User;
use App\Models\UserHasMenuPermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'username'                  => 'admin',
            'password'                  => bcrypt('ryansyah100200300'),
            'password_changed_at'       => now(),
            'is_need_to_update_profile' => false,
            'user_level'                => 'admin',
            'is_active'                 => true,
        ]);

        AdminDetail::create([
            'user_id' => $admin->id,
            'name'    => 'Admin',
        ]);

        MasterTahunAjaran::where('tahun_ajaran', date('Y'))->first()->update([
            'is_active' => true,
        ]);

        $allChildMenu = MasterMenu::where('level', 'admin')->get();
        foreach ($allChildMenu as $menu) {
            $childMenu = MasterMenuChildren::where('menu_id', $menu->id)->get();
            foreach ($childMenu as $child) {
                UserHasMenuPermission::create([
                    'user_id' => $admin->id,
                    'menu_children_id' => $child->id,
                    'assigned_at' => now(),
                    'is_permanent_access' => true,
                ]);
            }
        }
    }
}
