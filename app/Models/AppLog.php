<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppLog extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'user_id',
        'type',
        'description',
        'ip',
        'user_agent',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
