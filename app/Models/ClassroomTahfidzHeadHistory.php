<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassroomTahfidzHeadHistory extends Model
{
    use HasFactory, Uuid;
    
    protected $fillable = [
        'classroom_id',
        'head_tahfidz_id',
        'tahun_ajaran_id',
    ];

    public function classRoomDetail()
    {
        return $this->belongsTo(MasterClassroom::class, 'classroom_id');
    }
    
    public function userDetail()
    {
        return $this->belongsTo(User::class, 'head_tahfidz_id');
    }

    public function tahunAjaranDetail()
    {
        return $this->belongsTo(MasterTahunAjaran::class, 'tahun_ajaran_id');
    }
}
