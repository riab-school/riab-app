<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function showPageForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function handleForgotPassword(Request $request)
    {
        // dd(isOnWhatsapp(['Phone' => ['6281263280610']]));
        $request->validate([
            'username' => 'required|exists:users,username'
        ], [
            'username.exists' => 'Username tidak ditemukan.'
        ]);

        try {
            $user = User::where('username', $request->username)->first();
            if(!empty($user->reset_pass_token)){
                return redirect()->route('reset-password')->with([
                    'status'    => 'error',
                    'message'   => 'Anda sudah pernah melakukan reset password, tunggu beberapa saat untuk melakukan reset password kembali. Hubungi admin jika tidak menerima pesan.'
                ]);
            }
            $user->reset_pass_token = rand(100000, 999999);
            $user->save();
            // Kirim pesan wa
            $message = "Assalamualaikum, " . $user->username . ".\n\n";
            $message .= "Berikut adalah token untuk mereset password anda:\n\n*".$user->reset_pass_token."*\n\n";
            $message .= "Jika anda tidak merasa melakukan permintaan ini, abaikan pesan ini.\n\n";
            $message .= "Terima kasih. Wassalamualaikum.";
            
            switch ($user->user_level) {
                case 'admin':
                    $detail = $user->adminDetail;
                    break;
                case 'staff':
                    $detail = $user->staffDetail;
                    break;
                case 'parent':
                    $detail = $user->parentDetail;
                    break;
                case 'student':
                    $detail = $user->studentDetail;
                    break;
            }
            $payload = [
                'phone'     => whatsappNumber($detail->phone),
                'name'      => $detail->name,
                'message'   => $message,
                'category'  => 'password_reset',
            ];
            $send = sendText($payload);
            if($send){
                return redirect()->route('reset-password')->with([
                    'status'    => 'success',
                    'message'   => 'Reset password berhasil, silahkan cek pesan whatsapp anda.'
                ]);
            }
            $user->reset_pass_token = NULL;
            $user->save();
            return redirect()->back()->with([
                'status'    => 'error',
                'message'   => 'Gagal mengirim pesan whatsapp. Nomor tidak terdaftar di whatsapp.'
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([
                'status'    => 'error',
                'message'   => $th->getMessage()
            ]);
        }
    }
}
