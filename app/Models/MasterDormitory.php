<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterDormitory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'building',
        'number',
        'level',
        'limitation',
        'head_id',
        'tahun_ajaran_id'
    ];

    public function headDetail()
    {
        return $this->hasOne(DormitoryHeadHistory::class, 'dormitory_id', 'id');
    }
}
