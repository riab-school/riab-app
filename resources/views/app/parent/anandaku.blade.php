@extends('_layouts.mobile-layouts.index')
@section('title', 'Anandaku')
@section('content')
    @if($status)
    <div class="d-flex flex-column py-3 gap-2">
        <div class="container">
            <div class="profile-wrapper-area">
                <div class="card user-info-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="user-profile me-3">
                            <img class="img-preview img-responsive" 
                            data-src="{{ $data->studentDocument && $data->studentDocument->photo !== NULL ? Storage::disk('s3')->url($data->studentDocument->photo) : asset('assets/images/blank_person.jpg') }}" 
                            src="{{ $data->studentDocument && $data->studentDocument->photo !== NULL ? Storage::disk('s3')->url($data->studentDocument->photo) : asset('assets/images/blank_person.jpg') }}" 
                            alt="">
                        </div>
                        <div class="user-info">
                            <h5 class="mb-0">{{ $data->name }}</h5>
                            <h6>{{ $data->studentParentDetail ? "Ananda, Bapak ". $data->studentParentDetail->dad_name." dan Ibu ".$data->studentParentDetail->mom_name : ""}}</h6>
                        </div>
                    </div>
                </div>
                <div class="card user-data-card">
                    <div class="card-body">
                        <div class="single-profile-data d-flex align-items-center justify-content-between">
                            <div class="title d-flex align-items-center">
                                <i class="fa-solid fa-key"></i>
                                <span>NIS</span>
                            </div>
                            <div class="data-content">{{ $data->nis }}</div>
                        </div>
    
                        <div class="single-profile-data d-flex align-items-center justify-content-between">
                            <div class="title d-flex align-items-center">
                                <i class="fa-solid fa-key"></i>
                                <span>NISN</span>
                            </div>
                            <div class="data-content">{{ $data->nisn }}</div>
                        </div>
    
                        <div class="single-profile-data d-flex align-items-center justify-content-between">
                            <div class="title d-flex align-items-center">
                                <i class="fa-solid fa-venus-mars"></i>
                                <span>Jenis Kelamin</span>
                            </div>
                            <div class="data-content">@switch($data->gender)
                                @case('male')
                                    Laki-Laki
                                    @break
                                @case('female')
                                    Perempuan
                                    @break
                            @endswitch</div>
                        </div>
    
                        <div class="single-profile-data d-flex align-items-center justify-content-between">
                            <div class="title d-flex align-items-center">
                                <i class="fa-solid fa-phone"></i>
                                <span>No HP</span>
                            </div>
                            <div class="data-content">{{ $data->phone !== NULL ? indoNumber($data->phone) : "-" }}</div>
                        </div>
    
                        <div class="single-profile-data d-flex align-items-center justify-content-between">
                            <div class="title d-flex align-items-center">
                                <i class="fa-solid fa-calendar"></i>
                                <span>TTL</span>
                            </div>
                            <div class="data-content">{{ $data->place_of_birth }}, {{ dateIndo($data->date_of_birth) }}</div>
                        </div>
    
                        <div class="single-profile-data d-flex align-items-center justify-content-between">
                            <div class="title d-flex align-items-center">
                                <i class="fa-solid fa-door-open"></i>
                                <span>Kelas</span>
                            </div>
                            <div class="data-content">{{ $classroomInfo !== NULL ? $classroomInfo->name : "-" }}</div>
                        </div>
    
                        <div class="single-profile-data d-flex align-items-center justify-content-between">
                            <div class="title d-flex align-items-center">
                                <i class="fa-solid fa-home"></i>
                                <span>Asrama</span>
                            </div>
                            <div class="data-content">{{ $dormitoryInfo !== NULL ? $dormitoryInfo->name.", Lantai ".$dormitoryInfo->level : "-" }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card">
                <div class="card-header fw-bold">
                    Alamat
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" width="100%">
                            <tbody>
                                <tr>
                                    <td>Alamat</td>
                                    <td class="text-end">{{ $data->address }}</td>
                                </tr>
                                <tr>
                                    <td>Provinsi</td>
                                    <td class="text-end">{{ $data->province_id ? getProvince($data->province_id) : '' }}</td>
                                </tr>
                                <tr>
                                    <td>Kota/Kab</td>
                                    <td class="text-end">{{ $data->city_id ? getCity($data->city_id) : '' }}</td>
                                </tr>
                                <tr>
                                    <td>Kecamatan</td>
                                    <td class="text-end">{{ $data->district_id ? getDistrict($data->district_id) : '' }}</td>
                                </tr>
                                <tr>
                                    <td>Desa</td>
                                    <td class="text-end">{{ $data->village_id ? getVillage($data->village_id) : "" }}</td>
                                </tr>
                                <tr>
                                    <td>Kode Pos</td>
                                    <td class="text-end">{{ $data->postal_code }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card">
                <div class="card-header fw-bold">
                    Data Ayah
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" width="100%">
                            <tbody>
                                <tr>
                                    <td>Nama Ayah</td>
                                    <td class="text-end">{{ $data->studentParentDetail ? $data->studentParentDetail->dad_name : '' }}</td>
                                </tr>
                                <tr>
                                    <td>Nomor HP Ayah</td>
                                    <td class="text-end">{{ $data->studentParentDetail ? $data->studentParentDetail->dad_phone : '' }}</td>
                                </tr>
                                <tr>
                                    <td>Status Ayah</td>
                                    <td class="text-end">
                                        @if($data->studentParentDetail)
                                            @switch($data->studentParentDetail->dad_status)
                                                @case(1)
                                                    Masih
                                                    @break
                                                @case(0)
                                                    Meninggal
                                                    @break
                                            @endswitch
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card">
                <div class="card-header fw-bold">
                    Data Ibu
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" width="100%">
                            <tbody>
                                <tr>
                                    <td>Nama Ibu</td>
                                    <td class="text-end">{{ $data->studentParentDetail ? $data->studentParentDetail->mom_name : '' }}</td>
                                </tr>
                                <tr>
                                    <td>Nomor HP Ibu</td>
                                    <td class="text-end">{{ $data->studentParentDetail ? $data->studentParentDetail->mom_phone : '' }}</td>
                                </tr>
                                <tr>
                                    <td>Status Ibu</td>
                                    <td class="text-end">
                                        @if($data->studentParentDetail)
                                            @switch($data->studentParentDetail->mom_status)
                                                @case(1)
                                                    Masih
                                                    @break
                                                @case(0)
                                                    Meninggal
                                                    @break
                                            @endswitch
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card">
                <div class="card-header fw-bold">
                    Data Wali Santi
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" width="100%">
                            <tbody>
                                <tr>
                                    <td>Nama Wali</td>
                                    <td class="text-end">{{ $data->studentGuardianDetail ? $data->studentGuardianDetail->name : '' }}</td>
                                </tr>
                                <tr>
                                    <td>Nomor HP Wali</td>
                                    <td class="text-end">{{ $data->studentGuardianDetail ? $data->studentGuardianDetail->phone : '' }}</td>
                                </tr>
                                <tr>
                                    <td>Hubungan dengan Wali</td>
                                    <td class="text-end">{{ $data->studentGuardianDetail ? $data->studentGuardianDetail->relation_detail : '' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card">
                <div class="card-header fw-bold">
                    Data Lainnya
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" width="100%">
                            <tbody>
                                <tr>
                                    <td>Anak Ke</td>
                                    <td class="text-end">{{ $data->child_order }} dari {{ $data->from_child_order }} Bersaudara</td>
                                </tr>
                                <tr>
                                    <td>Hobi</td>
                                    <td class="text-end">{{ $data->hobby }}</td>
                                </tr>
                                <tr>
                                    <td>Cita Cita</td>
                                    <td class="text-end">{{ $data->ambition }}</td>
                                </tr>
                                <tr>
                                    <td>Angkatan</td>
                                    <td class="text-end">{{ $data->generation_id }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-danger text-center" role="alert">
                    <h1 class="alert-heading">
                        <i class="fas fa-exclamation-triangle text-danger"></i>
                    </h1>
                    <h6>Akun anda belum terhubung dengan data Ananda, Hubungkan sekarang dengan memasukkan nomor NIS/NISN</h6>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" id="nis_nisn" name="nis_nisn" placeholder="Masukkan NIS/NISN" required>
                </div>
                <div class="form-group text-center">
                    <button type="button" id="btnFindData" class="btn btn-primary mt-3 " id="submit">Cari Data</button>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection

@if($status == false)
@push('scripts-mobile')
    <script>
        $('#btnFindData').on('click', function() {
            var nis_nisn = $('#nis_nisn').val();
            if (nis_nisn) {
                $.ajax({
                    url: "{{ route('parent.anandaku.find') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        nis_nisn: nis_nisn
                    },
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                title: "Data anada di temukan",
                                html: "Nama : <b>" + response.data.name + "</b><br>NIS : <b>" + response.data.nis+"</b>"+"<br>NISN : <b>" + response.data.nisn+"</b>",
                                icon: "success",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Hubungkan Sekarang!",
                                cancelButtonText: "Batalkan"
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: "{{ route('parent.anandaku.pair') }}",
                                        type: "POST",
                                        data: {
                                            _token: "{{ csrf_token() }}",
                                            student_user_id: response.data.user_id
                                        },
                                        success: function(response) {
                                            if (response.status) {
                                                showSwal('success', 'Berhasil menghubungkan data ananda', true);
                                            } else {
                                                showSwal('warning', 'Gagal menghubungkan data ananda');
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            showSwal('warning', xhr.responseJSON.message);
                                        }
                                    });
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        showSwal('warning', xhr.responseJSON.message);
                    }
                });
            } else {
                showSwal('warning', 'NIS/NISN tidak boleh kosong');
            }
        });
    </script>
@endpush
@endif