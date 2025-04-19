<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterDormitory extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'name',
        'building',
        'number',
        'level',
        'limitation',
        'head_id'
    ];
}
