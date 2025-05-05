<?php

namespace App\Http\Controllers\Staff\Pelanggaran;

use App\Http\Controllers\Controller;
use App\Models\StudentsViolation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Storage;

class ListController extends Controller
{
    public function showListPelanggaranPage(Request $request)
    {
        if($request->ajax()){
            $data  = StudentsViolation::with(['userDetail.studentDetail', 'processBy'])->orderBy('created_at', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d-m-Y');
                })
                ->editColumn('process_by', function ($row) {
                    return $row->process_by ? $row->processBy->staffDetail->name : '-';
                })
                ->editColumn('evidence', function ($row) {
                    return $row->evidence   ?   '<div class="btn-group">
                                                    <button data-src="'.Storage::disk('s3')->url($row->evidence).'" class="btn btn-icon btn-outline-primary img-preview"><i class="fas fa-eye"></i></button>
                                                </div>' 
                                            : 'Tidak Ada';                                                    
                })
                ->rawColumns(['evidence'])
                ->make(true);
        }
        return view('app.staff.pelanggaran.list.index');
    }

    public function showDetailData(Request $request)
    {
        $data = StudentsViolation::with(['userDetail.studentDetail', 'processBy.staffDetail'])->find($request->id);
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found'
            ], 404);
        }        
        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }
}
