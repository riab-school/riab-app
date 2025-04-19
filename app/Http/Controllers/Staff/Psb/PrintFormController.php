<?php

namespace App\Http\Controllers\Staff\Psb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrintFormController extends Controller
{
    public function showPrintFormIndex()
    {
        return view('app.staff.master-psb.print-form.index');
    }
    
    public function showPrintFormResult()
    {
        return view('app.staff.master-psb.print-form.result');
    }
}
