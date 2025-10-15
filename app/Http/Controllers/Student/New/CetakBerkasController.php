<?php

namespace App\Http\Controllers\Student\New;

use App\Http\Controllers\Controller;
use App\Models\PsbCatRoom;
use App\Models\PsbInterviewRoom;
use App\Models\PsbParentInterviewRoom;
use App\Models\StudentDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Pdf;

class CetakBerkasController extends Controller
{
    public function index()
    {
        return view('app.student.new.cetak-berkas');
    }

    public function getAvailabilitySchedule(Request $request)
    {
        if ($request->ajax()) {

            $method  = request()->registration_method;
            $history = request()->registration_history;
            $config  = request()->psb_config;
            $exam_date = $request->exam_date;

            // --- 1. Hitung jumlah peserta yang sudah terdaftar di tanggal itu ---
            if (in_array($method, ['reguler', 'invited-reguler'])) {
                // Jalur reguler & invited-reguler ikut CAT
                $countToday = PsbCatRoom::whereDate('exam_date', $exam_date)->count();
            } else {
                // Jalur undangan hanya interview
                $countToday = PsbInterviewRoom::whereDate('exam_date', $exam_date)->count();
            }

            // --- 2. Hitung counter untuk peserta berikutnya ---
            $counter = $countToday + 1;

            // --- 3. Dapatkan jadwal dari helper ---
            $jadwal = getJadwal($counter, $exam_date);

            // --- 4. Jika kapasitas penuh ---
            if ($jadwal === false) {
                return response()->json([
                    'status' => 'full',
                    'message' => 'Kuota untuk tanggal ' . dateIndo($exam_date) . ' sudah penuh. Silakan pilih tanggal lain.'
                ]);
            }

            // --- 5. Jika masih tersedia ---
            return response()->json([
                'status' => 'success',
                'data'   => $jadwal,
                'message'=> 'Kuota masih tersedia untuk tanggal ' . dateIndo($exam_date)
            ]);
        }

        // Jika bukan AJAX
        abort(403, 'Unauthorized access');
    }




    public function handlePilihJadwal(Request $request)
    {
        $request->validate([
            'exam_date'         => 'required|date',
            'class_focus'       => 'required',
            'verify_exam_date'  => 'accepted',
        ], [
            'verify_exam_date.accepted' => 'Anda harus menyetujui pernyataan diatas',
        ]);

        $user      = auth()->user();
        $method    = request()->registration_method;
        $config    = request()->psb_config;
        $examDate  = $request->exam_date;
        $history   = request()->registration_history;
        
        // === 1. Pastikan peserta belum memilih jadwal sebelumnya ===
        if ($history->studentInterviewRoom !== NULL) {
            return redirect()->back()->with([
                'status'  => 'error',
                'message' => 'Anda sudah pernah memilih jadwal ujian sebelumnya',
            ]);
        }
        
        try {
            \DB::beginTransaction();

            // === 2. Hitung total peserta di tanggal tersebut (berdasar jalur) ===
            if (in_array($method, ['reguler', 'invited-reguler'])) {
                $countToday = PsbCatRoom::whereDate('exam_date', $examDate)->count();
            } else {
                $countToday = PsbInterviewRoom::whereDate('exam_date', $examDate)->count();
            }

            $counter = $countToday + 1;

            // === 3. Dapatkan jadwal dari helper ===
            $jadwal = getJadwal($counter, $examDate);
            if ($jadwal === false) {
                return redirect()->back()->with([
                    'status'  => 'error',
                    'message' => 'Kuota untuk tanggal ' . dateIndo($examDate) . ' sudah penuh. Silakan pilih tanggal lain.',
                ]);
            }

            // === 4. Update PSB History ===
            $history->update([
                'class_focus' => $request->class_focus,
            ]);

            // === 5. Simpan Ruangan ===
            if (in_array($method, ['reguler', 'invited-reguler'])) {
                // --- CAT (Reguler dan Invited-Reguler) ---
                PsbCatRoom::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'psb_config_id' => $config->id,
                        'exam_date'     => $jadwal['exam_date'],
                        'room_name'     => $jadwal['ruang_cat'],
                        'room_session'  => $jadwal['sesi_cat'],
                    ]
                );
            }

