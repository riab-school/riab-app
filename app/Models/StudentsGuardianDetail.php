<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsGuardianDetail extends Model
{
    use HasFactory, Uuid;
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'country',
        'address',
        'province_id',
        'city_id',
        'district_id',
        'village_id',
        'postal_code',
        'relation_detail',
        'is_completed'
    ];
}
