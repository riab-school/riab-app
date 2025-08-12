@extends('_layouts.app-layouts.index')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>List Hafalan Santri</h5>
        <div class="card-header-right">
            <a href="{{ route('staff.tahfidz.list.create') }}" class="btn btn-primary btn-sm">Tambah Hafalan</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTable" class="table table-sm table-hover" width="100%">
                <thead>
                    <tr>
                        {{-- <th>Action</th> --}}
                        <th>Nama Santri</th>
                        <th>NIS</th>
                        <th>NISN</th>
                        <th>Juz</th>
                        <th>Surah</th>
                        <th>Ayat</th>
                        <th>Point Tahsin</th>
                        <th>Point Tahfidz</th>
                        <th>Evidence</th>
                        <th>Tasmik Oleh</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection


@push('scripts')
    <script>

        $(document).ready(function() {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url()->current() }}?by=all',
                drawCallback: function() {
                    $('.pagination').addClass('pagination-sm');
                },
                columns: [
                    // {
                    //     className: 'text-center',
                    //     orderable: false,
                    //     render: function(data, type, row) {
                    //         return ``;
                    //     }
                    // },
                    {data: 'user_detail.student_detail.name', name: 'nama'},
                    {data: 'user_detail.student_detail.nis', name: 'nis'},
                    {data: 'user_detail.student_detail.nisn', name: 'nisn'},
                    {data: 'juz', name: 'juz'},
                    {data: 'surah', name: 'surah'},
                    {data: 'ayat', name: 'ayat'},
                    {data: 'point_tahsin', name: 'point_tahsin'},
                    {data: 'point_tahfidz', name: 'point_tahfidz'},
                    {data: 'evidence', name: 'evidence', orderable: false, searchable: false, className: 'text-center'},
                    {data: 'process_by', name: 'process_by'},
                    {data: 'created_at', name: 'created_at'},
                ]
            })
        })
    </script>
@endpush