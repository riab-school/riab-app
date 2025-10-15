<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsbParentInterviewRoom extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'user_id', 'psb_config_id', 'exam_date', 'room_name', 'room_session'
    ];
}
