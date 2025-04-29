<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function showPageResetPassword()
    {
        return view('auth.reset-password');
    }

    public function handleResetPassword(Request $request)
    {
        $request->validate([
            'token'     =>  'required|exists:users,reset_pass_token',
            'password'  =>  'required|confirmed'
        ], [
            'token.exists' => 'Token tidak ditemukan.',
            'password.confirmed' => 'Password tidak sama.'
        ]);

        $user = User::where('reset_pass_token', $request->token)->first();
        $user->password = bcrypt($request->password);
        $user->reset_pass_token = null;
        $user->save();
        appLog($user->id, 'success', 'Berhasil reset password.');
        return redirect()->route('login')->with([
            'status'    => 'success',
            'message'   => 'Password berhasil direset.'
        ]);
    }
}
