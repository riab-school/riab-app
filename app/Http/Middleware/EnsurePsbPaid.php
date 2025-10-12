<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePsbPaid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->registration_method == 'reguler' && $request->registration_history->is_paid == false) {
            return redirect()->route('student.home.new')->with([
                'status'    => 'error',
                'message'   => 'Pendaftaran belum lunas, silahkan selesaikan pembayaran terlebih dahulu'
            ]);
        }
        if($request->registration_method == 'invited-reguler' && $request->registration_history->is_paid == false) {
            return redirect()->route('student.home.new')->with([
                'status'    => 'error',
                'message'   => 'Pendaftaran belum lunas, silahkan selesaikan pembayaran terlebih dahulu'
            ]);
        }
        return $next($request);
    }
}
