<?php

namespace App\Imports;

use App\Models\StaffDetail;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StaffImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $staff = User::create([
            'username'                  => $row['username'],
            'password'                  => bcrypt($row['password']),
            'password_changed_at'       => now(),
            'is_need_to_update_profile' => true,
            'user_level'                => 'staff',
            'is_active'                 => true,
        ]);

        return StaffDetail::create([
            'user_id'           => $staff->id,
            'employee_number'   => $row['nip'],
            'name'              => strtoupper($row['full_name']),
            'role_id'           => '1',
            'status'            => 'active',
        ]);
    }
}
