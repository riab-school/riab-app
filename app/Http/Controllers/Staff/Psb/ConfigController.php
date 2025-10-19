<?php

namespace App\Http\Controllers\Staff\Psb;

use App\Http\Controllers\Controller;
use App\Models\MasterTahunAjaran;
use App\Models\PsbConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ConfigController extends Controller
{
    /**
     * Tampilkan daftar semua konfigurasi PSB.
     */
    public function showConfigPage(Request $request)
    {
        $data = [
            'dataConfig' => PsbConfig::orderBy('tahun_ajaran', 'desc')->get(),
        ];
        return view('app.staff.master-psb.config.list', $data);
    }

    /**
     * Halaman tambah konfigurasi baru.
     */
    public function addNewConfigPage()
    {
        return view('app.staff.master-psb.config.add', [
            'tahunAjaran' => MasterTahunAjaran::all(),
        ]);
    }

    /**
     * Halaman edit konfigurasi.
     */
    public function editConfigPage(Request $request)
    {
        if ($request->has('id')) {
            $data = [
                'tahunAjaran' => MasterTahunAjaran::all(),
                'dataConfig'  => PsbConfig::findOrFail($request->id),
            ];
            return view('app.staff.master-psb.config.update', $data);
        }

        abort(404, 'Config tidak ditemukan');
    }

    /**
     * Proses tambah / update konfigurasi PSB.
     */
    public function handleUpdateConfig(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'ketua_panitia' => 'required',
            'tanda_tangan_ketua_panitia' => 'nullable|mimes:png|max:1024',
            'kode_undangan' => 'required',
            'tahun_ajaran' => 'required',
            'no_rekening_psb' => 'required',
            'nama_rekening_psb' => 'required',
            'nama_bank_rekening_psb' => 'required',
            'biaya_psb' => 'required|numeric',
            'target_undangan' => 'required|numeric',
            'target_reguler' => 'required|numeric',
            'nama_cp_1' => 'required',
            'nomor_cp_1' => 'required',
            'nama_cp_2' => 'required',
            'nomor_cp_2' => 'required',
            'nama_cp_3' => 'required',
            'nomor_cp_3' => 'required',
            'buka_daftar_undangan' => 'required|date',
            'tutup_daftar_undangan' => 'required|date',
            'pengumuman_administrasi_undangan' => 'required|date',
            'buka_tes_undangan' => 'required|date',
            'tutup_tes_undangan' => 'required|date',
            'pengumuman_undangan' => 'required|date',
            'buka_daftar_ulang_undangan' => 'required|date',
            'tutup_daftar_ulang_undangan' => 'required|date',
            'buka_daftar_reguler' => 'required|date',
            'tutup_daftar_reguler' => 'required|date',
            'buka_tes_reguler' => 'required|date',
            'tutup_tes_reguler' => 'required|date',
            'pengumuman_reguler' => 'required|date',
            'buka_daftar_ulang_reguler' => 'required|date',
            'tutup_daftar_ulang_reguler' => 'required|date',
            'jumlah_sesi_sehari' => 'required|integer',
            'jumlah_ruang_cat' => 'required|integer',
            'prefix_ruang_cat' => 'required|string',
            'kapasitas_ruang_cat' => 'required|integer',
            'jumlah_ruang_interview' => 'required|integer',
            'prefix_ruang_interview' => 'required|string',
            'kapasitas_ruang_interview' => 'required|integer',
            'jumlah_ruang_interview_orangtua' => 'required|integer',
            'prefix_ruang_interview_orangtua' => 'required|string',
            'kapasitas_ruang_interview_orangtua' => 'required|integer',
            'brosur_link' => 'nullable|mimes:pdf|max:2048',
            'booklet_link' => 'nullable|mimes:pdf|max:2048',
            'popup_psb' => 'nullable|mimes:png,jpg,jpeg|max:1024',
        ]);

        try {
            DB::beginTransaction();

            $tahunAjaran = $request->tahun_ajaran;
            $pathBase = 'psb_config/' . $tahunAjaran . '/';

            // --- Upload Helper ---
            $uploadFile = function ($field, $old = null) use ($request, $pathBase) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $fileName = $field . '-' . time() . '.' . $file->getClientOriginalExtension();
                    $filePath = $pathBase . $fileName;
                    Storage::disk('s3')->put($filePath, file_get_contents($file), 'public');
                    return $filePath;
                }
                return $old;
            };

            // Upload semua file
            $tandaTangan = $uploadFile('tanda_tangan_ketua_panitia', $request->old_tanda_tangan_ketua_panitia);
            $brosurLink  = $uploadFile('brosur_link', $request->old_brosur_link);
            $bookletLink = $uploadFile('booklet_link', $request->old_booklet_link);
            $popupPsb    = $uploadFile('popup_psb', $request->old_popup_psb);

            // Simpan ke Database
            $config = PsbConfig::updateOrCreate(
                ['id' => $request->id ?? null],
                [
                    'tahun_ajaran' => $tahunAjaran,
                    'ketua_panitia' => $request->ketua_panitia,
                    'tanda_tangan_ketua_panitia' => $tandaTangan,
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
                    'buka_tes_reguler' => $request->buka_tes_reguler,
                    'tutup_tes_reguler' => $request->tutup_tes_reguler,
                    'pengumuman_reguler' => $request->pengumuman_reguler,
                    'buka_daftar_ulang_reguler' => $request->buka_daftar_ulang_reguler,
                    'tutup_daftar_ulang_reguler' => $request->tutup_daftar_ulang_reguler,
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
                    'brosur_link' => $brosurLink,
                    'booklet_link' => $bookletLink,
                    'popup_psb' => $popupPsb,
                    'is_active' => $request->boolean('is_active', false),
                ]
            );
            DB::commit();
            appLog(auth()->user()->id, 'success', 'Mengubah konfigurasi PSB tahun ' . $tahunAjaran);
            return redirect()->route('staff.master-psb.config')->with([
                'status' => 'success',
                'message' => 'Konfigurasi PSB tahun ' . $tahunAjaran . ' berhasil disimpan.'
            ]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            DB::rollBack();
            appLog(auth()->user()->id, 'error', 'Gagal update konfigurasi PSB');
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $th->getMessage()
            ]);
        }
    }

    /**
     * Ubah konfigurasi PSB yang aktif.
     */
    public function handleSwitch(Request $request)
    {
        try {
            DB::beginTransaction();

            PsbConfig::where('is_active', true)->update(['is_active' => false]);

            $config = PsbConfig::findOrFail($request->id);
            $config->update(['is_active' => true]);

            userLog(auth()->user()->id, 'update', 'Mengaktifkan konfigurasi PSB tahun ' . $config->tahun_ajaran);

            DB::commit();
            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'Konfigurasi PSB tahun ' . $config->tahun_ajaran . ' sekarang aktif.'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            userLog(auth()->user()->id, 'error', 'Gagal mengubah status konfigurasi PSB');
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Gagal mengaktifkan konfigurasi: ' . $th->getMessage(),
            ]);
        }
    }
}
