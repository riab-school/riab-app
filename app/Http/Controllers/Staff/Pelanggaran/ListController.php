<?php

namespace App\Http\Controllers\Staff\Pelanggaran;

use App\Http\Controllers\Controller;
use App\Models\StudentDetail;
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

    public function storeViolationPage()
    {
        return view('app.staff.pelanggaran.list.store');
    }

    public function storeViolation(Request $request)
    {
        $request->validate([
            'user_id'       => 'required|exists:users,id',
            'detail'        => 'required',
            'action_taked'  => 'required',
            'evidence'      => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            // dd($request->all());
            if($request->has('evidence')) {
                $folder     = 'student/' . $request->user_id . '/' . 'violation';
                $file       = $request->file('evidence');
                $filename   = time().'-'.$request->user_id . "." . $file->getClientOriginalExtension();
                $fullPath   = $folder . '/' . $filename;
                Storage::disk('s3')->put($fullPath, file_get_contents($file));
            }
            StudentsViolation::create([
                'user_id'       => $request->user_id,
                'detail'        => $request->detail,
                'action_taked'  => $request->action_taked,
                'evidence'      => $fullPath ?? null,
                'process_by'    => auth()->user()->id
            ]);

            // Todo : Send Whatsapp Notification to parent
            appLog(auth()->user()->id, 'success', 'Berhasil menambah pelanggaran untuk : '.$request->nama);
            return redirect()->back()->with([
                'status'    => 'success',
                'message'   => 'Pelanggaran berhasil ditambahkan',
            ]);
            
        } catch (\Throwable $th) {
            appLog(auth()->user()->id, 'error', 'Gagal menambah pelanggaran untuk : '.$request->nama);
            return redirect()->back()->with([
                'status'    => 'error',
                'message'   => 'Pelanggaran gagal ditambahkan',
            ]);
        }
    }

    public function searchData(Request $request)
    {
        if($request->ajax()){
            $data = StudentDetail::with(['studentViolationHistory'])->where('nis', $request->nis_or_nisn)->orWhere('nisn', $request->nis_or_nisn)->first();
            if (!$data) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found'
                ], 404);
            }

            // Map evidance button
            $data->studentViolationHistory->map(function ($violation) {
                if ($violation->evidence) {
                    $url = Storage::disk('s3')->url($violation->evidence);
                    $violation->evidence = '<div class="btn-group">
                        <button data-src="' . $url . '" class="btn btn-icon btn-outline-primary img-preview">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>';
                } else {
                    $violation->evidence = '-';
                }

                // Format created_at
                $violation->created_date = $violation->created_at ? $violation->created_at->format('d-m-Y') : '-';
                
                // Format process_by
                $violation->process_by = $violation->process_by ? $violation->processBy->staffDetail->name : '-';
                return $violation;
            });
            
            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);
        }
    }
}
