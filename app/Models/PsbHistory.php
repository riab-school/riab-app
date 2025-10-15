<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsbHistory extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'user_id',
        'psb_config_id',
        'registration_number',
        'registration_method',
        'is_paid',
        'class_focus',
        'is_administration_confirmed',
        'is_administration_pass',
        'administration_summary',
        'is_exam_offline',
        'link',
        'exam_number',
        'exam_date',
        'is_cat_exam_completed',
        'is_interview_session_completed',
        'is_parent_interview_session_completed',
        'is_exam_pass',
        'exam_summary',
        'is_moved_to_non_invited'
    ];

    public function studentDetail()
    {
        return $this->belongsTo(StudentDetail::class, 'user_id', 'user_id');
    }

    public function userDetail()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function psbConfig()
    {
        return $this->belongsTo(PsbConfig::class, 'psb_config_id', 'id');
    }

    public function studentCatRoom()
    {
        return $this->hasOne(PsbCatRoom::class, 'user_id', 'user_id');
    }

    public function studentInterviewRoom()
    {
        return $this->hasOne(PsbInterviewRoom::class, 'user_id', 'user_id');
    }

    public function parentInterviewRoom()
    {
        return $this->hasOne(PsbParentInterviewRoom::class, 'user_id', 'user_id');
    }
}
