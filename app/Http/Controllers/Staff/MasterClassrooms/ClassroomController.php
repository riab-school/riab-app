<?php

namespace App\Http\Controllers\Staff\MasterClassrooms;

use App\Http\Controllers\Controller;
use App\Models\MasterClassroom;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ClassroomController extends Controller
{
    public function showClassroomList(Request $request)
    {
        if($request->ajax()) {
            $data = MasterClassroom::get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('head_id', function ($row) {
                    return $row->headDetail !== NULL ? $row->headDetail->staffDetail->name : '-';
                })
                ->editColumn('head_tahfidz_id', function ($row) {
                    return $row->headTahfidzDetail !== NULL ? $row->headTahfidzDetail->staffDetail->name : '-';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d-m-Y H:i:s');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d-m-Y H:i:s');
                })
                ->make(true);
        }
        return view('app.staff.classroom.list');
    }
}
