<?php

namespace App\Http\Controllers\Staff\Perizinan;

use App\Http\Controllers\Controller;
use App\Models\StudentPermissionHistory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ListController extends Controller
{
    public function showListPerizinanPage(Request $request)
    {  
        if($request->ajax()){
            $data  = StudentPermissionHistory::with(['detail.studentDetail'])->orderBy('created_at', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d-m-Y H:i:s');
                })
                ->make(true);
        }
        return view('app.staff.perizinan.list.index');
    }

    public function showDetailData(Request $request)
    {
        $data = StudentPermissionHistory::with(['detail.studentDetail', 'requestedBy', 'approvedBy', 'checkedOutBy', 'checkedInBy', 'rejectedBy'])->find($request->id);
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

    public function createPagePermission()
    {
        return view('app.staff.perizinan.list.store');    
    }

    public function handleCreatePermission(Request $request)
    {
        
    }


}
