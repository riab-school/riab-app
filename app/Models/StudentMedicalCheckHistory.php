<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentMedicalCheckHistory extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'user_id',
        'diagnose',
        'treatment',
        'drug_given',
        'note',
        'evidence',
        'is_allow_home',
        'diagnozed_by',
        'is_notify_parent'
    ];
}
