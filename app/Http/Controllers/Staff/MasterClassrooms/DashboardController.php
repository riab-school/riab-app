<?php

namespace App\Http\Controllers\Staff\MasterClassrooms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showDashboard(Request $request)
    {
        return view('app.staff.classroom.dashboard');
    }
}
