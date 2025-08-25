<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsMemorization extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'user_id',
        'surah',
        'from_ayat',
        'to_ayat',
        'point_tahsin',
        'point_tahfidz',
        'status',
        'note',
        'evidence',
        'process_by',
        'is_notify_parent',
    ];

    public function userDetail()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tasmikBy()
    {
        return $this->belongsTo(User::class, 'process_by', 'id');
    }

    public function getSurahNameAttribute()
    {
        return MasterAlquran::where('nomor_surah', $this->surah)->first()->nama_surah ?? 'Tidak Diketahui';
    }

    public function getJuzAttribute()
    {
        $juz = MasterJuz::where(function ($query) {
            $query->where('from_surah', '<=', $this->surah)
                ->where(function ($q) {
                    $q->where('to_surah', '>', $this->surah)
                        ->orWhere(function ($q2) {
                            $q2->where('to_surah', '=', $this->surah)
                            ->where('to_ayat', '>=', $this->to_ayat);
                        });
                });
        })
        ->orWhere(function ($query) {
            $query->where('from_surah', '=', $this->surah)
                ->where('from_ayat', '<=', $this->to_ayat)
                ->where(function ($q) {
                    $q->where('to_surah', '>', $this->surah)
                        ->orWhere(function ($q2) {
                            $q2->where('to_surah', '=', $this->surah)
                            ->where('to_ayat', '>=', $this->to_ayat);
                        });
                });
        })
        ->orderBy('juz', 'asc')
        ->first();

        return $juz ? $juz->juz : null;
    }
}
