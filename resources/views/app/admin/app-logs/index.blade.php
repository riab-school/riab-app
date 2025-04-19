@extends('_layouts.app-layouts.index')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>App Logs</h5>
        <form action="{{ route('admin.app-logs.delete') }}" method="POST" onsubmit="return processData(this)">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">Delete All</button>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTable" class="table table-sm table-hover" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Code</th>
                        <th>IP</th>
                        <th>Description</th>
                        <th>Timestamp</th>
                        <th>User Agent</th>
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
            columnDefs: [
                {
                    targets: 2,
                    width: '5%',
                },
                {
                    targets: 4,
                    width: '25%',
                },
                {
                    targets: 6,
                    width: '10%',
                },
            ],
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'user.username',
                    name: 'user.username',
                },
                {
                    data: 'type',
                    name: 'type',
                    render: function(data, type, row) {
                        switch(row.type){
                            case 'success':
                                return `<span class="badge badge-light-primary">200</span>`;
                            case 'error':
                                return `<span class="badge badge-light-danger">400</span>`;
                            case NULL:
                                return ``;
                        }
                    }
                },
                {
                    data: 'ip',
                    name: 'ip'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'user_agent',
                    name: 'user_agent',
                }
            ]
        });

        $('#resetForm').on('click', function(){
            table.search('').draw();
        });
    });
    </script>
@endpush