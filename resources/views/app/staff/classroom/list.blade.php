@extends('_layouts.app-layouts.index')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Classroom List <span class="text-danger">{{ Session::get('tahun_ajaran_aktif') }}/{{ Session::get('tahun_ajaran_aktif')+1 }}</span></h5>
        <div>
            <a href="{{ route('staff.kelas.create') }}" class="btn btn-primary btn-sm">Create Classroom</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTable" class="table table-sm table-hover" style="width: 100%">
                <thead>
                    <tr>
                        <th>Actions</th>
                        <th>Nama</th>
                        <th>Fokus</th>
                        <th>Tingkat</th>
                        <th>Nomor</th>
                        <th>Batas Siswa</th>
                        <th>Lokasi</th>
                        <th>Wali Kelas</th>
                        <th>Wali Kelas (Tahfidz)</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url()->current() }}',
                type: 'GET'
            },
            drawCallback: function() {
                $('.pagination').addClass('pagination-sm');
            },
            columns: [
                {
                className: 'text-center',
                    render: function(data, type, row) {
                        return `<div class="btn-group">
                                    <a href="?id=${row.id}" class="btn btn-icon btn-outline-info"><i class="fas fa-eye"></i></a>
                                    <a href="?id=${row.id}" class="btn btn-icon btn-outline-info"><i class="fas fa-eye"></i></a>
                                </div>`;
                    }
                },
                { data: 'name', name: 'name' },
                { data: 'focus', name: 'focus' },
                { data: 'grade', name: 'grade' },
                { data: 'number', name: 'number' },
                { data: 'limitation', name: 'limitation' },
                { data: 'location', name: 'location' },
                { data: 'head_id', name: 'head_id' },
                { data: 'head_tahfidz_id', name: 'head_tahfidz_id' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' }
            ]
        });
    });
</script>

@endpush