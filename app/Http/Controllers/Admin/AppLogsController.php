<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AppLogsController extends Controller
{
    public function showPageAppLogs(Request $request)
    {
        if ($request->ajax()) {
            $data  = AppLog::with(['user'])->orderBy('created_at', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d-m-Y H:i:s');
                })
                ->make(true);
        }
        return view('app.admin.app-logs.index');
    }

    public function deleteAllLogs(Request $request)
    {
        try {
            AppLog::truncate();
            appLog(auth()->user()->id, 'success', 'Delete all logs');
            return redirect()->back()->with([
                'status'    => 'success',
                'message'   => 'Log berhasil di hapus',
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([
                'status'    => 'error',
                'message'   => 'Log gagal di hapus',
            ]);
        }
    }
}
