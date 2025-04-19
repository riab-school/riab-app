<?php

namespace Database\Seeders;

use App\Models\MasterMenu;
use App\Models\MasterMenuChildren;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menu1 = MasterMenu::create([
            'title'     => 'Master Student',
            'icon'      => 'fas fa-user',
            'order'     => 1,
            'level'     => 'staff',
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu1->id,
            'title'     => 'Student List',
            'route'     => 'staff/master-student/list',
            'order'     => 1,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu1->id,
            'title'     => 'Student Status',
            'route'     => 'staff/master-student/status',
            'order'     => 2,
            'is_active' => true
        ]);

        // PSB
        $menu2 = MasterMenu::create([
            'title'     => 'PSB',
            'icon'      => 'fas fa-smile',
            'order'     => 2,
            'level'     => 'staff',
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu2->id,
            'title'     => 'Config',
            'route'     => 'staff/psb/config',
            'order'     => 1,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu2->id,
            'title'     => 'Dashboard',
            'route'     => 'staff/psb/dashboard',
            'order'     => 2,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu2->id,
            'title'     => 'Payment',
            'route'     => 'staff/psb/payment',
            'order'     => 3,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu2->id,
            'title'     => 'Student List',
            'route'     => 'staff/psb/student-list',
            'order'     => 4,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu2->id,
            'title'     => 'Interview',
            'route'     => 'staff/psb/interview',
            'order'     => 5,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu2->id,
            'title'     => 'Exam Result',
            'route'     => 'staff/psb/exam-result',
            'order'     => 6,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu2->id,
            'title'     => 'Print Form',
            'route'     => 'staff/psb/print-form',
            'order'     => 7,
            'is_active' => true
        ]);
        
        MasterMenuChildren::create([
            'menu_id'   => $menu2->id,
            'title'     => 'Print Report',
            'route'     => 'staff/psb/print-report',
            'order'     => 8,
            'is_active' => true
        ]);

        // Sarpras
        $menu3 = MasterMenu::create([
            'title'     => 'Sarpras',
            'icon'      => 'fas fa-chess-board',
            'order'     => 3,
            'level'     => 'staff',
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu3->id,
            'title'     => 'List Sarpras',
            'route'     => 'staff/sarpras/list',
            'order'     => 1,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu3->id,
            'title'     => 'Status Sarpras',
            'route'     => 'staff/sarpras/status',
            'order'     => 2,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu3->id,
            'title'     => 'Lapor Sarpras',
            'route'     => 'staff/sarpras/lapor',
            'order'     => 3,
            'is_active' => true
        ]);

        // TU
        $menu4 = MasterMenu::create([
            'title'     => 'Tata Usaha',
            'icon'      => 'fas fa-city',
            'order'     => 4,
            'level'     => 'staff',
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu4->id,
            'title'     => 'Surat Masuk',
            'route'     => 'staff/tu/surat-masuk',
            'order'     => 1,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu4->id,
            'title'     => 'Surat Keluar',
            'route'     => 'staff/tu/surat-keluar',
            'order'     => 2,
            'is_active' => true
        ]);

        // Perizinan
        $menu5 = MasterMenu::create([
            'title'     => 'Perizinan',
            'icon'      => 'fas fa-clipboard-check',
            'order'     => 5,
            'level'     => 'staff',
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu5->id,
            'title'     => 'Dashboard Perizinan',
            'route'     => 'staff/perizinan/dashboard',
            'order'     => 1,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu5->id,
            'title'     => 'List Perizinan',
            'route'     => 'staff/perizinan/list',
            'order'     => 2,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu5->id,
            'title'     => 'Laporan Perizinan',
            'route'     => 'staff/perizinan/laporan',
            'order'     => 3,
            'is_active' => true
        ]);

        // Pelanggaran
        $menu6 = MasterMenu::create([
            'title'     => 'Pelanggaran',
            'icon'      => 'fas fa-hammer',
            'order'     => 6,
            'level'     => 'staff',
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu6->id,
            'title'     => 'Dashboard Pelanggaran',
            'route'     => 'staff/pelanggaran/dashboard',
            'order'     => 1,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu6->id,
            'title'     => 'List Pelanggaran',
            'route'     => 'staff/pelanggaran/list',
            'order'     => 2,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu6->id,
            'title'     => 'Laporan Pelanggaran',
            'route'     => 'staff/pelanggaran/laporan',
            'order'     => 3,
            'is_active' => true
        ]);

        //Prestasi
        $menu7 = MasterMenu::create([
            'title'     => 'Prestasi',
            'icon'      => 'fas fa-trophy',
            'order'     => 7,
            'level'     => 'staff',
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu7->id,
            'title'     => 'Dashboard Prestasi',
            'route'     => 'staff/prestasi/dashboard',
            'order'     => 1,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu7->id,
            'title'     => 'List Prestasi',
            'route'     => 'staff/prestasi/list',
            'order'     => 2,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu7->id,
            'title'     => 'Laporan Prestasi',
            'route'     => 'staff/prestasi/laporan',
            'order'     => 3,
            'is_active' => true
        ]);

        //Hafalan & Tahfidz
        $menu8 = MasterMenu::create([
            'title'     => 'Hafalan & Tahfidz',
            'icon'      => 'fas fa-quran',
            'order'     => 8,
            'level'     => 'staff',
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu8->id,
            'title'     => 'Dashboard Hafalan & Tahfidz',
            'route'     => 'staff/hafalan-tahfidz/dashboard',
            'order'     => 1,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu8->id,
            'title'     => 'List Hafalan & Tahfidz',
            'route'     => 'staff/hafalan-tahfidz/list',
            'order'     => 2,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu8->id,
            'title'     => 'Setoran Hafalan & Tahfidz',
            'route'     => 'staff/hafalan-tahfidz/setoran',
            'order'     => 3,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu8->id,
            'title'     => 'Laporan Hafalan & Tahfidz',
            'route'     => 'staff/hafalan-tahfidz/laporan',
            'order'     => 4,
            'is_active' => true
        ]);

        //Kesehatan
        $menu9 = MasterMenu::create([
            'title'     => 'Kesehatan',
            'icon'      => 'fas fa-hospital',
            'order'     => 9,
            'level'     => 'staff',
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu9->id,
            'title'     => 'Dashboard Kesehatan',
            'route'     => 'staff/kesehatan/dashboard',
            'order'     => 1,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu9->id,
            'title'     => 'List Kesehatan',
            'route'     => 'staff/kesehatan/list',
            'order'     => 2,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu9->id,
            'title'     => 'Laporan Kesehatan',
            'route'     => 'staff/kesehatan/laporan',
            'order'     => 3,
            'is_active' => true
        ]);

        //Asrama
        $menu10 = MasterMenu::create([
            'title'     => 'Asrama',
            'icon'      => 'fas fa-bed',
            'order'     => 10,
            'level'     => 'staff',
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu10->id,
            'title'     => 'Dashboard Asrama',
            'route'     => 'staff/asrama/dashboard',
            'order'     => 1,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu10->id,
            'title'     => 'List Asrama',
            'route'     => 'staff/asrama/list',
            'order'     => 2,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu10->id,
            'title'     => 'Laporan Asrama',
            'route'     => 'staff/asrama/laporan',
            'order'     => 3,
            'is_active' => true
        ]);

        // Kelas
        $menu11 = MasterMenu::create([
            'title'     => 'Kelas',
            'icon'      => 'fas fa-chalkboard-teacher',
            'order'     => 11,
            'level'     => 'staff',
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu11->id,
            'title'     => 'Dashboard Kelas',
            'route'     => 'staff/kelas/dashboard',
            'order'     => 1,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu11->id,
            'title'     => 'List Kelas',
            'route'     => 'staff/kelas/list',
            'order'     => 2,
            'is_active' => true
        ]);

        MasterMenuChildren::create([
            'menu_id'   => $menu11->id,
            'title'     => 'Laporan Kelas',
            'route'     => 'staff/kelas/laporan',
            'order'     => 3,
            'is_active' => true
        ]);
    }
}
