<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ParentDetail;
use App\Models\PsbConfig;
use App\Models\PsbHistory;
use App\Models\StudentDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function showRegisterPageStudent()
    {
        $data = [
            'psbData'   => PsbConfig::where('is_active', true)->first(),
        ];
        return view('auth.register-student', $data);
    }

    public function handleRegisterStudent(Request $request)
    {
        $request->validate([
            'method'        => 'required|in:reg,inv',
            'username'      => 'required|unique:users,username|Username hanya boleh berisi huruf kecil dan angka.',
            'name'          => 'required',
            'whatsapp'      => 'required',
            'password'      => 'required|confirmed',
            'invite_code'   => 'required_if:method,inv|exists:psb_configs,kode_undangan',
        ],
        [
            'invite_code.exists'        => 'Kode undangan tidak valid.',
            'invite_code.required_if'   => 'Kode undangan tidak boleh kosong.',
            'username.regex'        => 'Username hanya boleh berisi huruf kecil dan angka.',
        ]);

        try {
            DB::beginTransaction();
            $psbConfig = PsbConfig::where('is_active', true)->first();
            $studentNew = User::create([
                'username'                  => $request->username,
                'password'                  => bcrypt($request->password),
                'password_changed_at'       => now(),
                'is_need_to_update_profile' => false,
                'user_level'                => 'student',
                'is_active'                 => true,
            ]);
    
            StudentDetail::create([
                'user_id' => $studentNew->id,
                'name'    => $request->name,
                'phone'   => indoNumber($request->whatsapp),
                'status'  => 'new',
            ]);
            if($request->method == 'inv'){
                PsbHistory::create([
                    'user_id'                   => $studentNew->id,
                    'psb_config_id'             => $psbConfig->id,
                    'registration_number'       => "UDG-".rand(1000, 9999)."-".date('dmyhis'),
                    'registration_method'       => 'invited',
                    'is_moved_to_non_invited'   => false
                ]);
                $psbConfig->increment('jumlah_pendaftar_undangan');
            }
            if($request->method == 'reg'){
                PsbHistory::create([
                    'user_id'               => $studentNew->id,
                    'psb_config_id'         => $psbConfig->id,
                    'registration_number'   => "REG-".rand(1000, 9999)."-".date('dmyhis'),
                    'registration_method'   => 'reguler',
                ]);
                $psbConfig->increment('jumlah_pendaftar_reguler');
            }
            appLog($studentNew->id, 'success', 'New student account is success register to system');
            DB::commit();
            return redirect()->route('login')->with([
                'status'    => 'success',
                'message'   => 'Berhasil mendaftar, silahkan login.'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with([
                'status'    => 'error',
                'message'   => 'Gagal mendaftar, silahkan coba lagi.'
            ]);
        }
    }

    public function showRegisterPageParent()
    {
        return view('auth.register-parent');
    }

    public function handleRegisterParent(Request $request)
    {
        $request->validate([
            'method'        => 'required|in:reg,inv',
            'username'      => 'required|unique:users,username|regex:/^[a-z0-9]+$/i',
            'name'          => 'required',
            'whatsapp'      => 'required',
            'password'      => 'required|confirmed',
        ],
        [
            'username.regex'        => 'Username hanya boleh berisi huruf kecil dan angka.',
        ]);
        try {
            DB::beginTransaction();
            $parentNew = User::create([
                'username'                  => $request->username,
                'password'                  => bcrypt($request->password),
                'password_changed_at'       => now(),
                'is_need_to_update_profile' => false,
                'user_level'                => 'parent',
                'is_active'                 => true,
            ]);
    
            ParentDetail::create([
                'user_id' => $parentNew->id,
                'name'    => $request->name,
                'photo'   => 'default.png',
                'phone'   => indoNumber($request->whatsapp),
            ]);
            appLog($parentNew->id, 'success', 'New parent account is success register to system');
            DB::commit();
            return redirect()->route('login')->with([
                'status'    => 'success',
                'message'   => 'Berhasil mendaftar, silahkan login.'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with([
                'status'    => 'error',
                'message'   => 'Gagal mendaftar, silahkan coba lagi.'
            ]);
        }
    }
}
