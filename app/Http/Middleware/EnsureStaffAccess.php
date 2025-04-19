<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStaffAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user()->user_level !== 'staff'){
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses ke halaman ini'
            ]);
        }

        if(!session()->get('tahun_ajaran_aktif_id')){
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login');
        }
        
        $request->merge([
            'home_url' => route('staff.home'),
        ]);
        return $next($request);
    }
}
