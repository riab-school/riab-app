<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ClassroomImport;
use App\Imports\DormitoryImport;
use App\Imports\StaffImport;
use App\Imports\StudentImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use File;

class ImportOldDataController extends Controller
{
    public function showImportPage()
    {
        return view('app.admin.import-old.index');
    }

    public function handleImportClassrooms(Request $request)
    {
        $request->validate([
            'file_classroom' => 'required|file|mimes:xlsx,xls,csv',
        ]);
        try {
            $file = $request->file('file_classroom');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/temp'), $fileName);
            $path = 'uploads/temp/'.$fileName;
            $import = Excel::import(new ClassroomImport(), public_path($path));
            File::delete(public_path($path));
            if($import) {
                appLog(auth()->user()->id, 'success', 'Berhasil Import Data Kelas');
                return redirect()->back()->with([
                    'status' => 'success',
                    'message' => 'Data berhasil diimport'
                ]);
            } 
        } catch (\Throwable $th) {
            File::delete(public_path($path));
            appLog(auth()->user()->id, 'error', 'Gagal Import Data Kelas');
            return redirect()->back()->with([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function handleImportDormitories(Request $request)
    {
        $request->validate([
            'file_dormitory' => 'required|file|mimes:xlsx,xls,csv',
        ]);
        try {
            $file = $request->file('file_dormitory');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/temp'), $fileName);
            $path = 'uploads/temp/'.$fileName;
            $import = Excel::import(new DormitoryImport(), public_path($path));
            File::delete(public_path($path));
            if($import) {
                appLog(auth()->user()->id, 'success', 'Berhasil Import Data Asrama');
                return redirect()->back()->with([
                    'status' => 'success',
                    'message' => 'Data berhasil diimport'
                ]);
            } 
        } catch (\Throwable $th) {
            File::delete(public_path($path));
            appLog(auth()->user()->id, 'error', 'Gagal Import Data Asrama');
            return redirect()->back()->with([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function handleImportStaffAccounts(Request $request)
    {
        $request->validate([
            'file_staff' => 'required|file|mimes:xlsx,xls,csv',
        ]);
        try {
            $file = $request->file('file_staff');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/temp'), $fileName);
            $path = 'uploads/temp/'.$fileName;
            $import = Excel::import(new StaffImport(), public_path($path));
            File::delete(public_path($path));
            if($import) {
                appLog(auth()->user()->id, 'success', 'Berhasil Import Akun Staff');
                return redirect()->back()->with([
                    'status' => 'success',
                    'message' => 'Data berhasil diimport'
                ]);
            } 
        } catch (\Throwable $th) {
            File::delete(public_path($path));
            appLog(auth()->user()->id, 'error', 'Gagal Import Akun Staff');
            return redirect()->back()->with([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function handleImportOldStudentAccounts(Request $request)
    {
        $request->validate([
            'file_old_student'  => 'required|file|mimes:xlsx,xls,csv',
            'classroom_id'      => 'required|exists:master_classrooms,id',
            'tahun_ajaran_id'   => 'required|exists:master_tahun_ajarans,id',
        ]);
        try {
            $file = $request->file('file_old_student');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/temp'), $fileName);
            $path = 'uploads/temp/'.$fileName;
            $data = [
                'classroom_id'      => $request->classroom_id,
                'tahun_ajaran_id'   => $request->tahun_ajaran_id,
                'is_active'         => $request->is_active,
            ];
            $import = Excel::import(new StudentImport($data), public_path($path));
            File::delete(public_path($path));
            if($import) {
                appLog(auth()->user()->id, 'success', 'Berhasil Import Akun Siswa Lama');
                return redirect()->back()->with([
                    'status' => 'success',
                    'message' => 'Data berhasil diimport'
                ]);
            } 
        } catch (\Throwable $th) {
            File::delete(public_path($path));
            appLog(auth()->user()->id, 'error', 'Gagal Import Akun Siswa Lama');
            return redirect()->back()->with([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }
}
