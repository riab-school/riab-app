<?php

namespace App\Imports;

use App\Models\DormitoryHeadHistory;
use App\Models\MasterDormitory;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DormitoryImport implements ToModel, WithHeadingRow
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
    public function model(array $row)
    {
        // check if name and tahun_ajaran_id already exists
        $existingClassroom = MasterDormitory::where('name', strtoupper($row['building']).' - '.$row['number'])
            ->where('tahun_ajaran_id', $this->data['tahun_ajaran_id'])
            ->first();
        if ($existingClassroom) {   
            throw new \Exception('Data sudah pernah diimport');
        }

        // check if wali asrama
        if (empty($row['username_wali_asrama'])) {
            throw new \Exception('Wali asrama username cannot be empty');
        }

        // get wali kelas id by username
        $waliAsrama = User::where('username', $row['username_wali_asrama'])->first();

        if (!$waliAsrama) {
            throw new \Exception('Wali asrama username not found');
        }

        $dataAsrama = MasterDormitory::create([
            'name'              => strtoupper($row['building']).' - '.$row['number'],
            'building'          => strtoupper($row['building']),
            'number'            => $row['number'],
            'level'             => $row['level'],
            'limitation'        => $row['limitation'],
            'tahun_ajaran_id'   => $this->data['tahun_ajaran_id']
        ]);

        return DormitoryHeadHistory::create([
            'dormitory_id'      => $dataAsrama->id,
            'head_id'           => $waliAsrama->id,
            'tahun_ajaran_id'   => $this->data['tahun_ajaran_id'],
        ]);
    }
}
