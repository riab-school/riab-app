@extends('_layouts.app-layouts.index')

@section('content')
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5>Filter Laporan</h5>
            </div>
            <form action="{{ route('staff.pelanggaran.laporan.handle') }}" method="POST" onsubmit="processData(this);">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama">Filter Data</label>
                        <select class="form-control" id="report_by" name="report_by" required>
                            <option value="">Silahkan Pilih</option>
                            <option value="date">Berdasarkan Tanggal</option>
                            <option value="nis_nisn">Berdasarkan NIS / NISN</option>
                        </select>
                    </div>
                    <div class="d-none" id="by_date">
                        <div class="form-group">
                            <label for="from_date">Tanggal Awal</label>
                            <input type="date" class="form-control @error('from_date') is-invalid @enderror" id="from_date" name="from_date">
                            @error('from_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="to_date">Tanggal Akhir</label>
                            <input type="date" class="form-control @error('to_date') is-invalid @enderror" id="to_date" name="to_date">
                            @error('to_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-none" id="by_nis_nisn">
                        <div class="form-group">
                            <label for="id_siswa">NIS / NISN</label>
                            <input type="text" class="form-control @error('id_siswa') is-invalid @enderror" id="id_siswa" name="id_siswa">
                            @error('id_siswa')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="from_date2">Tanggal Awal <span class="text-danger">(Optional)</span></label>
                            <input type="date" class="form-control @error('from_date2') is-invalid @enderror" id="from_date2" name="from_date2">
                            @error('from_date2')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="to_date2">Tanggal Akhir <span class="text-danger">(Optional)</span></label>
                            <input type="date" class="form-control @error('to_date2') is-invalid @enderror" id="to_date2" name="to_date2">
                            @error('to_date2')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Tampilkan</button>
                    <button class="btn btn-secondary" type="reset">Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#report_by').change(function() {
                if ($(this).val() == 'date') {
                    $('#by_date').removeClass('d-none');
                    $('#by_nis_nisn').addClass('d-none');
                } else if ($(this).val() == 'nis_nisn') {
                    $('#by_date').addClass('d-none');
                    $('#by_nis_nisn').removeClass('d-none');
                } else {
                    $('#by_date').addClass('d-none');
                    $('#by_nis_nisn').addClass('d-none');
                }
            });
        });
    </script>
@endpush