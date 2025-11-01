<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsbExamAlquranHistory extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'user_id',
        'psb_configs_id',
        'khatak_jali',
        'khatak_kafi',
        'total_skor',
        'jumlah_hafalan',
        'kualitas_hafalan',
        'rekomendasi_hafalan',
        'rekomendasi_bacaan',
        'keterangan_hafalan',
        'point',
        'point_hafalan',
        'tested_by'
    ];
}
