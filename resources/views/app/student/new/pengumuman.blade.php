@extends('_layouts.app-layouts.index')

@php
    $tglSekarang = date('Y-m-d');
    $history = request()->registration_history;
@endphp

@section('content')
<div class="row justify-content-center">

    @if(request()->registration_method == 'invited')
        {{-- ===================== --}}
        {{-- PENGUMUMAN VERIFIKASI BERKAS (JALUR UNDANGAN) --}}
        {{-- ===================== --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Pengumuman Verifikasi Berkas</h5>
                </div>
                <div class="card-body text-center">

                    @php
                        $tglPengumumanAdm = request()->psb_config->pengumuman_administrasi_undangan;
                    @endphp

                    @if($tglPengumumanAdm <= $tglSekarang)
                        {{-- Sudah waktunya diumumkan --}}
                        @if(!$history->is_administration_confirmed || $history->is_administration_confirmed === null)
                            <span class="text-info fs-4">
                                Berkas anda belum diverifikasi oleh panitia
                            </span>
                        @elseif($history->is_administration_confirmed && $history->is_administration_pass)
                            <div class="text-success">
                                <div class="fs-4">Selamat!!</div>
                                <div class="fs-5">
                                    Anda dinyatakan Lulus Verifikasi Berkas, silahkan melanjutkan ke tahap cetak kartu ujian dan memilih jadwal ujian dan cetak berkas
                                </div>
                                <a href="{{ route('student.new.cetak-berkas') }}" class="btn btn-primary btn-sm mt-2">Cetak Berkas dan Kartu</a>
                            </div>
                            <hr>
                            <p>Silahkan bergabung ke grup whatsapp khusus peserta yang lulus</p>
                            <a href="https://chat.whatsapp.com/EDyFzjJKya67hlFQdsoqoV?mode=wwt" target="_blank" class="btn btn-success btn-sm mt-2">
                                <i class="fab fa-whatsapp"></i> Gabung Grup WhatsApp
                            </a>
                        @elseif($history->is_administration_confirmed && !$history->is_administration_pass)
                            <div class="text-danger">
                                <div class="fs-4">Mohon Maaf!!</div>
                                <div class="fs-5">Anda dinyatakan Tidak Lulus Seleksi Berkas Prestasi, silahkan pindah jalur pendaftaran menjadi Reguler</div>
                                <form action="{{ route('student.new.announcement.pindah-reguler') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm mt-2">Pindah Ke Reguler</button>
                                </form>
                            </div>
                        @else
                            <div class="text-warning fs-4">
                                Proses verifikasi berkas sedang berlangsung, silahkan menunggu informasi selanjutnya
                            </div>
                        @endif
                    @else
                        {{-- Belum waktunya diumumkan --}}
                        <div class="text-warning fs-4">
                            Proses verifikasi berkas sedang berlangsung, silahkan menunggu informasi selanjutnya
                        </div>
                    @endif

                </div>
            </div>
        </div>


        {{-- ===================== --}}
        {{-- PENGUMUMAN KELULUSAN JALUR UNDANGAN --}}
        {{-- ===================== --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Pengumuman Kelulusan Jalur Undangan</h5>
                </div>
                <div class="card-body text-center">
                    @php
                        $tglPengumumanUndangan = request()->psb_config->pengumuman_undangan;
                    @endphp

                    @if($tglPengumumanUndangan > $tglSekarang)
                        <div class="text-warning fs-4">
                            Pengumuman kelulusan jalur undangan akan diumumkan pada <br>
                            {{ dateIndo($tglPengumumanUndangan) }}
                        </div>
                    @else
                        @if($history->is_exam_pass === null)
                            <div class="text-danger fs-4">
                                Mohon tunggu, hasil ujian belum diumumkan.
                            </div>
                        @elseif(!$history->is_exam_pass)
                        <div class="text-danger fs-4">
                            Mohon maaf, Anda dinyatakan tidak lulus jalur undangan.
                            <p>Silahkan pindah ke jalur reguler, jika anda masih berminat untuk melanjutkan pendaftaran</p>
                            <a href="#" class="btn btn-primary btn-sm mt-2">Pindah Ke Reguler</a>
                        </div>
                        @else
                        {{-- tampilkan hasil kelulusan di sini --}}
                        <div class="text-success fs-4">
                            Selamat! Anda dinyatakan lulus jalur undangan.
                            <p>Silahkan melakukan pendaftaran ulang untuk melanjutkan ke tahap berikutnya.</p>
                            <a href="{{ route('student.new.daftar-ulang.upload-bukti') }}" class="btn btn-primary btn-sm mt-2">Daftar Ulang</a>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    @endif

    {{-- ===================== --}}
    {{-- PENGUMUMAN KELULUSAN JALUR REGULER --}}
    {{-- ===================== --}}
    @if(in_array(request()->registration_method, ['reguler', 'invited-reguler']))
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Pengumuman Kelulusan Jalur Reguler</h5>
                </div>
                <div class="card-body text-center">
                    @php
                        $tglPengumumanReguler = request()->psb_config->pengumuman_reguler;
                    @endphp

                    @if($tglPengumumanReguler > $tglSekarang)
                        <div class="text-warning fs-4">
                            Pengumuman kelulusan jalur reguler akan diumumkan pada <br>
                            {{ dateIndo($tglPengumumanReguler) }}
                        </div>
                    @else
                        @if($history->is_exam_pass === null)
                            <div class="text-danger fs-4">
                                Mohon tunggu, hasil ujian belum diumumkan.
                            </div>
                        @elseif(!$history->is_exam_pass)
                        <div class="text-danger fs-4">
                            Mohon maaf, Anda dinyatakan tidak lulus jalur reguler.
                            <p>Jangan khawatir data pribadi anda akan kami hapus 30 hari sejak pengumuman ini di umumkan.</p>
                        </div>
                        @else
                        {{-- tampilkan hasil kelulusan di sini --}}
                        <div class="text-success fs-4">
                            Selamat! Anda dinyatakan lulus jalur reguler.
                            <p>Silahkan melakukan pendaftaran ulang untuk melanjutkan ke tahap berikutnya.</p>
                            <a href="{{ route('student.new.daftar-ulang.upload-bukti') }}" class="btn btn-primary btn-sm mt-2">Daftar Ulang</a>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    @endif

</div>
@endsection
