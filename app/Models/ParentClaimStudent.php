<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentClaimStudent extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'parent_user_id',
        'student_user_id'
    ];

    public function parentDetail()
    {
        return $this->belongsTo(ParentDetail::class, 'parent_user_id', 'user_id');
    }
}
