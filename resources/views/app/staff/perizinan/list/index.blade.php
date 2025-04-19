@extends('_layouts.app-layouts.index')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Permission List</h5>
        <a href="{{ route('staff.perizinan.create') }}" class="btn btn-primary btn-sm">Tambah Izin</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTable" class="table table-sm table-hover" width="100%">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Status</th>
                        <th>NIS</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Alasan</th>
                        <th>Dari Tanggal</th>
                        <th>Hingga Tanggal</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
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
                            <label class="col-sm-2 col-form-label col-form-label-sm">Check Out Oleh</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="checked_out_by" readonly disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label col-form-label-sm">Check In Oleh</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="checked_in_by" readonly disabled>
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
@endsection

@push('scripts')
    <script>

        $(document).on('click', '#modalDetail', function() {
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
                    $('#to_date').val(res.data.token);
                    $('#requested_by').val(res.data.requested_by.name);
                    $('#approved_by').val(res.data.approved_by.name);
                    $('#checked_out_by').val(res.data.checked_out_by.name);
                    $('#checked_in_by').val(res.data.checked_in_by.name);
                    $('#rejected_by').val(res.data.rejected_by.name);
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
        $(document).ready(function() {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url()->current() }}',
                drawCallback: function() {
                    $('.pagination').addClass('pagination-sm');
                },
                columns: [
                    {
                        className: 'text-center',
                        orderable: false,
                        render: function(data, type, row) {
                            return `<div class="btn-group">
                                        <a href="/?id=${row.id}" class="btn btn-icon btn-outline-info"><i class="fas fa-edit"></i></a>
                                        <button id="modalDetail" data-id="${row.id}" class="btn btn-icon btn-outline-primary"><i class="fas fa-eye"></i></button>
                                    </div>`;
                        }
                    },
                    {data: 'status',
                        render: function(data, type, row) {
                            switch (row.status) {
                                case 'requested':
                                    return '<span class="badge badge-light-info">Requested</span>';
                                    break;
                                case 'approved':
                                    return '<span class="badge badge-light-success">Approved</span>';
                                    break;
                                case 'check_out':
                                    return '<span class="badge badge-light-primary">Check Out</span>';
                                    break;
                                case 'check_in':
                                    return '<span class="badge badge-light-secodary">Check Out</span>';
                                    break;
                                case 'rejected':
                                    return '<span class="badge badge-light-danger">Rejected</span>';
                                    break;
                                case 'canceled':
                                    return '<span class="badge badge-light-warning">Canceled</span>';
                                    break;
                            }
                        }
                    },
                    {data: 'detail.student_detail.nis', name: 'nis'},
                    {data: 'detail.student_detail.nisn', name: 'nisn'},
                    {data: 'detail.student_detail.name', name: 'nama'},
                    {data: 'reason', name: 'reason'},
                    {data: 'from_date', name: 'from_date'},
                    {data: 'to_date', name: 'to_date'},
                ]
            })
        })
    </script>
@endpush