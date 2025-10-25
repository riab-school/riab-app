<?php

namespace App\Http\Controllers\Staff\Psb;

use App\Http\Controllers\Controller;
use App\Models\StudentDetail;
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
}
