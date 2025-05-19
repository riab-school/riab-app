<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterClassroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'focus',
        'grade',
        'number',
        'limitation',
        'location',
        'tahun_ajaran_id',
    ];

    public function headDetail()
    {
        return $this->hasOne(ClassroomHeadHistory::class, 'classroom_id', 'id');
    }

    public function headTahfidzDetail()
    {
        return $this->hasOne(ClassroomTahfidzHeadHistory::class, 'classroom_id', 'id');
    }
}
