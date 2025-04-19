<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminDetail extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'user_id',
        'name',
        'nik_ktp',
        'employee_number',
        'photo',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'phone',
        'address',
        'province_id',
        'city_id',
        'district_id',
        'village_id',
    ];
}
