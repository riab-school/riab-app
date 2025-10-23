<?php

namespace App\Http\Controllers\Staff\Psb;

use App\Http\Controllers\Controller;
use App\Models\PsbHistory;
use App\Models\PsbPaymentHistory;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function showPaymentPage(Request $request)
    {
        $data = [
            'dataPayment'   => PsbPaymentHistory::where('payment_status', 'pending')->with('userDetail')->get(),
        ];
        return view('app.staff.master-psb.payment', $data);
    }

    public function handleVerification(Request $request)
    {
        if($request->status == 'verified') {
            PsbPaymentHistory::where('id', $request->id)->update([
                'payment_status'    => 'paid',
                'status'            => 'success',
            ]);
            PsbHistory::where('user_id', $request->student_id)->update([
                'is_paid'    => 1,
            ]);
            appLog(auth()->user()->id, 'success', 'Berhasil memverifikasi pembayaran PSB dengan ID ' . $request->id);
            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'Berhasil memverifikasi pembayaran.'
            ]);
        } else {
            appLog(auth()->user()->id, 'error', 'Gagal memverifikasi pembayaran PSB dengan ID ' . $request->id);
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Gagal memverifikasi pembayaran.'
            ]);
        }
    }
}
