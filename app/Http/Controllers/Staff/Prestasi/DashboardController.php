<?php

namespace App\Http\Controllers\Staff\Prestasi;

use App\Http\Controllers\Controller;
use App\Models\StudentsAchievement;
use Illuminate\Http\Request;
use Storage;

class DashboardController extends Controller
{
    public function showDashboard(Request $request)
    {
        if($request->ajax()){
            $topAchievement = StudentsAchievement::select('user_id', \DB::raw('count(*) as total'))->groupBy('user_id')->with('userDetail.studentDetail')->orderBy('total', 'desc')
                ->get()
                ->take(10)
                ->map(function ($item) {
                    $document = $item->userDetail->studentDetail->studentDocument ?? null;
                    $item->userDetail->studentDetail->photo_url = $document && $document->photo
                        ? Storage::disk('s3')->url($document->photo)
                        : asset('assets/images/blank_person.jpg');
                    return $item;
            });

            $topMonthAchievement = StudentsAchievement::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
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

            $chartAchievement = StudentsAchievement::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
                            ->whereYear('created_at', $years)
                            ->groupBy('year', 'month')
                            ->orderBy('year')
                            ->orderBy('month')
                            ->get();

            $data = [
                'total_achievement_count' => StudentsAchievement::count(),
                'month_achievement_count' => StudentsAchievement::where('created_at', '>=', now()->startOfMonth())->where('created_at', '<=', now()->endOfMonth())->count(),
                'week_achievement_count'  => StudentsAchievement::where('created_at', '>=', now()->startOfWeek())->where('created_at', '<=', now()->endOfWeek())->count(),
                'day_achievement_count'   => StudentsAchievement::where('created_at', '>=', now()->startOfDay())->where('created_at', '<=', now()->endOfDay())->count(),
                'top_achievement_count'   => $topAchievement,
                'top_month_achievement'   => $topMonthAchievement,
                'chart_achievement'       => $chartAchievement,
            ];
            return response()->json([
                'status' => 'success',
                'message' => 'Dashboard data retrieved successfully',
                'data' => $data,
            ]);
        }
        return view('app.staff.prestasi.dashboard');
    }
}
