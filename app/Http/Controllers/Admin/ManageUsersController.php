<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminDetail;
use App\Models\MasterTahunAjaran;
use App\Models\ParentDetail;
use App\Models\StaffDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class ManageUsersController extends Controller
{
    public function userListPage(Request $request)
    {
        if($request->ajax()) {
            $data  = User::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('full_name', function ($row) {
                    switch ($row->user_level) {
                        case 'admin':
                            return $row->adminDetail->name;
                            break;
                        case 'staff':
                            return $row->staffDetail->name;
                            break;
                        case 'parent':
                            return $row->parentDetail->name;
                            break;
                        case 'student':
                            return $row->studentDetail->name;
                            break;
                        default:
                            return "";
                            break;
                    }
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d-m-Y H:i:s');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d-m-Y H:i:s');
                })
                ->make(true);
        }
        return view('app.admin.manage-users.list');
    }

    public function createUserPage()
    {
        return view('app.admin.manage-users.create');
    }

    public function handleCreateUser(Request $request)
    {
        $request->validate([
            'username'  => 'required|unique:users,username',
            'name'      => 'required',
            'password'  => 'required',
            'user_level'=> 'required|in:admin,staff,parent',
        ]);

        try {
            $user = User::create([
                'username'                  => $request->username,
                'password'                  => bcrypt($request->password),
                'password_changed_at'       => now(),
                'is_need_to_update_profile' => true,
                'user_level'                => $request->user_level,
                'is_active'                 => true,
            ]);
            switch ($request->user_level) {
                case 'admin':
                AdminDetail::create([
                    'user_id' => $user->id,
                    'name'    => $request->name,
                ]);
                case 'staff':
                StaffDetail::create([
                    'user_id' => $user->id,
                    'name'    => $request->name,
                ]);
                case 'parent':
                ParentDetail::create([
                    'user_id' => $user->id,
                    'name'    => $request->name,
                ]);
                break;
            }
            appLog(auth()->user()->id, 'success', 'Berhasil menambah user baru : '.$request->username);
            return redirect()->route('admin.manage-users')->with([
                'status'    => 'success',
                'message'   => 'User berhasil dibuat',
            ]);
        } catch (\Throwable $th) {
            appLog(auth()->user()->id, 'error', 'Gagal menambah user baru : '.$request->username);
            return redirect()->back()->withInput()->withErrors([
                'status'    => 'error',
                'message'   => 'User gagal dibuat',
            ]);
        }
    }

    public function userDetail(Request $request)
    {
        if($request->id){
            $id = User::where('id', $request->id)->first();

            switch ($id->user_level) {
                case 'admin':
                    $detail = $id->adminDetail;
                    break;
                case 'staff':
                    $detail = $id->staffDetail;
                    break;
                case 'parent':
                    $detail = $id->parentDetail;
                    break;
                case 'student':
                    $detail = $id->studentDetail;
                    break;
                
            }
            $data = [
                'user' => $id,
                'detail' => $detail,
            ];
            return view('app.admin.manage-users.detail', $data);
        }
    }

    public function handleUpdateUsers(Request $request)
    {
        $request->validate([
            'username'  => 'required',
            'name'      => 'required',
            'user_level'=> 'required|in:admin,staff,parent,student',
        ]);

        try {
            $id = User::find($request->id);
            $id->username = $request->username;
            $id->user_level = $request->user_level;
            $id->save();
            switch ($id->user_level) {
                case 'admin':
                    $id->adminDetail->name = $request->name;
                    $id->adminDetail->save();
                    break;
                case 'staff':
                    $id->staffDetail->name = $request->name;
                    $id->staffDetail->save();
                    break;
                case 'parent':
                    $id->parentDetail->name = $request->name;
                    $id->parentDetail->save();
                    break;
                case 'student':
                    $id->studentDetail->name = $request->name;
                    $id->studentDetail->save();
                    break;
            }
            appLog(auth()->user()->id, 'success', 'Berhasil memperbarui detail : '.$request->username);
            return redirect()->route('admin.manage-users')->with([
                'status'    => 'success',
                'message'   => 'User berhasil diperbarui',
            ]);
        } catch (\Throwable $th) {
            appLog(auth()->user()->id, 'error', 'Gagal memperbarui detail : '.$request->username);
            return redirect()->back()->with([
                'status'    => 'error',
                'message'   => 'User gagal diperbarui',
            ]);
        }
    }

    public function setStatus(Request $request)
    {
        $id = User::findOrFail($request->id);
        if($id->is_active == true){
            $id->is_active = false;
        } else {
            $id->is_active = true;
        }
        $id->save();
        appLog(auth()->user()->id, 'success', "Berhasil merubah status user : $id->username to $id->is_active");
        return response()->json([
            'status'    => 'success',
            'message'   => 'Status berhasil diperbarui',
        ]);
    }

    public function actAsUser(Request $request)
    {
        if(auth()->user()->is_allow_act_as == false){
            return redirect()->back()->with([
                'status'    => 'error',
                'message'   => 'Anda tidak diizinkan untuk menggunakan fitur ini',
            ]);
        }
        $oldId = auth()->user()->id;
        // Login to user only with id
        if (Auth::loginUsingId($request->id)) {
            $request->session()->regenerate();
            appLog($oldId, 'success', 'Berhasil Masuk sebagai ' . auth()->user()->user_level . ' dengan username : ' . auth()->user()->username);
            switch (auth()->user()->user_level) {
                case 'admin':
                    return redirect()->route('admin.home')->with([
                        'status'    => 'success',
                        'message'   => 'Berhasil login sebagai admin'
                    ]);
                    break;
                case 'staff':
                    // Get Tahun Ajaran Aktif
                    $tahunAjaran = MasterTahunAjaran::where('is_active', '1')->first();
                    // Set Session
                    Session::put('tahun_ajaran_aktif_id', $tahunAjaran->id);
                    Session::put('tahun_ajaran_aktif', $tahunAjaran->tahun_ajaran);
                    return redirect()->route('staff.home')->with([
                        'status'    => 'success',
                        'message'   => 'Berhasil login sebagai staff'
                    ]);
                    break;
                case 'parent':
                    return redirect()->route('parent.home')->with([
                        'status'    => 'success',
                        'message'   => 'Berhasil login sebagai orang tua'
                    ]);
                    break;
                case 'student':
                    if (auth()->user()->myDetail->status == 'active') {
                        return redirect()->route('student.home.active')->with([
                            'status'    => 'success',
                            'message'   => 'Berhasil login sebagai siswa'
                        ]);
                    } else {
                        return redirect()->route('student.home.new')->with([
                            'status'    => 'success',
                            'message'   => 'Berhasil login sebagai siswa'
                        ]);
                    }
                    break;
            }
        }
    }
}
