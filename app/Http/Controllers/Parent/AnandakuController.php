<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\MasterTahunAjaran;
use App\Models\ParentClaimStudent;
use App\Models\StudentDetail;
use Illuminate\Http\Request;

class AnandakuController extends Controller
{
    public function showPage()
    {
        // Check if the user is logged in has student
        $check = ParentClaimStudent::where('parent_user_id', auth()->user()->id)->first();
        if ($check && $check->student_user_id !== null) {
            $tahun_ajaran_id = MasterTahunAjaran::where('is_active', 1)->first()->id;
            $detail = StudentDetail::where('user_id', $check->student_user_id)
            ->with([
                'studentDocument',
                'studentParentDetail',
                'studentGuardianDetail',
                'studentClassroomHistory' => function($q) use ($tahun_ajaran_id) {
                    $q->where('tahun_ajaran_id', $tahun_ajaran_id)
                    ->with('classroomDetail')
                    ->limit(1);
                },
                'studentDormitoryHistory' => function($q) use ($tahun_ajaran_id) {
                    $q->where('tahun_ajaran_id', $tahun_ajaran_id)
                    ->with('dormitoryDetail')
                    ->limit(1);
                },
                'studentClassroomHistory.classroomDetail' => function($q) use ($tahun_ajaran_id) {
                    $q->where('tahun_ajaran_id', $tahun_ajaran_id)
                    ->with('userDetail')
                    ->limit(1);
                },
            ])
            ->first();

            $classroomHistory = $detail->studentClassroomHistory->first(); 
            $dormitoryHistory = $detail->studentDormitoryHistory->first();            

            $data = [
                'status'  => true,
                'message' => 'Data ditemukan',
                'data'    => $detail,
                'classroomInfo' => $classroomHistory ? $classroomHistory->classroomDetail : null,
                'dormitoryInfo' => $dormitoryHistory ? $dormitoryHistory->dormitoryDetail : null,
                
            ];
        } else {
            $data = [
                'status' => false,
                'message' => 'Data tidak ditemukan',
                'data' => null
            ];
        }
        return view('app.parent.anandaku', $data);
    }

    public function findStudentData(Request $request)
    {
        if($request->ajax()) {
            $data = StudentDetail::where('status', 'active')->where('nis', $request->nis_nisn)->orWhere('nisn', $request->nis_nisn)->first();
            if (!$data) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data NIS/NISN tidak ditemukan'
                ], 404);
            }
            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);
        }
    }

    public function pairingStudentWithParent(Request $request)
    {
        if($request->ajax()) {
            try {
                $check = ParentClaimStudent::where('parent_user_id', auth()->user()->id)->first();
                if ($check && $check->student_user_id !== null) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data sudah terdaftar'
                    ], 400);
                }

                ParentClaimStudent::create([
                    'parent_user_id'    => auth()->user()->id,
                    'student_user_id'   => $request->student_user_id
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil disambungkan',
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
                
        }
    }
}
