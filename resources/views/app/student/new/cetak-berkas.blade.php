@extends('_layouts.app-layouts.index')

@if(request()->registration_method == "reguler" || request()->registration_method == 'invited-reguler')
    @php
        $startDate = \Carbon\Carbon::parse(request()->psb_config->buka_tes_reguler);
        $endDate = \Carbon\Carbon::parse(request()->psb_config->tutup_tes_reguler);
        $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
    @endphp
@else
    @php
        $startDate = \Carbon\Carbon::parse(request()->psb_config->buka_tes_undangan);
        $endDate = \Carbon\Carbon::parse(request()->psb_config->tutup_tes_undangan);
        $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
    @endphp
@endif

@php
    $history   = request()->registration_history;
@endphp

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5>Pilih Jadwal Ujian & Minat Jurusan</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-danger" role="alert">
                    <strong>Informasi Penting</strong>
                    <ol class="mt-1">
                        <li>Jadwal yang sudah di pilih <b>tidak dapat di rubah dengan alasan apapun.</b></li>
                        <li>Setelah memilih jadwal maka <b>data diri dan seluruh dokumen anda tidak dapat dirubah, dimodifikasi, atau dihapus.</b></li>
                        <li>Pastikan jadwal yang anda pilih tidak berhalangan dengan aktifitas anda.</li>
                        <li>Tidak ada pengembalian biaya pendaftaran jika anda salah melakukan pengisian data dan pemilihan jadwal.</li>
                        <li>Hubungi panitia jika ditemukan error/kendala dalam pemilihan jadwal</li>
                    </ol>
                </div>
                <div class="m-t-30">
                    @if(empty($history->studentInterviewRoom->exam_date))
                    {{-- Add JS Chech Schedule --}}
                    @push('scripts')
                        <script>
                            $('#exam_date').change(function(){
                                $.ajax({
                                    type: "GET",
                                    url: '{{ route("student.new.get-availability-schedule") }}',
                                    async : true,
                                    data: {
                                        exam_date : $(this).val()
                                    },
                                    dataType : 'json',
                                    beforeSend: function(){
                                        $.LoadingOverlay('show');
                                    },
                                    success: function (data) {
                                        $.LoadingOverlay('hide');
                                        // Will allow user to submit form
                                    }
                                });
                            });
                        </script>
                    @endpush

                    {{-- Form Pilih Jadwal --}}
                    <form action="{{ route('student.new.set-schedule') }}" method="POST" onsubmit="return processDataWithLoading(this);">
                        @csrf
                        <div class="row text-center">
                            <div class="mx-auto col-md-6">
                                <div class="form-group">
                                    <label for="class_focus">Jurusan Plihan</label>
                                    <select name="class_focus" id="class_focus" class="form-control @error('class_focus') is-invalid @enderror" required>
                                        <option value="">--Pilih Jurusan--</option>
                                        <option value="mipa">MIPA - Matematika & Ilmu Pengatahuan Alam</option>
                                        <option value="mak">AGAMA - Ilmu Keagamaan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exam_date">Pilih Tanggal Ujian</label>
                                    <select class="form-control @error('exam_date') is-invalid @enderror" name="exam_date" id="exam_date" required>
                                        <option value="">--Plih Tanggal Ujian--</option>
                                        @foreach ($period as $item)
                                        <option value="{{ $item->format('Y-m-d') }}">{{ dateIndo($item->format('Y-m-d')) }}</option>   
                                        @endforeach
                                    </select>
                                    @error('exam_date')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    <div class="d-block" id="result"></div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" id="verify_exam_date" name="verify_exam_date" type="checkbox" class="@error('exam_date') is-invalid @enderror">
                                        <label for="verify_exam_date">Saya setuju untuk tidak mengajukan permohonan perubahan jadwal ujian di kemudian hari, dan jadwal yang telah saya pilih adalah benar.</label>
                                    </div>
                                    @error('verify_exam_date')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <button class="btn btn-primary btn-sm" type="submit" id="btn-process">Pilih Jadwal</button>
                            </div>
                        </div>
                    </form>
                    @else
                    <div class="alert alert-success" role="alert">
                        <strong>Anda sudah memilih tanggal ujian</strong>
                        <table width="100%" class="m-4">
                            <tbody>
                                <tr>
                                    <td>Nomor Ujian</td>
                                    <td>:</td>
                                    <td><b>{{ request()->registration_history->class_focus == 'mipa' ? "A-" : "G-" }}{{ request()->registration_history->exam_number }}</b></td>
                                </tr>
                                @if(request()->registration_method == "invited")
                                <tr>
                                    <td>Metode Ujian</td>
                                    <td>:</td>
                                    <td><b>{{ request()->registration_history->is_exam_offline ? "Offline / Di Sekolah" : "Zoom / GoogleMeet" }}</b></td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="3">
                                        <hr>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tanggal Ujian Komputer / CAT</td>
                                    <td>:</td>
                                    @if(request()->registration_method == "invited")
                                    <td>Tidak ada ujian Komputer / CAT</td>
                                    @else
                                    <td><b>{{ dateIndo(request()->registration_history->studentCatRoom->exam_date) }}</b></td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Lokasi Ujian Komputer / CAT</td>
                                    <td>:</td>
                                    @if(request()->registration_method == "invited")
                                    <td>Tidak ada ujian Komputer / CAT</td>
                                    @else
                                    <td><b>{{ request()->registration_history->studentCatRoom->room_name }} | {{ request()->registration_history->studentCatRoom->room_session }}</b></td>
                                    @endif
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <hr>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tanggal Ujian Wawancara / Interview</td>
                                    <td>:</td>
                                    <td><b>{{ dateIndo(request()->registration_history->studentInterviewRoom->exam_date) }}</b></td>
                                </tr>
                                <tr>
                                    <td>Lokasi Ujian Wawancara / Interview</td>
                                    <td>:</td>
                                    <td><b>Ruang : {{ request()->registration_history->studentInterviewRoom->room_name }} | Sesi : {{ request()->registration_history->studentInterviewRoom->room_session }}</b></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <hr>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tanggal Wawancara Orang Tua</td>
                                    <td>:</td>
                                    <td><b>{{ dateIndo(request()->registration_history->parentInterviewRoom->exam_date) }}</b></td>
                                </tr>
                                <tr>
                                    <td>Lokasi Wawancara Orang Tua</td>
                                    <td>:</td>
                                    <td><b>Ruang : {{ request()->registration_history->parentInterviewRoom->room_name }} | Sesi : {{ request()->registration_history->parentInterviewRoom->room_session }}</b></td>
                                </tr>
                            </tbody>
                        </table>
                        <center>
                            <form action="{{ route('student.new.handle.cetak-berkas') }}" method="POST" class="d-inline" onsubmit="return processDataWithLoading(this);">
                                @csrf
                                <button class="btn btn-primary btn-sm" type="submit" id="btn-process">
                                    <i class="fas fa-print"></i> Cetak Berkas
                                </button>
                            </form>
                        </center>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection