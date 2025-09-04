<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\ParentClaimStudent;
use App\Models\StudentsMemorization;
use Illuminate\Http\Request;

class TahfidzController extends Controller
{
    public function showPage()
    {
        return view('app.parent.tahfidz');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $check = ParentClaimStudent::where('parent_user_id', auth()->user()->id)->first();

            if ($check && $check->student_user_id !== null) {
                $page = $request->input('page', 1);
                $limit = 8;

                $history = StudentsMemorization::where('user_id', $check->student_user_id)
                    ->orderBy('created_at', 'desc')
                    ->paginate($limit, ['*'], 'page', $page);

                $history->getCollection()->transform(function ($item) {
                    $item->created_at = $item->createdAt = $item->created_at->format('d-M-Y H:i');
                    $item->diagnozed_by = $item->tasmikBy->staffDetail->name ?? '-';
                    $item->evidence = $item->evidence !== NULL ? Storage::disk('s3')->url($item->evidence) : null;
                    $item->surah = $item->getSurahNameAttribute();
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

    public function getDetail(Request $request)
    {
        if ($request->ajax()) {
            $history = StudentsMemorization::where('id', $request->id)->first();
            if ($history) {
                $history->created_at = $history->createdAt = $history->created_at->format('d-M-Y H:i');
                $history->diagnozed_by = $history->tasmikBy->staffDetail->name ?? '-';
                $history->evidence = $history->evidence !== NULL ? Storage::disk('s3')->url($history->evidence) : null;
                $history->surah = $history->getSurahNameAttribute();
                return response()->json([
                    'status' => true,
                    'data' => $history
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'Data not found'
            ], 404);
        }
    }
}
