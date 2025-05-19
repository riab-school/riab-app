<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnandakuController extends Controller
{
    public function showPage(Request $request)
    {
        return view('app.parent.anandaku');
    }

    public function findStudentData(Request $request)
    {
        
    }

    public function pairingStudentWithParent()
    {
        
    }
}
