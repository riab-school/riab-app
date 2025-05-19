@extends('_layouts.mobile-layouts.index')

@section('content')
    @if($status)
    <div class="container">
        <div class="profile-wrapper-area py-3">
            <div class="card user-info-card">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="user-profile me-3">
                        <img src="{{ $data->studentDocument && $data->studentDocument->photo !== NULL ? Storage::disk('s3')->url($data->studentDocument->photo) : asset('assets/images/blank_person.jpg') }}" alt="">
                    </div>
                    <div class="user-info">
                        <h5 class="mb-0">{{ $data->name }}</h5>
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
                            <i class="fa-solid fa-phone"></i>
                            <span>No HP</span>
                        </div>
                        <div class="data-content">{{ $data->phone }}</div>
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
                        <div class="data-content"></div>
                    </div>

                    <div class="single-profile-data d-flex align-items-center justify-content-between">
                        <div class="title d-flex align-items-center">
                            <i class="fa-solid fa-home"></i>
                            <span>Asrama</span>
                        </div>
                        <div class="data-content"></div>
                    </div>

                    <div class="single-profile-data d-flex align-items-center justify-content-between">
                        <div class="title d-flex align-items-center">
                            <i class="fa-solid fa-book"></i>
                            <span>Pembina Tahfidz</span>
                        </div>
                        <div class="data-content"></div>
                    </div>

                    <div class="edit-profile-btn mt-3">
                        <a class="btn btn-primary w-100" href="#">Selengkapnya</a>
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