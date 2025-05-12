<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterClassroom extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'name',
        'focus',
        'grade',
        'number',
        'limitation',
        'location',
        'head_id',
        'head_tahfidz_id'
    ];

    public function headDetail()
    {
        return $this->belongsTo(User::class, 'head_id');
    }

    public function headTahfidzDetail()
    {
        return $this->belongsTo(User::class, 'head_tahfidz_id ');
    }
}
