@extends('_layouts.app-layouts.index')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Achievement List</h5>
        <a href="{{ route('staff.prestasi.create') }}" class="btn btn-primary btn-sm">Tambah Prestasi</a>
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
                        <th>Keterangan</th>
                        <th>Bukti / Sertifikat</th>
                        <th>Tindakan</th>
                        <th>Proses Oleh</th>
                        <th>Tanggal Rekam</th>
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
                <h5 class="modal-title">Detail Prestasi</h5>
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
                url: '{{ route('staff.prestasi.detail') }}?id=' + id,
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
                    {data: 'detail', name: 'detail'},
                    {data: 'evidence', name: 'evidence', orderable: false, searchable: false, className: 'text-center'},
                    {data: 'action_taked', name: 'action_taked'},
                    {data: 'process_by', name: 'process_by'},
                    {data: 'created_at', name: 'created_at'},
                ]
            })
        })
    </script>
@endpush