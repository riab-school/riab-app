<?php

namespace App\Http\Controllers\Staff\Perizinan;

use App\Http\Controllers\Controller;
use App\Models\StudentDetail;
use App\Models\StudentPermissionHistory;
use App\Models\StudentsParentDetail;
use Illuminate\Container\Attributes\DB;
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
        $data = StudentPermissionHistory::with(['detail.studentDetail', 'approvedBy.staffDetail', 'checkedOutBy.staffDetail', 'checkedInBy.staffDetail', 'rejectedBy.staffDetail'])->find($request->id);
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

    public function searchData(Request $request)
    {
        if($request->ajax()){
            $data = StudentDetail::with(['studentPermissionHistory'])->where('nis', $request->nis_or_nisn)->orWhere('nisn', $request->nis_or_nisn)->first();
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

    public function handleCreatePermission(Request $request)
    {
        $request->validate([
            'user_id'       => 'required|exists:users,id',
            'reason'        => 'required|string',
            'pickup_by'     => 'required|string',
            'from_date'     => 'required|date',
            'to_date'       => 'required|date',
            'requested_by'  => 'required',
        ]);

        try {
            // check if user already has permission with approved status
            $check = StudentPermissionHistory::where('user_id', $request->user_id)
                ->where('to_date', '<=', $request->from_date)
                ->whereNot('status', 'check_in')
                ->where('status', 'approved')
                ->first();
            if ($check) {
                return redirect()->back()->with([
                    'status'    => 'error',
                    'message'   => 'Perizinan sudah ada, silahkan cek di list perizinan',
                ]);
            }
            \DB::beginTransaction();
            $token = rand(100000, 999999);
            StudentPermissionHistory::create([
                'user_id'       => $request->user_id,
                'requested_by'  => $request->requested_by,
                'approved_by'   => auth()->user()->id,
                'token'         => $token,
                'reason'        => $request->reason,
                'pickup_by'     => $request->pickup_by,
                'from_date'     => $request->from_date,
                'to_date'       => $request->to_date,
                'status'        => 'approved',
            ]);

            \DB::commit();

            // Try Get Parents Number
            $studentParent = StudentsParentDetail::where('user_id', $request->user_id)->first();
            if ($studentParent) {
                $parentNumber = $studentParent->dad_phone != null ? $studentParent->dad_phone : $studentParent->mom_phone;
                // Send Whatsapp Notification
                $message = "Assalamualaikum Bapak/Ibu,.\n\n";
                $message .= "Ananda : *".$request->nama."* telah melakukan permohonan izin keluar sekolah.\n";
                $message .= "Tujuan :  ".$request->reason."\n";
                $message .= "Di jemput oleh :  ".$request->pickup_by."\n";
                $message .= "Dari Tanggal  :  ".$request->from_date."\n";
                $message .= "Hingga Tanggal  :  ".$request->to_date."\n";
                $message .= "----------------";
                $message .= "Di setuji oleh : *".auth()->user()->staffDetail->name."*\n";
                $message .= "Terima kasih. Wassalamualaikum.";
                $payload = [
                    'Phone'     => indoNumber($parentNumber),
                    'Body'      => $message,
                    'Category'  => 'permission_request',
                ];
                sendText($payload, true);
            }
            appLog(auth()->user()->id, 'success', 'Create new permission out for student : '.$request->nama);
            return redirect()->back()->with([
                'status'    => 'success',
                'message'   => 'Perizinan berhasil dibuat',
                'token'     => $token,
            ]);
        } catch (\Throwable $th) {
            \DB::rollBack();
            return redirect()->back()->with([
                'status'    => 'error',
                'message'   => 'Perizinan gagal dibuat',
            ]);
        }
    }

    public function handleUpdateStatus(Request $request)
    {
        $request->validate([
            'id'            => 'required|exists:student_permission_histories,id',
            'status'        => 'required|string',
            'reject_reason' => 'required_if:status,rejected'
        ]);
        try {
            \DB::beginTransaction();
            $data = StudentPermissionHistory::find($request->id);
            if ($data) {
                if ($request->status == 'approved') {
                    $token = rand(100000, 999999);
                    $data->update([
                        'status'            => $request->status,
                        'approved_by'       => auth()->user()->id,
                        'token'             => $token,
                        'reject_reason'     => null,
                        'rejected_by'       => null,
                        'checked_in_by'     => null,
                        'checked_in_at'     => null,
                        'checked_out_by'    => null,
                        'checked_out_at'    => null,
                    ]);
                    // Try Get Parents Number
                    $studentParent = StudentsParentDetail::where('user_id', $request->user_id)->first();
                    if ($studentParent) {
                        $parentNumber = $studentParent->dad_phone != null ? $studentParent->dad_phone : $studentParent->mom_phone;
                        // Send Whatsapp Notification
                        $message = "Assalamualaikum Bapak/Ibu,.\n\n";
                        $message .= "Ananda : *".$data->detail->studentDetail->name."* telah melakukan permohonan izin keluar sekolah.\n";
                        $message .= "Tujuan :  ".$data->reason."\n";
                        $message .= "Di jemput oleh :  ".$data->pickup_by."\n";
                        $message .= "Dari Tanggal  :  ".$data->from_date."\n";
                        $message .= "Hingga Tanggal  :  ".$data->to_date."\n";
                        $message .= "------------------";
                        $message .= "Di setuji oleh : *".auth()->user()->staffDetail->name."*\n";
                        $message .= "Terima kasih. Wassalamualaikum.";
                        $payload = [
                            'Phone'     => indoNumber($parentNumber),
                            'Body'      => $message,
                            'Category'  => 'permission_request',
                        ];
                        dd(sendText($payload, true));
                    }
                }
                if($request->status == 'rejected') {
                    $data->update([
                        'status'            => $request->status,
                        'reject_reason'     => $request->reject_reason,
                        'rejected_by'       => auth()->user()->id,
                        'checked_in_by'     => null,
                        'checked_in_at'     => null,
                        'checked_out_by'    => null,
                        'checked_out_at'    => null,
                        'token'             => null,
                    ]);
                }
                if($request->status == 'canceled') {
                    $data->update([
                        'status'            => $request->status,
                        'reject_reason'     => null,
                        'rejected_by'       => null,
                        'checked_in_by'     => null,
                        'checked_in_at'     => null,
                        'checked_out_by'    => null,
                        'checked_out_at'    => null,
                        'token'             => null,
                    ]);
                }
            }
            \DB::commit();
            appLog(auth()->user()->id, 'success', 'Update Status for : '.$data->detail->studentDetail->name. 'successfully');
            return redirect()->back()->with([
                'status'    => 'success',
                'message'   => 'Perizinan berhasil dirubah',
                'token'     => $data->token ?? null,
            ]);
        } catch (\Throwable $th) {
            \DB::rollBack();
            return redirect()->back()->with([
                'status'    => 'error',
                'message'   => 'Perizinan gagal dirubah',
            ]);
        }
    }


}
