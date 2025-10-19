<?php

namespace App\Http\Controllers\Student\New;

use App\Http\Controllers\Controller;
use App\Models\PsbReRegisterHistory;
use Illuminate\Http\Request;
use Storage;

class DaftarUlangController extends Controller
{
    public function uploadBuktiBayarPage(Request $request)
    {
        return view('app.student.new.daftar-ulang.upload-bukti');
    }

    public function handleUploadSlip(Request $request)
    {
        $request->validate([
            'paid_verification_file'    => 'required|file|mimes:jpg,jpeg,png|max:1024',
            'paid_via'                  => 'required|string'
        ]);

        try {
            \DB::beginTransaction();

            // Upload file to S3
            $folder     = 'student/' . auth()->user()->id . '/payment-psb';
            $file       = $request->file('paid_verification_file');
            $filename   = auth()->user()->id . "." . $file->getClientOriginalExtension();
            $fullPath   = $folder . '/' . $filename;
            Storage::disk('s3')->put($fullPath, file_get_contents($request->paid_verification_file));

            // Save Data
            PsbReRegisterHistory::create([
                'user_id'                   => auth()->user()->id,
                'psb_configs_id'            => $request->psb_config->id,
                'paid_verification_file'    => $fullPath,
                'payment_verified_by'       => NULL,
                'paid_via'                  => $request->paid_via,
                'paid_amount'               => $request->paid_amount
            ]);

            \DB::commit();
            appLog(auth()->user()->id, 'success', 'Berhasil kirim bukti pembayaran');
            return redirect()->back()->with([
                'status'    => 'success',
                'message'   => 'Bukti pembayaran berhasil dikirim'
            ]);
        } catch (\Throwable $th) {
            \DB::rollback();
            appLog(auth()->user()->id, 'error', 'Gagal kirim bukti pembayaran');
            return redirect()->back()->withInput()->with([
                'status'    => 'error',
                'message'   => 'Terjadi kesalahan saat mengirim bukti pembayaran'
            ]);
        }
    }
}
