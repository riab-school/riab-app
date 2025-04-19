<?php

namespace App\Http\Controllers\Staff\Psb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function showPaymentPage(Request $request)
    {
        return view('app.staff.master-psb.payment');
    }
}
