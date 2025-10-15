<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePsbAdmChecingkIsPassed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->registration_history->is_administration_confirmed == NULL) {
            return redirect()->route('student.home.new')->with([
                'status'    => 'error',
                'message'   => 'Anda belum dapat melanjutkan, silahkan tunggu verifikasi berkas dan administrasi dari panitia.',
            ]);
        } elseif($request->registration_history->is_administration_confirmed == 1 && $request->registration_history->is_administration_pass == 0) {
            return redirect()->route('student.home.new')->with([
                'status'    => 'error',
                'message'   => 'Maaf, Anda tidak lulus seleksi administrasi, silahkan hubungi panitia untuk informasi lebih lanjut.',
            ]);
        }
        return $next($request);
    }
}
