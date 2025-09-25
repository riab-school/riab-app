@extends('_layouts.app-layouts.index')

@php
    // ambil relasi origin jika ada, aman kalau null
    $origin = auth()->user()->myDetail->studentOriginDetail ?? null;
    $isCompletedOrigin = !empty($origin) && ($origin->is_completed ?? false);
    $disabled = $isCompletedOrigin ? 'disabled' : '';
@endphp

@section('content')
<div class="row">
    <div class="col-md-2">
        @include('app.student.active.data-diri.switcher')
    </div>

    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h5>Data Asal Sekolah</h5>
            </div>

            <div class="card-body">
                @if($isCompletedOrigin)
                    <div class="alert alert-danger" role="alert">
                        Data asal sekolah Anda sudah lengkap, silahkan lanjut ke halaman berikutnya.
                    </div>
                @endif

                <form action="{{ route('student.active.data-diri.store-page-2') }}" method="POST" onsubmit="return processData(this)">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="origin_school">Nama Sekolah Asal</label>
                        <input type="text"
                                class="form-control @error('origin_school') is-invalid @enderror"
                                id="origin_school"
                                name="origin_school"
                                value="{{ old('origin_school', $origin->origin_school ?? '') }}"
                                required {{ $disabled }}>
                        @error('origin_school')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="origin_school_address">Alamat Sekolah Asal</label>
                        <textarea class="form-control @error('origin_school_address') is-invalid @enderror"
                                    id="origin_school_address"
                                    name="origin_school_address"
                                    rows="3"
                                    required {{ $disabled }}>{{ old('origin_school_address', $origin->origin_school_address ?? '') }}</textarea>
                        @error('origin_school_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="mb-3">
                                <label class="form-label" for="origin_school_category">Kategori Sekolah</label>
                                <select class="form-select @error('origin_school_category') is-invalid @enderror"
                                        id="origin_school_category"
                                        name="origin_school_category"
                                        required {{ $disabled }}>
                                    <option value="">-- Pilih --</option>
                                    <option value="negeri" {{ old('origin_school_category', $origin->origin_school_category ?? '') == 'negeri' ? 'selected' : '' }}>Negeri</option>
                                    <option value="swasta" {{ old('origin_school_category', $origin->origin_school_category ?? '') == 'swasta' ? 'selected' : '' }}>Swasta</option>
                                </select>
                                @error('origin_school_category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="origin_school_npsn">NPSN</label>
                            <input type="text"
                                    class="form-control @error('origin_school_npsn') is-invalid @enderror"
                                    id="origin_school_npsn"
                                    name="origin_school_npsn"
                                    value="{{ old('origin_school_npsn', $origin->origin_school_npsn ?? '') }}"
                                    required {{ $disabled }}>
                            @error('origin_school_npsn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="origin_school_graduate">Tahun Lulus</label>
                            <input type="number"
                                    class="form-control @error('origin_school_graduate') is-invalid @enderror"
                                    id="origin_school_graduate"
                                    name="origin_school_graduate"
                                    value="{{ old('origin_school_graduate', $origin->origin_school_graduate ?? '') }}"
                                    required {{ $disabled }}>
                            @error('origin_school_graduate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" {{ $disabled }}>Simpan dan Lanjutkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
