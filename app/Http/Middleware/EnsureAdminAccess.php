<?php

namespace App\Http\Middleware;

use App\Models\UserHasMenuPermission;
use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // cek dulu ada izin menu atau tidak
        if(auth()->user()->user_level !== 'admin') {
            $url = $request->segment(1) . '/' . $request->segment(2). '/' . $request->segment(3);

            $dateTime = Carbon::now()->format('Y-m-d H:i:s');
            $getAccessList = UserHasMenuPermission::where('user_id', auth()->user()->id)->whereRelation('childMenuDetail', ['route' => $url, 'is_active'  => true])->first();

            if (!$getAccessList) abort(404, 'Page not found.');

            if ($getAccessList->is_permanent_access == false) {
                if ($dateTime < $getAccessList->permited_start_at) abort(403, 'You can access this page after ' . Carbon::createFromTimeStamp(strtotime($getAccessList->permited_start_at))->diffForHumans());

                if ($dateTime > $getAccessList->permited_end_at) abort(403, 'Your access to this page was ended');
            }
            
        } elseif (auth()->user()->user_level !== 'admin') {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses ke halaman ini'
            ]);
        } 

        $request->merge([
            'home_url' => route('admin.home'),
        ]);
        return $next($request);
    }
}
