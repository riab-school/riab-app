<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MasterTahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function handleLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:users,username',
            'password' => 'required',
        ], [
            'username.exists'   => 'Username atau password salah',
        ]);
        
        if (Auth::attempt($request->only('username', 'password'), true)) {
            appLog(auth()->user()->id, 'success', 'Success login to system');
            switch (auth()->user()->user_level) {
                case 'admin':
                    return redirect()->route('admin.home');
                    break;
                case 'staff':
                    // Get Tahun Ajaran Aktif
                    $tahunAjaran = MasterTahunAjaran::where('is_active', '1')->first();
                    // Set Session
                    Session::put('tahun_ajaran_aktif_id', $tahunAjaran->id);
                    Session::put('tahun_ajaran_aktif', $tahunAjaran->tahun_ajaran);
                    return redirect()->route('staff.home');
                    break;
                case 'parent':
                    return redirect()->route('parent.home');
                    break;
                case 'student':
                    if (auth()->user()->myDetail->status == 'active') {
                        return redirect()->route('student.home.active');
                    } else {
                        return redirect()->route('student.home.new');
                    }
                    break;
            }
        }

        return redirect()->back()->withInput()->withErrors([
            'username' => 'Username atau password salah',
        ]);
    }
}
