<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsDocument extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'user_id',
        'photo',
        'signature',
        'ktp_file',
        'kk_file',
        'akte_file',
        'nisn_file',
        'nis_file',
        'dad_ktp_file',
        'mom_ktp_file',
        'guardian_ktp_file',
        'rank_certificate',
        'origin_head_recommendation',
        'certificate_of_letter',
        'letter_of_promise_to_financing',
        'report_1_1',
        'report_1_2',
        'report_2_1',
        'report_2_2',
        'report_3_1',
        'report_3_2',
        'report_4_1',
        'report_4_2',
        'report_5_1',
        'report_5_2',
        'report_6_1',
        'report_6_2',
        'bpjs',
        'kis',
        'kip',
        'certificate_of_health',
        'vaccine_certificate_1',
        'vaccine_certificate_2',
        'vaccine_certificate_3',
        'statement_letter_of_not_changing_majors',
        'is_completed'
    ];
}
