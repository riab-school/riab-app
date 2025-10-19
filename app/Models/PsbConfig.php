<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsbConfig extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'ketua_panitia',
        'tanda_tangan_ketua_panitia',
        'kode_undangan',
        'tahun_ajaran',
        'no_rekening_psb',
        'nama_rekening_psb',
        'nama_bank_rekening_psb',
        'biaya_psb',
        'target_undangan',
        'target_reguler',
        'nama_cp_1',
        'nomor_cp_1',
        'nama_cp_2',
        'nomor_cp_2',
        'nama_cp_3',
        'nomor_cp_3',
        'buka_daftar_undangan',
        'tutup_daftar_undangan',
        'buka_verifikasi_berkas_undangan',
        'tutup_verifikasi_berkas_undangan',
        'pengumuman_administrasi_undangan',
        'buka_tes_undangan',
        'tutup_tes_undangan',
        'pengumuman_undangan',
        'buka_daftar_ulang_undangan',
        'tutup_daftar_ulang_undangan',
        'buka_daftar_reguler',
        'tutup_daftar_reguler',
        'buka_verifikasi_berkas_reguler',
        'tutup_verifikasi_berkas_reguler',

        'buka_tes_reguler',
        'tutup_tes_reguler',
        'pengumuman_reguler',
        'buka_daftar_ulang_reguler',
        'tutup_daftar_ulang_reguler',
        'jumlah_sesi_sehari',
        'jumlah_ruang_cat',
        'prefix_ruang_cat',
        'kapasitas_ruang_cat',
        'jumlah_ruang_interview',
        'prefix_ruang_interview',
        'kapasitas_ruang_interview',
        'jumlah_ruang_interview_orangtua',
        'prefix_ruang_interview_orangtua',
        'kapasitas_ruang_interview_orangtua',
        'brosur_link',
        'booklet_link',
        'popup_psb',
        'jumlah_pendaftar_undangan',
        'jumlah_pendaftar_undangan_lulus',
        'jumlah_pendaftar_undangan_tidak_lulus',
        'jumlah_pendaftar_undangan_pindah',
        'jumlah_pendaftar_reguler',
        'jumlah_pendaftar_reguler_lulus',
        'jumlah_pendaftar_reguler_tidak_lulus',
        'is_active'
    ];
}
