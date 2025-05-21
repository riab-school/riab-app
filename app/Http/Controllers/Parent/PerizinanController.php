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
        // Check if the user is logged in has student
        $check = ParentClaimStudent::where('parent_user_id', auth()->user()->id)->first();
        if ($check && $check->student_user_id !== null) {
            return view('app.parent.perizinan');
        } else {
            return redirect()->route('parent.anandaku');
        }
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
                    $item->from_date = $item->from_date !== NULL ? dateIndo($item->from_date) : '-';
                    $item->to_date = $item->to_date !== NULL ? dateIndo($item->to_date) : '-';
                    $item->rejected_by = $item->rejected_by !== NULL ? $item->rejectedBy->staffDetail->name : '-';
                    $item->approved_by = $item->approved_by !== NULL ? $item->approvedBy->staffDetail->name : '-';
                    $item->checked_in_by = $item->checked_in_by !== NULL ? $item->checkedInBy->staffDetail->name : '-';
                    $item->checked_out_by = $item->checked_out_by !== NULL ? $item->checkedOutBy->staffDetail->name : '-';
                    switch ($item->requested_by) {
                        case 'staff_kesehatan':
                            $item->requested_by = 'Staff Kesehatan';
                            break;
                        case 'wali':
                            $item->requested_by = 'Wali Santri';
                            $item->applicant_id = '-';
                            break;
                        case 'orang_tua':
                            $item->requested_by = 'Orang Tua';
                            break;
                        case 'siswa':
                            $item->requested_by = 'Siswa';
                            break;
                    }
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
