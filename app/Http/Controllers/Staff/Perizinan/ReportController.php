<?php

namespace App\Http\Controllers\Staff\Perizinan;

use App\Http\Controllers\Controller;
use App\Models\StudentDetail;
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
            'report_by' => 'required|in:date,nis_nisn',
            'from_date' => 'required_if:report_by,date|date|nullable',
            'to_date'   => 'required_if:report_by,date|date|nullable',
            'status'    => 'required_if:report_by,date|nullable',
            'id_siswa'  => 'required_if:report_by,nis_nisn|nullable',
        ]);

        try {

            if($request->report_by == 'date'){
                if($request->status == 'all'){
                    $data['permissions'] = StudentPermissionHistory::whereBetween('created_at', [$request->from_date, $request->to_date])->get();
                } else {
                    $data['permissions'] = StudentPermissionHistory::whereBetween('created_at', [$request->from_date, $request->to_date])
                        ->where('status', $request->status)
                        ->get();
                }
                $data['from_date'] = dateIndo($request->from_date);
                $data['to_date'] = dateIndo($request->to_date);
                $data['status'] = $request->status;
                $data['report_by'] = 'date';
                return view('app.staff.perizinan.report.print-report', $data);
            } elseif($request->report_by == 'nis_nisn'){
                $data['permissions'] = StudentPermissionHistory::where(function ($query) use ($request) {
                    if(!empty($request->from_date2) && !empty($request->to_date2)){
                        $query->whereBetween('created_at', [$request->from_date2, $request->to_date2]);
                    }
                    $query->whereRelation('detail.studentDetail', 'nis', $request->id_siswa)->orWhereRelation('detail.studentDetail', 'nisn', $request->id_siswa);
                })->get();
                $data['from_date2'] = $request->from_date2 ? dateIndo($request->from_date2) : null;
                $data['to_date2'] = $request->to_date2 ? dateIndo($request->to_date2) : null;
                $data['status'] = 'all';
                $data['report_by'] = 'nis_nisn';
                $data['studentData'] = StudentDetail::where(function ($query) use ($request) {
                    $query->where('nis', $request->id_siswa)
                        ->orWhere('nisn', $request->id_siswa);
                })->first();
                return view('app.staff.perizinan.report.print-report', $data);
                
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with([
                'status'    => 'error',
                'message'   => 'An error occurred while generating the report: ' . $th->getMessage()
            ]);
        }
    }
}
