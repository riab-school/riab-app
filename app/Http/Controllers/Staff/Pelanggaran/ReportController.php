<?php

namespace App\Http\Controllers\Staff\Pelanggaran;

use App\Http\Controllers\Controller;
use App\Models\StudentDetail;
use App\Models\StudentsViolation;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function showReportFilterPage()
    {
        return view('app.staff.pelanggaran.report.index');	
    }

    public function handleReportPrint(Request $request)
    {
        $request->validate([
            'report_by' => 'required|in:date,nis_nisn',
            'from_date' => 'required_if:report_by,date',
            'to_date'   => 'required_if:report_by,date',
            'id_siswa'  => 'required_if:report_by,nis_nisn|',
        ]);

        try {

            if($request->report_by == 'date'){
                $data['violations'] = StudentsViolation::whereBetween('created_at', [$request->from_date.' 00:00:00', $request->to_date.' 23:59:59'])->get();
                $data['from_date'] = dateIndo($request->from_date);
                $data['to_date'] = dateIndo($request->to_date);
                $data['report_by'] = 'date';
                return view('app.staff.pelanggaran.report.print-report', $data);
            } elseif($request->report_by == 'nis_nisn'){
                $data['violations'] = StudentsViolation::where(function ($query) use ($request) {
                    if(!empty($request->from_date2) && !empty($request->to_date2)){
                        $query->whereBetween('created_at', [$request->from_date2.' 00:00:00', $request->to_date2.' 23:59:59']);
                    }
                    $query->whereRelation('userDetail.studentDetail', 'nis', $request->id_siswa)
                        ->orWhereRelation('userDetail.studentDetail', 'nisn', $request->id_siswa);
                })->get();
                $data['report_by'] = 'nis_nisn';
                $data['studentData'] = StudentDetail::where(function ($query) use ($request) {
                    $query->where('nis', $request->id_siswa)
                        ->orWhere('nisn', $request->id_siswa);
                })->first();
                return view('app.staff.pelanggaran.report.print-report', $data);
                
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with([
                'status'    => 'error',
                'message'   => 'An error occurred while generating the report: ' . $th->getMessage()
            ]);
        }
    }
}
