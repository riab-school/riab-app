@extends('_layouts.app-layouts.index')

@php
    $contact = auth()->user()->myDetail->studentGuardianDetail ?? null;
    $disabled = $contact && $contact->is_completed ? 'disabled' : '';
@endphp
@section('content')
@include('app.student.new.data-diri.running-text')
<div class="row">
    <div class="col-md-2">
        @include('app.student.new.data-diri.switcher')
    </div>
    <div class="col-md-10">
        @if(auth()->user()->myDetail && $contact->is_rejected !== NULL && $contact->is_rejected)
        <div class="alert alert-danger" role="alert">
            <strong>Data anda ditolak karena : "{{ $contact->rejection_reason }}"</strong>
        </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h5>Data Wali</h5>
            </div>
            <div class="card-body">
                    @if($contact && $contact->is_completed)
                    <div class="alert alert-danger" role="alert">
                        Data wali Anda sudah diverifikasi, anda dapat melakukan perubahan data dengan menghubungi admin atau panitia.
                    </div>
                @endif
                <form action="{{ route('student.new.data-diri.store-page-4') }}" method="POST" onsubmit="return processData(this)">
                    @if(!$contact || !$contact->is_completed)
                    @csrf
                    @endif
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" name="name" id="name" 
                            class="form-control @error('name') is-invalid @enderror" 
                            value="{{ old('name', $contact->name ?? '') }}" 
                            required {{ $disabled }}>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">No. HP</label>
                        <input type="text" name="phone" id="phone" 
                            class="form-control @error('phone') is-invalid @enderror" 
                            value="{{ old('phone', $contact->phone ?? '') }}" 
                            required {{ $disabled }}>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="relation_detail" class="form-label">Hubungan dengan Anda</label>
                        <input type="text" name="relation_detail" id="relation_detail" 
                            class="form-control @error('relation_detail') is-invalid @enderror" 
                            value="{{ old('relation_detail', $contact->relation_detail ?? '') }}" 
                            required {{ $disabled }}>
                        @error('relation_detail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="country" class="form-label">Negara</label>
                        <select name="country" id="country" 
                                class="form-control @error('country') is-invalid @enderror" 
                                required {{ $disabled }}>
                            <option value="idn" {{ old('country', $contact->country ?? '') == 'idn' ? 'selected' : '' }}>Indonesia</option>
                            <option value="others" {{ old('country', $contact->country ?? '') == 'others' ? 'selected' : '' }}>Luar Negeri</option>
                        </select>
                        @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <input type="text" name="address" id="address" 
                            class="form-control @error('address') is-invalid @enderror" 
                            value="{{ old('address', $contact->address ?? '') }}" 
                            required {{ $disabled }}>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div id="indonesia_fields" style="display: none;">
                        <div class="mb-3">
                            <label for="province_id" class="form-label @error('province_id') is-invalid @enderror">Provinsi</label>
                            <select name="province_id" id="province_id" class="form-control" data-selected="{{ old('province_id', $contact->province_id ?? '') }}" {{ $disabled }}></select>
                            @error('province_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="city_id" class="form-label @error('city_id') is-invalid @enderror">Kota/Kabupaten</label>
                            <select name="city_id" id="city_id" class="form-control" data-selected="{{ old('city_id', $contact->city_id ?? '') }}" {{ $disabled }}></select>
                            @error('city_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="district_id" class="form-label @error('district_id') is-invalid @enderror">Kecamatan</label>
                            <select name="district_id" id="district_id" class="form-control" data-selected="{{ old('district_id', $contact->district_id ?? '') }}" {{ $disabled }}></select>
                            @error('district_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="village_id" class="form-label @error('village_id') is-invalid @enderror">Desa/Kelurahan</label>
                            <select name="village_id" id="village_id" class="form-control" data-selected="{{ old('village_id', $contact->village_id ?? '') }}" {{ $disabled }}></select>
                            @error('village_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="postal_code" class="form-label @error('postal_code') is-invalid @enderror">Kode Pos</label>
                            <input type="text" name="postal_code" id="postal_code" class="form-control" value="{{ old('postal_code', $contact->postal_code ?? '') }}" {{ $disabled }}>
                            @error('postal_code')
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

@push('scripts')
<script>
$(document).ready(function () {
    function loadLocations() {
        let $country = $('#country');
        let $province = $('#province_id');
        let $city = $('#city_id');
        let $district = $('#district_id');
        let $village = $('#village_id');
        let $wrapper = $('#indonesia_fields');

        function loadProvinces(selected = null) {
            $.get('{{ route("api.wilayah.province") }}', function(data) {
                let html = '<option value="">Pilih Provinsi</option>';
                data.forEach(item => html += `<option value="${item.id}" ${selected == item.id ? 'selected' : ''}>${item.name}</option>`);
                $province.html(html);
                if(selected) $province.val(selected).trigger('change');
            });
        }

        function loadCities(provinceId, selected = null) {
            if(!provinceId) return $city.html('<option value="">Pilih Kota/Kabupaten</option>');
            $.get('{{ route("api.wilayah.city") }}', { province_id: provinceId }, function(data) {
                let html = '<option value="">Pilih Kota/Kabupaten</option>';
                data.forEach(item => html += `<option value="${item.id}" ${selected == item.id ? 'selected' : ''}>${item.name}</option>`);
                $city.html(html);
                if(selected) $city.val(selected).trigger('change');
            });
        }

        function loadDistricts(cityId, selected = null) {
            if(!cityId) return $district.html('<option value="">Pilih Kecamatan</option>');
            $.get('{{ route("api.wilayah.district") }}', { city_id: cityId }, function(data) {
                let html = '<option value="">Pilih Kecamatan</option>';
                data.forEach(item => html += `<option value="${item.id}" ${selected == item.id ? 'selected' : ''}>${item.name}</option>`);
                $district.html(html);
                if(selected) $district.val(selected).trigger('change');
            });
        }

        function loadVillages(districtId, selected = null) {
            if(!districtId) return $village.html('<option value="">Pilih Desa/Kelurahan</option>');
            $.get('{{ route("api.wilayah.village") }}', { district_id: districtId }, function(data) {
                let html = '<option value="">Pilih Desa/Kelurahan</option>';
                data.forEach(item => html += `<option value="${item.id}" ${selected == item.id ? 'selected' : ''}>${item.name}</option>`);
                $village.html(html);
                if(selected) $village.val(selected);
            });
        }

        $country.on('change', function () {
            if($(this).val() === 'idn') {
                $wrapper.show();
                if($province.children().length === 0) loadProvinces($province.data('selected'));
            } else {
                $wrapper.hide();
                $province.val(''); $city.val(''); $district.val(''); $village.val('');
            }
        }).trigger('change');

        $province.on('change', function () { loadCities($(this).val(), $city.data('selected')); });
        $city.on('change', function () { loadDistricts($(this).val(), $district.data('selected')); });
        $district.on('change', function () { loadVillages($(this).val(), $village.data('selected')); });
    }

    loadLocations();
});
</script>
@endpush
