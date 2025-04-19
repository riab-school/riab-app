<?php

namespace App\Http\Controllers\Staff\Psb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamResultController extends Controller
{
    public function showExamResultIndex()
    {
        return view('app.staff.master-psb.exam-result.index');
    }
    
    public function showExamResultResult()
    {
        return view('app.staff.master-psb.exam-result.result');
    }
}
