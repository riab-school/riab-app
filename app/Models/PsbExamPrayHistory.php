<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsbExamPrayHistory extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'user_id',
        'psb_configs_id',
        'bacaan_sholat',
        'doa_sehari_hari',
        'sholat_jenazah',
        'niat_niat',
        'qiraatul_kutub',
        'rekomendasi_ibadah',
        'keterangan_ibadah',
        'point',
        'tested_by'
    ];
}
