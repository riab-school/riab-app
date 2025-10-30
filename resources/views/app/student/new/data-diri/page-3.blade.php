@extends('_layouts.app-layouts.index')

@php
    // ambil relasi origin jika ada, aman kalau null
    $parent = auth()->user()->myDetail->studentParentDetail ?? null;
    $isCompleteParent = !empty($parent) && ($parent->is_completed ?? false);
    $disabled = $isCompleteParent ? 'disabled' : '';
@endphp
@section('content')
@include('app.student.new.data-diri.running-text')
<div class="row">
    <div class="col-md-2">
        @include('app.student.new.data-diri.switcher')
    </div>
    <div class="col-md-10">
        @if(auth()->user()->myDetail && $parent !== NULL && $parent->is_rejected !== NULL && $parent->is_rejected)
        <div class="alert alert-danger" role="alert">
            <strong>Data anda ditolak karena : "{{ $parent->rejection_reason }}"</strong>
        </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h5>Data Orang Tua</h5>
            </div>
            <div class="card-body">
                @if($isCompleteParent)
                    <div class="alert alert-danger" role="alert">
                        Data orang tua Anda sudah diverifikasi, anda dapat melakukan perubahan data dengan menghubungi admin atau panitia.
                    </div>
                @endif
                <form action="{{ route('student.new.data-diri.store-page-3') }}" method="POST" onsubmit="return processData(this)">
                    @if(!$isCompleteParent)
                    @csrf
                    @endif
                    @php
                        $disabled = auth()->user()->myDetail->studentParentDetail &&
                                    auth()->user()->myDetail->studentParentDetail->is_completed
                                    ? 'disabled' : '';
                    @endphp

                    <div class="row">
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="marital_status">Status Perkawinan Orang Tua</label>
                                <select name="marital_status" id="marital_status" class="form-control @error('marital_status') is-invalid @enderror" required {{ $disabled }}>>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="married" {{ old('marital_status', auth()->user()->myDetail->studentParentDetail->marital_status ?? '') == 'married' ? 'selected' : '' }}>Menikah</option>
                                    <option value="divorce" {{ old('marital_status', auth()->user()->myDetail->studentParentDetail->marital_status ?? '') == 'divorce' ? 'selected' : '' }}>Cerai Hidup</option>
                                    <option value="dead-divorce" {{ old('marital_status', auth()->user()->myDetail->studentParentDetail->marital_status ?? '') == 'dead-divorce' ? 'selected' : '' }}>Cerai Mati</option>
                                </select>
                                @error('marital_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Data Ayah --}}
                        <div class="col-md-6">
                            <h6 class="mb-3">Ayah</h6>

                            <div class="mb-3">
                                <label for="dad_name" class="form-label">Nama Ayah</label>
                                <input type="text" class="form-control @error('dad_name') is-invalid @enderror"
                                    id="dad_name" name="dad_name"
                                    value="{{ old('dad_name', optional(auth()->user()->myDetail->studentParentDetail)->dad_name) }}"
                                    {{ $disabled }}>
                                @error('dad_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status_with_dad" class="form-label">Status hubungan ananda dengan ayah</label>
                                <select name="status_with_dad" id="status_with_dad" class="form-control @error('status_with_dad') is-invalid @enderror" {{ $disabled }}>
                                    <option value="">Pilih</option>
                                    <option value="biological" {{ old('status_with_dad', optional(auth()->user()->myDetail->studentParentDetail)->status_with_dad) == 'biological' ? 'selected' : '' }}>Anak Kandung</option>
                                    <option value="step" {{ old('status_with_dad', optional(auth()->user()->myDetail->studentParentDetail)->status_with_dad) == 'step' ? 'selected' : '' }}>Anak Tiri</option>
                                    <option value="adopted" {{ old('status_with_dad', optional(auth()->user()->myDetail->studentParentDetail)->status_with_dad) == 'adopted' ? 'selected' : '' }}>Anak Angkat</option>
                                </select>
                                @error('status_with_dad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="dad_nik_ktp" class="form-label">NIK Ayah</label>
                                <input type="text" class="form-control @error('dad_nik_ktp') is-invalid @enderror"
                                    id="dad_nik_ktp" name="dad_nik_ktp"
                                    value="{{ old('dad_nik_ktp', optional(auth()->user()->myDetail->studentParentDetail)->dad_nik_ktp) }}"
                                    {{ $disabled }}>
                                @error('dad_nik_ktp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="dad_phone" class="form-label">No. HP Ayah</label>
                                <input type="text" class="form-control @error('dad_phone') is-invalid @enderror"
                                    id="dad_phone" name="dad_phone"
                                    value="{{ old('dad_phone', optional(auth()->user()->myDetail->studentParentDetail)->dad_phone) }}"
                                    {{ $disabled }}>
                                @error('dad_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="dad_latest_education" class="form-label">Pendidikan Terakhir</label>
                                <input type="text" class="form-control @error('dad_latest_education') is-invalid @enderror"
                                    id="dad_latest_education" name="dad_latest_education"
                                    value="{{ old('dad_latest_education', optional(auth()->user()->myDetail->studentParentDetail)->dad_latest_education) }}"
                                    {{ $disabled }}>
                                @error('dad_latest_education')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="dad_occupation" class="form-label">Pekerjaan</label>
                                <input type="text" class="form-control @error('dad_occupation') is-invalid @enderror"
                                    id="dad_occupation" name="dad_occupation"
                                    value="{{ old('dad_occupation', optional(auth()->user()->myDetail->studentParentDetail)->dad_occupation) }}"
                                    {{ $disabled }}>
                                @error('dad_occupation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="dad_income" class="form-label">Penghasilan</label>
                                <input type="text" class="form-control @error('dad_income') is-invalid @enderror"
                                    id="dad_income" name="dad_income"
                                    value="{{ old('dad_income', optional(auth()->user()->myDetail->studentParentDetail)->dad_income) }}"
                                    {{ $disabled }}>
                                @error('dad_income')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="dad_is_alive" class="form-label">Status Hidup</label>
                                <select name="dad_is_alive" id="dad_is_alive" class="form-control @error('dad_is_alive') is-invalid @enderror" {{ $disabled }}>
                                    <option value="" 
                                        {{ is_null(optional(auth()->user()->myDetail->studentParentDetail)->dad_is_alive) ? 'selected' : '' }}>
                                        Pilih
                                    </option>
                                    <option value="1" 
                                        {{ old('dad_is_alive', optional(auth()->user()->myDetail->studentParentDetail)->dad_is_alive) === 1 ? 'selected' : '' }}>
                                        Masih Hidup
                                    </option>
                                    <option value="0" 
                                        {{ old('dad_is_alive', optional(auth()->user()->myDetail->studentParentDetail)->dad_is_alive) === 0 ? 'selected' : '' }}>
                                        Meninggal
                                    </option>
                                </select>
                                @error('dad_is_alive')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Country system (kayak page 1) --}}
                            <div class="mb-3">
                                <label for="dad_country" class="form-label">Negara</label>
                                <select id="dad_country" name="dad_country" class="form-control @error('dad_country') is-invalid @enderror" required {{ $disabled }}>
                                    <option value="idn" {{ old('dad_country', optional(auth()->user()->myDetail->studentParentDetail)->dad_country) == 'idn' ? 'selected' : '' }}>Indonesia</option>
                                    <option value="others" {{ old('dad_country', optional(auth()->user()->myDetail->studentParentDetail)->dad_country) == 'others' ? 'selected' : '' }}>Luar Negeri</option>
                                </select>
                                @error('dad_country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="dad_address" class="form-label">Alamat</label>
                                <input type="text" class="form-control @error('dad_address') is-invalid @enderror"
                                    id="dad_address" name="dad_address"
                                    value="{{ old('dad_address', optional(auth()->user()->myDetail->studentParentDetail)->dad_address) }}"
                                    {{ $disabled }}>
                                @error('dad_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Province, City, District, Village, Postal Code (hanya jika Indonesia) --}}
                            <div id="dad_indonesia_fields" style="display: none;">
                                <div class="mb-3">
                                    <label for="dad_province_id" class="form-label">Provinsi</label>
                                    <select id="dad_province_id" name="dad_province_id" class="form-control"
                                        data-selected="{{ old('dad_province_id', optional(auth()->user()->myDetail->studentParentDetail)->dad_province_id) }}" {{ $disabled }}>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="dad_city_id" class="form-label">Kota/Kabupaten</label>
                                    <select id="dad_city_id" name="dad_city_id" class="form-control"
                                        data-selected="{{ old('dad_city_id', optional(auth()->user()->myDetail->studentParentDetail)->dad_city_id) }}" {{ $disabled }}>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="dad_district_id" class="form-label">Kecamatan</label>
                                    <select id="dad_district_id" name="dad_district_id" class="form-control"
                                        data-selected="{{ old('dad_district_id', optional(auth()->user()->myDetail->studentParentDetail)->dad_district_id) }}" {{ $disabled }}>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="dad_village_id" class="form-label">Desa/Kelurahan</label>
                                    <select id="dad_village_id" name="dad_village_id" class="form-control"
                                        data-selected="{{ old('dad_village_id', optional(auth()->user()->myDetail->studentParentDetail)->dad_village_id) }}" {{ $disabled }}>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="dad_postal_code" class="form-label">Kode Pos</label>
                                <input type="text" class="form-control @error('dad_postal_code') is-invalid @enderror"
                                    id="dad_postal_code" name="dad_postal_code"
                                    value="{{ old('dad_postal_code', optional(auth()->user()->myDetail->studentParentDetail)->dad_postal_code) }}"
                                    {{ $disabled }}>
                                @error('dad_postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Data Ibu --}}
                        <div class="col-md-6">
                            <h6 class="mb-3">Ibu</h6>

                            <div class="mb-3">
                                <label for="mom_name" class="form-label">Nama Ibu</label>
                                <input type="text" class="form-control  @error('mom_name') is-invalid @enderror"
                                    id="mom_name" name="mom_name"
                                    value="{{ old('mom_name', optional(auth()->user()->myDetail->studentParentDetail)->mom_name) }}"
                                    {{ $disabled }}>
                                @error('mom_name')
                                    <div class="invalid-feedback">{{ $message }}</div>  
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status_with_mom" class="form-label">Status hubungan ananda dengan Ibu</label>
                                <select name="status_with_mom" id="status_with_mom" class="form-control @error('status_with_mom') is-invalid @enderror" {{ $disabled }}>
                                    <option value="">Pilih</option>
                                    <option value="biological" {{ old('status_with_mom', optional(auth()->user()->myDetail->studentParentDetail)->status_with_mom) == 'biological' ? 'selected' : '' }}>Anak Kandung</option>
                                    <option value="step" {{ old('status_with_mom', optional(auth()->user()->myDetail->studentParentDetail)->status_with_mom) == 'step' ? 'selected' : '' }}>Anak Tiri</option>
                                    <option value="adopted" {{ old('status_with_mom', optional(auth()->user()->myDetail->studentParentDetail)->status_with_mom) == 'adopted' ? 'selected' : '' }}>Anak Angkat</option>
                                </select>
                                @error('status_with_mom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mom_nik_ktp" class="form-label">NIK Ibu</label>
                                <input type="text" class="form-control @error('mom_nik_ktp') is-invalid @enderror"
                                    id="mom_nik_ktp" name="mom_nik_ktp"
                                    value="{{ old('mom_nik_ktp', optional(auth()->user()->myDetail->studentParentDetail)->mom_nik_ktp) }}"
                                    {{ $disabled }}>
                                @error('mom_nik_ktp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mom_phone" class="form-label">No. HP Ibu</label>
                                <input type="text" class="form-control @error('mom_phone') is-invalid @enderror"
                                    id="mom_phone" name="mom_phone"
                                    value="{{ old('mom_phone', optional(auth()->user()->myDetail->studentParentDetail)->mom_phone) }}"
                                    {{ $disabled }}>
                                @error('mom_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mom_latest_education" class="form-label">Pendidikan Terakhir</label>
                                <input type="text" class="form-control @error('mom_latest_education') is-invalid @enderror"
                                    id="mom_latest_education" name="mom_latest_education"
                                    value="{{ old('mom_latest_education', optional(auth()->user()->myDetail->studentParentDetail)->mom_latest_education) }}"
                                    {{ $disabled }}>
                                @error('mom_latest_education')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mom_occupation" class="form-label">Pekerjaan</label>
                                <input type="text" class="form-control @error('mom_occupation') is-invalid @enderror"
                                    id="mom_occupation" name="mom_occupation"
                                    value="{{ old('mom_occupation', optional(auth()->user()->myDetail->studentParentDetail)->mom_occupation) }}"
                                    {{ $disabled }}>
                                @error('mom_occupation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mom_income" class="form-label">Penghasilan</label>
                                <input type="text" class="form-control @error('mom_income') is-invalid @enderror"
                                    id="mom_income" name="mom_income"
                                    value="{{ old('mom_income', optional(auth()->user()->myDetail->studentParentDetail)->mom_income) }}"
                                    {{ $disabled }}>
                                @error('mom_income')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mom_is_alive" class="form-label">Status Hidup</label>
                                <select name="mom_is_alive" id="mom_is_alive" class="form-control @error('mom_is_alive') is-invalid @enderror" {{ $disabled }}>
                                    <option value="" 
                                        {{ is_null(optional(auth()->user()->myDetail->studentParentDetail)->mom_is_alive) ? 'selected' : '' }}>
                                        Pilih
                                    </option>
                                    <option value="1" 
                                        {{ old('mom_is_alive', optional(auth()->user()->myDetail->studentParentDetail)->mom_is_alive) === 1 ? 'selected' : '' }}>
                                        Masih Hidup
                                    </option>
                                    <option value="0" 
                                        {{ old('mom_is_alive', optional(auth()->user()->myDetail->studentParentDetail)->mom_is_alive) === 0 ? 'selected' : '' }}>
                                        Meninggal
                                    </option>
                                </select>
                                @error('mom_is_alive')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Country system (kayak step 1 & ayah) --}}
                            <div class="mb-3">
                                <label for="mom_country" class="form-label">Negara</label>
                                <select id="mom_country" name="mom_country" class="form-control @error('mom_country') is-invalid @enderror" {{ $disabled }}>
                                    <option value="idn" {{ old('mom_country', optional(auth()->user()->myDetail->studentParentDetail)->mom_country) == 'idn' ? 'selected' : '' }}>Indonesia</option>
                                    <option value="others" {{ old('mom_country', optional(auth()->user()->myDetail->studentParentDetail)->mom_country) == 'others' ? 'selected' : '' }}>Luar Negeri</option>
                                </select>
                                @error('mom_country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mom_address" class="form-label">Alamat</label>
                                <input type="text" class="form-control @error('mom_address') is-invalid @enderror"
                                    id="mom_address" name="mom_address"
                                    value="{{ old('mom_address', optional(auth()->user()->myDetail->studentParentDetail)->mom_address) }}"
                                    {{ $disabled }}>
                                @error('mom_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Province, City, District, Village, Postal Code (hanya jika Indonesia) --}}
                            <div id="mom_indonesia_fields" style="display: none;">
                                <div class="mb-3">
                                    <label for="mom_province_id" class="form-label">Provinsi</label>
                                    <select id="mom_province_id" name="mom_province_id" class="form-control"
                                        data-selected="{{ old('mom_province_id', optional(auth()->user()->myDetail->studentParentDetail)->mom_province_id) }}" {{ $disabled }}>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="mom_city_id" class="form-label">Kota/Kabupaten</label>
                                    <select id="mom_city_id" name="mom_city_id" class="form-control"
                                        data-selected="{{ old('mom_city_id', optional(auth()->user()->myDetail->studentParentDetail)->mom_city_id) }}" {{ $disabled }}>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="mom_district_id" class="form-label">Kecamatan</label>
                                    <select id="mom_district_id" name="mom_district_id" class="form-control"
                                        data-selected="{{ old('mom_district_id', optional(auth()->user()->myDetail->studentParentDetail)->mom_district_id) }}" {{ $disabled }}>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="mom_village_id" class="form-label">Desa/Kelurahan</label>
                                    <select id="mom_village_id" name="mom_village_id" class="form-control"
                                        data-selected="{{ old('mom_village_id', optional(auth()->user()->myDetail->studentParentDetail)->mom_village_id) }}" {{ $disabled }}>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="mom_postal_code" class="form-label">Kode Pos</label>
                                <input type="text" class="form-control @error('mom_postal_code') is-invalid @enderror"
                                    id="mom_postal_code" name="mom_postal_code"
                                    value="{{ old('mom_postal_code', optional(auth()->user()->myDetail->studentParentDetail)->mom_postal_code) }}"
                                    {{ $disabled }}>
                                @error('mom_postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
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
            function handleLocation(prefix) {
                let $country   = $(`#${prefix}_country`);
                let $province  = $(`#${prefix}_province_id`);
                let $city      = $(`#${prefix}_city_id`);
                let $district  = $(`#${prefix}_district_id`);
                let $village   = $(`#${prefix}_village_id`);
                let $wrapper   = $(`#${prefix}_indonesia_fields`);

                function loadProvinces(selected = null) {
                    $.ajax({
                        type: "GET",
                        url: '{{ route("api.wilayah.province") }}',
                        dataType: 'json',
                        success: function (data) {
                            let html = '<option value="">Pilih Provinsi</option>';
                            $.each(data, function (i, item) {
                                html += `<option value="${item.id}" ${selected == item.id ? 'selected' : ''}>${item.name}</option>`;
                            });
                            $province.html(html);

                            // kalau ada selected langsung load cities
                            if (selected) {
                                $province.val(selected).trigger('change');
                            }
                        }
                    });
                }

                function loadCities(provinceId, selected = null) {
                    $.ajax({
                        type: "GET",
                        url: '{{ route("api.wilayah.city") }}',
                        data: { province_id: provinceId },
                        dataType: 'json',
                        success: function (data) {
                            let html = '<option value="">Pilih Kota/Kabupaten</option>';
                            $.each(data, function (i, item) {
                                html += `<option value="${item.id}" ${selected == item.id ? 'selected' : ''}>${item.name}</option>`;
                            });
                            $city.html(html);

                            if (selected) {
                                $city.val(selected).trigger('change');
                            }
                        }
                    });
                }

                function loadDistricts(cityId, selected = null) {
                    $.ajax({
                        type: "GET",
                        url: '{{ route("api.wilayah.district") }}',
                        data: { city_id: cityId },
                        dataType: 'json',
                        success: function (data) {
                            let html = '<option value="">Pilih Kecamatan</option>';
                            $.each(data, function (i, item) {
                                html += `<option value="${item.id}" ${selected == item.id ? 'selected' : ''}>${item.name}</option>`;
                            });
                            $district.html(html);

                            if (selected) {
                                $district.val(selected).trigger('change');
                            }
                        }
                    });
                }

                function loadVillages(districtId, selected = null) {
                    $.ajax({
                        type: "GET",
                        url: '{{ route("api.wilayah.village") }}',
                        data: { district_id: districtId },
                        dataType: 'json',
                        success: function (data) {
                            let html = '<option value="">Pilih Desa/Kelurahan</option>';
                            $.each(data, function (i, item) {
                                html += `<option value="${item.id}" ${selected == item.id ? 'selected' : ''}>${item.name}</option>`;
                            });
                            $village.html(html);

                            if (selected) {
                                $village.val(selected);
                            }
                        }
                    });
                }

                // === EVENTS ===
                $country.on('change', function () {
                    if ($(this).val() === 'idn') {
                        $wrapper.show();
                        if ($province.children().length === 0) {
                            loadProvinces($province.data('selected'));
                        }
                    } else {
                        $wrapper.hide();
                        $province.val('');
                        $city.val('');
                        $district.val('');
                        $village.val('');
                    }
                }).trigger('change');

                $province.on('change', function () {
                    let id = $(this).val();
                    if (id) {
                        loadCities(id, $city.data('selected'));
                    } else {
                        $city.html('<option value="">Pilih Kota/Kabupaten</option>');
                        $district.html('<option value="">Pilih Kecamatan</option>');
                        $village.html('<option value="">Pilih Desa/Kelurahan</option>');
                    }
                });

                $city.on('change', function () {
                    let id = $(this).val();
                    if (id) {
                        loadDistricts(id, $district.data('selected'));
                    } else {
                        $district.html('<option value="">Pilih Kecamatan</option>');
                        $village.html('<option value="">Pilih Desa/Kelurahan</option>');
                    }
                });

                $district.on('change', function () {
                    let id = $(this).val();
                    if (id) {
                        loadVillages(id, $village.data('selected'));
                    } else {
                        $village.html('<option value="">Pilih Desa/Kelurahan</option>');
                    }
                });
            }

            // Panggil untuk ayah dan ibu
            handleLocation('dad');
            handleLocation('mom');
        });
    </script>

@endpush
