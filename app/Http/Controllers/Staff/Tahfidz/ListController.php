<?php

namespace App\Http\Controllers\Staff\Tahfidz;

use App\Http\Controllers\Controller;
use App\Models\StudentDetail;
use App\Models\StudentsMemorization;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Storage;

class ListController extends Controller
{
    public function showListPage(Request $request)
    {
        if($request->ajax() && $request->by == 'all'){
            $data  = StudentsMemorization::with(['userDetail.studentDetail'])->orderBy('created_at', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d-m-Y');
                })
                ->editColumn('process_by', function ($row) {
                    return  $row->tasmikBy->staffDetail->name ?? '-';
                })
                ->editColumn('surah', function ($row) {
                    return $row->getSurahNameAttribute();
                })
                ->editColumn('juz', function ($row) {
                    return $row->getJuzAttribute();
                })
                ->editColumn('ayat', function ($row) {
                    return $row->from_ayat . ' - ' . $row->to_ayat;
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
        return view('app.staff.tahfidz-hafalan.list.list');
    }

    public function searchData(Request $request)
    {
        if($request->ajax()){
            $data = StudentDetail::with(['studentTahfidzHistory'])->where('nis', $request->nis_or_nisn)->orWhere('nisn', $request->nis_or_nisn)->first();
            if (!$data) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found'
                ], 404);
            }

            $data->progress = getJuzProgress($data->user_id);
            
            // Map evidance button
            $data->studentTahfidzHistory->map(function ($tahfidz) {
                if ($tahfidz->evidence) {
                    $url = Storage::disk('s3')->url($tahfidz->evidence);
                    $tahfidz->evidence = '<div class="btn-group">
                        <button data-src="' . $url . '" class="btn btn-icon btn-outline-primary img-preview">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>';
                } else {
                    $tahfidz->evidence = '-';
                }

                // Format Juz
                $tahfidz->juz = $tahfidz->getJuzAttribute();
                
                // Format Surah Name
                $tahfidz->surah_name = $tahfidz->getSurahNameAttribute();

                $tahfidz->ayat = $tahfidz->from_ayat . ' s/d ' . $tahfidz->to_ayat;

                // Progress Per Jus

                


                // Format created_at
                $tahfidz->created_date = $tahfidz->created_at ? $tahfidz->created_at->format('d-m-Y') : '-';
                
                // Format process_by
                $tahfidz->process_by = $tahfidz->tasmikBy->staffDetail->name ?? '-';
                return $tahfidz;
            });
            
            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);
        }
    }
}
