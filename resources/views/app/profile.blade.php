@extends('_layouts.app-layouts.index')

@push('styles')
    <style>
        .img-fit {
            height: 100%; /* Menyesuaikan tinggi gambar dengan container */
            object-fit: cover; /* Memastikan gambar akan "cover" area container */
            border-radius: 0.25rem; /* Menambahkan rounded sesuai container */
        }
    </style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-4 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5>Update Password</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST" onsubmit="return processData(this)">
                    @csrf
                    <input type="hidden" name="section" value="password">
                    <div class="mb-3">
                        <label class="form-label @error('old_password') is-invalid @enderror" for="old_password">Password Lama</label>
                        <input type="password" class="form-control" id="old_password" name="old_password">
                        @error('old_password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label @error('new_password') is-invalid @enderror" for="new_password">Password Baru</label>
                        <input type="password" class="form-control" id="new_password" name="new_password">
                        @error('new_password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if(auth()->user()->user_level == 'admin' || auth()->user()->user_level == 'staff')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Update Profile</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST" onsubmit="return processData(this)" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="section" value="profile">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label" for="name">Your Photo</label>
                            <div class="border border-dark rounded h-75 mb-2">
                                <img id="img_output" src="{{ auth()->user()->myDetail->photo == NULL ? asset('assets/images/blank_person.jpg') : Storage::disk('s3')->url(auth()->user()->myDetail->photo) }}" 
                                    class="w-100 img-fit" alt="User-Profile-Image" loading="lazy">
                            </div>
                            <div class="mb-3">
                                <input type="file" class="form-control-sm  @error('photo') is-invalid @enderror" id="photo" name="photo" 
                                    onchange="document.getElementById('img_output').src = window.URL.createObjectURL(this.files[0])" accept=".jpeg,.jpg,.png" required>
                                @error('photo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>                        
                        <div class="col-md-9">
                            <div class="mb-3">
                                <label class="form-label" for="name">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ auth()->user()->myDetail->name }}" required>
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="nik_ktp">NIK KTP</label>
                                <input type="number" class="form-control @error('nik_ktp') is-invalid @enderror" id="nik_ktp" name="nik_ktp" value="{{ auth()->user()->myDetail->nik_ktp }}" required>
                                @error('nik_ktp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="employee_number">NIP</label>
                                <input type="number" class="form-control @error('employee_number') is-invalid @enderror" id="employee_number" name="employee_number" value="{{ auth()->user()->myDetail->employee_number }}" required>
                                @error('employee_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            @if(auth()->user()->user_level == 'staff')
                            <div class="mb-3">
                                <label class="form-label" for="role_id">Jabatan</label>
                                <select name="role_id" id="role_id" class="form-control" required>
                                    <option value="">Pilih Jabatan</option>
                                    @foreach(App\Models\Roles::all() as $role)
                                    <option value="{{ $role->id }}" {{ auth()->user()->myDetail->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label" for="place_of_birth">Tempat Lahir</label>
                                <input type="text" class="form-control @error('place_of_birth') is-invalid @enderror" id="place_of_birth" name="place_of_birth" value="{{ auth()->user()->myDetail->place_of_birth }}" required>
                                @error('place_of_birth')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label" for="date_of_birth">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ auth()->user()->myDetail->date_of_birth }}" required>
                                @error('date_of_birth')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label" for="gender">Jenis Kelamin</label>
                                <select name="gender" id="gender" class="form-control" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="male" {{ auth()->user()->myDetail->gender == 'male' ? 'selected' : '' }}>Laki Laki</option>
                                    <option value="female" {{ auth()->user()->myDetail->gender == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label" for="phone">Nomor Whatsapp</label>
                                <input type="number" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ auth()->user()->myDetail->phone }}" required>
                                @error('phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="address">Alamat</label>
                            <textarea type="number" class="form-control @error('address') is-invalid @enderror" id="address" name="address" required>{{ auth()->user()->myDetail->address }}</textarea>
                            @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label" for="province_id">Province</label>
                                <select name="province_id" id="province_id" class="form-control @error('province_id') is-invalid @enderror" onchange="getCity(this.value);">
                                    
                                </select>
                                @error('province_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label" for="city_id">City</label>
                                <select name="city_id" id="city_id" class="form-control @error('city_id') is-invalid @enderror" onchange="getDistrict(this.value);">
                                    
                                </select>
                                @error('city_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label" for="district_id">District</label>
                                <select name="district_id" id="district_id" class="form-control @error('district_id') is-invalid @enderror" onchange="getVillage(this.value);">
                                    
                                </select>
                                @error('district_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label" for="village_id">Village</label>
                                <select name="village_id" id="village_id" class="form-control @error('village_id') is-invalid @enderror">
                                    
                                </select>
                                @error('village_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection

@push('scripts')
    <script>
        @error('province_id')
            changeCountry('idn')
        @enderror
        @error('city_id')
            changeCountry('idn')
        @enderror
        @error('district_id')
            changeCountry('idn')
        @enderror
        @error('village_id')
            changeCountry('idn')
        @enderror

        @if(auth()->user()->myDetail->address == NULL)
        getProvince();
        @else
        getProvince('{{ auth()->user()->myDetail->province_id }}');
        getCity('{{ auth()->user()->myDetail->province_id }}', '{{ auth()->user()->myDetail->city_id }}');
        getDistrict('{{ auth()->user()->myDetail->city_id }}', '{{ auth()->user()->myDetail->district_id }}');
        getVillage('{{ auth()->user()->myDetail->district_id }}', '{{ auth()->user()->myDetail->village_id }}');
        @endif

        function getProvince(id)
        {
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
            $.ajax({
                type: "GET",
                url: '{{ route("api.wilayah.city") }}',
                data: {
                    province_id: province_id
                },
                async : true,
                dataType : 'json',
                success: function (data) {
                    var html = '<option value="">Pilih Kabupaten</option>';
                    $.each(data, function(i, item) {
                        html += `<option value="${item.id}" ${id == item.id ? 'selected' : ''}>${item.name}</option>`;
                    });
                    $('#city_id').html(html);
                }
            });
        }

        function getDistrict(city_id, id)
        {
            $.ajax({
                type: "GET",
                url: '{{ route("api.wilayah.district") }}',
                data: {
                    city_id: city_id
                },
                async : true,
                dataType : 'json',
                success: function (data) {
                    var html = '<option value="">Pilih Kecamatan</option>';
                    $.each(data, function(i, item) {
                        html += `<option value="${item.id}" ${id == item.id ? 'selected' : ''}>${item.name}</option>`;
                    });
                    $('#district_id').html(html);
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
    </script>
@endpush