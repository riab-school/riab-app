<?php

namespace App\Http\Controllers\Staff\MasterStudents;

use App\Http\Controllers\Controller;
use App\Models\MasterClassroom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class StudentListController extends Controller
{
    public function showListStudentPage(Request $request)
    {
        if ($request->ajax()) {
            $data = User::whereRelation('studentDetail', 'status', 'active')
                ->whereRelation('studentDetail.studentClassroomHistory', 'classroom_id', $request->classroom)
                ->whereRelation('studentDetail.studentClassroomHistory', 'tahun_ajaran_id', Session::get('tahun_ajaran_aktif_id'))
                ->with(['studentDetail'])
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('ttl', function ($row) {
                    return $row->studentDetail->place_of_birth !== NULL && $row->studentDetail->date_of_birth !== NULL ? $row->studentDetail->place_of_birth.", ".dateIndo($row->studentDetail->date_of_birth) : '-';
                })
                ->editColumn('gender', function ($row) {
                    return $row->studentDetail->gender !== NULL ? ($row->studentDetail->gender == 'male' ? 'Laki-laki' : 'Perempuan') : "-";
                })
                ->editColumn('address', function ($row) {
                    return $row->studentDetail->province_id ? getProvince($row->studentDetail->province_id). ", ".getCity($row->studentDetail->city_id): '-';
                })
                ->make(true);
        }
        return view('app.staff.master-student.list');
    }

    public function getClassRoomsByGrade(Request $request)
    {
        if ($request->ajax()) {
            $data = MasterClassroom::where('grade', $request->grade)->orderBy('name', 'ASC')->get();
            return $data;
        }
    }

    public function studentDetail(Request $request)
    {
        if($request->has('id')) {
            $student = User::where('id', $request->id)->with(['studentDetail'])->first();
            return view('app.staff.master-student.detail', ['detail' => $student]);
        }
        return redirect()->route('staff.master-student.list');
    }

}
