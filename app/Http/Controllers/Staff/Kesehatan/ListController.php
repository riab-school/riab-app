<?php

namespace App\Http\Controllers\Staff\Kesehatan;

use App\Http\Controllers\Controller;
use App\Models\ParentClaimStudent;
use App\Models\StudentDetail;
use App\Models\StudentMedicalCheckHistory;
use App\Models\StudentPermissionHistory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Storage;

class ListController extends Controller
{
    public function showListKesehatanPage(Request $request)
    {
        if($request->ajax()){
            $data  = StudentMedicalCheckHistory::with(['userDetail.studentDetail', 'diagnozedBy'])->orderBy('created_at', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d-m-Y');
                })
                ->editColumn('diagnoze_by', function ($row) {
                    return $row->diagnoze_by ? $row->diagnozedBy->staffDetail->name : '-';
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
        return view('app.staff.kesehatan.list.index');
    }

    public function showDetailData(Request $request)
    {
        $data = StudentMedicalCheckHistory::with(['userDetail.studentDetail', 'diagnozedBy.staffDetail'])->find($request->id);
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

    public function storeDataPage()
    {
        return view('app.staff.kesehatan.list.store');
    }

    public function handleStoreData(Request $request)
    {
        $request->validate([
            'user_id'       => 'required|exists:users,id',
            'diagnose'      => 'required',
            'treatment'     => 'required',
            'drug_given'    => 'required',
            'evidence'      => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            if($request->has('evidence')) {
                $folder     = 'student/' . $request->user_id . '/' . 'medical';
                $file       = $request->file('evidence');
                $filename   = time().'-'.$request->user_id . "." . $file->getClientOriginalExtension();
                $fullPath   = $folder . '/' . $filename;
                Storage::disk('s3')->put($fullPath, file_get_contents($file));
            }
            $data = StudentMedicalCheckHistory::create([
                'user_id'           => $request->user_id,
                'diagnose'          => $request->diagnose,
                'treatment'         => $request->treatment,
                'drug_given'        => $request->drug_given,
                'note'              => $request->note ?? NULL,
                'evidence'          => $fullPath ?? null,
                'is_allow_home'     => $request->has('allow_home') && $request->allow_home == "1" ? 1 : 0,
                'is_notify_parent'  => $request->has('notify_parent') ? $request->notify_parent : 0,
                'diagnozed_by'      => auth()->user()->id,
            ]);

            if($request->has('notify_parent') && $request->notify_parent == "1"){
                // Try Get Parents Number
                $studentParent = ParentClaimStudent::where('student_user_id', $request->user_id)->first();
                if ($studentParent && $studentParent->parentDetail->phone !== NULL && $studentParent->parentDetail->is_allow_send_wa) {
                    $parentNumber = $studentParent->parentDetail->phone;
                    // Send Whatsapp Notification
                    $message = "Assalamualaikum Bapak/Ibu, ".$studentParent->parentDetail->name."\n\n";
                    $message .= "*Ananda :*\n*".$data->userDetail->studentDetail->name."*\n\nTelah melakukan kunjungan ke *Pusat Kesehatan Pesantren* (POSKESTREN)\n\n";
                    $message .= "*Diagnosa :*\n".$request->diagnose."\n\n";
                    $message .= "*Treatment :*\n".$request->treatment."\n\n";
                    $message .= "*Obat Di Berikan :*\n".$request->drug_given."\n\n";
                    $message .= "*Catatan :*\n".$request->note."\n\n";
                    $message .= "*Status Izin :*\n".($request->allow_home == "1" ? 'Di izinkan pulang. *_Lapor dahulu ke pembina sebelum penjemputan_*' : 'Tidak di beri izin pulang, *_Cukup istirahat di asrama_*')."\n\n";
                    $message .= "------------------\n";
                    $message .= "*Di Periksa oleh :*\nUstd/Ustzh/Dokter *".auth()->user()->staffDetail->name."*\n";
                    $message .= "Terima kasih. Wassalamualaikum.";
                    
                    if($request->has('evidence')) {
                        $message .= "\n\n_Berikut kami sertakan bukti kunjungan ananda serta kondisi ananda saat ini_";
                        $payloadImage = [
                            'sessionId' => appSet('WHATSAPP_SESSION_ID'),
                            'type'      => 'image',
                            'category'  => 'parent_notification',
                            'name'      => $studentParent->dad_name != null ? $studentParent->dad_name : $studentParent->mom_name,
                            'jid'       => whatsappNumber($parentNumber),
                            'media_url' => Storage::disk('s3')->url($fullPath),
                            'media_mime'=> 'image/jpg',
                            "media" => [
                                        "image" => [
                                            "url" => Storage::disk('s3')->url($fullPath) 
                                        ]
                                    ], 
                            "caption" => $message 
                        ];
                        sendMedia($payloadImage);
                    } else {
                        $payloadText = [
                            'sessionId' => appSet('WHATSAPP_SESSION_ID'),
                            'type'      => 'text',
                            'category'  => 'parent_notification',
                            'name'      => $studentParent->dad_name != null ? $studentParent->dad_name : $studentParent->mom_name,
                            'jid'       => whatsappNumber($parentNumber),
                            'text'      => $message
                        ];
                        sendText($payloadText);
                    }
                }
            }

            if($request->has('allow_home') && $request->allow_home == "1"){
                // Forward to perizinan
                StudentPermissionHistory::create([
                    'user_id'           => $request->user_id,
                    'requested_by'      => "staff_kesehatan",
                    'applicant_id'      => auth()->user()->id,
                    'approved_by'       => NULL,
                    'token'             => NULL,
                    'reason'            => 'Sakit, tidak bisa mengikuti kegiatan belajar mengajar',
                    'pickup_by'         => 'Orang Tua/Wali',
                    'from_date'         => NULL,
                    'to_date'           => NULL,
                    'is_notify_parent'  => 0,
                    'status'            => 'requested',
                ]);
            }
            appLog(auth()->user()->id, 'success', 'Berhasil menambah rekam kesehatan untuk : '.$request->nama);
            return redirect()->back()->with([
                'status'    => 'success',
                'message'   => 'Rekam kesehatan berhasil ditambahkan',
            ]);
            
        } catch (\Throwable $th) {
            appLog(auth()->user()->id, 'error', 'Gagal menambah rekam kesehatan untuk : '.$request->nama);
            return redirect()->back()->with([
                'status'    => 'error',
                'message'   => 'Rekam kesehatan gagal ditambahkan',
            ]);
        }
    }
    
    public function searchData(Request $request)
    {
        if($request->ajax()){
            $data = StudentDetail::with(['studentMedicalCheckHistory'])->where('nis', $request->nis_or_nisn)->orWhere('nisn', $request->nis_or_nisn)->first();
            if (!$data) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found'
                ], 404);
            }

            // Map evidance button
            $data->studentMedicalCheckHistory->map(function ($medicalHistory) {
                if ($medicalHistory->evidence) {
                    $url = Storage::disk('s3')->url($medicalHistory->evidence);
                    $medicalHistory->evidence = '<div class="btn-group">
                        <button data-src="' . $url . '" class="btn btn-icon btn-outline-primary img-preview">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>';
                } else {
                    $medicalHistory->evidence = '-';
                }

                // Format created_at
                $medicalHistory->created_date = $medicalHistory->created_at ? $medicalHistory->created_at->format('d-m-Y') : '-';
                
                // Format process_by
                $medicalHistory->diagnozed_by = $medicalHistory->diagnozed_by ? $medicalHistory->diagnozedBy->staffDetail->name : '-';
                return $medicalHistory;
            });
            
            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);
        }
    }
}
