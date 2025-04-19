<?php

namespace App\Http\Controllers\Staff\Psb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showDashboardPage(Request $request)
    {
        return view('app.staff.master-psb.dashboard');
    }
}
