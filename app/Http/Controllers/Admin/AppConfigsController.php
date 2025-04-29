<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSettings;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AppConfigsController extends Controller
{
    public function showPageConfigs(Request $request)
    {
        if ($request->ajax()) {
            $data  = AppSettings::orderBy('created_at', 'DESC')->get();
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
        return view('app.admin.app-configs.index');
    }

    public function detailConfigs(Request $request)
    {
        $find = AppSettings::findOrFail($request->id);
        if($find){
            return view('app.admin.app-configs.detail', $find);
        } else {
            abort(404, 'Data tidak di temukan');
        }
    }

    public function handleUpdateConfigs(Request $request)
    {
        try {
            if($request->hasFile('value')){
                $request->validate([
                    'value' => 'required|file|mimes:png,jpg,jpeg,ico|max:1024'
                ]);
                $file = $request->file('value');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/images'), $fileName);
                AppSettings::where('id', $request->id)->update([
                    'value' => 'uploads/images/'.$fileName,
                ]);
            } else {
                $request->validate([
                    'value' => 'required'
                ]);
                AppSettings::where('id', $request->id)->update([
                    'value' => $request->value,
                ]);
            }
            appLog(auth()->user()->id, 'success', 'Berhasil Update Config');
            return redirect()->route('admin.app-configs')->with([
                'status'    => 'success',
                'message'   => 'Config berhasil di rubah',
            ]);
        } catch (\Throwable $th) {
            appLog(auth()->user()->id, 'error', 'Gagal Update Config');
            return redirect()->back()->with([
                'status'    => 'error',
                'message'   => 'Config gagal di rubah',
            ]);
        }
    }

    public function handleResetDefault(Request $request)
    {
        try {
            $settings = AppSettings::where('id', $request->id)->first();
            if($settings->is_file){
                $file = public_path($settings->value);
                if (file_exists($file)) {
                    unlink($file);
                }
            }
            $settings->update([
                'value' => $settings->default_value,
            ]);
            appLog(auth()->user()->id, 'success', 'Berhasil Update Config ke default');
            return redirect()->route('admin.app-configs')->with([
                'status'    => 'success',
                'message'   => 'Config berhasil di rubah',
            ]);
        } catch (\Throwable $th) {
            appLog(auth()->user()->id, 'error', 'Gagal Update Config ke default');
            return redirect()->back()->with([
                'status'    => 'error',
                'message'   => 'Config gagal di rubah',
            ]);
        }
    }
}
