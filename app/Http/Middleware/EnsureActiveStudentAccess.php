<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveStudentAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user()->user_level !== 'student' || auth()->user()->myDetail->status !== 'active'){
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses ke halaman ini'
            ]);
        }
        $request->merge([
            'home_url' => route('student.home.active'),
        ]);
        return $next($request);
    }
}
