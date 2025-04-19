<?php

namespace App\Http\Controllers\Staff\Psb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentListController extends Controller
{
    public function showStudentListPage(Request $request)
    {
        return view('app.staff.master-psb.student-list');   
    }
}
