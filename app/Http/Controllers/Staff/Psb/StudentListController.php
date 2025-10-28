<?php

namespace App\Http\Controllers\Staff\Psb;

use App\Http\Controllers\Controller;
use App\Models\PsbConfig;
use App\Models\PsbDocumentRejection;
use App\Models\PsbHistory;
use App\Models\StudentDetail;
use App\Models\StudentsDocument;
use App\Models\User;
use Illuminate\Http\Request;

class StudentListController extends Controller
{
    public function showStudentListPage(Request $request)
    {
        $data = [
            'dataStudent' => StudentDetail::where('status', 'new')->with('studentOriginDetail', 'cityDetail', 'studentDocument')->get(),
        ];
        return view('app.staff.master-psb.student-list', $data);
    }

    public function studentDetail(Request $request, $id)
    {
        $data = [
            'detail' => StudentDetail::with('studentOriginDetail', 'cityDetail', 'studentDocument')->findOrFail($id),
        ];
        return view('app.staff.master-psb.student-detail', $data);
    }

    public function loginAsStudent(Request $request)
    {
        $student = User::findOrFail($request->user_id);
        auth()->login($student);
        return redirect()->route('student.home.new')->with([
            'status'    => 'success',
            'message'   => 'Berhasil login sebagai siswa.'
        ]);
    }

    public function handleAcceptAndRejectData(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'type'      => 'required|string',
            'action'    => 'required|string',
            'reason'    => 'nullable|string',
        ]);

        // type is a table_name like students_origin_schools, students_parent_details, students_guardian_details, students_documents
        if($request->type == 'students_documents' && $request->action == 'approve') {
            StudentsDocument::where('user_id', $request->user_id)->update([
                'is_completed' => true,
            ]);
        } elseif($request->type !== 'students_documents' && $request->action == 'reject') {
            \DB::table($request->type)->where('user_id', $request->user_id)->update([
                'is_completed' => false,
                'is_rejected'  => true,
                'rejection_reason' => $request->reason,
            ]);
        } elseif($request->type !== 'students_documents' && $request->action == 'approve') {
            \DB::table($request->type)->where('user_id', $request->user_id)->update([
                'is_completed' => true,
                'is_rejected'  => false,
                'rejection_reason' => null,
            ]);
        } elseif(!in_array($request->type, ['students_origin_schools', 'students_parent_details', 'students_guardian_details', 'students_documents', 'student_details']) && $request->action == 'reject_item') {
            StudentsDocument::where('user_id', $request->user_id)->update([
                'is_completed' => false,
            ]);
            PsbDocumentRejection::create([
                'user_id'               => $request->user_id,
                'psb_config_id'         => PsbConfig::where('is_active', true)->first()->id,
                'document_field_key'    => $request->type,
                'rejection_reason'      => $request->reason,
                'reject_by'             => auth()->user()->id,
                'status'                => 'rejected',
            ]);
        }

        return response()->json(['message' => 'Status updated successfully.']);
    }

    public function handleKelulusanAdm(Request $request)
    {
        // Check All Required to be verified

        $check0 = StudentDetail::where('user_id', $request->user_id)->where('is_completed', true)->first();
        $check1 = StudentsDocument::where('user_id', $request->user_id)->where('is_completed', true)->first();
        $check2 = \DB::table('students_origin_schools')->where('user_id', $request->user_id)->where('is_completed', true)->first();
        $check3 = \DB::table('students_parent_details')->where('user_id', $request->user_id)->where('is_completed', true)->first();
        $check4 = \DB::table('students_guardian_details')->where('user_id', $request->user_id)->where('is_completed', true)->first();

        if(!$check0 || !$check1 || !$check2 || !$check3 || !$check4) {
            PsbHistory::where('user_id', $request->user_id)
            ->update([
                'is_administration_confirmed'   => NULL,
                'is_administration_pass'        => NULL,
                'administration_summary'        => NULL,
            ]);
            return redirect()->back()->with([
                'status'    => 'error',
                'message'   => 'Semua data siswa belum lengkap atau ada yang ditolak. Tidak dapat memproses kelulusan administrasi.'
            ]);
        }

        if($request->action == 'approve') {
            // 
        }

        PsbHistory::where('user_id', $request->user_id)
            ->update([
                'is_administration_confirmed'   => 1,
                'is_administration_pass'        => $request->action == 'approve' ? 1 : 0,
                'is_paid'                       => $request->action == 'approve' ? 1 : 0,
                'administration_summary'        => NULL,
            ]);
        
        return redirect()->route('staff.master-psb.student-list')->with([
            'status'    => 'success',
            'message'   => 'Berhasil memperbarui status kelulusan administrasi siswa.'
        ]);
    }
}
