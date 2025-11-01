<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsbExamStudentInterviewHistory extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'user_id',
        'psb_configs_id',
        'prestasi_akademik',
        'prestasi_non_akademik',
        'bahasa_inggris',
        'bahasa_arab',
        'info_masuk',
        'alasan_masuk',
        'riwayat_penyakit',
        'merokok',
        'pacaran',
        'penggunaan_hp',
        'pelanggaran',
        'guru_tidak_suka',
        'pelajaran_suka',
        'pelajaran_tidak_suka',
        'cita_cita',
        'alasan_memilih_jurusan',
        'hubungan_ortu',
        'rekomendasi_interview',
        'keterangan_interview',
        'point',
        'tested_by'
    ];
}
