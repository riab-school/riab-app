<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class ProfileController extends Controller
{
    public function showProfilePage()
    {
        if(auth()->user()->user_level !== 'parent'){
            return view('app.profile');
        }
    }

    public function handleProfileUpdate(Request $request)
    {
        $request->validate([
            'name'                  => 'required_if:section,profile',
            'nik_ktp'               => 'required_if:section,profile',
            'employee_number'       => 'required_if:section,profile',
            'place_of_birth'        => 'required_if:section,profile',
            'date_of_birth'         => 'required_if:section,profile',
            'gender'                => 'required_if:section,profile',
            'phone'                 => 'required_if:section,profile',
            'photo'                 => 'required_if:section,profile|image|mimes:jpeg,png,jpg|max:1024',
            'old_password'          => 'required_with:new_password',
            'new_password'          => 'required_with:old_password',
        ],
        [
            'old_password.required_with'        => 'Password lama harus diisi',
            'new_password.required_with'        => 'Password baru harus diisi',
            'photo.max'                         => 'Ukuran foto maksimal 1MB',
        ]);

        // Update user data
        if($request->section == 'profile') {
            if($request->has('photo')) {
                $folder     = 'staff/' . auth()->user()->id . '/' . 'photo';
                $file       = $request->file('photo');
                $filename   = auth()->user()->id . "." . $file->getClientOriginalExtension();
                $fullPath   = $folder . '/' . $filename;
                Storage::disk('s3')->put($fullPath, file_get_contents($file));
                auth()->user()->myDetail->photo = $fullPath;
            }
            auth()->user()->myDetail->name = $request->name;
            auth()->user()->myDetail->nik_ktp = $request->nik_ktp;
            auth()->user()->myDetail->employee_number = $request->employee_number;
            if(auth()->user()->user_level == 'staff') {
                auth()->user()->myDetail->role_id = $request->role_id;
            }
            auth()->user()->myDetail->place_of_birth = $request->place_of_birth;
            auth()->user()->myDetail->date_of_birth = $request->date_of_birth;
            auth()->user()->myDetail->gender = $request->gender;
            auth()->user()->myDetail->phone = $request->phone;
            auth()->user()->myDetail->address = $request->address;
            auth()->user()->myDetail->province_id = $request->province_id;
            auth()->user()->myDetail->city_id = $request->city_id;
            auth()->user()->myDetail->district_id = $request->district_id;
            auth()->user()->myDetail->village_id = $request->village_id;
            auth()->user()->is_need_to_update_profile = false;
            auth()->user()->myDetail->save();
            auth()->user()->save();
            appLog(auth()->user()->id, 'success', 'Berhasil update data profile');
            return redirect()->back()->with([
                'status'    => 'success',
                'message'   => 'Profil berhasil diperbarui',
            ]);
        }

        // Update password
        if($request->section == 'password') {
            if(!password_verify($request->old_password, auth()->user()->password)) {
                return redirect()->back()->withInput()->withErrors([
                    'old_password'  => 'Password lama salah',
                ]);
            }
            auth()->user()->password = bcrypt($request->new_password);
            auth()->user()->save();
            appLog(auth()->user()->id, 'success', 'Berhasil merubah password');
            return redirect()->back()->with([
                'status'    => 'success',
                'message'   => 'Password berhasil diperbarui',
            ]);
        }

        return redirect()->back()->with([
            'status'    => 'info',
            'message'   => 'Tidak ada data yang diperbarui',
        ]);
        

    }
}
