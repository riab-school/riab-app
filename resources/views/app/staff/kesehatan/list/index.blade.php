@extends('_layouts.app-layouts.index')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Kesehatan List</h5>
        <a href="{{ route('staff.kesehatan.create') }}" class="btn btn-primary btn-sm">Tambah Catatan</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTable" class="table table-sm table-hover" width="100%">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Nama</th>
                        <th>NIS</th>
                        <th>NISN</th>
                        <th>Diagnosa</th>
                        <th>Tindakan</th>
                        <th>Obat diberikan</th>
                        <th>Catatan</th>
                        <th>Izin Pulang</th>
                        <th>Bukti</th>
                        <th>Dignosa Oleh</th>
                        <th>Notifikasi Orang Tua</th>
                        <th>Tanggal Kejadian</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Keluhan Kesehatan</h5>
            </div>
            <div class="modal-body">
                
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

        $(document).on('click', '#btnModalEdit', function() {
            let id = $(this).data('id');
            $.ajax({
                url: '{{ route('staff.kesehatan.detail') }}?id=' + id,
                type: 'GET',
                success: function(res) {
                    $('#id').val(res.data.id);
                    $('#modalEdit').modal('show');
                },
                error: function(xhr, status, error) {
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
                                        <button id="btnModalEdit" data-id="${row.id}" class="btn btn-icon btn-outline-warning"><i class="fas fa-edit"></i></button>
                                    </div>`;
                        }
                    },
                    {data: 'user_detail.student_detail.name', name: 'nama'},
                    {data: 'user_detail.student_detail.nis', name: 'nis'},
                    {data: 'user_detail.student_detail.nisn', name: 'nisn'},
                    {data: 'diagnose', name: 'diagnose'},
                    {data: 'treatment', name: 'treatment'},
                    {data: 'drug_given', name: 'drug_given'},
                    {data: 'note', name: 'note'},
                    {data: 'is_allow_home', name: 'is_allow_home'},
                    {data: 'evidence', name: 'evidence', orderable: false, searchable: false, className: 'text-center'},
                    {data: 'diagnoze_by', name: 'diagnoze_by'},
                    {data: 'is_notify_parent', name: 'is_notify_parent'},
                    {data: 'created_at', name: 'created_at'},
                ]
            })
        })
    </script>
@endpush