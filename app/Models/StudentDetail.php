<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDetail extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'user_id',
        'name',
        'nik_ktp',
        'nik_kk',
        'akte_number',
        'nisn',
        'nis',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'phone',
        'country',
        'address',
        'province_id',
        'city_id',
        'district_id',
        'village_id',
        'postal_code',
        'child_order',
        'from_child_order',
        'hobby',
        'ambition',
        'is_biological',
        'is_rejected',
        'rejection_reason',
        'is_completed',
        'generation_id',
        'status'
    ];

    public function studentClassroomHistory()
    {
        return $this->hasMany(StudentClassroomHistory::class, 'user_id', 'user_id');
    }

    public function studentDormitoryHistory()
    {
        return $this->hasMany(StudentDormitoryHistory::class, 'user_id', 'user_id');
    }

    public function studentDocument()
    {
        return $this->hasOne(StudentsDocument::class, 'user_id', 'user_id');
    }

    public function studentAchievementHistory()
    {
        return $this->hasMany(StudentsAchievement::class, 'user_id', 'user_id');
    }

    public function studentOriginDetail()
    {
        return $this->hasOne(StudentsOriginSchool::class, 'user_id', 'user_id');
    }

    public function studentPermissionHistory()
    {
        return $this->hasMany(StudentPermissionHistory::class, 'user_id', 'user_id');
    }

    public function studentViolationHistory()
    {
        return $this->hasMany(StudentsViolation::class, 'user_id', 'user_id');
    }

    public function studentMedicalCheckHistory()
    {
        return $this->hasMany(StudentMedicalCheckHistory::class, 'user_id', 'user_id');
    }

    public function studentParentDetail()
    {
        return $this->hasOne(StudentsParentDetail::class, 'user_id', 'user_id');
    }

    public function studentGuardianDetail()
    {
        return $this->hasOne(StudentsGuardianDetail::class, 'user_id', 'user_id');
    }

    public function studentTahfidzHistory()
    {
        return $this->hasMany(StudentsMemorization::class, 'user_id', 'user_id');
    }

    public function studentHealthDetail()
    {
        return $this->hasOne(StudentsHealth::class, 'user_id', 'user_id');
    }

    public function studentDocumentRejection()
    {
        return $this->hasMany(PsbDocumentRejection::class, 'user_id', 'user_id');
    }

    public function provinceDetail()
    {
        return $this->hasOne(Province::class, 'id', 'province_id');
    }

    public function cityDetail()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function districtDetail()
    {
        return $this->hasOne(District::class, 'id', 'district_id');
    }

    public function villageDetail()
    {
        return $this->hasOne(Village::class, 'id', 'village_id');
    }

    public function psbHistory()
    {
        return $this->hasOne(PsbHistory::class, 'user_id', 'user_id');
    }
}
