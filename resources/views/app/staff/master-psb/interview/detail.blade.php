@extends('_layouts.app-layouts.index')

@section('content')
<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5>Soal Interview</h5>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <h4>Nama : <b class="text-primary">{{ $detail->name }}</b></h4>
                            <h4>NIK : <b class="text-primary">{{ $detail->nik_ktp }}</b></h4>
                            <h4>No Ujian : <b class="text-primary">{{ $psbData->exam_number }}</b></h4>
                        </div>
                        <div class="col-6">
                            <h4>Asal Sekolah : <b class="text-primary">{{ $detail->studentOriginDetail->origin_school }}</b></h4>
                            <h4>Asal Daerah : <b class="text-primary">{{ getProvince($detail->province_id) }}, {{ getCity($detail->city_id) }}</b></h4>
                            <h4>NISN : <b class="text-primary">{{ $detail->nisn }}</b></h4>
                        </div>
                    </div>
                    <hr>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active text-uppercase" id="home-tab" data-bs-toggle="tab"
                                href="#home" role="tab" aria-controls="home" aria-selected="true">Interview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase" id="profile-tab" data-bs-toggle="tab"
                                href="#profile" role="tab" aria-controls="profile"
                                aria-selected="false">Baca Alquran</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase" id="contact-tab" data-bs-toggle="tab"
                                href="#contact" role="tab" aria-controls="contact"
                                aria-selected="false">Ibadah</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase" id="wali-tab" data-bs-toggle="tab"
                                href="#wali" role="tab" aria-controls="wali"
                                aria-selected="false">Interview Wali</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    @if(!empty($detail->studentInterview))
                                    <div class="alert alert-danger">
                                        <h4>Siswa sudah pernah di interview, perhatikan kembali jika ingin merubah data.</h4>
                                    </div>
                                    <hr>
                                    @endif
                                    <form action="{{ route('staff.master-psb.interview.store-1') }}" method="POST" onsubmit="return processData(this)">
                                        @csrf
                                        <input type="hidden" name="user_id" id="user_id" value="{{ $detail->user_id }}" required> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Prestasi Akademik</label>
                                                            <textarea type="text" name="prestasi_akademik" id="prestasi_akademik" class="form-control" required>{{ $detail->studentInterview ? $detail->studentInterview->prestasi_akademik : '' }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Prestasi NON-Akademik</label>
                                                            <textarea type="text" name="prestasi_non_akademik" id="prestasi_non_akademik" class="form-control" required>{{ $detail->studentInterview ? $detail->studentInterview->prestasi_non_akademik : '' }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 ">
    
                                                        <p>Di Biodata :</p>
                                                        <ol>
                                                            @foreach ($detail->studentAchievementHistory as $item)
                                                                <li>{{ $item->detail }}</li>
                                                            @endforeach
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Kemampuan Bahasa Inggris</label>
                                                    <select class="form-control" name="bahasa_inggris" id="bahasa_inggris" required>
                                                        <option value="">Pilih</option>
                                                        <option value="SANGAT BAIK" {{ $detail->studentInterview ? ($detail->studentInterview->bahasa_inggris == 'SANGAT BAIK' ? 'selected': '') : '' }}>SANGAT BAIK</option>
                                                        <option value="BAIK" {{ $detail->studentInterview ? ($detail->studentInterview->bahasa_inggris == 'BAIK' ? 'selected': '') : '' }}>BAIK</option>
                                                        <option value="CUKUP" {{ $detail->studentInterview ? ($detail->studentInterview->bahasa_inggris == 'CUKUP' ? 'selected': '') : '' }}>CUKUP</option>
                                                        <option value="KURANG" {{ $detail->studentInterview ? ($detail->studentInterview->bahasa_inggris == 'KURANG' ? 'selected': '') : '' }}>KURANG</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Kemampuan Bahasa Arab</label>
                                                    <select class="form-control" name="bahasa_arab" id="bahasa_arab" required>
                                                        <option value="">Pilih</option>
                                                        <option value="SANGAT BAIK" {{ $detail->studentInterview ? ($detail->studentInterview->bahasa_arab == 'SANGAT BAIK' ? 'selected': '') : '' }}>SANGAT BAIK</option>
                                                        <option value="BAIK" {{ $detail->studentInterview ? ($detail->studentInterview->bahasa_arab == 'BAIK' ? 'selected': '') : '' }}>BAIK</option>
                                                        <option value="CUKUP" {{ $detail->studentInterview ? ($detail->studentInterview->bahasa_arab == 'CUKUP' ? 'selected': '') : '' }}>CUKUP</option>
                                                        <option value="KURANG" {{ $detail->studentInterview ? ($detail->studentInterview->bahasa_arab == 'KURANG' ? 'selected': '') : '' }}>KURANG</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Info Masuk RIAB</label>
                                                    <textarea type="text" name="info_masuk" id="info_masuk" class="form-control" required>{{ $detail->studentInterview ? $detail->studentInterview->info_masuk : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Alasan Masuk RIAB</label>
                                                    <textarea type="text" name="alasan_masuk" id="alasan_masuk" class="form-control" required>{{ $detail->studentInterview ? $detail->studentInterview->alasan_masuk : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Riwayat Penyakit</label>
                                                    <textarea type="text" name="riwayat_penyakit" id="riwayat_penyakit" class="form-control" required>{{ $detail->studentInterview ? $detail->studentInterview->riwayat_penyakit : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Pernah Merokok ?</label>
                                                    <select class="form-control" name="merokok" id="merokok" required>
                                                        <option value="">Pilih</option>
                                                        <option value="PERNAH" {{ $detail->studentInterview ? ($detail->studentInterview->merokok == 'PERNAH' ? 'selected': '') : '' }}>PERNAH</option>
                                                        <option value="TIDAK PERNAH" {{ $detail->studentInterview ? ($detail->studentInterview->merokok == 'TIDAK PERNAH' ? 'selected': '') : '' }}>TIDAK PERNAH</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Pernah Pacaran ?</label>
                                                    <select class="form-control" name="pacaran" id="pacaran" required>
                                                        <option value="">Pilih</option>
                                                        <option value="PERNAH" {{ $detail->studentInterview ? ($detail->studentInterview->pacaran == 'PERNAH' ? 'selected': '') : '' }}>PERNAH</option>
                                                        <option value="TIDAK PERNAH" {{ $detail->studentInterview ? ($detail->studentInterview->pacaran == 'TIDAK PERNAH' ? 'selected': '') : '' }}>TIDAK PERNAH</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Penggunaan HP</label>
                                                    <textarea type="text" name="penggunaan_hp" id="penggunaan_hp" class="form-control" required>{{ $detail->studentInterview ? $detail->studentInterview->penggunaan_hp : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Pelanggaran</label>
                                                    <textarea type="text" name="pelanggaran" id="pelanggaran" class="form-control" required>{{ $detail->studentInterview ? $detail->studentInterview->pelanggaran : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Guru Yang Tidak disukai</label>
                                                    <textarea type="text" name="guru_tidak_suka" id="guru_tidak_suka" class="form-control" required>{{ $detail->studentInterview ? $detail->studentInterview->guru_tidak_suka : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Pelajaran yang disukai</label>
                                                    <textarea type="text" name="pelajaran_suka" id="pelajaran_suka" class="form-control" required>{{ $detail->studentInterview ? $detail->studentInterview->pelajaran_suka : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Pelajaran yang Tidak disukai</label>
                                                    <textarea type="text" name="pelajaran_tidak_suka" id="pelajaran_tidak_suka" class="form-control" required>{{ $detail->studentInterview ? $detail->studentInterview->pelajaran_tidak_suka : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Cita Cita</label>
                                                    <br>
                                                    <div class="alert alert-warning">
                                                        <span>Di Biodata : <br>
                                                            <b>{{ $detail->ambition }}</b>
                                                        </span>
                                                    </div>
                                                    <textarea type="text" name="cita_cita" id="cita_cita" class="form-control" required>{{ $detail->studentInterview ? $detail->studentInterview->cita_cita : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Alasan Memilih Jurusan : </label>
                                                    <br>
                                                    <div class="alert alert-warning">
                                                        <span>Di Biodata : <br>
                                                            <b>{{ strtoupper($psbData->class_focus) }}</b>
                                                        </span>
                                                    </div>
                                                    <textarea type="text" name="alasan_memilih_jurusan" id="alasan_memilih_jurusan" class="form-control" required>{{ $detail->studentInterview ? $detail->studentInterview->alasan_memilih_jurusan : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Bagaimana Hubungan Dengan Orang Tua : </label>
                                                    <textarea type="text" name="hubungan_ortu" id="hubungan_ortu" class="form-control" required>{{ $detail->studentInterview ? $detail->studentInterview->hubungan_ortu : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Rekomendasi Interview</label>
                                                    <select class="form-control" name="rekomendasi_interview" id="rekomendasi_interview" required>
                                                        <option value="">Pilih</option>
                                                        <option value="REKOM SEKALI" {{ $detail->studentInterview ? ($detail->studentInterview->rekomendasi_interview == 'REKOM SEKALI' ? 'selected': '') : '' }}>REKOM SEKALI</option>
                                                        <option value="REKOM" {{ $detail->studentInterview ? ($detail->studentInterview->rekomendasi_interview == 'REKOM' ? 'selected': '') : '' }}>REKOM</option>
                                                        <option value="KURANG REKOM" {{ $detail->studentInterview ? ($detail->studentInterview->rekomendasi_interview == 'KURANG REKOM' ? 'selected': '') : '' }}>KURANG REKOM</option>
                                                        <option value="TIDAK REKOM" {{ $detail->studentInterview ? ($detail->studentInterview->rekomendasi_interview == 'TIDAK REKOM' ? 'selected': '') : '' }}>TIDAK REKOM</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Keterangan Interview</label>
                                                    <textarea class="form-control" name="keterangan_interview" id="keterangan_interview" required>{{ $detail->studentInterview ? $detail->studentInterview->keterangan_interview : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Point / Nilai (Minimal 1 & Maksimal 10)</label>
                                                    <input type="number" name="point" id="point" class="form-control" placeholder="Isikan hanya angka dari 0 s/d 10" min="1" max="10" value="{{ $detail->studentInterview ? $detail->studentInterview->point : '' }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" id="btn-process" class="btn btn-primary">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    @if(!empty($detail->studentBacaan))
                                    <div class="alert alert-danger">
                                        <h4>Siswa sudah pernah di interview, perhatikan kembali jika ingin merubah data.</h4>
                                    </div>
                                    <hr>
                                    @endif
                                    <form action="{{ route('staff.master-psb.interview.store-2') }}" method="post" onsubmit="return processData(this)">
                                        @csrf
                                        <input type="hidden" name="user_id" id="user_id" value="{{ $detail->user_id }}" required> 
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                <label>Khatak Jali</label>
                                                <input type="number" name="khatak_jali" id="khatak_jali" class="form-control" placeholder="Isikan hanya angka dari 0 s/d 50" min="0" max="50" value="{{ $detail->studentBacaan ? $detail->studentBacaan->khatak_jali : '' }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                <label>Khatak Kafi</label>
                                                <input type="number" name="khatak_kafi" id="khatak_kafi" class="form-control" placeholder="Isikan hanya angka dari 0 s/d 50" min="0" max="50" value="{{ $detail->studentBacaan ? $detail->studentBacaan->khatak_kafi : '' }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                <label>Total Skor</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="total_skor" id="total_skor" value="{{ $detail->studentBacaan ? $detail->studentBacaan->total_skor : '' }}" readonly>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Point</span>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                <label>Jumlah Hafalan</label>
                                                <input type="number" name="jumlah_hafalan" id="jumlah_hafalan" min="0" max="30" placeholder="Isikan hanya angka dari 0 s/d 30" class="form-control" value="{{ $detail->studentBacaan ? $detail->studentBacaan->jumlah_hafalan : '' }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                <label>Kualitas Hafalan</label>
                                                <select class="form-control" name="kualitas_hafalan" id="kualitas_hafalan" required>
                                                    <option value="">Pilih</option>
                                                    <option value="SANGAT BAIK" {{ $detail->studentBacaan ? ($detail->studentBacaan->kualitas_hafalan == 'SANGAT BAIK' ? 'selected': '') : '' }}>SANGAT BAIK</option>
                                                    <option value="BAIK" {{ $detail->studentBacaan ? ($detail->studentBacaan->kualitas_hafalan == 'BAIK' ? 'selected': '') : '' }}>BAIK</option>
                                                    <option value="CUKUP" {{ $detail->studentBacaan ? ($detail->studentBacaan->kualitas_hafalan == 'CUKUP' ? 'selected': '') : '' }}>CUKUP</option>
                                                    <option value="KURANG" {{ $detail->studentBacaan ? ($detail->studentBacaan->kualitas_hafalan == 'KURANG' ? 'selected': '') : '' }}>KURANG</option>
                                                </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                <label>Rekomendasi Hafalan</label>
                                                <select class="form-control" name="rekomendasi_hafalan" id="rekomendasi_hafalan" required>
                                                    <option value="">Pilih</option>
                                                    <option value="REKOM SEKALI" {{ $detail->studentBacaan ? ($detail->studentBacaan->rekomendasi_hafalan == 'REKOM SEKALI' ? 'selected': '') : '' }}>REKOM SEKALI</option>
                                                    <option value="REKOM" {{ $detail->studentBacaan ? ($detail->studentBacaan->rekomendasi_hafalan == 'REKOM' ? 'selected': '') : '' }}>REKOM</option>
                                                    <option value="KURANG REKOM" {{ $detail->studentBacaan ? ($detail->studentBacaan->rekomendasi_hafalan == 'KURANG REKOM' ? 'selected': '') : '' }}>KURANG REKOM</option>
                                                    <option value="TIDAK REKOM" {{ $detail->studentBacaan ? ($detail->studentBacaan->rekomendasi_hafalan == 'TIDAK REKOM' ? 'selected': '') : '' }}>TIDAK REKOM</option>
                                                </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                <label>Rekomendasi Bacaan</label>
                                                <select class="form-control" name="rekomendasi_bacaan" id="rekomendasi_bacaan" required>
                                                    <option value="">Pilih</option>
                                                    <option value="REKOM SEKALI" {{ $detail->studentBacaan ? ($detail->studentBacaan->rekomendasi_bacaan == 'REKOM SEKALI' ? 'selected': '') : '' }}>REKOM SEKALI</option>
                                                    <option value="REKOM" {{ $detail->studentBacaan ? ($detail->studentBacaan->rekomendasi_bacaan == 'REKOM' ? 'selected': '') : '' }}>REKOM</option>
                                                    <option value="KURANG REKOM" {{ $detail->studentBacaan ? ($detail->studentBacaan->rekomendasi_bacaan == 'KURANG REKOM' ? 'selected': '') : '' }}>KURANG REKOM</option>
                                                    <option value="TIDAK REKOM" {{ $detail->studentBacaan ? ($detail->studentBacaan->rekomendasi_bacaan == 'TIDAK REKOM' ? 'selected': '') : '' }}>TIDAK REKOM</option>
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <label>Keterangan Hafalan</label>
                                                <textarea class="form-control" name="keterangan_hafalan" id="keterangan_hafalan" rows="4" required>{{ $detail->studentBacaan ? $detail->studentBacaan->keterangan_hafalan : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                <label>Point Bacaan / Nilai (Minimal 1 & Maksimal 10)</label>
                                                <input type="number" name="point" id="point" class="form-control" placeholder="Isikan hanya angka dari 0 s/d 10" min="1" max="10" value="{{ $detail->studentBacaan ? $detail->studentBacaan->point : '' }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                <label>Point Hafalan / Nilai (Minimal 1 & Maksimal 10)</label>
                                                <input type="number" name="point_hafalan" id="point_hafalan" class="form-control" placeholder="Isikan hanya angka dari 0 s/d 10" min="1" max="10" value="{{ $detail->studentBacaan ? $detail->studentBacaan->point_hafalan : '' }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" id="btn-process" class="btn btn-primary">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    @if(!empty($detail->studentIbadah))
                                    <div class="alert alert-danger">
                                        <h4>Siswa sudah pernah di interview, perhatikan kembali jika ingin merubah data.</h4>
                                    </div>
                                    <hr>
                                    @endif
                                    <form action="{{ route('staff.master-psb.interview.store-3') }}" method="post" onsubmit="return processData(this)">
                                        @csrf
                                        <input type="hidden" name="user_id" id="user_id" value="{{ $detail->user_id }}" required> 
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Bacaan Sholat</label>
                                                    <select class="form-control" name="bacaan_sholat" id="bacaan_sholat" required>
                                                        <option value="">Pilih</option>
                                                        <option value="SANGAT BAIK" {{ $detail->studentIbadah ? ($detail->studentIbadah->bacaan_sholat == 'SANGAT BAIK' ? 'selected': '') : '' }}>SANGAT BAIK</option>
                                                        <option value="BAIK" {{ $detail->studentIbadah ? ($detail->studentIbadah->bacaan_sholat == 'BAIK' ? 'selected': '') : '' }}>BAIK</option>
                                                        <option value="CUKUP" {{ $detail->studentIbadah ? ($detail->studentIbadah->bacaan_sholat == 'CUKUP' ? 'selected': '') : '' }}>CUKUP</option>
                                                        <option value="KURANG" {{ $detail->studentIbadah ? ($detail->studentIbadah->bacaan_sholat == 'KURANG' ? 'selected': '') : '' }}>KURANG</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Doa Sehari Hari</label>
                                                    <select class="form-control" name="doa_sehari_hari" id="doa_sehari_hari" required>
                                                        <option value="">Pilih</option>
                                                        <option value="SANGAT BAIK" {{ $detail->studentIbadah ? ($detail->studentIbadah->doa_sehari_hari == 'SANGAT BAIK' ? 'selected': '') : '' }}>SANGAT BAIK</option>
                                                        <option value="BAIK" {{ $detail->studentIbadah ? ($detail->studentIbadah->doa_sehari_hari == 'BAIK' ? 'selected': '') : '' }}>BAIK</option>
                                                        <option value="CUKUP" {{ $detail->studentIbadah ? ($detail->studentIbadah->doa_sehari_hari == 'CUKUP' ? 'selected': '') : '' }}>CUKUP</option>
                                                        <option value="KURANG" {{ $detail->studentIbadah ? ($detail->studentIbadah->doa_sehari_hari == 'KURANG' ? 'selected': '') : '' }}>KURANG</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Sholat Jenazah</label>
                                                    <select class="form-control" name="sholat_jenazah" id="sholat_jenazah" required>
                                                        <option value="">Pilih</option>
                                                        <option value="SANGAT BAIK" {{ $detail->studentIbadah ? ($detail->studentIbadah->sholat_jenazah == 'SANGAT BAIK' ? 'selected': '') : '' }}>SANGAT BAIK</option>
                                                        <option value="BAIK" {{ $detail->studentIbadah ? ($detail->studentIbadah->sholat_jenazah == 'BAIK' ? 'selected': '') : '' }}>BAIK</option>
                                                        <option value="CUKUP" {{ $detail->studentIbadah ? ($detail->studentIbadah->sholat_jenazah == 'CUKUP' ? 'selected': '') : '' }}>CUKUP</option>
                                                        <option value="KURANG" {{ $detail->studentIbadah ? ($detail->studentIbadah->sholat_jenazah == 'KURANG' ? 'selected': '') : '' }}>KURANG</option>
                                                    </select>
                                                </div>  
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Niat Niat</label>
                                                    <select class="form-control" name="niat_niat" id="niat_niat" required>
                                                        <option value="">Pilih</option>
                                                        <option value="SANGAT BAIK" {{ $detail->studentIbadah ? ($detail->studentIbadah->niat_niat == 'SANGAT BAIK' ? 'selected': '') : '' }}>SANGAT BAIK</option>
                                                        <option value="BAIK" {{ $detail->studentIbadah ? ($detail->studentIbadah->niat_niat == 'BAIK' ? 'selected': '') : '' }}>BAIK</option>
                                                        <option value="CUKUP" {{ $detail->studentIbadah ? ($detail->studentIbadah->niat_niat == 'CUKUP' ? 'selected': '') : '' }}>CUKUP</option>
                                                        <option value="KURANG" {{ $detail->studentIbadah ? ($detail->studentIbadah->niat_niat == 'KURANG' ? 'selected': '') : '' }}>KURANG</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Qiraatul Kutub</label>
                                                    <select class="form-control" name="qiraatul_kutub" id="qiraatul_kutub" required>
                                                        <option value="">Pilih</option>
                                                        <option value="SANGAT BAIK" {{ $detail->studentIbadah ? ($detail->studentIbadah->qiraatul_kutub == 'SANGAT BAIK' ? 'selected': '') : '' }}>SANGAT BAIK</option>
                                                        <option value="BAIK" {{ $detail->studentIbadah ? ($detail->studentIbadah->qiraatul_kutub == 'BAIK' ? 'selected': '') : '' }}>BAIK</option>
                                                        <option value="CUKUP" {{ $detail->studentIbadah ? ($detail->studentIbadah->qiraatul_kutub == 'CUKUP' ? 'selected': '') : '' }}>CUKUP</option>
                                                        <option value="KURANG" {{ $detail->studentIbadah ? ($detail->studentIbadah->qiraatul_kutub == 'KURANG' ? 'selected': '') : '' }}>KURANG</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Rekomendasi Ibadah</label>
                                                    <select class="form-control" name="rekomendasi_ibadah" id="rekomendasi_ibadah" required>
                                                        <option value="">Pilih</option>
                                                        <option value="REKOM SEKALI" {{ $detail->studentIbadah ? ($detail->studentIbadah->rekomendasi_ibadah == 'REKOM SEKALI' ? 'selected': '') : '' }}>REKOM SEKALI</option>
                                                        <option value="REKOM" {{ $detail->studentIbadah ? ($detail->studentIbadah->rekomendasi_ibadah == 'REKOM' ? 'selected': '') : '' }}>REKOM</option>
                                                        <option value="KURANG REKOM" {{ $detail->studentIbadah ? ($detail->studentIbadah->rekomendasi_ibadah == 'KURANG REKOM' ? 'selected': '') : '' }}>KURANG REKOM</option>
                                                        <option value="TIDAK REKOM" {{ $detail->studentIbadah ? ($detail->studentIbadah->rekomendasi_ibadah == 'TIDAK REKOM' ? 'selected': '') : '' }}>TIDAK REKOM</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <label>Keterangan Ibadah</label>
                                                <textarea class="form-control" name="keterangan_ibadah" id="keterangan_ibadah" rows="4" required>{{ $detail->studentIbadah ? $detail->studentIbadah->keterangan_ibadah : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <label>Point / Nilai (Minimal 1 & Maksimal 10)</label>
                                                <input type="number" name="point" id="point" class="form-control" placeholder="Isikan hanya angka dari 0 s/d 10" min="1" max="10" value="{{ $detail->studentIbadah ? $detail->studentIbadah->point : '' }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" id="btn-process" class="btn btn-primary">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="wali" role="tabpanel" aria-labelledby="wali-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    @if(!empty($detail->studentParentInterview))
                                    <div class="alert alert-danger">
                                        <h4>Siswa sudah pernah di interview, perhatikan kembali jika ingin merubah data.</h4>
                                    </div>
                                    <hr>
                                    @endif
                                    <form action="{{ route('staff.master-psb.interview.store-4') }}" method="post" onsubmit="return processData(this)">
                                        @csrf
                                        <input type="hidden" name="user_id" id="user_id" value="{{ $detail->user_id }}" required> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>1. Nama Santri</label>
                                                    <textarea class="form-control" name="q1" id="q1" rows="2" required>{{ $detail->studentParentInterview ? $detail->studentParentInterview->q1 : $detail->name }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>2. Nama Bapak / Ibu</label>
                                                    <textarea class="form-control" name="q2" id="q2" rows="2" required>{{ $detail->studentParentInterview ? $detail->studentParentInterview->q2 : $detail->studentParentDetail->dad_name." & ".$detail->studentParentDetail->mom_name }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>3. Pekerjaan Bapak / Ibu</label>
                                                    <textarea class="form-control" name="q3" id="q3" rows="2" required>{{ $detail->studentParentInterview ? $detail->studentParentInterview->q3 : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>4. Hubungan dengan calon santri</label>
                                                    <textarea class="form-control" name="q4" id="q4" rows="2" required>{{ $detail->studentParentInterview ? $detail->studentParentInterview->q4 : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>5. Alamat Domisili</label>
                                                    <textarea class="form-control" name="q5" id="q5" rows="2" required>{{ $detail->studentParentInterview ? $detail->studentParentInterview->q5 : $detail->address.", Desa ".getVillage($detail->village_id).", Kecamatan ".getDistrict($detail->district_id).", Kab ".getCity($detail->city_id).". Prov ".getProvince($detail->province_id) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>6. Wali terdekat (jika domisili di luar Banda Aceh dan Aceh Besar)</label>
                                                    <textarea class="form-control" name="q6" id="q6" rows="2" required>{{ $detail->studentParentInterview ? $detail->studentParentInterview->q6 : $detail->studentGuardianDetail->name }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>7. Jika ananda lulus, apakah Bapak/Ibu siap membayar biaya SPP dan biaya konsumsi setiap awal bulan tepat waktu?</label>
                                                    <textarea class="form-control" name="q7" id="q7" rows="2" required>{{ $detail->studentParentInterview ? $detail->studentParentInterview->q7 : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>8. Menurut Bapak/Ibu, apa solusi terbaik jika ada wali santri yang tidak membayar SPP tepat waktu bahkan menunggak hingga beberapa bulan?</label>
                                                    <textarea class="form-control" name="q8" id="q8" rows="2" required>{{ $detail->studentParentInterview ? $detail->studentParentInterview->q8 : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>9. Bagaimana hubungan Bapak/Ibu dengan pasangan selama ini?</label>
                                                    <textarea class="form-control" name="q9" id="q9" rows="2" required>{{ $detail->studentParentInterview ? $detail->studentParentInterview->q9 : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>10. Siapa yang akan membiayai pendidikan ananda selama belajar di dayah (jika orang tua berpisah)?</label>
                                                    <textarea class="form-control" name="q10" id="q10" rows="2" required>{{ $detail->studentParentInterview ? $detail->studentParentInterview->q10 : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>11. Siapkah Bapak/Ibu menerima konsekuensi jika ananda melanggar aturan yang telah ditetapkan oleh dayah? Seperti:</label>
                                                    <div class="alert alert-warning mb-2">
                                                        <ol>
                                                            <li>Di awal pembelajaran, tidak ada kunjungan, tidak boleh keluar dayah atau dijemput pada 2 bulan pertama</li>
                                                            <li>Jika membawa HP, konsekuensinya HP akan dihancurkan</li>
                                                            <li>Jika cabut, merokok, berpacaran, maka akan diskorsing</li>
                                                            <li>Jika kedapatan mencuri, maka akan dikeluarkan</li>
                                                        </ol>
                                                    </div>
                                                    <textarea class="form-control" name="q11" id="q11" rows="2" required>{{ $detail->studentParentInterview ? $detail->studentParentInterview->q11 : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>12. Bagaimana pandangan Bapak/Ibu mengenai hukuman: rotan, push-up, squat jump, cukur rambut atau dimandikan jika melakukan kesalahan?</label>
                                                    <textarea class="form-control" name="q12" id="q12" rows="2" required>{{ $detail->studentParentInterview ? $detail->studentParentInterview->q12 : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>13. Apakah jurusan yang dipilih oleh ananda sudah sesuai dengan harapan ananda juga Bapak/Ibu? Jika sudah sesuai, tidak ada pemindahan jurusan lagi setelah pengumuman kelulusan.</label>
                                                    <textarea class="form-control" name="q13" id="q13" rows="2" required>{{ $detail->studentParentInterview ? $detail->studentParentInterview->q13 : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>14. Sakit apa yang paling sering dialami oleh ananda selama ini? Bagaimana penanganan awal?</label>
                                                    <textarea class="form-control" name="q14" id="q14" rows="2" required>{{ $detail->studentParentInterview ? $detail->studentParentInterview->q14 : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Keterangan</label>
                                                    <textarea class="form-control" name="q15" id="q15" rows="4" required>{{ $detail->studentParentInterview ? $detail->studentParentInterview->q15 : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Rekomendasi ?</label>
                                                    <select class="form-control" name="q16" id="q16" required>
                                                        <option value="">Pilih</option>
                                                        <option value="REKOM SEKALI" {{ $detail->studentParentInterview ? ($detail->studentParentInterview->q16 == 'REKOM SEKALI' ? 'selected': '') : '' }}>REKOM SEKALI</option>
                                                        <option value="REKOM" {{ $detail->studentParentInterview ? ($detail->studentParentInterview->q16 == 'REKOM' ? 'selected': '') : '' }}>REKOM</option>
                                                        <option value="KURANG REKOM" {{ $detail->studentParentInterview ? ($detail->studentParentInterview->q16 == 'KURANG REKOM' ? 'selected': '') : '' }}>KURANG REKOM</option>
                                                        <option value="TIDAK REKOM" {{ $detail->studentParentInterview ? ($detail->studentParentInterview->q16 == 'TIDAK REKOM' ? 'selected': '') : '' }}>TIDAK REKOM</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" id="btn-process" class="btn btn-primary">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            counters();
            $('#khatak_jali').change(function() {
                counters();
            });
            $('#khatak_kafi').change(function() {
                counters();
            });

        });
        function counters()
        {
            var total = 50;
            var k_jali = $('#khatak_jali').val() * 3;
            var k_kafi = $('#khatak_kafi').val();
            
            var hasil = total - (parseInt(k_jali) + parseInt(k_kafi));
            $('#total_skor').val(hasil);
        }
    </script>
@endpush