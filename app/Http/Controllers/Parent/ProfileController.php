<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;

use function Ramsey\Uuid\v1;

class ProfileController extends Controller
{
    public function showPage()
    {
        return view('app.parent.profile');
    }

    public function updateProfile(Request $request)
    {
        if($request->has('photo')) {
            $request->validate([
                'photo' => 'image|mimes:jpeg,png,jpg|max:1024',
            ]);

            $folder     = 'parent/' . auth()->user()->id . '/' . 'photo';
            $file       = $request->file('photo');
            $filename   = auth()->user()->id . "." . $file->getClientOriginalExtension();
            $fullPath   = $folder . '/' . $filename;
            Storage::disk('s3')->put($fullPath, file_get_contents($file));
            auth()->user()->myDetail->photo = $fullPath;

            if(auth()->user()->myDetail->save()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Profile photo updated successfully.',
                    'photo' => $fullPath,
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to update profile photo.',
                ], 500);
            }
        } else {
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
            ]);

            auth()->user()->myDetail->name = $request->name;
            auth()->user()->myDetail->phone = $request->phone;

            if(auth()->user()->myDetail->save()) {
                return redirect()->route('parent.profile')->with([
                    'status' => 'success',
                    'message' => 'Profile updated successfully.',
                ]);
            } else {
                return redirect()->route('parent.profile')->with([
                    'status' => 'error',
                    'message' => 'Failed to update profile.',
                ]);
            }
        }
        
    }

    public function showPagePassword()
    {
        return view('app.parent.update-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!password_verify($request->old_password, auth()->user()->password)) {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Old password is incorrect.',
            ]);
        }

        auth()->user()->password = bcrypt($request->new_password);
        auth()->user()->remember_token = null;
        auth()->user()->password_changed_at = now();

        if(auth()->user()->save()) {
            return redirect()->route('parent.password')->with([
                'status' => 'success',
                'message' => 'Password updated successfully.',
            ]);
        } else {
            return redirect()->route('parent.password')->with([
                'status' => 'error',
                'message' => 'Failed to update password.',
            ]);
        }
    }
}
