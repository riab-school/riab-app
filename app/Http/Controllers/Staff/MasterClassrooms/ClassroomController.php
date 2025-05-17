<?php

namespace App\Http\Controllers\Staff\MasterClassrooms;

use App\Http\Controllers\Controller;
use App\Models\MasterClassroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class ClassroomController extends Controller
{
    public function showClassroomList(Request $request)
    {
        if($request->ajax()) {
            $activeYearId = Session::get('tahun_ajaran_aktif_id');
            $data = MasterClassroom::whereRelation('headDetail', 'tahun_ajaran_id', $activeYearId)->whereRelation('headTahfidzDetail', 'tahun_ajaran_id', $activeYearId)
                ->with(['headDetail.userDetail', 'headTahfidzDetail.userDetail'])
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('head_id', function ($row) {
                    return $row->headDetail->userDetail->staffDetail->name;
                })
                ->editColumn('head_tahfidz_id', function ($row) {
                    return $row->headTahfidzDetail->userDetail->staffDetail->name;
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d-m-Y H:i:s');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d-m-Y H:i:s');
                })
                ->make(true);
        }
        return view('app.staff.classroom.list');
    }

    public function showCreatePage()
    {
        return view('app.staff.classroom.create');
    }

    public function handleCreate(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'focus'             => 'required',
            'grade'             => 'required',
            'number'            => 'required|integer',
            'limitation'        => 'required|integer',
            'location'          => 'nullable',
            'head_id'           => 'required|exists:users,id',
            'head_tahfidz_id'   => 'required|exists:users,id',
            'tahun_ajaran_id'   => 'required|exists:master_tahun_ajarans,id',
        ]);

        try {

            // check if the classroom already exists in same tahun_ajaran_id
            $checkClassroom = MasterClassroom::where('name', $request->name)
                ->whereRelation('headDetail', 'tahun_ajaran_id', $request->tahun_ajaran_id)
                ->whereRelation('headTahfidzDetail', 'tahun_ajaran_id', $request->tahun_ajaran_id)
                ->first();
            if ($checkClassroom) {
                return redirect()->back()->with([
                    'status'    => 'error',
                    'message'   => 'Ruang kelas sudah ada pada tahun ajaran ini',
                ]);
            }

            $classroom = MasterClassroom::create([
                'name'              => $request->name,
                'focus'             => $request->focus,
                'grade'             => $request->grade,
                'number'            => $request->number,
                'limitation'        => $request->limitation,
                'location'          => $request->location,
            ]);

            $classroom->headDetail()->create([
                'classroom_id'      => $classroom->id,
                'head_id'           => $request->head_id,
                'tahun_ajaran_id'   => $request->tahun_ajaran_id,
            ]);
            $classroom->headTahfidzDetail()->create([
                'classroom_id'      => $classroom->id,
                'head_tahfidz_id'   => $request->head_tahfidz_id,
                'tahun_ajaran_id'   => $request->tahun_ajaran_id,
            ]);

            appLog(auth()->user()->id, 'success', 'Berhasil menambah kelas baru');
            return redirect()->route('staff.kelas.list')->with([
                'status'    => 'success',
                'message'   => 'Ruang kelas berhasil ditambahkan',
            ]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            appLog(auth()->user()->id, 'error', 'Gagal menambah kelas baru');
            return redirect()->back()->with([
                'status'    => 'error',
                'message'   => 'Ruang kelas gagal ditambahkan',
            ]);
        }
    }
}
