<?php

namespace Database\Seeders\Test;

use App\Models\MasterGenerationList;
use App\Models\PsbConfig;
use App\Models\PsbHistory;
use App\Models\StudentDetail;
use App\Models\StudentsDocument;
use App\Models\StudentsGuardianDetail;
use App\Models\StudentsOriginSchool;
use App\Models\StudentsParentDetail;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeederNewStudentInvited extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Loop 100 Students Invited
        try {
            for ($i=1; $i <= 100; $i++) {
                DB::beginTransaction();
                $psbConfig = PsbConfig::where('is_active', true)->first();
                $studentNew = User::create([
                    'username'                  => 'student-invited_test-'.$i    ,
                    'password'                  => bcrypt('12345678'),
                    'password_changed_at'       => now(),
                    'is_need_to_update_profile' => false,
                    'user_level'                => 'student',
                    'is_active'                 => true,
                ]);
        
                StudentDetail::create([
                    'user_id'       => $studentNew->id,
                    'name'          => 'Student Invited '.$i,
                    'nik_ktp'       => '317201234567822'.$i,
                    'nik_kk'        => '317201234567822'.$i,
                    'akte_number'   => '1234567823'.$i,
                    'nisn'          => '1234567823'.$i,
                    'nis'           => '1234567823'.$i,
                    'place_of_birth'=> 'Jakarta',
                    'date_of_birth' => '2015-01-01',
                    'gender'        => 'male',
                    'country'       => 'idn',
                    'address'       => 'Jl. Contoh Alamat No. '.$i,
                    'province_id'   => 11,
                    'city_id'       => 1171,
                    'district_id'   => 1171010,
                    'village_id'    => 1171010035,
                    'postal_code'   => '12345',
                    'child_order'   => 1,
                    'from_child_order' => 3,
                    'hobby'         => 'Reading',
                    'ambition'      => 'Doctor',
                    'is_biological' => true,
                    'is_completed'  => true,
                    'phone'         => indoNumber('08123456789'),
                    'generation_id' => MasterGenerationList::where('year', $psbConfig->tahun_ajaran)->first()->id ?? null,
                    'status'        => 'new',
                ]);
    
                StudentsOriginSchool::create([
                    'user_id'               => $studentNew->id,
                    'origin_school'         => 'SD Negeri Contoh '.$i,
                    'origin_school_address' => 'Jl. Sekolah No. '.$i,
                    'origin_school_category'=> 'public',
                    'origin_school_npsn'    => '12345678'.$i,
                    'origin_school_graduate'=> 2023,
                    'is_completed'          => true,
                ]);
    
                StudentsParentDetail::create([
                    'user_id'               => $studentNew->id,
                    'dad_name'              => 'Bapak '.$studentNew->name,
                    'dad_nik_ktp'          => '317201234567822'.$i,
                    'dad_phone'            => indoNumber('08123456789'),
                    'dad_latest_education' => 'bachelor',
                    'dad_occupation'       => 'employee',
                    'dad_income'           => '2000000',
                    'dad_country'          => 'idn',
                    'dad_address'          => 'Jl. Ayah No. '.$i,
                    'dad_province_id'      => 11,
                    'dad_city_id'          => 1171,
                    'dad_district_id'      => 1171010,
                    'dad_village_id'       => 1171010035,
                    'dad_postal_code'      => '12345',
                    'dad_is_alive'         => true,
                    'status_with_dad'      => 'biological',
                    'mom_name'             => 'Ibu '.$studentNew->name,
                    'mom_nik_ktp'         => '317201234567822'.$i,
                    'mom_phone'           => indoNumber('08123456789'),
                    'mom_latest_education'=> 'bachelor',
                    'mom_occupation'      => 'employee',
                    'mom_income'          => '2000000',
                    'mom_country'         => 'idn',
                    'mom_address'         => 'Jl. Ibu No. '.$i,
                    'mom_province_id'     => 11,
                    'mom_city_id'         => 1171,
                    'mom_district_id'     => 1171010,
                    'mom_village_id'      => 1171010035,
                    'mom_postal_code'     => '12345',
                    'mom_is_alive'        => true,
                    'status_with_mom'     => 'biological',
                    'marital_status'      => 'married',
                    'is_completed'        => true,
                ]);
    
                StudentsGuardianDetail::create([
                    'user_id'           => $studentNew->id,
                    'name'              => 'Wali '.$studentNew->name,
                    'phone'             => indoNumber('08123456789'),
                    'country'           => 'idn',
                    'address'           => 'Jl. Wali No. '.$i,
                    'province_id'       => 11,
                    'city_id'           => 1171,
                    'district_id'       => 1171010,
                    'village_id'        => 1171010035,
                    'postal_code'       => '12345',
                    'relation_detail'   => 'Uncle',
                    'is_completed'      => true,
                ]);
    
                StudentsDocument::create([
                    'user_id'                   => $studentNew->id,
                    'photo'                     => 'default.png',
                    'certificate_of_letter'     => 'default.png',
                    'origin_head_recommendation'=> 'default.png',
                    'certificate_of_health'     => 'default.png',
                    'report_1_1'                => 'default.png',
                    'report_1_2'                => 'default.png',
                    'report_2_1'                => 'default.png',
                    'report_2_2'                => 'default.png',
                    'is_completed'              => true,
                ]);
    
                PsbHistory::create([
                    'user_id'                       => $studentNew->id,
                    'psb_config_id'                 => $psbConfig->id,
                    'registration_number'           => "UDG-".rand(1000, 9999)."-".date('dmyhis'),
                    'registration_method'           => 'invited',
                    'class_focus'                   => rand(0, 1) ? 'mipa' : 'mak',
                    'is_administration_confirmed'   => true,
                    'is_administration_pass'        => true,
                    'administration_summary'        => 'Semua berkas lengkap dan sesuai persyaratan',
                    'is_exam_offline'               => true,
                    'is_paid'                       => true,
                    'is_moved_to_non_invited'       => false
                ]);
                $psbConfig->increment('jumlah_pendaftar_undangan');
                DB::commit();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
