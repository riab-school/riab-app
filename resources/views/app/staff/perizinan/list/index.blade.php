@extends('_layouts.app-layouts.index')

@section('content')
@if (\Session::has('token'))
    <div class="alert alert-success mt-2">
        <strong>Perizinan Berhasil di setujui !</strong>
        <br>Token Izin : <b>{{ \Session::get('token') }}</b>
    </div>
@endif

<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="pills-siswa-tab" data-bs-toggle="pill"
            href="#pills-siswa" role="tab" aria-controls="pills-siswa"
            aria-selected="true">Permohonan Mandiri</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="pills-orang-tua-tab" data-bs-toggle="pill"
            href="#pills-orang-tua" role="tab" aria-controls="pills-orang-tua"
            aria-selected="false">Via Orang Tua / Wali</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="pills-staff-kesehatan-tab" data-bs-toggle="pill"
            href="#pills-staff-kesehatan" role="tab" aria-controls="pills-staff-kesehatan"
            aria-selected="false">Via Staff Kesehatan</a>
    </li>
</ul>

<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-siswa" role="tabpanel" aria-labelledby="pills-siswa-tab">
        <div class="d-flex justify-content-between align-items-center">
            <h5>List Perizinan (Mandiri)</h5>
            <a href="{{ route('staff.perizinan.create') }}" class="btn btn-primary btn-sm">Tambah Izin</a>
        </div>
        <hr>
        <div class="table-responsive">
            <table id="dataTable1" class="table table-sm table-hover dataTable" width="100%">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Status</th>
                        <th>Nama</th>
                        <th>NIS</th>
                        <th>NISN</th>
                        <th>Token Izin</th>
                        <th>Alasan</th>
                        <th>Dari Tanggal</th>
                        <th>Hingga Tanggal</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="tab-pane fade" id="pills-orang-tua" role="tabpanel" aria-labelledby="pills-orang-tua-tab">
        <h5>List Perizinan (Via Orang Tua / Wali)</h5>
        <hr>
        <div class="table-responsive">
            <table id="dataTable2" class="table table-sm table-hover dataTable" width="100%">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Status</th>
                        <th>Nama</th>
                        <th>NIS</th>
                        <th>NISN</th>
                        <th>Token Izin</th>
                        <th>Alasan</th>
                        <th>Dari Tanggal</th>
                        <th>Hingga Tanggal</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="tab-pane fade" id="pills-staff-kesehatan" role="tabpanel" aria-labelledby="pills-staff-kesehatan-tab">
        <h5>List Perizinan (Via Staff Kesehatan)</h5>
        <hr>
        <div class="table-responsive">
            <table id="dataTable3" class="table table-sm table-hover dataTable" width="100%">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Status</th>
                        <th>Nama</th>
                        <th>NIS</th>
                        <th>NISN</th>
                        <th>Token Izin</th>
                        <th>Alasan</th>
                        <th>Dari Tanggal</th>
                        <th>Hingga Tanggal</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="modalDetailContent" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Izin</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label col-form-label-sm">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" readonly disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label col-form-label-sm">NIS</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nis" readonly disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label col-form-label-sm">NISN</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nisn" readonly disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label col-form-label-sm">Alasan Izin</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="reason" readonly disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label col-form-label-sm">Dijemput Oleh</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="pickup_by" readonly disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label col-form-label-sm">Dari Tanggal</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="from_date" readonly disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label col-form-label-sm">Hingga Tanggal</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="to_date" readonly disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label col-form-label-sm">Token Izin</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="token" readonly disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label col-form-label-sm">Permohonan Oleh</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="requested_by" readonly disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label col-form-label-sm">Di Setujui Oleh</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="approved_by" readonly disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label col-form-label-sm">Check Out Oleh - Jam</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="checked_out_by" readonly disabled>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="checked_out_at" readonly disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label col-form-label-sm">Check In Oleh - Jam</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="checked_in_by" readonly disabled>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="checked_in_at" readonly disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label col-form-label-sm">Di Tolak Oleh</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="rejected_by" readonly disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label col-form-label-sm">Alasan Di tolak</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="reject_reason" readonly disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Status</h5>
            </div>
            <form action="{{ route('staff.perizinan.status') }}" method="POST" onsubmit="return processData(this)">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" id="id" required>
                    <input type="hidden" name="user_id" id="user_id" required>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label col-form-label-sm">Status</label>
                        <div class="col-sm-10">
                            <select class="form-select form-select-sm" id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                                <option value="canceled">Canceled</option>
                                <option value="check_in">Check In</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3 d-none" id="reject_reason_div">
                        <label class="col-sm-2 col-form-label col-form-label-sm">Alasan</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="reject_reason" name="reject_reason" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>

        $(document).on('click', '#btnModalDetail', function() {
            let id = $(this).data('id');
            $.ajax({
                url: '{{ route('staff.perizinan.detail') }}?id=' + id,
                type: 'GET',
                success: function(res) {
                    $('#name').val(res.data.detail.student_detail.name);
                    $('#nis').val(res.data.detail.student_detail.nis);
                    $('#nisn').val(res.data.detail.student_detail.nisn);
                    $('#reason').val(res.data.reason);
                    $('#pickup_by').val(res.data.pickup_by);
                    $('#from_date').val(res.data.from_date);
                    $('#to_date').val(res.data.to_date);
                    $('#token').val(res.data.token);
                    $('#requested_by').val(res.data.requested_by);
                    $('#approved_by').val(res.data.approved_by ? res.data.approved_by.staff_detail.name : '-');
                    $('#checked_out_by').val(res.data.checked_out_by ? res.data.checked_out_by.staff_detail.name : '-');
                    $('#checked_out_at').val(res.data.checked_out_at);
                    $('#checked_in_by').val(res.data.checked_in_by ? res.data.checked_in_by.staff_detail.name : '-');
                    $('#checked_in_at').val(res.data.checked_in_at);
                    $('#rejected_by').val(res.data.rejected_by ? res.data.rejected_by.staff_detail.name : '-');
                    $('#reject_reason').val(res.data.reject_reason);
                    $('#modalDetailContent').modal('show');
                },
                error: function(xhr, status, error) {
                    // if 401 return to login page
                    if (xhr.status === 401) {
                        window.location.href = '{{ route('login') }}';
                    }
                }
            });
        });

        $(document).on('click', '#btnModalEdit', function() {
            let id = $(this).data('id');
            $.ajax({
                url: '{{ route('staff.perizinan.detail') }}?id=' + id,
                type: 'GET',
                success: function(res) {
                    $('#id').val(res.data.id);
                    $('#user_id').val(res.data.user_id);
                    $('#status').find('option').each(function() {
                        if ($(this).val() == res.data.status) {
                            $(this).hide();
                        }
                    });
                    if (res.data.status == 'check_out') {
                        $('#status').find('option[value="canceled"]').hide();
                        $('#status').find('option[value="approved"]').hide();
                        $('#status').find('option[value="rejected"]').hide();
                    }
                    if (res.data.status == 'check_in') {
                        $('#status').find('option[value="check_in"]').hide();
                        $('#status').find('option[value="canceled"]').hide();
                        $('#status').find('option[value="approved"]').hide();
                        $('#status').find('option[value="rejected"]').hide();
                    }
                    if (res.data.status == 'rejected') {
                        $('#status').find('option[value="check_in"]').hide();
                        $('#status').find('option[value="canceled"]').hide();
                        $('#status').find('option[value="approved"]').hide();
                    }
                    $('#modalEdit').modal('show');
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 401) {
                        window.location.href = '{{ route('login') }}';
                    }
                }
            });
        });

        $(document).on('change', '#status', function() {
            if ($(this).val() == 'rejected') {
                $('#reject_reason_div').removeClass('d-none');
                $('#reject_reason').attr('required', true);
            } else {
                $('#reject_reason_div').addClass('d-none');
                $('#reject_reason').attr('required', false);
            }
        });

        $(document).ready(function() {
            $('#dataTable1').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url()->current() }}?requested_by=siswa',
                drawCallback: function() {
                    $('.pagination').addClass('pagination-sm');
                },
                rowCallback: function(row, data) {
                    switch (data.status) {
                        case 'requested':
                            $(row).addClass('table-info'); // Biru muda
                            break;
                        case 'approved':
                            $(row).addClass('table-success'); // Hijau
                            break;
                        case 'check_out':
                            $(row).addClass('table-primary'); // Biru
                            break;
                        case 'check_in':
                            $(row).addClass('table-secondary'); // Abu-abu
                            break;
                        case 'rejected':
                            $(row).addClass('table-danger'); // Merah
                            break;
                        case 'canceled':
                            $(row).addClass('table-warning'); // Kuning
                            break;
                    }
                },
                columns: [
                    {
                        className: 'text-center',
                        orderable: false,
                        render: function(data, type, row) {
                            return `<div class="btn-group">
                                        <button id="btnModalEdit" data-id="${row.id}" class="btn btn-icon btn-outline-warning"><i class="fas fa-edit"></i></button>
                                        <button id="btnModalDetail" data-id="${row.id}" class="btn btn-icon btn-outline-primary"><i class="fas fa-eye"></i></button>
                                    </div>`;
                        }
                    },
                    {data: 'status',
                        render: function(data, type, row) {
                            switch (row.status) {
                                case 'requested':
                                    return 'Permohonan Izin';
                                    break;
                                case 'approved':
                                    return 'Disetujui';
                                    break;
                                case 'check_out':
                                    return 'Sudah Keluar';
                                    break;
                                case 'check_in':
                                    return 'Sudah Kembali';
                                    break;
                                case 'rejected':
                                    return 'Di Tolak';
                                    break;
                                case 'canceled':
                                    return 'Di Batalkan';
                                    break;
                            }
                        }
                    },
                    {data: 'detail.student_detail.name', name: 'nama'},
                    {data: 'detail.student_detail.nis', name: 'nis'},
                    {data: 'detail.student_detail.nisn', name: 'nisn'},
                    {
                        data: 'token',
                        name: 'token',
                        className: 'fw-bold',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            if (!data) {
                                return '-'; // atau bisa dikosongkan dengan return '' jika kamu mau
                            }

                            return `
                                <span class="token-mask" data-token="${data}">******</span>
                                <button type="button" class="btn btn-sm btn-link p-0 ms-1 toggle-token" title="Lihat Token">
                                    <i class="fas fa-eye"></i>
                                </button>
                            `;
                        }
                    },
                    {data: 'reason', name: 'reason'},
                    {data: 'from_date', name: 'from_date'},
                    {data: 'to_date', name: 'to_date'},
                ]
            })

            $('#dataTable2').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url()->current() }}?requested_by=orang_tua',
                drawCallback: function() {
                    $('.pagination').addClass('pagination-sm');
                },
                rowCallback: function(row, data) {
                    switch (data.status) {
                        case 'requested':
                            $(row).addClass('table-info'); // Biru muda
                            break;
                        case 'approved':
                            $(row).addClass('table-success'); // Hijau
                            break;
                        case 'check_out':
                            $(row).addClass('table-primary'); // Biru
                            break;
                        case 'check_in':
                            $(row).addClass('table-secondary'); // Abu-abu
                            break;
                        case 'rejected':
                            $(row).addClass('table-danger'); // Merah
                            break;
                        case 'canceled':
                            $(row).addClass('table-warning'); // Kuning
                            break;
                    }
                },
                columns: [
                    {
                        className: 'text-center',
                        orderable: false,
                        render: function(data, type, row) {
                            return `<div class="btn-group">
                                        <button id="btnModalEdit" data-id="${row.id}" class="btn btn-icon btn-outline-warning"><i class="fas fa-edit"></i></button>
                                        <button id="btnModalDetail" data-id="${row.id}" class="btn btn-icon btn-outline-primary"><i class="fas fa-eye"></i></button>
                                    </div>`;
                        }
                    },
                    {data: 'status',
                        render: function(data, type, row) {
                            switch (row.status) {
                                case 'requested':
                                    return 'Permohonan Izin';
                                    break;
                                case 'approved':
                                    return 'Disetujui';
                                    break;
                                case 'check_out':
                                    return 'Sudah Keluar';
                                    break;
                                case 'check_in':
                                    return 'Sudah Kembali';
                                    break;
                                case 'rejected':
                                    return 'Di Tolak';
                                    break;
                                case 'canceled':
                                    return 'Di Batalkan';
                                    break;
                            }
                        }
                    },
                    {data: 'detail.student_detail.name', name: 'nama'},
                    {data: 'detail.student_detail.nis', name: 'nis'},
                    {data: 'detail.student_detail.nisn', name: 'nisn'},
                    {
                        data: 'token',
                        name: 'token',
                        className: 'fw-bold',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            if (!data) {
                                return '-'; // atau bisa dikosongkan dengan return '' jika kamu mau
                            }

                            return `
                                <span class="token-mask" data-token="${data}">******</span>
                                <button type="button" class="btn btn-sm btn-link p-0 ms-1 toggle-token" title="Lihat Token">
                                    <i class="fas fa-eye"></i>
                                </button>
                            `;
                        }
                    },
                    {data: 'reason', name: 'reason'},
                    {data: 'from_date', name: 'from_date'},
                    {data: 'to_date', name: 'to_date'},
                ]
            })

            $('#dataTable3').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url()->current() }}?requested_by=staff_kesehatan',
                drawCallback: function() {
                    $('.pagination').addClass('pagination-sm');
                },
                rowCallback: function(row, data) {
                    switch (data.status) {
                        case 'requested':
                            $(row).addClass('table-info'); // Biru muda
                            break;
                        case 'approved':
                            $(row).addClass('table-success'); // Hijau
                            break;
                        case 'check_out':
                            $(row).addClass('table-primary'); // Biru
                            break;
                        case 'check_in':
                            $(row).addClass('table-secondary'); // Abu-abu
                            break;
                        case 'rejected':
                            $(row).addClass('table-danger'); // Merah
                            break;
                        case 'canceled':
                            $(row).addClass('table-warning'); // Kuning
                            break;
                    }
                },
                columns: [
                    {
                        className: 'text-center',
                        orderable: false,
                        render: function(data, type, row) {
                            return `<div class="btn-group">
                                        <button id="btnModalEdit" data-id="${row.id}" class="btn btn-icon btn-outline-warning"><i class="fas fa-edit"></i></button>
                                        <button id="btnModalDetail" data-id="${row.id}" class="btn btn-icon btn-outline-primary"><i class="fas fa-eye"></i></button>
                                    </div>`;
                        }
                    },
                    {data: 'status',
                        render: function(data, type, row) {
                            switch (row.status) {
                                case 'requested':
                                    return 'Permohonan Izin';
                                    break;
                                case 'approved':
                                    return 'Disetujui';
                                    break;
                                case 'check_out':
                                    return 'Sudah Keluar';
                                    break;
                                case 'check_in':
                                    return 'Sudah Kembali';
                                    break;
                                case 'rejected':
                                    return 'Di Tolak';
                                    break;
                                case 'canceled':
                                    return 'Di Batalkan';
                                    break;
                            }
                        }
                    },
                    {data: 'detail.student_detail.name', name: 'nama'},
                    {data: 'detail.student_detail.nis', name: 'nis'},
                    {data: 'detail.student_detail.nisn', name: 'nisn'},
                    {
                        data: 'token',
                        name: 'token',
                        className: 'fw-bold',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            if (!data) {
                                return '-'; // atau bisa dikosongkan dengan return '' jika kamu mau
                            }

                            return `
                                <span class="token-mask" data-token="${data}">******</span>
                                <button type="button" class="btn btn-sm btn-link p-0 ms-1 toggle-token" title="Lihat Token">
                                    <i class="fas fa-eye"></i>
                                </button>
                            `;
                        }
                    },
                    {data: 'reason', name: 'reason'},
                    {data: 'from_date', name: 'from_date'},
                    {data: 'to_date', name: 'to_date'},
                ]
            })
        })
        $('.dataTable').on('click', '.toggle-token', function() {
            const $span = $(this).closest('td').find('.token-mask');
            const isHidden = $span.text() === '******';
            if (isHidden) {
                $span.text($span.data('token'));
                $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                $span.text('******');
                $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    </script>
@endpush