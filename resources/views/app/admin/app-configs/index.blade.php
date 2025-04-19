@extends('_layouts.app-layouts.index')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>App Settings</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTable" class="table table-sm table-hover" width="100%">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Key</th>
                        <th>Value</th>
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
        $(document).ready(function(){
        var table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ url()->current() }}",
            drawCallback: function() {
                $('.pagination').addClass('pagination-sm');
            },
            columns: [
                {
                    className: 'text-center',
                    orderable: false,
                    render: function(data, type, row) {
                        return `<div class="btn-group">
                                    <a href="{{ route('admin.app-configs.detail') }}/?id=${row.id}" class="btn btn-icon btn-outline-info"><i class="fas fa-edit"></i></a>
                                </div>`;
                    }
                },
                {
                    data: 'key',
                    name: 'key',
                },
                {
                    data: 'value',
                    name: 'value',
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'updated_at',
                    name: 'updated_at',
                },
            ],
        });
    });
    </script>
@endpush