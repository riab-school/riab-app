<?php

namespace App\Http\Controllers\Staff\Kesehatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        return view('app.staff.kesehatan.dashboard');
    }
}
