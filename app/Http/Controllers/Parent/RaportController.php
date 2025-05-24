<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\ParentClaimStudent;
use App\Models\StudentsDocument;
use Illuminate\Http\Request;

class RaportController extends Controller
{
    public function showPageRaportSekolah()
    {
        $check = ParentClaimStudent::where('parent_user_id', auth()->user()->id)->first();
        if ($check && $check->student_user_id !== null) {
            $detail = StudentsDocument::where('user_id', $check->student_user_id);
            $data = [
                'code'      => 200,                
                'data'      => $detail->first(),
            ];
        }
        return view('app.parent.raport-sekolah', $data);
    }

    public function showPageRaportDayah()
    {
        $check = ParentClaimStudent::where('parent_user_id', auth()->user()->id)->first();
        if ($check && $check->student_user_id !== null) {
            $detail = StudentsDocument::where('user_id', $check->student_user_id);
            $data = [
                'code'      => 200,                
                'data'      => $detail->first(),
            ];
        }
        return view('app.parent.raport-dayah', $data);
    }
}