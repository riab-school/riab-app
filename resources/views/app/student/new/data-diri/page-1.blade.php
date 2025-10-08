@extends('_layouts.app-layouts.index')
@php
    $disabled = auth()->user()->myDetail->is_completed ?? false ? 'disabled' : '';
    $country = old('country', auth()->user()->myDetail->country ?? 'idn');
@endphp
@section('content')
@include('app.student.new.data-diri.running-text')
<div class="row">
    <div class="col-md-2">
        @include('app.student.new.data-diri.switcher')
    </div>
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h5>Data Siswa</h5>
            </div>
            <div class="card-body">
                @if(auth()->user()->myDetail->is_completed) 
                <div class="alert alert-danger" role="alert">
                    Data diri anda sudah diverifikasi, anda dapat melakukan perubahan data dengan menghubungi admin atau panitia.
                </div>
                @endif
                <form action="{{ route('student.new.data-diri.store-page-1') }}" method="POST" onsubmit="return processData(this)">
                    @if(!auth()->user()->myDetail->is_completed)
                    @csrf
                    @endif
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label" for="name">Your Photo</label>
                            <div class="border border-dark rounded mb-2">
                                <img id="img_output"
                                src="{{ auth()->user()->myDetail->studentDocument && auth()->user()->myDetail->studentDocument->photo
                                        ? Storage::disk('s3')->url(auth()->user()->myDetail->studentDocument->photo)
                                        : asset('assets/images/blank_person.jpg') }}"
                                class="w-100 img-fit" alt="User-Profile-Image" loading="lazy">
                            </div>
                            <span class="text-muted small"><i>Anda dapat mengupload pas photo anda pada laman upload berkas</i></span>
                        </div>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <label class="form-label" for="name">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ auth()->user()->myDetail->name }}" required {{ $disabled }}>
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="nik_ktp">NIK KTP</label>
                                        <input type="text" class="form-control @error('nik_ktp') is-invalid @enderror"
                                            id="nik_ktp" name="nik_ktp"
                                            value="{{ old('nik_ktp', auth()->user()->myDetail->nik_ktp ?? '') }}" required {{ $disabled }}>
                                        @error('nik_ktp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="nik_kk">NIK KK</label>
                                        <input type="text" class="form-control @error('nik_kk') is-invalid @enderror"
                                            id="nik_kk" name="nik_kk"
                                            value="{{ old('nik_kk', auth()->user()->myDetail->nik_kk ?? '') }}" required {{ $disabled }}>
                                        @error('nik_kk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                    <label class="form-label" for="nisn">NISN</label>
                                    <input type="text" class="form-control @error('nisn') is-invalid @enderror"
                                        id="nisn" name="nisn"
                                        value="{{ old('nisn', auth()->user()->myDetail->nisn ?? '') }}" required {{ $disabled }}>
                                    @error('nisn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="akte_number">Nomor Akte Kelahiran</label>
                                <input type="text" class="form-control @error('akte_number') is-invalid @enderror"
                                    id="akte_number" name="akte_number"
                                    value="{{ old('akte_number', auth()->user()->myDetail->akte_number ?? '') }}" required {{ $disabled }}>
                                @error('akte_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="mb-3">
                                        <label class="form-label" for="place_of_birth">Tempat Lahir</label>
                                        <input type="text" class="form-control @error('place_of_birth') is-invalid @enderror"
                                            id="place_of_birth" name="place_of_birth"
                                            value="{{ old('place_of_birth', auth()->user()->myDetail->place_of_birth ?? '') }}" required {{ $disabled }}>
                                        @error('place_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label class="form-label" for="date_of_birth">Tanggal Lahir</label>
                                        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                                            id="date_of_birth" name="date_of_birth"
                                            value="{{ old('date_of_birth', auth()->user()->myDetail->date_of_birth ?? '') }}" required {{ $disabled }}>
                                        @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="gender">Jenis Kelamin</label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required {{ $disabled }}>
                                    <option value="">-- Pilih --</option>
                                    <option value="male" {{ old('gender', auth()->user()->myDetail->gender ?? '') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ old('gender', auth()->user()->myDetail->gender ?? '') == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="phone">No HP</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone"
                                    value="{{ old('phone', auth()->user()->myDetail->phone ?? '') }}" required {{ $disabled }}>
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label" for="country">Negara</label>
                                <select class="form-select @error('country') is-invalid @enderror"
                                        id="country" name="country" {{ $disabled }}>
                                    <option value="idn" {{ $country == 'idn' ? 'selected' : '' }}>Indonesia</option>
                                    <option value="others" {{ $country == 'others' ? 'selected' : '' }}>Luar Negeri</option>
                                </select>
                                @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <label class="form-label" for="address">Alamat</label>
                                <textarea class="form-control @error('address') is-invalid @enderror"
                                        id="address" name="address" rows="2" {{ $disabled }}>{{ old('address', auth()->user()->myDetail->address ?? '') }}</textarea>
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div id="indo-fields" style="display: {{ $country == 'idn' ? 'block' : 'none' }};">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="province_id">Provinsi</label>
                                <select class="form-select @error('province_id') is-invalid @enderror" id="province_id" name="province_id" {{ $disabled }} onchange="getCity(this.value);">
                                    
                                </select>
                                @error('province_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="city_id">Kota/Kabupaten</label>
                                <select class="form-select @error('city_id') is-invalid @enderror" id="city_id" name="city_id" {{ $disabled }} onchange="getDistrict(this.value);">
                                    
                                </select>
                                @error('city_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="district_id">Kecamatan</label>
                                <select class="form-select @error('district_id') is-invalid @enderror" id="district_id" name="district_id" {{ $disabled }} onchange="getVillage(this.value);">
                                    
                                </select>
                                @error('district_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="village_id">Desa/Kelurahan</label>
                                <select class="form-select @error('village_id') is-invalid @enderror" id="village_id" name="village_id" {{ $disabled }}>
                                    
                                </select>
                                @error('village_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="postal_code">Kode Pos</label>
                            <input type="text" class="form-control @error('postal_code') is-invalid @enderror"
                                id="postal_code" name="postal_code"
                                value="{{ old('postal_code', auth()->user()->myDetail->postal_code ?? '') }}"
                                {{ $disabled }}>
                            @error('postal_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="child_order">Anak ke</label>
                            <input type="number" class="form-control @error('child_order') is-invalid @enderror"
                                id="child_order" name="child_order"
                                value="{{ old('child_order', auth()->user()->myDetail->child_order ?? '') }}" required {{ $disabled }}>
                            @error('child_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="from_child_order">Dari</label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('from_child_order') is-invalid @enderror" id="from_child_order" name="from_child_order" value="{{ old('from_child_order', auth()->user()->myDetail->from_child_order ?? '') }}" required {{ $disabled }}>
                                <span class="input-group-text">Bersaudara</span>
                                @error('from_child_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="mb-3">
                                <label class="form-label" for="hobby">Hobi</label>
                                <input type="text" class="form-control @error('hobby') is-invalid @enderror"
                                    id="hobby" name="hobby"
                                    value="{{ old('hobby', auth()->user()->myDetail->hobby ?? '') }}" required {{ $disabled }}>
                                @error('hobby')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="mb-3">
                                <label class="form-label" for="ambition">Cita-cita</label>
                                <input type="text" class="form-control @error('ambition') is-invalid @enderror"
                                    id="ambition" name="ambition"
                                    value="{{ old('ambition', auth()->user()->myDetail->ambition ?? '') }}" required {{ $disabled }}>
                                @error('ambition')
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
            function toggleIndoFields() {
                if ($('#country').val() === 'idn') {
                    $('#indo-fields').show();
                    $('#province_id, #city_id, #district_id, #village_id, #postal_code').attr('required', true);
                } else {
                    $('#indo-fields').hide();
                    $('#province_id, #city_id, #district_id, #village_id, #postal_code').removeAttr('required');
                }
            }

            toggleIndoFields();
            $('#country').on('change', toggleIndoFields);
        });

        @if(empty(auth()->user()->myDetail->address))
            getProvince();
        @else
            getProvince('{{ auth()->user()->myDetail->province_id }}');
            getCity('{{ auth()->user()->myDetail->province_id }}', '{{ auth()->user()->myDetail->city_id }}');
            getDistrict('{{ auth()->user()->myDetail->city_id }}', '{{ auth()->user()->myDetail->district_id }}');
            getVillage('{{ auth()->user()->myDetail->district_id }}', '{{ auth()->user()->myDetail->village_id }}');
        @endif

        function getProvince(id)
        {
            resetCity();
            $.ajax({
                type: "GET",
                url: '{{ route("api.wilayah.province") }}',
                async : true,
                dataType : 'json',
                success: function (data) {
                    var html = '<option value="">Pilih Provinsi</option>';
                    $.each(data, function(i, item) {
                        html += `<option value="${item.id}" ${id == item.id ? 'selected' : ''}>${item.name}</option>`;
                    });
                    $('#province_id').html(html);
                }
            });
        }

        function getCity(province_id, id)
        {
            resetDistrict();
            $.ajax({
                type: "GET",
                url: '{{ route("api.wilayah.city") }}',
                data: { province_id: province_id },
                async : true,
                dataType : 'json',
                success: function (data) {
                    var html = '<option value="">Pilih Kabupaten</option>';
                    $.each(data, function(i, item) {
                        html += `<option value="${item.id}" ${id == item.id ? 'selected' : ''}>${item.name}</option>`;
                    });
                    $('#city_id').html(html); // <- ini yang kurang
                }
            });
        }

        function getDistrict(city_id, id)
        {
            resetVillage();
            $.ajax({
                type: "GET",
                url: '{{ route("api.wilayah.district") }}',
                data: { city_id: city_id },
                async : true,
                dataType : 'json',
                success: function (data) {
                    var html = '<option value="">Pilih Kecamatan</option>';
                    $.each(data, function(i, item) {
                        html += `<option value="${item.id}" ${id == item.id ? 'selected' : ''}>${item.name}</option>`;
                    });
                    $('#district_id').html(html); // <- ini juga yang kurang
                }
            });
        }


        function getVillage(district_id, id)
        {
            $.ajax({
                type: "GET",
                url: '{{ route("api.wilayah.village") }}',
                data: {
                    district_id: district_id
                },
                async : true,
                dataType : 'json',
                success: function (data) {
                    var html = '<option value="">Pilih Kelurahan / Desa</option>';
                    $.each(data, function(i, item) {
                        html += `<option value="${item.id}" ${id == item.id ? 'selected' : ''}>${item.name}</option>`;
                    });
                    $('#village_id').html(html);
                }
            });
        }

        function resetCity() {
            $('#city_id').html('<option value="">Pilih Kabupaten</option>');
            resetDistrict();
        }
        function resetDistrict() {
            $('#district_id').html('<option value="">Pilih Kecamatan</option>');
            resetVillage();
        }
        function resetVillage() {
            $('#village_id').html('<option value="">Pilih Kelurahan / Desa</option>');
        }
    </script>

@endpush