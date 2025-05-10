<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsViolation extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'user_id',
        'detail',
        'evidence',
        'action_taked',
        'process_by',
        'is_notify_parent',
    ];

    public function userDetail()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function processBy()
    {
        return $this->belongsTo(User::class, 'process_by', 'id');
    }
}
