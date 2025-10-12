<?php

namespace App\Http\Controllers\Student\New;

use App\Http\Controllers\Controller;
use App\Models\PsbPaymentHistory;
use Illuminate\Http\Request;
use Storage;

class PaymentController extends Controller
{
    public function index(Request $request)
    {

        // dd($request->all());

        $checkHistory = PsbPaymentHistory::where('user_id', auth()->user()->id)->first();
        if (!$checkHistory) {   
            PsbPaymentHistory::create([
                'user_id'           => auth()->user()->id,
                'psb_config_id'    => $request->psb_config->id,
                'payment_method'    => 'manual',
                'manual_invoiceid'  => 'INV-'.date('Ymd').rand(1000,9999),
                'payment_status'    => 'unpaid',
            ]);
            $checkHistory = PsbPaymentHistory::where('user_id', auth()->user()->id)->first();
            return view('app.student.new.payment', $checkHistory);
        }
        return view('app.student.new.payment', $checkHistory);
    }

    public function handleVerification(Request $request)
    {
        $request->validate([
            'manual_bank_from'  => 'required|string|max:255',
            'evidence'          => 'required|image|max:1024', // max 1MB
        ]);

        try {
            $checkHistory = PsbPaymentHistory::where('user_id', auth()->user()->id)->first();
            if ($checkHistory) {
                // Upload evidence
                if ($request->hasFile("evidence")) {
                    // hapus file lama di s3 jika ada
                    if ($checkHistory->evidence) {
                        Storage::disk('s3')->delete($checkHistory->evidence);
                    }

                    $file     = $request->file("evidence");
                    $folder   = "student/" . auth()->id() . "/psb_payments";
                    $filename = "evidence_" . time() . "_." . $file->getClientOriginalExtension();
                    $fullPath = $folder . '/' . $filename;

                    Storage::disk('s3')->put($fullPath, file_get_contents($file));
                    $checkHistory->evidence = $fullPath;
                    $checkHistory->payment_status = 'pending';
                    $checkHistory->manual_bank_from = $request->manual_bank_from;
                }

                $checkHistory->save();
            }
            appLog(auth()->id(), 'success', 'Berhasil upload bukti pembayaran PSB');
            return redirect()->back()->with([
                'status'  => 'success',
                'message' => 'Terima kasih, bukti pembayaran anda sudah kami terima. Silahkan menunggu proses verifikasi dari kami.',
            ]);
        } catch (\Throwable $th) {
            appLog(auth()->id(), 'error', 'Gagal upload bukti pembayaran PSB', $th);
            return redirect()->back()->with([
                'status'  => 'error',
                'message' => 'Maaf, kami mengalami kesalahan pada sistem kami. Silahkan coba beberapa saat lagi atau hubungi bagian administrasi sekolah.',
            ]);
        }

    }
}
