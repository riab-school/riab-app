@extends('_layouts.app-layouts.index')

@section('content')
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5>Interview</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('staff.master-psb.interview.detail') }}" method="GET" onsubmit="return processData(this)">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="value">Cari Data Peserta Berdasarkan</label>
                            <div class="input-group">
                                <select name="search_by" id="search_by" class="form-control" required>
                                    <option value="">--Pilih--</option>
                                    <option value="exam_number">Nomor Ujian</option>
                                    <option value="registration_number">Kode Registrasi</option>
                                    <option value="nik_ktp">NIK</option>
                                </select>
                                <input type="text" class="form-control @error('value') is-invalid @enderror" id="value" name="value" value="" required>
                                @error('value')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary btn-sm" type="submit" id="btn-process">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection