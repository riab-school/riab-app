<?php

namespace App\Imports;

use App\Models\MasterGenerationList;
use App\Models\MasterTahunAjaran;
use App\Models\StudentClassroomHistory;
use App\Models\StudentDetail;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel, WithHeadingRow
{

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Create a new user and student detail
        $studentActive = User::create([
            'username'                  => $row['nis'],
            'password'                  => bcrypt($row['nis']),
            'password_changed_at'       => now(),
            'is_need_to_update_profile' => true,
            'user_level'                => 'student',
            'is_active'                 => true,
        ]);

        StudentClassroomHistory::create([
            'user_id'           => $studentActive->id,
            'classroom_id'      => $this->data['classroom_id'],
            'tahun_ajaran_id'   => $this->data['tahun_ajaran_id'],
            'is_active'         => $this->data['is_active'],
        ]);

        // Get generation id from tahun ajaran
        $tahunAjaran = MasterTahunAjaran::where('id', $this->data['tahun_ajaran_id'])->first();
        if ($tahunAjaran) {
            //find generation id by year
            $generation = MasterGenerationList::where('year', $tahunAjaran->tahun_ajaran)->first();
            if ($generation) {
                $generationId = $generation->id;
            } else {
                $generationId = null;
            }
        }

        return StudentDetail::create([
            'user_id'           => $studentActive->id,
            'name'              => strtoupper($row['name']),
            'nisn'              => $row['nisn'] ?? NULL,
            'nis'               => $row['nis'],
            'place_of_birth'    => strtoupper($row['place_of_birth']),
            'date_of_birth'     => $row['date_of_birth'],
            'generation_id'     => $generationId,
            'status'            => 'active',
        ]);
    }
}
