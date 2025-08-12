<?php

namespace App\Http\Controllers\Staff\Tahfidz;

use App\Http\Controllers\Controller;
use App\Models\MasterJuz;
use App\Models\StudentsMemorization;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        return view('app.staff.tahfidz-hafalan.dashboard');
    }

    public function cardData()
    {
        $users = StudentsMemorization::select('user_id')->distinct()->get();
        $juzMap = MasterJuz::all();
        $result = [
            "over_5" => 0,
            "over_10" => 0,
            "over_20_under_30" => 0,
            "30_juz" => 0,
        ];

        foreach ($users as $user) {
            $juzTouched = [];

            $hafalan = StudentsMemorization::where('user_id', $user->user_id)
                ->get();

            foreach ($hafalan as $row) {
                foreach ($juzMap as $juz) {
                    if ($row->surah >= $juz->from_surah && $row->surah <= $juz->to_surah) {
                        $juzTouched[$juz->juz] = true;
                    }
                }
            }

            $juzCount = count($juzTouched);

            if ($juzCount >= 30) {
                $result["30_juz"]++;
            } elseif ($juzCount > 20 && $juzCount < 30) {
                $result["over_20_under_30"]++;
            } elseif ($juzCount > 10) {
                $result["over_10"]++;
            } elseif ($juzCount > 5) {
                $result["over_5"]++;
            }
        }

        return response()->json($result);
    }

    public function getStudentCountPerJuz()
    {
        $juzMap = MasterJuz::all();
        $memorizations = StudentsMemorization::all();

        $juzStudentMap = [];

        foreach ($juzMap as $juz) {
            $juzStudentMap[$juz->juz] = []; // Inisialisasi semua juz agar tetap muncul walau 0
        }

        foreach ($memorizations as $m) {
            foreach ($juzMap as $juz) {
                $isInSameSurah = $m->surah == $juz->from_surah && $m->surah == $juz->to_surah;
                $isInRange = false;

                if ($isInSameSurah) {
                    $isInRange = $m->from_ayat <= $juz->to_ayat && $m->to_ayat >= $juz->from_ayat;
                } elseif ($m->surah == $juz->from_surah) {
                    $isInRange = $m->to_ayat >= $juz->from_ayat;
                } elseif ($m->surah == $juz->to_surah) {
                    $isInRange = $m->from_ayat <= $juz->to_ayat;
                } elseif ($m->surah > $juz->from_surah && $m->surah < $juz->to_surah) {
                    $isInRange = true;
                }

                if ($isInRange) {
                    $juzNumber = $juz->juz;
                    $userId = $m->user_id;

                    $juzStudentMap[$juzNumber][$userId] = true;
                }
            }
        }

        // Bentuk array hasil akhir
        $result = [];
        foreach ($juzStudentMap as $juz => $users) {
            $result[] = [
                'juz' => (int) $juz,
                'student_count' => count($users)
            ];
        }

        usort($result, fn($a, $b) => $a['juz'] <=> $b['juz']);

        return response()->json($result);
    }

}
