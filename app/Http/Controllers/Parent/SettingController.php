<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\ParentDetail;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function showSettingPage()
    {
        return view('app.parent.settings');
    }

    public function updateNotificationSetting(Request $request)
    {
        $request->validate([
            'is_allow_send_wa' => 'required|boolean',
        ]);

        $update = ParentDetail::where('user_id', auth()->user()->id)
        ->update([
            'is_allow_send_wa' => $request->is_allow_send_wa,
        ]);

        if (!$update) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui pengaturan notifikasi',
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Pengaturan notifikasi berhasil diperbarui',
        ], 200);
    }
}
