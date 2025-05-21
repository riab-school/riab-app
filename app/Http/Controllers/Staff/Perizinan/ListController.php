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
            if($request->requested_by == 'orang_tua'){
                $data  = StudentPermissionHistory::where('requested_by', 'orang_tua')->orWhere('requested_by', 'wali')->with(['detail.studentDetail'])->orderBy('created_at', 'DESC')->get();
            } else {
                $data  = StudentPermissionHistory::where('requested_by', $request->requested_by)->with(['detail.studentDetail'])->orderBy('created_at', 'DESC')->get();
            }
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
        // dd($request->all());
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
                ->where('status', 'approved')
                ->orWhere('status', 'check_out')
                ->whereNot('status', 'check_in')
                ->first();
            if ($check) {
                return redirect()->back()->with([
                    'status'    => 'error',
                    'message'   => 'Perizinan sudah ada atau santri sudah izin, silahkan cek di list perizinan',
                ]);
            }
            \DB::beginTransaction();
            $token = rand(100000, 999999);
            StudentPermissionHistory::create([
                'user_id'           => $request->user_id,
                'requested_by'      => $request->requested_by,
                'applicant_id'      => $request->requested_by == 'siswa' ? $request->user_id : NULL,
                'approved_by'       => auth()->user()->id,
                'token'             => $token,
                'reason'            => $request->reason,
                'pickup_by'         => $request->pickup_by,
                'from_date'         => $request->from_date,
                'to_date'           => $request->to_date,
                'is_notify_parent'  => $request->has('notify_parent') ? $request->notify_parent : 0,
                'status'            => 'approved',
            ]);

            \DB::commit();

            // Try Get Parents Number
            if($request->has('notify_parent') && $request->notify_parent == "1"){
                $studentParent = StudentsParentDetail::where('user_id', $request->user_id)->first();
                if ($studentParent) {
                    $parentNumber = $studentParent->dad_phone != null ? $studentParent->dad_phone : $studentParent->mom_phone;
                    // Send Whatsapp Notification
                    $message = "Assalamualaikum Bapak/Ibu.\n\n";
                    $message .= "*Ananda :*\n*".$request->nama."*\n\n_Telah melakukan permohonan izin keluar sekolah/dayah._ \n\n";
                    $message .= "*Tujuan/Alasan :*\n".$request->reason."\n\n";
                    $message .= "*Di jemput oleh :*\n".$request->pickup_by."\n\n";
                    $message .= "*Dari Tgl  :*\n".dateIndo($request->from_date)."\n\n";
                    $message .= "*Hingga Tgl  :*\n".dateIndo($request->to_date)."\n\n";
                    $message .= "----------------\n";
                    $message .= "*Di setujui oleh :*\nUstd/Ustzh *".auth()->user()->staffDetail->name."*\n\n";
                    $message .= "*Token Izin :*\n".$token."\n\n";
                    $message .= "Terima kasih. \nWassalamualaikum.";
                
                    $payloadText = [
                        'sessionId' => appSet('WHATSAPP_SESSION_ID'),
                        'type'      => 'text',
                        'category'  => 'permission_request',
                        'name'      => $studentParent->dad_name != null ? $studentParent->dad_name : $studentParent->mom_name,
                        'jid'       => whatsappNumber($parentNumber),
                        'text'      => $message
                    ];
                    sendText($payloadText);
                }
            }
            appLog(auth()->user()->id, 'success', 'Berhasil memberikan izin keluar sekolah untuk : '.$request->nama);
            return redirect()->back()->with([
                'status'    => 'success',
                'message'   => 'Perizinan berhasil dibuat',
                'token'     => $token,
            ]);
        } catch (\Throwable $th) {
            appLog(auth()->user()->id, 'error', 'Gagal memberikan izin keluar sekolah untuk : '.$request->nama);
            \DB::rollBack();
            return redirect()->back()->with([
                'status'    => 'error',
                'message'   => 'Perizinan gagal dibuat',
            ]);
        }
    }

    public function handleUpdateStatus(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'id'            => 'required|exists:student_permission_histories,id',
            'status'        => 'required|string',
            'reject_reason' => 'nullable|required_if:status,rejected',
            'from_date'     => 'nullable|required_if:status,approved',
            'to_date'       => 'nullable|required_if:status,approved',
        ]);

        try {
            \DB::beginTransaction();
            $data = StudentPermissionHistory::find($request->id);
            if ($data) {
                if ($request->status == 'approved') {
                    $token = rand(100000, 999999);
                    // Try Get Parents Number
                    $studentParent = StudentsParentDetail::where('user_id', $request->user_id)->first();
                    if ($studentParent) {
                        $parentNumber = $studentParent->dad_phone != null ? $studentParent->dad_phone : $studentParent->mom_phone;
                        // Send Whatsapp Notification
                        $message = "Assalamualaikum Bapak/Ibu.\n\n";
                        $message .= "*Ananda :*\n*".$data->detail->studentDetail->name."*\n\n_Telah melakukan permohonan izin keluar sekolah/dayah._ \n\n";
                        $message .= "*Tujuan/Alasan :*\n".$data->reason."\n\n";
                        $message .= "*Di jemput oleh :*\n".$data->pickup_by."\n\n";
                        $message .= "*Dari Tgl  :*\n".dateIndo($request->from_date)."\n\n";
                        $message .= "*Hingga Tgl  :*\n".dateIndo($request->to_date)."\n\n";
                        $message .= "----------------\n";
                        $message .= "*Di setujui oleh :*\nUstd/Ustzh *".auth()->user()->staffDetail->name."*\n\n";
                        $message .= "*Token Izin :*\n".$token."\n\n";
                        $message .= "Terima kasih. \nWassalamualaikum.";

                        $payloadText = [
                            'sessionId' => appSet('WHATSAPP_SESSION_ID'),
                            'type'      => 'text',
                            'category'  => 'permission_request',
                            'name'      => $studentParent->dad_name != null ? $studentParent->dad_name : $studentParent->mom_name,
                            'jid'       => whatsappNumber($parentNumber),
                            'text'      => $message
                        ];
                        sendText($payloadText);
                    }
                    // Update Data
                    $data->update([
                        'status'            => $request->status,
                        'approved_by'       => auth()->user()->id,
                        'token'             => $token,
                        'from_date'         => $request->from_date,
                        'to_date'           => $request->to_date,
                        'reject_reason'     => null,
                        'rejected_by'       => null,
                        'checked_in_by'     => null,
                        'checked_in_at'     => null,
                        'checked_out_by'    => null,
                        'checked_out_at'    => null,
                        'is_notify_parent'  => $studentParent ? 1 : 0,
                    ]);
                }
                if($request->status == 'rejected') {
                    // Try Get Parents Number
                    $studentParent = StudentsParentDetail::where('user_id', $request->user_id)->first();
                    if ($studentParent) {
                        $parentNumber = $studentParent->dad_phone != null ? $studentParent->dad_phone : $studentParent->mom_phone;
                        // Send Whatsapp Notification
                        $message = "Assalamualaikum Bapak/Ibu,.\n\n";
                        $message .= "*Ananda :*\n*".$data->detail->studentDetail->name."*\n\nPermohanan izin ananda telah *Di Tolak*.\n\n";
                        $message .= "*Alasan Penolakan :*\n".$request->reject_reason."\n";
                        $message .= "------------------\n";
                        $message .= "*Di Tolak oleh :*\nUstd/Ustzh *".auth()->user()->staffDetail->name."*\n";
                        $message .= "Terima kasih. Wassalamualaikum.";
                    
                        $payloadText = [
                            'sessionId' => appSet('WHATSAPP_SESSION_ID'),
                            'type'      => 'text',
                            'category'  => 'permission_request',
                            'name'      => $studentParent->dad_name != null ? $studentParent->dad_name : $studentParent->mom_name,
                            'jid'       => whatsappNumber($parentNumber),
                            'text'      => $message
                        ];
                        sendText($payloadText);
                    }
                    // Update Data
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
                    // Try Get Parents Number
                    $studentParent = StudentsParentDetail::where('user_id', $request->user_id)->first();
                    if ($studentParent) {
                        $parentNumber = $studentParent->dad_phone != null ? $studentParent->dad_phone : $studentParent->mom_phone;
                        // Send Whatsapp Notification
                        $message = "Assalamualaikum Bapak/Ibu,.\n\n";
                        $message .= "*Ananda :*\n*".$data->detail->studentDetail->name."*\n\nPermohanan izin ananda telah *Di Batalkan*.\n\n";
                        $message .= "------------------\n";
                        $message .= "*Di Batalkan oleh :*\nUstd/Ustzh *".auth()->user()->staffDetail->name."*\n";
                        $message .= "Terima kasih. Wassalamualaikum.";
                    
                        $payloadText = [
                            'sessionId' => appSet('WHATSAPP_SESSION_ID'),
                            'type'      => 'text',
                            'category'  => 'permission_request',
                            'name'      => $studentParent->dad_name != null ? $studentParent->dad_name : $studentParent->mom_name,
                            'jid'       => whatsappNumber($parentNumber),
                            'text'      => $message
                        ];
                        sendText($payloadText);
                    }
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
                if($request->status == 'check_in') {
                    // Try Get Parents Number
                    $studentParent = StudentsParentDetail::where('user_id', $request->user_id)->first();
                    if ($studentParent) {
                        $parentNumber = $studentParent->dad_phone != null ? $studentParent->dad_phone : $studentParent->mom_phone;
                        // Send Whatsapp Notification
                        $message = "Assalamualaikum Bapak/Ibu,.\n\n";
                        $message .= "*Ananda :*\n*".$data->detail->studentDetail->name."*\n\nTelah kembali ke Dayah/Sekolah.\n\n";
                        $message .= "*Check In Pada :*\n".dateIndo(date('Y-m-d'))."\n\n";
                        $message .= "------------------\n";
                        $message .= "*Di Terima oleh :*\nUstd/Ustzh *".auth()->user()->staffDetail->name."*\n";
                        $message .= "Terima kasih. Wassalamualaikum.";
                    
                        $payloadText = [
                            'sessionId' => appSet('WHATSAPP_SESSION_ID'),
                            'type'      => 'text',
                            'category'  => 'permission_request',
                            'name'      => $studentParent->dad_name != null ? $studentParent->dad_name : $studentParent->mom_name,
                            'jid'       => whatsappNumber($parentNumber),
                            'text'      => $message
                        ];
                        sendText($payloadText);
                    }
                    // Update Data
                    $data->update([
                        'status'            => $request->status,
                        'reject_reason'     => null,
                        'rejected_by'       => null,
                        'checked_in_by'     => auth()->user()->id,
                        'checked_in_at'     => now(),
                        'token'             => null,
                    ]);
                }
            }
            \DB::commit();
            appLog(auth()->user()->id, 'success', 'Berhasil merubah status izin untuk : '. $data->detail->studentDetail->name);
            return redirect()->back()->with([
                'status'    => 'success',
                'message'   => 'Perizinan berhasil dirubah',
                'token'     => $data->token ?? null,
            ]);
        } catch (\Throwable $th) {
            appLog(auth()->user()->id, 'error', 'Gagal merubah status izin untuk : '. $data->detail->studentDetail->name);
            \DB::rollBack();
            return redirect()->back()->with([
                'status'    => 'error',
                'message'   => 'Perizinan gagal dirubah',
            ]);
        }
    }


}
