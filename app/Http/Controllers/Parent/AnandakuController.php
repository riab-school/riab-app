<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\StudentDetail;
use Illuminate\Http\Request;

class AnandakuController extends Controller
{
    public function showPage(Request $request)
    {
        return view('app.parent.anandaku');
    }

    public function findStudentData(Request $request)
    {
        if($request->ajax()) {
            $data = StudentDetail::where('nis', $request->nis_nisn)->orWhere('nisn', $request->nis_nisn)->first();
            if (!$data) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data NIS/NISN tidak ditemukan'
                ], 404);
            }
            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);
        }
    }

    public function pairingStudentWithParent()
    {
        
    }
}
