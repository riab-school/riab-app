<?php

namespace App\Http\Controllers\Staff\MasterStudents;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class StudentStatusController extends Controller
{
    public function showStatusStudentPage(Request $request)
    {
        return view('app.staff.master-student.status');
    }

}
