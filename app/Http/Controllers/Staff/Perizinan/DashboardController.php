<?php

namespace App\Http\Controllers\Staff\Perizinan;

use App\Http\Controllers\Controller;
use App\Models\StudentPermissionHistory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $data = [
            'requested_count'   => StudentPermissionHistory::where('status', 'requested')->count(),
            'approved_count'    => StudentPermissionHistory::where('status', 'approved')->count(),
            'rejected_count'    => StudentPermissionHistory::where('status', 'rejected')->count(),
            'cancelled_count'   => StudentPermissionHistory::where('status', 'cancelled')->count(),
            'checkout_data'     => StudentPermissionHistory::where('status', 'checked_iut')->get()->take(5),
            'checkin_data'      => StudentPermissionHistory::where('status', 'checked_in')->get()->take(5),
        ];
        return view('app.staff.perizinan.dashboard', $data);
    }
}
