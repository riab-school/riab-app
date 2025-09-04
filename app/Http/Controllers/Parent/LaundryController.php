<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaundryController extends Controller
{
    public function showPageRaport()
    {
        // $check = ParentClaimStudent::where('parent_user_id', auth()->user()->id)->first();
        // if ($check && $check->student_user_id !== null) {
        //     $detail = StudentsDocument::where('user_id', $check->student_user_id);
        //     $data = [
        //         'code'      => 200,                
        //         'data'      => $detail->first(),
        //     ];
        // } else {
        //     return redirect()->route('parent.anandaku');
        // }
        // return view('app.parent.raport-dayah', $data);
        return view('app.parent.laundry');
    }
}