            // --- Interview Santri (semua jalur) ---
            PsbInterviewRoom::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'psb_config_id' => $config->id,
                    'exam_date'     => $jadwal['exam_date'],
                    'room_name'     => $jadwal['ruang_interview'],
                    'room_session'  => $jadwal['sesi_interview'],
                ]
            );

            // --- Interview Orang Tua (semua jalur) ---
            PsbParentInterviewRoom::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'psb_config_id' => $config->id,
                    'exam_date'     => $jadwal['exam_date'],
                    'room_name'     => $jadwal['ruang_interview_orangtua'],
                    'room_session'  => $jadwal['sesi_interview_orangtua'],
                ]
            );

            // === 6. (Opsional) Generate Exam Number ===
            // Nomor ujian bisa dibuat otomatis saat panitia menyetujui administrasi,
            // tapi kalau mau langsung di sini, aktifkan kode berikut:
            if (!$history->exam_number) {
                $examNumber = getCounter($user->id); // aman dengan lock
                $history->update(['exam_number' => $examNumber]);
            }

            \DB::commit();

            appLog($user->id, 'success', 'Berhasil memilih jadwal ujian');
            return redirect()->back()->with([
                'status'  => 'success',
                'message' => 'Berhasil memilih jadwal ujian pada tanggal ' . dateIndo($jadwal['exam_date']) . ' - ' . $jadwal['ruang_cat'] . ' (Sesi ' . $jadwal['sesi_cat'] . ')' . ' dan ' . $jadwal['ruang_interview'] . ' (Sesi ' . $jadwal['sesi_interview'] . ')' . '. Silakan cetak kartu ujian Anda pada halaman berikutnya.',
            ]);

        } catch (\Throwable $th) {
            \DB::rollBack();
            appLog(auth()->user()->id, 'error', 'Gagal memilih jadwal ujian: ' . $th->getMessage());
            return redirect()->back()->with([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan saat memilih jadwal ujian: ' . $th->getMessage(),
            ]);
        }
    }


    public function handleCetak()
    {

        $user     = auth()->user();
        $history  = request()->registration_history;
        $config   = request()->psb_config;
        $method   = request()->registration_method;

        // === Pastikan peserta sudah memilih jadwal sebelumnya ===
        if ($history->studentInterviewRoom == NULL) {
            return redirect()->back()->with([
                'status'  => 'error',
                'message' => 'Anda belum memilih jadwal ujian',
            ]);
        }
        
        // --- Jalur efektif ---
        $jalur = match ($method) {
            'reguler'          => 'Reguler / Umum',
            'invited'          => 'Undangan',
            'invited-reguler'  => 'Undangan (Pindah Reguler)',
            default            => 'Tidak Diketahui',
        };

        // --- Ambil data lengkap siswa ---
        $student = StudentDetail::where('user_id', $user->id)
            ->with([
                'studentParentDetail',
                'studentGuardianDetail',
                'studentOriginDetail',
                'studentDocument',
            ])
            ->firstOrFail();

        // --- Persiapkan data yang dikirim ke view PDF ---
        $psbHistory = (object) [
            'exam_number'              => $history->exam_number,
            'registration_number'      => $history->registration_number,
            'class_focus'              => $history->class_focus,
            'exam_date'                => $history->studentCatRoom->exam_date
                                            ?? $history->studentInterviewRoom->exam_date
                                            ?? $history->parentInterviewRoom->exam_date
                                            ?? now()->format('Y-m-d'),
            'cat_room'                 => $history->studentCatRoom->room_name ?? null,
            'cat_session'              => $history->studentCatRoom->room_session ?? null,
            'interview_room'           => $history->studentInterviewRoom->room_name ?? null,
            'interview_session'        => $history->studentInterviewRoom->room_session ?? null,
            'parent_interview_room'    => $history->parentInterviewRoom->room_name ?? null,
            'parent_interview_session' => $history->parentInterviewRoom->room_session ?? null,
        ];

        // --- Siapkan data untuk view ---
        $data = [
            'student'    => $student,
            'psbHistory' => $psbHistory,
            'psbConfig'  => $config,
            'jalur'      => $jalur,
        ];

        // --- Render PDF ---
        $pdf = Pdf::setOption(['dpi' => 150])
            ->loadView('app.student.new.berkas-pdf', $data)
            ->setOption('isRemoteEnabled', true);

        // --- Stream hasilnya ke browser ---
        $filename = strtoupper($jalur) . '_' . $student->nik_ktp . '_KartuUjian.pdf';
        return $pdf->stream($filename);
    }
}
