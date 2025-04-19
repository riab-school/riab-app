<?php

namespace App\Http\Controllers\Staff\MasterClassrooms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function showClassroomList(Request $request)
    {
        return view('app.staff.classroom.list');
    }
}
