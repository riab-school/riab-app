@extends('_layouts.app-layouts.index')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-b-20">Total User</h6>
                                <h3 class="text-dark" id="totalUsers">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </h3>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users bg-c-blue"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-b-20">App Log</h6>
                                <h3 class="text-dark" id="totalLogs">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </h3>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-list bg-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-b-20">Total Classrooms</h6>
                                <h3 class=text-dark" id="totalClassrooms">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </h3>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chalkboard-teacher bg-c-blue"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-b-20">Total Dormitory</h6>
                                <h3 class=text-dark" id="totalDormitories">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </h3>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-bed bg-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-b-20">Whatsapp Log</h6>
                                <h3 class="text-dark" id="whatsappLog">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </h3>
                            </div>
                            <div class="col-auto">
                                <i class="fab fa-whatsapp bg-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-b-20">Whatsapp API</h6>
                                <h3 class="text-dark" id="whatsappStatus">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </h3>
                            </div>
                            <div class="col-auto text-end">
                                <h6 class="m-b-20">Device Status</h6>
                                <h3 class="text-dark" id="deviceStatus">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Recent Activity</h5>
                <a href="{{ route('admin.app-logs') }}" class="btn btn-outline-primary btn-sm m-0">
                    <i class="feather icon-arrow-left"></i>
                    Selengkapnya
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-sm table-hover" width="100%">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Code</th>
                                <th>Description</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $.get("{{ url()->current() }}", function(data){
                $.each(data,function(key,value){
                    $('#'+key).html(value);
                })
            });

        var table = $('#dataTable').DataTable({
            searching: false,
            pageLength: 5,
            lengthChange: false,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('admin.app-logs') }}",
            drawCallback: function() {
                $('.pagination').addClass('pagination-sm');
            },
            columns: [
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
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                },
            ]
        });

        $('#resetForm').on('click', function(){
            table.search('').draw();
        });
    });
    </script>
@endpush