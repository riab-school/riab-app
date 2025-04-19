<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClassroomHistory extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'tahun_ajaran_id',
        'user_id',
        'classroom_id',
        'is_active',
    ];

    public function classroomDetail()
    {
        return $this->belongsTo(MasterClassroom::class, 'classroom_id');
    }

    public function userDetail()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function yearDetail()
    {
        return $this->belongsTo(MasterTahunAjaran::class, 'tahun_ajaran_id');
    }
}
