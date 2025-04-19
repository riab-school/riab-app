<?php

namespace App\Imports;

use App\Models\MasterDormitory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DormitoryImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new MasterDormitory([
            'name'         => strtoupper($row['building']).' - '.$row['number'],
            'building'     => strtoupper($row['building']),
            'number'       => $row['number'],
            'level'        => $row['level'],
            'limitation'   => $row['limitation'],
        ]);
    }
}
