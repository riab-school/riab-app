<?php

namespace App\Http\Controllers\Staff\Prestasi;

use App\Http\Controllers\Controller;
use App\Models\StudentDetail;
use App\Models\StudentsAchievement;
use App\Models\StudentsParentDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Storage;

class ListController extends Controller
{
    public function showListPrestasiPage(Request $request)
    {
        if($request->ajax()){
            $data  = StudentsAchievement::with(['userDetail.studentDetail', 'processBy'])->orderBy('created_at', 'DESC')->get();
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
        return view('app.staff.prestasi.list.index');
    }

    public function showDetailData(Request $request)
    {
        $data = StudentsAchievement::with(['userDetail.studentDetail', 'processBy.staffDetail'])->find($request->id);
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

    public function storeAchievementPage()
    {
        return view('app.staff.prestasi.list.store');
    }

    public function storeAchievement(Request $request)
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
                $folder     = 'student/' . $request->user_id . '/' . 'achievement';
                $file       = $request->file('evidence');
                $filename   = time().'-'.$request->user_id . "." . $file->getClientOriginalExtension();
                $fullPath   = $folder . '/' . $filename;
                Storage::disk('s3')->put($fullPath, file_get_contents($file));
            }
            $data = StudentsAchievement::create([
                'user_id'           => $request->user_id,
                'detail'            => $request->detail,
                'action_taked'      => $request->action_taked,
                'evidence'          => $fullPath ?? null,
                'process_by'        => auth()->user()->id,
                'is_notify_parent'  => $request->has('notify_parent') ? $request->notify_parent : 0,
            ]);

            if($request->has('notify_parent') && $request->notify_parent == "1"){
                // Try Get Parents Number
                $studentParent = StudentsParentDetail::where('user_id', $request->user_id)->first();
                if ($studentParent) {
                    $parentNumber = $studentParent->dad_phone != null ? $studentParent->dad_phone : $studentParent->mom_phone;
                    // Send Whatsapp Notification
                    $message = "Assalamualaikum Bapak/Ibu,.\n\n";
                    $message .= "*Ananda :*\n*".$data->userDetail->studentDetail->name."*\n\nTelah mendapatkan sebuah prestasi membanggakan\n\n";
                    $message .= "*Ket :*\n".$request->detail."\n\n";
                    $message .= "*Tindakan :*\n".$request->action_taked."\n\n";
                    $message .= "------------------\n";
                    $message .= "*Di Catat oleh :*\nUstd/Ustzh *".auth()->user()->staffDetail->name."*\n";
                    $message .= "Terima kasih. Wassalamualaikum.";
                    
                    if($request->has('evidence')) {
                        $message .= "\n\n_Berikut kami sertakan bukti prestasi atau sertifikat serta tindakan yang dilakukan_";
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
            appLog(auth()->user()->id, 'success', 'Berhasil menambah prestasi untuk : '.$request->nama);
            return redirect()->back()->with([
                'status'    => 'success',
                'message'   => 'Prestasi berhasil ditambahkan',
            ]);
            
        } catch (\Throwable $th) {
            appLog(auth()->user()->id, 'error', 'Gagal menambah prestasi untuk : '.$request->nama);
            return redirect()->back()->with([
                'status'    => 'error',
                'message'   => 'Prestasi gagal ditambahkan',
            ]);
        }
    }

    public function searchData(Request $request)
    {
        if($request->ajax()){
            $data = StudentDetail::with(['studentAchievementHistory'])->where('nis', $request->nis_or_nisn)->orWhere('nisn', $request->nis_or_nisn)->first();
            if (!$data) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found'
                ], 404);
            }

            // Map evidance button
            $data->studentAchievementHistory->map(function ($achievement) {
                if ($achievement->evidence) {
                    $url = Storage::disk('s3')->url($achievement->evidence);
                    $achievement->evidence = '<div class="btn-group">
                        <button data-src="' . $url . '" class="btn btn-icon btn-outline-primary img-preview">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>';
                } else {
                    $achievement->evidence = '-';
                }

                // Format created_at
                $achievement->created_date = $achievement->created_at ? $achievement->created_at->format('d-m-Y') : '-';
                
                // Format process_by
                $achievement->process_by = $achievement->process_by ? $achievement->processBy->staffDetail->name : '-';
                return $achievement;
            });
            
            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);
        }
    }
}
