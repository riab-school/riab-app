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
        'evidance',
        'action_taked',
        'process_by',
    ];

    public function detail()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function processBy()
    {
        return $this->belongsTo(User::class, 'process_by', 'id');
    }
}
