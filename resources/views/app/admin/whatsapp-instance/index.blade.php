@extends('_layouts.app-layouts.index')

@push('styles')
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
@endpush

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Chat History</h5>
        <form action="{{ route('admin.whatsapp-intance.delete-history') }}" method="POST" onsubmit="return processData(this)">
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
                        <th>Type</th>
                        <th>Category</th>
                        <th>Phone</th>
                        <th>Name</th>
                        <th>Is Read</th>
                        <th>Response ID</th>
                        <th>Response Status</th>
                        <th>Response Message</th>
                        <th>Process Status</th>
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
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'type',
                    name: 'type',
                    render: function(data, type, row) {
                        switch(data){
                            case 'text':
                                return `<span class="badge badge-light-primary">Text</span>`;
                            case 'image':
                                return `<span class="badge badge-light-danger">Image</span>`;
                            case 'video':
                                return `<span class="badge badge-light-success">Video</span>`;
                            case 'audio':
                                return `<span class="badge badge-light-success">Audio</span>`;
                            case 'document':
                                return `<span class="badge badge-light-success">Document</span>`;
                            case NULL:
                                return ``;
                        }
                    }
                },
                {
                    data: 'category',
                    name: 'category',
                },
                {
                    data: 'phone',
                    name: 'phone',
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'is_read',
                    name: 'is_read',
                    render: function(data, type, row) {
                        switch(data){
                            case 1:
                                return `<span class="badge badge-light-primary">Readed</span>`;
                            case 0:
                                return `<span class="badge badge-light-danger">Unread</span>`;
                        }
                    }
                },
                {
                    data: 'response_id',
                    name: 'response_id',
                },
                {
                    data: 'response_status',
                    name: 'response_status'
                },
                {
                    data: 'response_message',
                    name: 'response_message',
                },
                {
                    data: 'process_status',
                    name: 'process_status',
                    render: function(data, type, row) {
                        switch(data){
                            case 'pending':
                                return `<span class="badge badge-light-warning">Pending</span>`;
                            case 'success':
                                return `<span class="badge badge-light-success">Success</span>`;
                            case 'failed':
                                return `<span class="badge badge-light-danger">Failed</span>`;
                            case NULL:
                                return ``;
                        }
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'updated_at',
                    name: 'updated_at',
                }
            ]
        });
    });
</script>
@endpush