<?php

namespace App\Http\Controllers\Staff\Psb;

use App\Http\Controllers\Controller;
use App\Models\MasterTahunAjaran;
use App\Models\PsbConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigController extends Controller
{
    public function showConfigPage(Request $request)
    {
        $data = [
            'dataConfig' => PsbConfig::all(),
        ];
        return view('app.staff.master-psb.config.list', $data);
    }

    public function addNewConfigPage()
    {
        $data = [
            'tahunAjaran'   => MasterTahunAjaran::all(),
        ];
        return view('app.staff.master-psb.config.add', $data);
    }

    public function editConfigPage(Request $request)
    {
        if($request->has('id')){
            $data = [
                'tahunAjaran'   => MasterTahunAjaran::all(),
                'dataConfig' => PsbConfig::findOrFail($request->id),
            ];
            return view('app.staff.master-psb.config.update', $data);
        }
    }

    public function handleUpdateConfig(Request $request)
    {   
        $request->validate([
            'ketua_panitia' => 'required',
            'tanda_tangan_ketua_panitia' => 'required',
            'kode_undangan' => 'required',
            'tahun_ajaran' => 'required',
            'no_rekening_psb' => 'required',
            'nama_rekening_psb' => 'required',
            'nama_bank_rekening_psb' => 'required',
            'biaya_psb' => 'required',
            'target_undangan' => 'required',
            'target_reguler' => 'required',
            'nama_cp_1' => 'required',
            'nomor_cp_1' => 'required',
            'nama_cp_2' => 'required',
            'nomor_cp_2' => 'required',
            'nama_cp_3' => 'required',
            'nomor_cp_3' => 'required',
            'buka_daftar_undangan' => 'required',
            'tutup_daftar_undangan' => 'required',
            'pengumuman_administrasi_undangan' => 'required',
            'buka_tes_undangan' => 'required',
            'tutup_tes_undangan' => 'required',
            'pengumuman_undangan' => 'required',
            'buka_daftar_ulang_undangan' => 'required',
            'tutup_daftar_ulang_undangan' => 'required',
            'buka_daftar_reguler' => 'required',
            'tutup_daftar_reguler' => 'required',
            'buka_cetak_berkas' => 'required',
            'tutup_cetak_berkas' => 'required',
            'buka_tes_reguler' => 'required',
            'tutup_tes_reguler' => 'required',
            'pengumuman_reguler' => 'required',
            'buka_daftar_ulang_reguler' => 'required',
            'tutup_daftar_ulang_reguler' => 'required',
            'jumlah_sesi_sehari' => 'required',
            'jumlah_ruang_cat' => 'required',
            'prefix_ruang_cat' => 'required',
            'kapasitas_ruang_cat' => 'required',
            'jumlah_ruang_interview' => 'required',
            'prefix_ruang_interview' => 'required',
            'kapasitas_ruang_interview' => 'required',
            'jumlah_ruang_interview_orangtua' => 'required',
            'prefix_ruang_interview_orangtua' => 'required',
            'kapasitas_ruang_interview_orangtua' => 'required',
            'brosur_link' => 'required',
            'booklet_link' => 'required',
            'popup_psb' => 'required',
        ]);

        try {
            DB::beginTransaction();
            PsbConfig::updateOrCreate([
                'id'    => $request->id ?? null
            ],
            [
                'tahun_ajaran' => $request->tahun_ajaran,
                'ketua_panitia' => $request->ketua_panitia,
                'tanda_tangan_ketua_panitia' => $request->tanda_tangan_ketua_panitia,
                'kode_undangan' => $request->kode_undangan,
                'no_rekening_psb' => $request->no_rekening_psb,
                'nama_rekening_psb' => $request->nama_rekening_psb,
                'nama_bank_rekening_psb' => $request->nama_bank_rekening_psb,
                'biaya_psb' => $request->biaya_psb,
                'target_undangan' => $request->target_undangan,
                'target_reguler' => $request->target_reguler,
                'nama_cp_1' => $request->nama_cp_1,
                'nomor_cp_1' => $request->nomor_cp_1,
                'nama_cp_2' => $request->nama_cp_2,
                'nomor_cp_2' => $request->nomor_cp_2,
                'nama_cp_3' => $request->nama_cp_3,
                'nomor_cp_3' => $request->nomor_cp_3,
                'buka_daftar_undangan' => $request->buka_daftar_undangan,
                'tutup_daftar_undangan' => $request->tutup_daftar_undangan,
                'pengumuman_administrasi_undangan' => $request->pengumuman_administrasi_undangan,
                'buka_tes_undangan' => $request->buka_tes_undangan,
                'tutup_tes_undangan' => $request->tutup_tes_undangan,
                'pengumuman_undangan' => $request->pengumuman_undangan,
                'buka_daftar_ulang_undangan' => $request->buka_daftar_ulang_undangan,
                'tutup_daftar_ulang_undangan' => $request->tutup_daftar_ulang_undangan,
                'buka_daftar_reguler' => $request->buka_daftar_reguler,
                'tutup_daftar_reguler' => $request->tutup_daftar_reguler,
                'bunga_daftar_reguler' => $request->bunga_daftar_reguler,
                'buka_cetak_berkas' => $request->buka_cetak_berkas,
                'tutup_cetak_berkas' => $request->tutup_cetak_berkas,
                'buka_tes_reguler' => $request->buka_tes_reguler,
                'tutup_tes_reguler' => $request->tutup_tes_reguler,
                'pengumuman_reguler' => $request->pengumuman_reguler,
                'buka_daftar_ulang_reguler' => $request->buka_daftar_ulang_reguler,
                'tutup_daftar_ulang_reguler' => $request->tutup_daftar_ulang_reguler,
                'bunga_daftar_ulang_reguler' => $request->bunga_daftar_ulang_reguler,
                'jumlah_sesi_sehari' => $request->jumlah_sesi_sehari,
                'jumlah_ruang_cat' => $request->jumlah_ruang_cat,
                'prefix_ruang_cat' => $request->prefix_ruang_cat,
                'kapasitas_ruang_cat' => $request->kapasitas_ruang_cat,
                'jumlah_ruang_interview' => $request->jumlah_ruang_interview,
                'prefix_ruang_interview' => $request->prefix_ruang_interview,
                'kapasitas_ruang_interview' => $request->kapasitas_ruang_interview,
                'jumlah_ruang_interview_orangtua' => $request->jumlah_ruang_interview_orangtua,
                'prefix_ruang_interview_orangtua' => $request->prefix_ruang_interview_orangtua,
                'kapasitas_ruang_interview_orangtua' => $request->kapasitas_ruang_interview_orangtua,
                'brosur_link' => $request->brosur_link,
                'booklet_link' => $request->booklet_link,
                'popup_psb' => $request->popup_psb,
            ]);
            DB::commit();
            return redirect()->route('staff.master-psb.config')->with([
                'status' => 'success',
                'message' => 'Berhasil menambahkan data konfigurasi PSB'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }
}
