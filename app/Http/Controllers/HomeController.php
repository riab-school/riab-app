<?php

namespace App\Http\Controllers;

use App\Models\AppLog;
use App\Models\MasterClassroom;
use App\Models\MasterDormitory;
use App\Models\MasterTahunAjaran;
use App\Models\StaffDetail;
use App\Models\StudentClassroomHistory;
use App\Models\StudentDetail;
use App\Models\StudentPermissionHistory;
use App\Models\StudentsAchievement;
use App\Models\StudentsViolation;
use App\Models\User;
use App\Models\WhatsappChatHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function homePageAdmin(Request $request)
    {
        if($request->ajax()){
            $status = waStatus();
            if($status->session->isConnected){
                $waStatus = "Connected";  
            } else{
                $waStatus = "Disconnect";
            }

            $data = [
                'totalUsers'        => User::count(),
                'totalLogs'         => AppLog::count(),
                'whatsappLog'       => WhatsappChatHistory::count(),
                'whatsappStatus'    => isWaServerOnline() ? 'Online' : 'Offline',
                'deviceStatus'      => $waStatus,
                'totalClassrooms'   => MasterClassroom::count(),
                'totalDormitories'  => MasterDormitory::count(),
            ];
            return $data;
        }
        return view('app.admin.dashboard');
    }

    public function homePageStaff(Request $request)
    {
        if($request->ajax()){

            // Change Session
            if($request->has('tahun_ajaran_new')){
                Session::put('tahun_ajaran_aktif_id', $request->tahun_ajaran_new);
                Session::put('tahun_ajaran_aktif', MasterTahunAjaran::where('id', $request->tahun_ajaran_new)->first()->tahun_ajaran);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Tahun ajaran berhasil diubah'
                ]);
            }

            // Get Card Count
            if($request->has('for') && $request->for == 'card_count'){
                $data = [
                    'totalStudents'     => StudentDetail::where('status', 'active')->count(),
                    'totalTeachers'     => StaffDetail::where('status', 'active')->count(),
                    'totalClassrooms'   => MasterClassroom::where('tahun_ajaran_id', Session::get('tahun_ajaran_aktif_id'))->count(),
                    'totalDormitories'  => MasterDormitory::where('tahun_ajaran_id', Session::get('tahun_ajaran_aktif_id'))->count(),
                ];
                return response()->json($data);
            }

            // Get Grafik data for Dashboard
            if($request->has('for') && $request->for == 'grafik'){
                $chartPermission = StudentPermissionHistory::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
                        ->whereYear('created_at', Session::get('tahun_ajaran_aktif'))
                        ->groupBy('year', 'month')
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get();
                $data = [
                    'studentViolation'      => StudentsViolation::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
                                                            ->whereYear('created_at', Session::get('tahun_ajaran_aktif'))
                                                            ->groupBy('year', 'month')
                                                            ->orderBy('year')
                                                            ->orderBy('month')
                                                            ->get(),
                                                            
                    'studentAchievement'    => StudentsAchievement::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
                                                            ->whereYear('created_at', Session::get('tahun_ajaran_aktif'))
                                                            ->groupBy('year', 'month')
                                                            ->orderBy('year')
                                                            ->orderBy('month')
                                                            ->get(),
                    

                    'byGender'              => StudentClassroomHistory::where('tahun_ajaran_id', Session::get('tahun_ajaran_aktif_id'))
                                                            ->where('is_active', 1)
                                                            ->join('student_details', 'student_classroom_histories.user_id', '=', 'student_details.user_id')
                                                            ->selectRaw('student_details.gender, COUNT(*) as total')
                                                            ->groupBy('student_details.gender')
                                                            ->get(),
                    
                    'byClassroom'           => StudentClassroomHistory::where('tahun_ajaran_id', Session::get('tahun_ajaran_aktif_id'))
                                                            ->where('is_active', 1)
                                                            ->join('master_classrooms', 'student_classroom_histories.classroom_id', '=', 'master_classrooms.id')
                                                            ->selectRaw('master_classrooms.grade, COUNT(*) as total')
                                                            ->groupBy('master_classrooms.grade')
                                                            ->orderBy('master_classrooms.grade') // Urutkan berdasarkan grade
                                                            ->get(),
                    
                    'byPermission'          => $chartPermission,
                    'byMemorization'        => '', // Todo

                ];
                return response()->json($data);
            }            

        }
        return view('app.staff.dashboard');
    }

    public function homePageParent(Request $request)
    {
        if($request->ajax()){
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://ruhulislam.com/wp-json/wp/v2/posts?per_page=6&_embed',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error retrieving data: '
                ]);
            } else {
                $data = json_decode($response, true);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data retrieved successfully',
                    'blog' => $data
                ]);
            }
        }
        return view('app.parent.dashboard');
    }

    public function homePageStudentActive()
    {
        return view('sample');
    }
    
    public function homePageStudentNew()
    {
        return view('sample');
    }

}
