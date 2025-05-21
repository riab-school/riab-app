<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\ParentClaimStudent;
use App\Models\StudentMedicalCheckHistory;
use Illuminate\Http\Request;
use Storage;

class KesehatanController extends Controller
{
    public function showPage()
    {
        // Check if the user is logged in has student
        $check = ParentClaimStudent::where('parent_user_id', auth()->user()->id)->first();
        if ($check && $check->student_user_id !== null) {
            return view('app.parent.kesehatan');
        } else {
            return redirect()->route('parent.anandaku');
        }
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $check = ParentClaimStudent::where('parent_user_id', auth()->user()->id)->first();

            if ($check && $check->student_user_id !== null) {
                $page = $request->input('page', 1);
                $limit = 8;

                $history = StudentMedicalCheckHistory::where('user_id', $check->student_user_id)
                    ->orderBy('created_at', 'desc')
                    ->paginate($limit, ['*'], 'page', $page);

                $history->getCollection()->transform(function ($item) {
                    $item->created_at = $item->createdAt = $item->created_at->format('d-M-Y H:i');
                    $item->diagnozed_by = $item->diagnozedBy->staffDetail->name ?? '-';
                    $item->evidence = $item->evidence !== NULL ? Storage::disk('s3')->url($item->evidence) : null;
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
}
