<?php

namespace App\Http\Controllers\Staff\Psb;

use App\Http\Controllers\Controller;
use App\Models\PsbHistory;
use App\Models\PsbInterviewRoom;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // public function showDashboardPage(Request $request)
    // {
    //     return view('app.staff.master-psb.dashboard');
    // }

    public function showDashboardPage()
    {
        $undangan_mipa_pria = PsbHistory::where([
            'registration_method' => 'invited',
            'is_moved_to_non_invited' => 0,
            'class_focus' => 'mipa'
        ])->whereRelation('studentDetail', 'gender', 'male')->count();

        $undangan_mipa_wanita = PsbHistory::where([
            'registration_method' => 'invited',
            'is_moved_to_non_invited' => 0,
            'class_focus' => 'mipa'
        ])->whereRelation('studentDetail', 'gender', 'female')->count();

        $undangan_mak_pria = PsbHistory::where([
            'registration_method' => 'invited',
            'is_moved_to_non_invited' => 0,
            'class_focus' => 'mak'
        ])->whereRelation('studentDetail', 'gender', 'male')->count();

        $undangan_mak_wanita = PsbHistory::where([
            'registration_method' => 'invited',
            'is_moved_to_non_invited' => 0,
            'class_focus' => 'mak'
        ])->whereRelation('studentDetail', 'gender', 'female')->count();

        $undangan_by_kota = PsbHistory::where([
            'registration_method' => 'invited',
            'is_moved_to_non_invited' => 0,
        ])
        ->get()
        ->groupBy(function ($item) {
            return $item->studentDetail->cityDetail->name ?? 'N/A';
        })
        ->map(function ($item) {
            return $item->count();
        });

        
        $reguler_mipa_pria = PsbHistory::where('class_focus', 'mipa')->whereRelation('studentDetail', 'gender', 'male')->count();
        $reguler_mipa_wanita = PsbHistory::where('class_focus', 'mipa')->whereRelation('studentDetail', 'gender', 'female')->count();
        $reguler_mak_pria = PsbHistory::where('class_focus', 'mak')->whereRelation('studentDetail', 'gender', 'male')->count();
        $reguler_mak_wanita = PsbHistory::where('class_focus', 'mak')->whereRelation('studentDetail', 'gender', 'female')->count();

        $reguler_by_kota = PsbHistory::get()
        ->groupBy(function ($item) {
            return $item->studentDetail->cityDetail->name ?? 'N/A'; // Ganti 'city' dengan relasi yang sesuai
        })
        ->map(function ($item) {
            return $item->count();
        });
        $data = [
            'undangan_mipa_pria'                    => $undangan_mipa_pria,
            'undangan_mipa_wanita'                  => $undangan_mipa_wanita,
            'undangan_mak_pria'                     => $undangan_mak_pria,
            'undangan_mak_wanita'                   => $undangan_mak_wanita,
            'undangan_ipa'                          => $undangan_mipa_pria + $undangan_mipa_wanita,
            'undangan_mak'                          => $undangan_mak_pria + $undangan_mak_wanita,
            'undangan'                              => $undangan_mipa_pria + $undangan_mipa_wanita + $undangan_mak_pria + $undangan_mak_wanita,
            'undangan_pindah'                       => PsbHistory::where([
                                                            'registration_method'       => 'invited',
                                                            'is_moved_to_non_invited'   => 1,
                                                        ])->count(),
            'undangan_by_kota'                      => $undangan_by_kota,

            'reguler_mipa_pria'                     => $reguler_mipa_pria,
            'reguler_mipa_wanita'                   => $reguler_mipa_wanita,
            'reguler_mak_pria'                      => $reguler_mak_pria,
            'reguler_mak_wanita'                    => $reguler_mak_wanita,
            'reguler_by_kota'                       => $reguler_by_kota,
            'reguler_by_day_ujian'                  => [
                                                            'day_1' => PsbInterviewRoom::where('exam_date', '2026-01-03')->count(),
                                                            'day_2' => PsbInterviewRoom::where('exam_date', '2026-01-04')->count(),
                                                            'day_3' => PsbInterviewRoom::where('exam_date', '2026-01-05')->count(),
                                                        ],
        ];
        return view('app.staff.master-psb.dashboard', $data);
    }
}
