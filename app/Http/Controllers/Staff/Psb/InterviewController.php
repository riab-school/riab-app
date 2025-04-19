<?php

namespace App\Http\Controllers\Staff\Psb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function showInterviewIndex(Request $request)
    {
        return view('app.staff.master-psb.interview.index');
    }

    public function showInterviewBacaan(Request $request)
    {
        return view('app.staff.master-psb.interview.bacaan');
    }

    public function showInterviewIbadah(Request $request)
    {
        return view('app.staff.master-psb.interview.ibadah');
    }

    public function showInterviewQA(Request $request)
    {
        return view('app.staff.master-psb.interview.qa');
    }

    public function showInterviewParent(Request $request)
    {
        return view('app.staff.master-psb.interview.parent');
    }
}
