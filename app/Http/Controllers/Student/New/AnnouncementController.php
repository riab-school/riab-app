<?php

namespace App\Http\Controllers\Student\New;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        return view('app.student.new.pengumuman');
    }
}
