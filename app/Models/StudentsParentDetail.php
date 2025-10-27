<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsParentDetail extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'user_id',
        'dad_name',
        'dad_nik_ktp',
        'dad_phone',
        'dad_latest_education',
        'dad_occupation',
        'dad_income',
        'dad_country',
        'dad_address',
        'dad_province_id',
        'dad_city_id',
        'dad_district_id',
        'dad_village_id',
        'dad_postal_code',
        'dad_is_alive',
        'status_with_dad',
        'mom_name',
        'mom_nik_ktp',
        'mom_phone',
        'mom_latest_education',
        'mom_occupation',
        'mom_income',
        'mom_country',
        'mom_address',
        'mom_province_id',
        'mom_city_id',
        'mom_district_id',
        'mom_village_id',
        'mom_postal_code',
        'mom_is_alive',
        'status_with_mom',
        'marital_status',
        'is_rejected',
        'rejection_reason',
        'is_completed'
    ];

    protected $casts = [
        'dad_is_alive' => 'boolean',
        'mom_is_alive' => 'boolean',
        'is_completed' => 'boolean'
    ];
}
