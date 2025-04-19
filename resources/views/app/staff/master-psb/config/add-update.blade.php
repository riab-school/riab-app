@extends('_layouts.app-layouts.index')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Psb Config</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('staff.master-psb.add-config.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <p class="lead">A. Informasi Umum</p>
                    <div class="form-group">
                        <label for="tahun_ajaran">Tahun Ajaran</label>
                        <select name="tahun_ajaran" id="tahun_ajaran" class="form-control" required>
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            @foreach ($tahunAjaran as $item)
                            <option value="{{ $item->tahun_ajaran }}">{{ $item->tahun_ajaran }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ketua_panitia">Ketua Panitia</label>
                        <input type="text" class="form-control" name="ketua_panitia" id="ketua_panitia" required>
                    </div>
                    <div class="form-group">
                        <label for="tanda_tangan_ketua_panitia">Tanda Tangan Ketua Panitia</label>
                        <input type="file" class="form-control" name="tanda_tangan_ketua_panitia" id="tanda_tangan_ketua_panitia" required>
                    </div>
                    <div class="form-group">
                        <label for="brosur_link">File Brosur</label>
                        <input type="file" class="form-control" name="brosur_link" id="brosur_link" required>
                    </div>
                    <div class="form-group">
                        <label for="booklet_link">File Booklet</label>
                        <input type="file" class="form-control" name="booklet_link" id="booklet_link" required>
                    </div>
                    <div class="form-group">
                        <label for="popup_psb">File Iklan / Popup</label>
                        <input type="file" class="form-control" name="popup_psb" id="popup_psb" required>
                    </div>
                    <hr>
                    <p class="lead">B. Informasi Biaya Dan Rekening</p>
                    <div class="form-group">
                        <label for="no_rekening_psb">Nomor Rekening PSB</label>
                        <input type="text" class="form-control" name="no_rekening_psb" id="no_rekening_psb" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_rekening_psb">Nama Rekening PSB</label>
                        <input type="text" class="form-control" name="nama_rekening_psb" id="nama_rekening_psb" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_bank_rekening_psb">Nama Bank Rekening PSB</label>
                        <select name="nama_bank_rekening_psb" id="nama_bank_rekening_psb" class="form-control" required>
                            <option value="">-- Pilih Bank --</option>
                            <option value="Bank BSI">Bank BSI</option>
                            <option value="Bank Aceh Syariah">Bank Aceh Syariah</option>
                            <option value="Bank Bukopin">Bank Bukopin</option>
                            <option value="Bank Danamon">Bank Danamon</option>
                            <option value="Bank Mandiri">Bank Mandiri</option>
                            <option value="Bank BRI">Bank BRI</option>
                            <option value="Bank BNI">Bank BNI</option>
                            <option value="Bank BCA">Bank BCA</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="biaya_psb">Biaya PSB</label>
                        <input type="number" class="form-control" name="biaya_psb" id="biaya_psb" required>
                    </div>
                    <hr>
                    <p class="lead">C. Informasi Contact Person</p>
                    <div class="form-group">
                        <label for="nama_cp_1">Nama Contact Person 1</label>
                        <input type="text" class="form-control" name="nama_cp_1" id="nama_cp_1" required>
                    </div>
                    <div class="form-group">
                        <label for="nomor_cp_1">Nomor Contact Person 1</label>
                        <input type="text" class="form-control" name="nomor_cp_1" id="nomor_cp_1" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_cp_2">Nama Contact Person 2</label>
                        <input type="text" class="form-control" name="nama_cp_2" id="nama_cp_2" required>
                    </div>
                    <div class="form-group">
                        <label for="nomor_cp_2">Nomor Contact Person 2</label>
                        <input type="text" class="form-control" name="nomor_cp_2" id="nomor_cp_2" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_cp_3">Nama Contact Person 3</label>
                        <input type="text" class="form-control" name="nama_cp_3" id="nama_cp_3" required>
                    </div>
                    <div class="form-group">
                        <label for="nomor_cp_3">Nomor Contact Person 3</label>
                        <input type="text" class="form-control" name="nomor_cp_3" id="nomor_cp_3" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <p class="lead">D. Konfigurasi Undangan</p>
                    <div class="form-group">
                        <label for="kode_undangan">Kode Undangan</label>
                        <input type="text" class="form-control" name="kode_undangan" id="kode_undangan" required>
                    </div>
                    <div class="form-group">
                        <label for="target_undangan">Target Undangan</label>
                        <input type="text" class="form-control" name="target_undangan" id="target_undangan" required>
                    </div>
                    <div class="form-group">
                        <label for="buka_daftar_undangan">Buka Pendaftaran Undangan</label>
                        <input type="date" class="form-control" name="buka_daftar_undangan" id="buka_daftar_undangan" required>
                    </div>
                    <div class="form-group">
                        <label for="tutup_daftar_undangan">Tutup Pendaftaran Undangan</label>
                        <input type="date" class="form-control" name="tutup_daftar_undangan" id="tutup_daftar_undangan" required>
                    </div>
                    <div class="form-group">
                        <label for="pengumuman_administrasi_undangan">Pengumuman Seleksi ADM Undangan</label>
                        <input type="date" class="form-control" name="pengumuman_administrasi_undangan" id="pengumuman_administrasi_undangan" required>
                    </div>
                    <div class="form-group">
                        <label for="buka_tes_undangan">Buka Tes Undangan</label>
                        <input type="date" class="form-control" name="buka_tes_undangan" id="buka_tes_undangan" required>
                    </div>
                    <div class="form-group">
                        <label for="tutup_tes_undangan">Tutup Tes Undangan</label>
                        <input type="date" class="form-control" name="tutup_tes_undangan" id="tutup_tes_undangan" required>
                    </div>
                    <div class="form-group">
                        <label for="pengumuman_undangan">Pengumuman Kelulusan Undangan</label>
                        <input type="date" class="form-control" name="pengumuman_undangan" id="pengumuman_undangan" required>
                    </div>
                    <div class="form-group">
                        <label for="buka_daftar_ulang_undangan">Buka Daftar Ulang Undangan</label>
                        <input type="date" class="form-control" name="buka_daftar_ulang_undangan" id="buka_daftar_ulang_undangan" required>
                    </div>
                    <div class="form-group">
                        <label for="tutup_daftar_ulang_undangan">Tutup Daftar Ulang Undangan</label>
                        <input type="date" class="form-control" name="tutup_daftar_ulang_undangan" id="tutup_daftar_ulang_undangan" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <p class="lead">E. Konfigurasi Reguler</p>
                    <div class="form-group">
                        <label for="target_reguler">Target Reguler</label>
                        <input type="text" class="form-control" name="target_reguler" id="target_reguler" required>
                    </div>
                    <div class="form-group">
                        <label for="buka_daftar_reguler">Buka Pendaftaran Reguler</label>
                        <input type="date" class="form-control" name="buka_daftar_reguler" id="buka_daftar_reguler" required>
                    </div>
                    <div class="form-group">
                        <label for="tutup_daftar_reguler">Tutup Pendaftaran Reguler</label>
                        <input type="date" class="form-control" name="tutup_daftar_reguler" id="tutup_daftar_reguler" required>
                    </div>
                    <div class="form-group">
                        <label for="buka_cetak_berkas">Buka Cetak Berkas Reguler</label>
                        <input type="date" class="form-control" name="buka_cetak_berkas" id="buka_cetak_berkas" required>
                    </div>
                    <div class="form-group">
                        <label for="tutup_cetak_berkas">Tutup Cetak Berkas Reguler</label>
                        <input type="date" class="form-control" name="tutup_cetak_berkas" id="tutup_cetak_berkas" required>
                    </div>
                    <div class="form-group">
                        <label for="buka_tes_reguler">Buka Tes Reguler</label>
                        <input type="date" class="form-control" name="buka_tes_reguler" id="buka_tes_reguler" required>
                    </div>
                    <div class="form-group">
                        <label for="tutup_tes_reguler">Tutup Tes Reguler</label>
                        <input type="date" class="form-control" name="tutup_tes_reguler" id="tutup_tes_reguler" required>
                    </div>
                    <div class="form-group">
                        <label for="pengumuman_reguler">Pengumuman Kelulusan Reguler</label>
                        <input type="date" class="form-control" name="pengumuman_reguler" id="pengumuman_reguler" required>
                    </div>
                    <div class="form-group">
                        <label for="buka_daftar_ulang_reguler">Buka Daftar Ulang Reguler</label>
                        <input type="date" class="form-control" name="buka_daftar_ulang_reguler" id="buka_daftar_ulang_reguler" required>
                    </div>
                    <div class="form-group">
                        <label for="tutup_daftar_ulang_reguler">Tutup Daftar Ulang Reguler</label>
                        <input type="date" class="form-control" name="tutup_daftar_ulang_reguler" id="tutup_daftar_ulang_reguler" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <p class="lead">F. Konfigurasi Ruangan</p>
                    <div class="form-group">
                        <label for="jumlah_sesi_sehari">Jumlah Sesi dalam Sehari</label>
                        <input type="number" class="form-control" name="jumlah_sesi_sehari" id="jumlah_sesi_sehari" required>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_ruang_cat">Jumlah Ruangan CAT</label>
                        <input type="number" class="form-control" name="jumlah_ruang_cat" id="jumlah_ruang_cat" required>
                    </div>
                    <div class="form-group">
                        <label for="prefix_ruang_cat">Prefix Ruangan CAT</label>
                        <input type="text" class="form-control" name="prefix_ruang_cat" id="prefix_ruang_cat" required>
                    </div>
                    <div class="form-group">
                        <label for="kapasitas_ruang_cat">Kapasitas Peserta Per Ruangan CAT</label>
                        <input type="number" class="form-control" name="kapasitas_ruang_cat" id="kapasitas_ruang_cat" required>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_ruang_interview">Jumlah Ruangan Interview</label>
                        <input type="number" class="form-control" name="jumlah_ruang_interview" id="jumlah_ruang_interview" required>
                    </div>
                    <div class="form-group">
                        <label for="prefix_ruang_interview">Prefix Ruangan Interview</label>
                        <input type="text" class="form-control" name="prefix_ruang_interview" id="prefix_ruang_interview" required>
                    </div>
                    <div class="form-group">
                        <label for="kapasitas_ruang_interview">Kapasitas Peserta Per Ruangan Interview</label>
                        <input type="number" class="form-control" name="kapasitas_ruang_interview" id="kapasitas_ruang_interview" required>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_ruang_interview_orangtua">Jumlah Ruangan Interview Wali</label>
                        <input type="number" class="form-control" name="jumlah_ruang_interview_orangtua" id="jumlah_ruang_interview_orangtua" required>
                    </div>
                    <div class="form-group">
                        <label for="prefix_ruang_interview_orangtua">Prefix Ruangan Interview Wali</label>
                        <input type="text" class="form-control" name="prefix_ruang_interview_orangtua" id="prefix_ruang_interview_orangtua" required>
                    </div>
                    <div class="form-group">
                        <label for="kapasitas_ruang_interview_orangtua">Kapasitas Peserta Per Ruangan Interview Wali</label>
                        <input type="number" class="form-control" name="kapasitas_ruang_interview_orangtua" id="kapasitas_ruang_interview_orangtua" required>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection