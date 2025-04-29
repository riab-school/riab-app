<?php

namespace App\Http\Controllers\Staff\Perizinan;

use App\Http\Controllers\Controller;
use App\Models\StudentPermissionHistory;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function showReportFilterPage()
    {
        return view('app.staff.perizinan.report.index');	
    }

    public function handleReportPrint(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            
        ]);

        try {
            if($request->status == 'all'){
                $data['permissions'] = StudentPermissionHistory::whereBetween('created_at', [$request->from_date, $request->to_date])->get();
            } else {
                $data['permissions'] = StudentPermissionHistory::where('status', $request->status)
                    ->whereBetween('created_at', [$request->from_date, $request->to_date])
                    ->get();
            }
            $data['from_date'] = dateIndo($request->from_date);
            $data['to_date'] = dateIndo($request->to_date);
            $data['status'] = $request->status;
            return view('app.staff.perizinan.report.print-report', $data);
        } catch (\Throwable $th) {
            return redirect()->back()->with([
                'status'    => 'error',
                'message'   => 'An error occurred while generating the report: ' . $th->getMessage()
            ]);
        }
    }
}
