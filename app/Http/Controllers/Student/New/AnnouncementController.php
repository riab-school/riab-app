<?php

namespace App\Http\Controllers\Student\New;

use App\Http\Controllers\Controller;
use App\Models\PsbHistory;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        return view('app.student.new.pengumuman');
    }

    public function handlePindahReguler(Request $request)
    {
        $history =  $request->registration_history;

        // Validasi hanya bisa pindah dari undangan
        if (! in_array($request->registration_method, ['invited', 'invited-reguler'])) {
            return redirect()->route('student.home.new')->with([
                'status' => 'error',
                'message' => 'Anda sudah berada di jalur reguler.',
            ]);
        }

        // Validasi: hanya boleh jika tidak lulus
        if ($history->is_administration_pass === true || $history->is_exam_pass === true) {
            return redirect()->route('student.home.new')->with([
                'status' => 'error',
                'message' => 'Anda tidak dapat berpindah jalur karena telah lulus jalur undangan.',
            ]);
        }

        // Update jalur di user
        $history->update([
            'is_paid' => false,
            'class_focus' => null,
            'is_moved_to_non_invited' => 1,
            'exam_number' => null,
            'is_administration_pass' => null,
            'administration_summary' => null,
            'exam_summary' => null,
            'is_administration_confirmed' => null,
            'is_exam_pass' => null,
        ]);

        // Hapus di psb_interview_rooms
        $history->studentInterviewRoom()->delete();
        $history->parentInterviewRoom()->delete();
        $history->studentCatRoom()->delete();

        // Tambahkan log (opsional)
        appLog($history->user_id, 'success', 'Pindah jalur dari Undangan ke Reguler');
        return redirect()->route('student.home.new')->with([
            'status' => 'success',
            'message' => 'Berhasil pindah ke jalur reguler. Silakan lanjutkan pengisian data diri jalur reguler.',
        ]);
    }
}
