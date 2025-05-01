<?php

namespace App\Http\Controllers\Staff\Pelanggaran;

use App\Http\Controllers\Controller;
use App\Models\StudentsViolation;
use Illuminate\Http\Request;
use Storage;

class DashboardController extends Controller
{
    public function showDashboard(Request $request)
    {
        if($request->ajax()){
            $topViolation = StudentsViolation::select('user_id', \DB::raw('count(*) as total'))->groupBy('user_id')->with('detail.studentDetail')->orderBy('total', 'desc')
                ->get()
                ->take(10)
                ->map(function ($item) {
                    $document = $item->detail->studentDetail->studentDocument ?? null;
                    $item->detail->studentDetail->photo_url = $document && $document->photo
                        ? Storage::disk('s3')->url($document->photo)
                        : null;
                    return $item;
            });

            $topMonthViolation = StudentsViolation::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->select('user_id', \DB::raw('count(*) as total'))
                ->groupBy('user_id')
                ->with('detail.studentDetail')
                ->orderBy('total', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($item) {
                    $document = $item->detail->studentDetail->studentDocument ?? null;
                    $item->detail->studentDetail->photo_url = $document && $document->photo
                        ? Storage::disk('s3')->url($document->photo)
                        : null;
                    return $item;
            });

            $data = [
                'total_violation_count' => StudentsViolation::count(),
                'month_violation_count' => StudentsViolation::where('created_at', '>=', now()->startOfMonth())->where('created_at', '<=', now()->endOfMonth())->count(),
                'week_violation_count'  => StudentsViolation::where('created_at', '>=', now()->startOfWeek())->where('created_at', '<=', now()->endOfWeek())->count(),
                'day_violation_count'   => StudentsViolation::where('created_at', '>=', now()->startOfDay())->where('created_at', '<=', now()->endOfDay())->count(),
                'top_violation_count'   => $topViolation,
                'top_month_violation'   => $topMonthViolation,
                'chart_violation'       => StudentsViolation::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
                                            ->whereYear('created_at', now()->year)
                                            ->groupBy('year', 'month')
                                            ->orderBy('year')
                                            ->orderBy('month')
                                            ->get(),
            ];
            return response()->json([
                'status' => 'success',
                'message' => 'Dashboard data retrieved successfully',
                'data' => $data,
            ]);
        }
        return view('app.staff.pelanggaran.dashboard');
    }
}
