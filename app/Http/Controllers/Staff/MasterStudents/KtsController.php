<?php

namespace App\Http\Controllers\Staff\MasterStudents;

use App\Http\Controllers\Controller;
use App\Models\StudentsDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Storage;

class KtsController extends Controller
{
    public function showKtsPage()
    {
        return view('app.staff.master-student.kts');
    }

    public function getDetail(Request $request)
    {
        $find = User::whereRelation('studentDetail', $request->search_by, $request->val)->first();

        if($find){
            return view('app.staff.master-student.kts-detail', [
                'detail' => $find
            ]);
        } else {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    public function saveNewPhoto(Request $request)
    {
        $request->validate([
            'image'        => 'required',
            'userId'       => 'required|exists:users,id'
        ]);

        try {
            // image is base 64
            $image = $request->image;
            $user = User::find($request->userId);
            
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'photo.jpeg';

            $folder     = 'student/' . $user->id . '/' . 'photo';
            $fullPath   = $folder . '/' . $imageName;
            Storage::disk('s3')->put($fullPath, base64_decode($image));
            StudentsDocument::updateOrCreate([
                'user_id' => $user->id,
            ], [
                'photo' => $fullPath
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Foto berhasil disimpan'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Foto gagal disimpan'
            ]);
        }
    }

    public function saveNewSign(Request $request)
    {
        $request->validate([
            'signature'         => 'required',
            'userId'            => 'required|exists:users,id'
        ]);

        try {
            // image is base 64
            $image = $request->signature;
            $user = User::find($request->userId);
            
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'signature.png';

            $folder     = 'student/' . $user->id . '/' . 'signature';
            $fullPath   = $folder . '/' . $imageName;
            Storage::disk('s3')->put($fullPath, base64_decode($image));
            StudentsDocument::updateOrCreate([
                'user_id' => $user->id,
            ], [
                'signature' => $fullPath
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Tanda Tangan berhasil disimpan'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function handlePrint()
    {
        
    }
}
