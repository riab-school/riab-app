<?php

namespace App\Http\Controllers\Staff\Perizinan;

use App\Http\Controllers\Controller;
use App\Models\StudentPermissionHistory;
use Illuminate\Http\Request;
use Storage;

class DashboardController extends Controller
{
    public function showDashboard(Request $request)
    {
        if($request->ajax()) {
            $checkoutData = StudentPermissionHistory::where('status', 'check_out')
                ->with('detail.studentDetail.studentDocument', 'approvedBy.staffDetail', 'checkedOutBy.staffDetail')
                ->get()
                ->take(5)
                ->map(function ($item) {
                    $document = $item->detail->studentDetail->studentDocument ?? null;
                    $item->detail->studentDetail->photo_url = $document && $document->photo
                        ? Storage::disk('s3')->url($document->photo)
                        : null;
                    return $item;
            });

            $checkinData = StudentPermissionHistory::where('status', 'check_in')
                ->with('detail.studentDetail.studentDocument', 'approvedBy.staffDetail', 'checkedInBy.staffDetail')
                ->get()
                ->take(5)
                ->map(function ($item) {
                    $document = $item->detail->studentDetail->studentDocument ?? null;
                    $item->detail->studentDetail->photo_url = $document && $document->photo
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
            $chartData = StudentPermissionHistory::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, requested_by, COUNT(*) as total')
                        ->whereYear('created_at', $years)
                        ->groupBy('year', 'month', 'requested_by')
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get();
            $data = [
                'requested_count'   => StudentPermissionHistory::where('status', 'requested')->count(),
                'approved_count'    => StudentPermissionHistory::where('status', 'approved')->count(),
                'rejected_count'    => StudentPermissionHistory::where('status', 'rejected')->count(),
                'cancelled_count'   => StudentPermissionHistory::where('status', 'cancelled')->count(),
                'checkout_data'     => $checkoutData,
                'checkout_count'    => StudentPermissionHistory::where('status', 'check_out')->count(),
                'checkin_data'      => $checkinData,
                'checkin_count'     => StudentPermissionHistory::where('status', 'check_in')->count(),
                'chart_data'        => $chartData,
            ];
            return response()->json([
                'status' => 'success',
                'message' => 'Dashboard data retrieved successfully',
                'data' => $data,
            ]);
        }

        return view('app.staff.perizinan.dashboard');
    }
}
