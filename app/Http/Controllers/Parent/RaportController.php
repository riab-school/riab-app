<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RaportController extends Controller
{
    public function showPageRaportSekolah()
    {
        return view('app.parent.raport-sekolah');
    }

    public function showPageRaportDayah()
    {
        return view('app.parent.raport-dayah');
    }
}
