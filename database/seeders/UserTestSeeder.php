<?php

namespace Database\Seeders;

use App\Models\AdminDetail;
use App\Models\ParentDetail;
use App\Models\PsbConfig;
use App\Models\PsbHistory;
use App\Models\StaffDetail;
use App\Models\StudentDetail;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'username'                  => 'admin',
            'password'                  => bcrypt('adminadmin'),
            'password_changed_at'       => now(),
            'is_need_to_update_profile' => false,
            'user_level'                => 'admin',
            'is_active'                 => true,
        ]);

        AdminDetail::create([
            'user_id' => $admin->id,
            'name'    => 'Admin',
        ]);

        $staff = User::create([
            'username'                  => 'staff',
            'password'                  => bcrypt('staffstaff'),
            'password_changed_at'       => now(),
            'is_need_to_update_profile' => false,
            'user_level'                => 'staff',
            'is_active'                 => true,
        ]);

        StaffDetail::create([
            'user_id' => $staff->id,
            'name'    => 'Staff',
            'status'  => 'active',
        ]);

        $parent = User::create([
            'username'                  => 'parent',
            'password'                  => bcrypt('parentparent'),
            'password_changed_at'       => now(),
            'is_need_to_update_profile' => false,
            'user_level'                => 'parent',
            'is_active'                 => true,
        ]);

        ParentDetail::create([
            'user_id' => $parent->id,
            'name'    => 'Parent',
        ]);

        $studentActive = User::create([
            'username'                  => 'studentactive',
            'password'                  => bcrypt('studentactivestudentactive'),
            'password_changed_at'       => now(),
            'is_need_to_update_profile' => false,
            'user_level'                => 'student',
            'is_active'                 => true,
        ]);

        StudentDetail::create([
            'user_id' => $studentActive->id,
            'name'    => 'Student Active',
            'status'  => 'active',
        ]);

        // Khusus Student New
        // Bikin Config Palsu Untuk PSB
        $psbConfig = PsbConfig::create([
            'ketua_panitia'                     => 'Ketua Panitia',
            'kode_undangan'                     => 'UND',
            'tahun_ajaran'                      => '2025',
            'no_rekening_psb'                   => '1234567890',
            'nama_rekening_psb'                 => 'Nama Rekening PSB',
            'nama_bank_rekening_psb'            => 'Nama Bank Rekening PSB',
            'biaya_psb'                         => 1000000,
            'target_undangan'                   => 100,
            'target_reguler'                    => 600,
            'nama_cp_1'                         => 'CP 1',
            'nomor_cp_1'                        => '081234567890',
            'nama_cp_2'                         => 'CP 2',
            'nomor_cp_2'                        => '081234567890',
            'nama_cp_3'                         => 'CP 3',
            'nomor_cp_3'                        => '081234567890',
            'buka_daftar_undangan'              => now(),
            'tutup_daftar_undangan'             => now()->addDays(7),
            'pengumuman_administrasi_undangan'  => now()->addDays(8),
            'buka_tes_undangan'                 => now()->addDays(9),
            'tutup_tes_undangan'                => now()->addDays(10),
            'pengumuman_undangan'               => now()->addDays(11),
            'buka_daftar_ulang_undangan'        => now()->addDays(12),
            'tutup_daftar_ulang_undangan'       => now()->addDays(13),
            'buka_daftar_reguler'               => now()->addDays(14),
            'tutup_daftar_reguler'              => now()->addDays(21),
            'buka_cetak_berkas'                 => now()->addDays(22),
            'tutup_cetak_berkas'                => now()->addDays(23),
            'buka_tes_reguler'                  => now()->addDays(24),
            'tutup_tes_reguler'                 => now()->addDays(25),
            'pengumuman_reguler'                => now()->addDays(26),
            'buka_daftar_ulang_reguler'         => now()->addDays(27),
            'tutup_daftar_ulang_reguler'        => now()->addDays(28),
            'jumlah_sesi_sehari'                => 3,
            'jumlah_ruang_cat'                  => 3,
            'prefix_ruang_cat'                  => 'Ruang LAB',
            'kapasitas_ruang_cat'               => 30,
            'jumlah_ruang_interview'            => 10,
            'prefix_ruang_interview'            => 'Ruang Kelas',
            'kapasitas_ruang_interview'         => 8,
            'jumlah_ruang_interview_orangtua'   => 4,
            'prefix_ruang_interview_orangtua'   => 'Ruang Kelas',
            'kapasitas_ruang_interview_orangtua'=> 4,
            'brosur_link'                       => 'https://brosur.com',
            'booklet_link'                      => 'https://booklet.com',
            'popup_psb'                         => 'https://popup.com',
            'jumlah_pendaftar_undangan'         => 0,
            'jumlah_pendaftar_reguler'          => 0,
            'is_active'                         => true,
        ]);

        $studentNew = User::create([
            'username'                  => 'studentnewinvited',
            'password'                  => bcrypt('studentnewinvitedstudentnewinvited'),
            'password_changed_at'       => now(),
            'is_need_to_update_profile' => false,
            'user_level'                => 'student',
            'is_active'                 => true,
        ]);

        PsbHistory::create([
            'user_id'               => $studentNew->id,
            'psb_config_id'         => $psbConfig->id,
            'registration_number'   => "UDG-".rand(1000, 9999)."-".date('dmyhis'),
            'registration_method'   => 'invited',
            'is_moved_to_non_invited' => false,
        ]);

        StudentDetail::create([
            'user_id' => $studentNew->id,
            'name'    => 'Student Invited',
            'status'  => 'new',
        ]);

        $studentNew = User::create([
            'username'                  => 'studentnewinvitedreguler',
            'password'                  => bcrypt('studentnewinvitedregulerstudentnewinvitedreguler'),
            'password_changed_at'       => now(),
            'is_need_to_update_profile' => false,
            'user_level'                => 'student',
            'is_active'                 => true,
        ]);

        PsbHistory::create([
            'user_id'               => $studentNew->id,
            'psb_config_id'         => $psbConfig->id,
            'registration_number'   => "UDG-".rand(1000, 9999)."-".date('dmyhis'),
            'registration_method'   => 'invited',
            'is_moved_to_non_invited' => true,
        ]);

        StudentDetail::create([
            'user_id' => $studentNew->id,
            'name'    => 'Student Invited to Reguler',
            'status'  => 'new',
        ]);

        $studentNew = User::create([
            'username'                  => 'studentnewreguler',
            'password'                  => bcrypt('studentnewregulerstudentnewreguler'),
            'password_changed_at'       => now(),
            'is_need_to_update_profile' => false,
            'user_level'                => 'student',
            'is_active'                 => true,
        ]);

        PsbHistory::create([
            'user_id'                   => $studentNew->id,
            'psb_config_id'             => $psbConfig->id,
            'registration_number'       => "REG-".rand(1000, 9999)."-".date('dmyhis'),
            'registration_method'       => 'reguler',
            'is_moved_to_non_invited'   => false,
        ]);

        StudentDetail::create([
            'user_id' => $studentNew->id,
            'name'    => 'Student Reguler',
            'status'  => 'new',
        ]);
    }
}
