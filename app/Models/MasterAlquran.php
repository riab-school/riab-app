<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterAlquran extends Model
{
    protected $fillable = [
        'nomor_surah',
        'nama_surah',
        'total_ayat',
    ];
}
