<?php

namespace App\Imports;

use App\Models\MasterClassroom;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClassroomImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new MasterClassroom([
            'name'          => strtoupper($row['grade'])."-".strtoupper($row['focus'])."-".$row['number'],
            'grade'         => $row['grade'],
            'focus'         => $row['focus'],
            'number'        => $row['number'],
            'limitation'    => $row['limitation'],
            'location'      => $row['location'],
        ]);
    }
}
