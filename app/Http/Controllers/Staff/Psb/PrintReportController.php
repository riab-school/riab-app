<?php

namespace App\Http\Controllers\Staff\Psb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrintReportController extends Controller
{
    public function showPrintReportIndex()
    {
        return view('app.staff.master-psb.print-report.index');
    }
    
    public function showPrintReportResult()
    {
        return view('app.staff.master-psb.print-report.result');
    }
}
