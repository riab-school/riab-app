<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsOriginSchool extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'user_id', 'origin_school', 'origin_school_address', 'origin_school_category', 'origin_school_npsn', 'origin_school_graduate', 'is_rejected',
        'rejection_reason', 'is_completed'
    ];
}
