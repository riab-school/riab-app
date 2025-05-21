<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\ParentClaimStudent;
use App\Models\StudentPermissionHistory;
use Illuminate\Http\Request;

class PerizinanController extends Controller
{
    public function showPage()
    {
        return view('app.parent.perizinan');
    }

    public function getHistory(Request $request)
    {
        if ($request->ajax()) {
            $check = ParentClaimStudent::where('parent_user_id', auth()->user()->id)->first();

            if ($check && $check->student_user_id !== null) {
                $page = $request->input('page', 1);
                $limit = 8;

                $history = StudentPermissionHistory::where('user_id', $check->student_user_id)
                    ->orderBy('created_at', 'desc')
                    ->paginate($limit, ['*'], 'page', $page);

                $history->getCollection()->transform(function ($item) {
                    $item->from_date = dateIndo($item->from_date);
                    $item->to_date = dateIndo($item->to_date);
                    return $item;
                });

                return response()->json([
                    'status' => true,
                    'data' => $history->items(),
                    'total' => $history->total(),
                    'next_page' => $history->hasMorePages() ? $page + 1 : null
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'Data not found'
            ], 404);
        }
    }


    public function showPageRequestPermission()
    {
        return view('app.parent.perizinan-request');
    }

    public function handleRequestPermission(Request $request)
    {
        
    }
}
