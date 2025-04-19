<?php

namespace App\Imports;

use App\Models\StudentDetail;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $studentActive = User::create([
            'username'                  => $row['nisn'],
            'password'                  => bcrypt($row['nisn']),
            'password_changed_at'       => now(),
            'is_need_to_update_profile' => true,
            'user_level'                => 'student',
            'is_active'                 => true,
        ]);

        return StudentDetail::create([
            'user_id'           => $studentActive->id,
            'name'              => strtoupper($row['name']),
            'nisn'              => $row['nisn'],
            'nis'               => $row['nis'],
            'place_of_birth'    => strtoupper($row['place_of_birth']),
            'date_of_birth'     => $row['date_of_birth'],
            'status'            => 'active',
        ]);
    }
}
