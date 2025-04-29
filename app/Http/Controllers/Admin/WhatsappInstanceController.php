<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhatsappChatHistory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WhatsappInstanceController extends Controller
{
    public function showPageWhatsappInstace(Request $request)
    {
        if($request->ajax()) {
            $data  = WhatsappChatHistory::orderBy('created_at', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d-m-Y H:i:s');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d-m-Y H:i:s');
                })
                ->make(true);
        }
        return view('app.admin.whatsapp-instance.index');
    }

    public function deleteAllHistory()
    {
        try {
            WhatsappChatHistory::truncate();
            appLog(auth()->user()->id, 'success', 'Berhasil menghapus semua riwayat whatsapp');
            return redirect()->back()->with([
                'status'    => 'success',
                'message'   => 'Log whatsapp berhasil di hapus',
            ]);
        } catch (\Throwable $th) {
            appLog(auth()->user()->id, 'error', 'Gagal menghapus semua riwayat whatsapp');
            return redirect()->back()->with([
                'status'    => 'error',
                'message'   => 'Log whatsapp gagal di hapus',
            ]);
        }
    }
}
