<?php

namespace App\Http\Controllers\Staff\Psb;

use App\Http\Controllers\Controller;
use App\Models\PsbConfig;
use App\Models\PsbExamAlquranHistory;
use App\Models\PsbExamParentInterviewHistory;
use App\Models\PsbExamPrayHistory;
use App\Models\PsbExamStudentInterviewHistory;
use App\Models\PsbHistory;
use App\Models\StudentDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InterviewController extends Controller
{
    public function showInterviewIndex(Request $request)
    {
        return view('app.staff.master-psb.interview.index');
    }

    public function showInterviewDetail(Request $request)
    {
        $request->validate([
            'search_by' => 'required',
            'value' => 'required'
        ]);

        try {
            switch ($request->search_by) {
                case 'nik_ktp':
                    $student = StudentDetail::where('nik_ktp', $request->value)->first();
                    $psbData = PsbHistory::where('user_id', $student->user_id)->first();
                    if ($psbData !== NULL && $psbData->is_moved_to_non_invited == false) {
                        $psbData = $psbData;
                        $jalur  = "Undangan";
                    } elseif ($psbData !== NULL && $psbData->is_moved_to_non_invited == true) {
                        $psbData = PsbHistory::where('user_id', $student->user_id)->first();
                        $jalur  = "Reguler";
                    } else {
                        $psbData = PsbHistory::where('user_id', $student->user_id)->first();
                        $jalur  = "Reguler";
                    }
                    break;
                case 'registration_number':
                    $psbData = PsbHistory::where('registration_number', $request->value)->first();
                    if ($psbData !== NULL && $psbData->is_moved_to_non_invited == false) {
                        $psbData = $psbData;
                        $jalur  = "Undangan";
                    } elseif ($psbData !== NULL && $psbData->is_moved_to_non_invited == true) {
                        $psbData = PsbHistory::where('registration_number', $request->value)->first();
                        $jalur  = "Reguler";
                    } else {
                        $psbData = PsbHistory::where('registration_number', $request->value)->first();
                        $jalur  = "Reguler";
                    }
                    $student = StudentDetail::where('user_id', $psbData->user_id)->first();
                    break;
                case 'exam_number':
                    $psbData = PsbHistory::where('exam_number', $request->value)->first();
                    if ($psbData !== NULL && $psbData->is_moved_to_non_invited == false) {
                        $psbData = $psbData;
                        $jalur  = "Undangan";
                    } elseif ($psbData !== NULL && $psbData->is_moved_to_non_invited == true) {
                        $psbData = PsbHistory::where('exam_number', $request->value)->first();
                        $jalur  = "Reguler";
                    } else {
                        $psbData = PsbHistory::where('exam_number', $request->value)->first();
                        $jalur  = "Reguler";
                    }
                    $student = StudentDetail::where('user_id', $psbData->user_id)->first();
                    break;
                case 'student_id':
                    $psbData = PsbHistory::where('user_id', $request->value)->first();
                    if ($psbData !== NULL && $psbData->is_moved_to_non_invited == false) {
                        $psbData = $psbData;
                        $jalur  = "Undangan";
                    } elseif ($psbData !== NULL && $psbData->is_moved_to_non_invited == true) {
                        $psbData = PsbHistory::where('exam_number', $request->value)->first();
                        $jalur  = "Reguler";
                    } else {
                        $psbData = PsbHistory::where('exam_number', $request->value)->first();
                        $jalur  = "Reguler";
                    }
                    $student = StudentDetail::where('user_id', $psbData->user_id)->first();
                    break;
            }
            
            $data = [
                'detail'    => StudentDetail::where('user_id', $student->user_id)->with(
                    [
                        'studentParentDetail', 
                        'studentGuardianDetail', 
                        'studentOriginDetail',
                        'studentDocument',
                        'studentAchievementHistory',
                        'studentInterview',
                        'studentParentInterview',
                        'studentBacaan',
                        'studentIbadah'
                    ])->first(),
                'jalur'     => $jalur,
                'psbData'   => $psbData,
            ];
            return view('app.staff.master-psb.interview.detail', $data);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->back()->with([
                'status'    => 'error',
                'message'   => 'Data tidak ditemukan atau terjadi kesalahan pada sistem.'
            ]);
        } 
    }

    public function storeExam1(Request $request)
    {
        $request->validate([
            'user_id'                   => 'required',
            'prestasi_akademik'         => 'required',
            'prestasi_non_akademik'     => 'required',
            'bahasa_inggris'            => 'required',
            'bahasa_arab'               => 'required',
            'info_masuk'                => 'required',
            'alasan_masuk'              => 'required',
            'riwayat_penyakit'          => 'required',
            'merokok'                   => 'required',
            'pacaran'                   => 'required',
            'penggunaan_hp'             => 'required',
            'pelanggaran'               => 'required',
            'guru_tidak_suka'           => 'required',
            'pelajaran_suka'            => 'required',
            'pelajaran_tidak_suka'      => 'required',
            'cita_cita'                 => 'required',
            'alasan_memilih_jurusan'    => 'required',
            'hubungan_ortu'             => 'required',
            'rekomendasi_interview'     => 'required',
            'keterangan_interview'      => 'required',
        ]);

        try {
            DB::beginTransaction();
            $psbConfig = PsbConfig::where('is_active', true)->first();
            PsbExamStudentInterviewHistory::updateOrCreate([
                'user_id'               => $request->user_id,
            ],
            [
                'psb_configs_id'        => $psbConfig->id,
                'prestasi_akademik'     => $request->prestasi_akademik,
                'prestasi_non_akademik' => $request->prestasi_non_akademik,
                'bahasa_inggris'        => $request->bahasa_inggris,
                'bahasa_arab'           => $request->bahasa_arab,
                'info_masuk'            => $request->info_masuk,
                'alasan_masuk'          => $request->alasan_masuk,
                'riwayat_penyakit'      => $request->riwayat_penyakit,
                'merokok'               => $request->merokok,
                'pacaran'               => $request->pacaran,
                'penggunaan_hp'         => $request->penggunaan_hp,
                'pelanggaran'           => $request->pelanggaran,
                'guru_tidak_suka'       => $request->guru_tidak_suka,
                'pelajaran_suka'        => $request->pelajaran_suka,
                'pelajaran_tidak_suka'  => $request->pelajaran_tidak_suka,
                'cita_cita'             => $request->cita_cita,
                'alasan_memilih_jurusan'=> $request->alasan_memilih_jurusan,
                'hubungan_ortu'         => $request->hubungan_ortu,
                'rekomendasi_interview' => $request->rekomendasi_interview,
                'keterangan_interview'  => $request->keterangan_interview,
                'point'                 => $request->point,     
                'tested_by'             => auth()->user()->id,
            ]);

            DB::commit();
            return redirect()->route('staff.master-psb.interview')->with([
                'status'    => 'success',
                'message'   => 'Data berhasil di simpan.'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('staff.master-psb.interview.detail', ['search_by' => 'student_id', 'value' => $request->user_id])->with([
                'status'    => 'error',
                'message'   => 'Data gagal di simpan.'
            ]);
        }
    }

    public function storeExam2(Request $request)
    {
        $request->validate([
            'user_id'               => 'required',
            'khatak_jali'           => 'required',
            'khatak_kafi'           => 'required',
            'total_skor'            => 'required',
            'jumlah_hafalan'        => 'required',
            'kualitas_hafalan'      => 'required',
            'rekomendasi_hafalan'   => 'required',
            'rekomendasi_bacaan'    => 'required',
            'keterangan_hafalan'    => 'required',
        ]);

        try {
            DB::beginTransaction();
            $psbConfig = PsbConfig::where('is_active', true)->first();
            PsbExamAlquranHistory::updateOrCreate([
                'user_id'               => $request->user_id,
            ],
            [
                'psb_configs_id'        => $psbConfig->id,
                'khatak_jali'           => $request->khatak_jali,
                'khatak_kafi'           => $request->khatak_kafi,
                'total_skor'            => $request->total_skor,
                'jumlah_hafalan'        => $request->jumlah_hafalan,
                'kualitas_hafalan'      => $request->kualitas_hafalan,
                'rekomendasi_hafalan'   => $request->rekomendasi_hafalan,
                'rekomendasi_bacaan'    => $request->rekomendasi_bacaan,
                'keterangan_hafalan'    => $request->keterangan_hafalan,
                'point'                 => $request->point,
                'point_hafalan'         => $request->point_hafalan,
                'tested_by'             => auth()->user()->id,
            ]);
            DB::commit();
            return redirect()->route('staff.master-psb.interview')->with([
                'status'    => 'success',
                'message'   => 'Data berhasil di simpan.'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('staff.master-psb.interview.detail', ['search_by' => 'student_id', 'value' => $request->user_id])->with([
                'status'    => 'error',
                'message'   => 'Data gagal di simpan.'
            ]);
        }
    }

    public function storeExam3(Request $request)
    {
        $request->validate([
            'user_id'               => 'required',
            'bacaan_sholat'         => 'required',
            'doa_sehari_hari'       => 'required',
            'sholat_jenazah'        => 'required',
            'niat_niat'             => 'required',
            'qiraatul_kutub'        => 'required',
            'rekomendasi_ibadah'    => 'required',
            'keterangan_ibadah'     => 'required',
            'point'                 => 'required',
        ]);

        try {
            DB::beginTransaction();
            $psbConfig = PsbConfig::where('is_active', true)->first();
            PsbExamPrayHistory::updateOrCreate([
                'user_id'               => $request->user_id,
            ],
            [
                'psb_configs_id'        => $psbConfig->id,
                'bacaan_sholat'         => $request->bacaan_sholat,
                'doa_sehari_hari'       => $request->doa_sehari_hari,
                'sholat_jenazah'        => $request->sholat_jenazah,
                'niat_niat'             => $request->niat_niat,
                'qiraatul_kutub'        => $request->qiraatul_kutub,
                'rekomendasi_ibadah'    => $request->rekomendasi_ibadah,
                'keterangan_ibadah'     => $request->keterangan_ibadah,
                'point'                 => $request->point,
                'tested_by'             => auth()->user()->id,
            ]);
            DB::commit();
            return redirect()->route('staff.master-psb.interview')->with([
                'status'    => 'success',
                'message'   => 'Data berhasil di simpan.'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            return redirect()->route('staff.master-psb.interview.detail', ['search_by' => 'student_id', 'value' => $request->user_id])->with([
                'status'    => 'error',
                'message'   => 'Data gagal di simpan.'
            ]);
        }
    }

    public function storeExam4(Request $request)
    {
        $request->validate([
            'user_id'               => 'required',
        ]);

        try {
            DB::beginTransaction();
            $psbConfig = PsbConfig::where('is_active', true)->first();
            PsbExamParentInterviewHistory::updateOrCreate([
                'user_id'               => $request->user_id,
            ],
            [
                'psb_configs_id'        => $psbConfig->id,
                'q1'                    => $request->q1,
                'q2'                    => $request->q2,
                'q3'                    => $request->q3,
                'q4'                    => $request->q4,
                'q5'                    => $request->q5,
                'q6'                    => $request->q6,
                'q7'                    => $request->q7,
                'q8'                    => $request->q8,
                'q9'                    => $request->q9,
                'q10'                   => $request->q10,
                'q11'                   => $request->q11,
                'q12'                   => $request->q12,
                'q13'                   => $request->q13,
                'q14'                   => $request->q14,
                'q15'                   => $request->q15,
                'q16'                   => $request->q16,
                'q17'                   => '-',
                'q18'                   => '-',
                'q19'                   => '-',
                'q20'                   => '-',
                'q21'                   => '-',
                'q22'                   => '-',
                'q23'                   => '-',
                'q24'                   => '-',
                'q25'                   => '-',
                'q26'                   => '-',
                'q27'                   => '-',
                'q28'                   => '-',
                'q29'                   => '-',
                'q30'                   => '-',
                'q31'                   => '-',
                'tested_by'             => auth()->user()->id,
            ]);
            DB::commit();
            return redirect()->route('staff.master-psb.interview')->with([
                'status'    => 'success',
                'message'   => 'Data berhasil di simpan.'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('staff.master-psb.interview.detail', ['search_by' => 'student_id', 'value' => $request->user_id])->with([
                'status'    => 'error',
                'message'   => 'Data gagal di simpan.'
            ]);
        }
    }
}
