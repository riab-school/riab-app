<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasTahunAjaranSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // check is tahun_ajaran_is is still exist on session
        if(Session::get('tahun_ajaran_aktif_id') == null) {
            return redirect()->route('logout');
        }
        return $next($request);
    }
}
