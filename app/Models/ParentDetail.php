<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentDetail extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'user_id',
        'name',
        'photo',
        'phone'
    ];
}
