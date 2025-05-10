<?php

namespace App\Http\Controllers\Staff\Kesehatan;

use App\Http\Controllers\Controller;
use App\Models\StudentMedicalCheckHistory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showDashboard(Request $request)
    {
        if($request->ajax()){
            $topPatient = StudentMedicalCheckHistory::select('user_id', \DB::raw('count(*) as total'))->groupBy('user_id')->with('userDetail.studentDetail')->orderBy('total', 'desc')
                ->get()
                ->take(10)
                ->map(function ($item) {
                    $document = $item->userDetail->studentDetail->studentDocument ?? null;
                    $item->userDetail->studentDetail->photo_url = $document && $document->photo
                        ? Storage::disk('s3')->url($document->photo)
                        : asset('assets/images/blank_person.jpg');
                    return $item;
            });

            $topMonthPatient = StudentMedicalCheckHistory::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->select('user_id', \DB::raw('count(*) as total'))
                ->groupBy('user_id')
                ->with('userDetail.studentDetail')
                ->orderBy('total', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($item) {
                    $document = $item->userDetail->studentDetail->studentDocument ?? null;
                    $item->userDetail->studentDetail->photo_url = $document && $document->photo
                        ? Storage::disk('s3')->url($document->photo)
                        : asset('assets/images/blank_person.jpg');
                    return $item;
            });

            if($request->has('chart_years')) {
                $years = $request->input('chart_years');
            }
            else {
                $years = now()->year;
            }

            $chartPatient = StudentMedicalCheckHistory::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
                            ->whereYear('created_at', $years)
                            ->groupBy('year', 'month')
                            ->orderBy('year')
                            ->orderBy('month')
                            ->get();

            $data = [
                'total_patient_count' => StudentMedicalCheckHistory::count(),
                'month_patient_count' => StudentMedicalCheckHistory::where('created_at', '>=', now()->startOfMonth())->where('created_at', '<=', now()->endOfMonth())->count(),
                'week_patient_count'  => StudentMedicalCheckHistory::where('created_at', '>=', now()->startOfWeek())->where('created_at', '<=', now()->endOfWeek())->count(),
                'day_patient_count'   => StudentMedicalCheckHistory::where('created_at', '>=', now()->startOfDay())->where('created_at', '<=', now()->endOfDay())->count(),
                'top_patient_count'   => $topPatient,
                'top_month_patient'   => $topMonthPatient,
                'chart_patient'       => $chartPatient,
            ];
            return response()->json([
                'status' => 'success',
                'message' => 'Dashboard data retrieved successfully',
                'data' => $data,
            ]);
        }
        return view('app.staff.kesehatan.dashboard');
    }
}
