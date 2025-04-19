<?php

namespace App\Http\Middleware;

use App\Models\UserHasMenuPermission;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCanAccessMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $url = $request->segment(1) . '/' . $request->segment(2). '/' . $request->segment(3);

        $dateTime = Carbon::now()->format('Y-m-d H:i:s');
        $getAccessList = UserHasMenuPermission::where('user_id', auth()->user()->id)->whereRelation('childMenuDetail', ['route' => $url, 'is_active'  => true])->first();

        if (!$getAccessList) abort(404, 'Page not found.');

        if ($getAccessList->is_permanent_access == false) {
            if ($dateTime < $getAccessList->permited_start_at) abort(403, 'You can access this page after ' . Carbon::createFromTimeStamp(strtotime($getAccessList->permited_start_at))->diffForHumans());

            if ($dateTime > $getAccessList->permited_end_at) abort(403, 'Your access to this page was ended');
        }
        return $next($request);
    }
}
