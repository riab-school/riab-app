<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDormitoryHistory extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'tahun_ajaran_id',
        'user_id',
        'dormitory_id',
        'is_mudabbir',
        'is_active'
    ];

    public function dormitoryDetail()
    {
        return $this->belongsTo(MasterDormitory::class, 'dormitory_id', 'id');
    }
}
