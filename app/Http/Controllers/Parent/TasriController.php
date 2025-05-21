<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TasriController extends Controller
{
    public function showPage()
    {
        return view('app.parent.tasri');
    }
}
