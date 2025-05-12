<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterGenerationList extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'name',
        'logo',
        'description',
        'year',
    ];
}
