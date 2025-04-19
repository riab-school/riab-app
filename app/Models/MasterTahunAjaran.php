<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTahunAjaran extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'tahun_ajaran',
        'is_active',
    ];
}
