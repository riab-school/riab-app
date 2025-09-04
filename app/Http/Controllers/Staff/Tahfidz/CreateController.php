<?php

namespace App\Http\Controllers\Staff\Tahfidz;

use App\Http\Controllers\Controller;
use App\Models\MasterAlquran;
use App\Models\ParentClaimStudent;
use App\Models\StudentsMemorization;
use Illuminate\Http\Request;
use Storage;

class CreateController extends Controller
{
    public function showCreatePage()
    {
        return view('app.staff.tahfidz-hafalan.list.add');
    }

    public function handleStoreTahfidz(Request $request)
    {
        $request->validate([
            'user_id'       => 'required|exists:users,id',
            'surah'         => 'required',
            'from_ayat'     => 'required|min:1',
            'to_ayat'       => 'required|min:1|',
            'point_tahsin'  => 'required',
            'point_tahfidz' => 'required',
            'note'          => 'required|string|max:255',
            'evidence'      => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);
        try {
            if($request->has('evidence')) {
                $folder     = 'student/' . $request->user_id . '/' . 'setoran-tahfidz';
                $file       = $request->file('evidence');
                $filename   = time().'-'.$request->user_id . "." . $file->getClientOriginalExtension();
                $fullPath   = $folder . '/' . $filename;
                Storage::disk('s3')->put($fullPath, file_get_contents($file));
            }
            $data = StudentsMemorization::create([
                'user_id'           => $request->user_id,
                'surah'             => $request->surah,
                'from_ayat'         => $request->from_ayat,
                'to_ayat'           => $request->to_ayat,
                'point_tahsin'      => $request->point_tahsin,
                'point_tahfidz'     => $request->point_tahfidz,
                'ket_juz_halaman'   => $request->ket_juz_halaman,
                'note'              => $request->note,
                'status'            => 'done',
                'evidence'          => $fullPath ?? null,
                'process_by'        => auth()->user()->id,
                'is_notify_parent'  => $request->has('notify_parent') ? $request->notify_parent : 0,
            ]);

            

            if($request->has('notify_parent') && $request->notify_parent == "1"){
                // Try Get Parents Number
                $studentParent = ParentClaimStudent::where('student_user_id', $request->user_id)->first();
                if ($studentParent && $studentParent->parentDetail->phone !== NULL && $studentParent->parentDetail->is_allow_send_wa) {
                    $parentNumber = $studentParent->parentDetail->phone;
                    // Send Whatsapp Notification
                    $message = "Assalamualaikum Bapak/Ibu, ".$studentParent->parentDetail->name."\n\n";
                    $message .= "*Ananda :*\n*".$data->userDetail->studentDetail->name."*\n\nTelah menyetorkan hafalan Alquran\n\n";
                    $message .= "*Surah :*\n".MasterAlquran::where('id', $request->surah)->first()->nama_surah."\n\n";
                    $message .= "*Ayat :*\n".$request->from_ayat." s/d ".$request->to_ayat."\n\n";
                    $message .= "*Catatan :*\n".$request->action_taked."\n\n";
                    $message .= "------------------\n";
                    $message .= "*Tasmik oleh :*\nUstd/Ustzh *".auth()->user()->staffDetail->name."*\n";
                    $message .= "Terima kasih. Wassalamualaikum.";
                    
                    if($request->has('evidence')) {
                        $message .= "\n\n_Berikut kami sertakan bukti setoran hafalan ananda_";
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
            appLog(auth()->user()->id, 'success', 'Berhasil menambah hafalan alquran untuk : '.$request->nama);
            return redirect()->back()->with([
                'status'    => 'success',
                'message'   => 'Hafalan berhasil ditambahkan',
            ]);
            
        } catch (\Throwable $th) {
            appLog(auth()->user()->id, 'error', 'Gagal menambah hafalan alquran untuk : '.$request->nama);
            return redirect()->back()->with([
                'status'    => 'error',
                // 'message'   => $th->getMessage(),
                'message'   => 'Hafalan gagal ditambahkan',
            ]);
        }
    }
}
