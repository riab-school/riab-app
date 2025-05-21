<?php

namespace App\Imports;

use App\Models\ClassroomHeadHistory;
use App\Models\ClassroomTahfidzHeadHistory;
use App\Models\MasterClassroom;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClassroomImport implements ToModel, WithHeadingRow
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
    
    public function model(array $row)
    {
        // check if name and tahun_ajaran_id already exists
        $existingClassroom = MasterClassroom::where('name', strtoupper($row['grade'])."-".strtoupper($row['focus'])."-".$row['number'])
            ->where('tahun_ajaran_id', $this->data['tahun_ajaran_id'])
            ->first();
        if ($existingClassroom) {   
            throw new \Exception('Data sudah pernah diimport');
        }

        // check if wali kelas and wali tahfidz not empty
        if (empty($row['username_wali_kelas']) || empty($row['username_wali_tahfidz'])) {
            throw new \Exception('Wali Kelas or Wali Tahfidz username cannot be empty');
        }

        // get wali kelas id by username
        $waliKelas = User::where('username', $row['username_wali_kelas'])->first();
        $waliTahfidz = User::where('username', $row['username_wali_tahfidz'])->first();

        if (!$waliKelas || !$waliTahfidz) {
            throw new \Exception('Wali Kelas or Wali Tahfidz not found');
        }

        $classRoom = MasterClassroom::create([
            'name'              => strtoupper($row['grade'])."-".strtoupper($row['focus'])."-".$row['number'],
            'grade'             => $row['grade'],
            'focus'             => $row['focus'],
            'number'            => $row['number'],
            'limitation'        => $row['limitation'],
            'location'          => $row['location'],
            'tahun_ajaran_id'   => $this->data['tahun_ajaran_id'],
        ]);

        ClassroomHeadHistory::create([
            'classroom_id'      => $classRoom->id,
            'head_id'           => $waliKelas->id,
            'tahun_ajaran_id'   => $this->data['tahun_ajaran_id'],
        ]);

        return ClassroomTahfidzHeadHistory::create([
            'classroom_id'      => $classRoom->id,
            'head_tahfidz_id'   => $waliTahfidz->id,
            'tahun_ajaran_id'   => $this->data['tahun_ajaran_id'],
        ]);
    }
}
