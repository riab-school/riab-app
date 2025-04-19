@extends('_layouts.app-layouts.index')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>User List</h5>
        <a href="{{ route('admin.manage-users.create') }}" class="btn btn-outline-primary btn-sm m-0">
            <i class="feather icon-plus"></i>
            Create
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive dt-responsive">
            <table id="dataTable" class="table table-striped table-bordered table-sm nowrap compact" width="100%">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>User Level</th>
                        <th>Is Active</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        let actAs = {{ auth()->user()->is_allow_act_as }};
        $(document).ready(function () {
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
                        render: function(data, type, row) {
                            if(actAs == 1){
                                var actAsButton = `<a href="{{ route('admin.manage-users.act-as') }}?id=${row.id}" type="button" class="btn btn-sm btn-outline-warning">Login As</a>`;
                            } else {
                                var actAsButton = '';
                            }
                            if(row.id == "{{ auth()->user()->id }}") {
                                return `<div class="btn-group">
                                    <a href="{{ route('admin.manage-users.detail') }}/?id=${row.id}" class="btn btn-icon btn-outline-info"><i class="fas fa-edit"></i></a>
                                </div>`;
                            } else {
                                return `
                                <div class="btn-group">
                                    <a href="{{ route('admin.manage-users.detail') }}/?id=${row.id}" class="btn btn-icon btn-outline-info"><i class="fas fa-edit"></i></a>
                                    <button type="button" id="setStatusButton" class="btn btn-icon btn-outline-${ row.is_active == 1 ? 'danger' : 'success' }"><i class="fas fa-power-off"></i></button>
                                    ${actAsButton}
                                </div>
                                `;
                            }
                        }
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'full_name',
                        name: 'full_name'
                    },
                    {
                        data: 'user_level',
                        name: 'user_level'
                    },
                    {
                        data: 'is_active',
                        name: 'is_active',
                        render: function(data) {
                            if(data == 1){
                                return `<span class="badge badge-light-success">Aktif</span>`;
                            }else{
                                return `<span class="badge badge-light-danger">Tidak Aktif</span>`;
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
                    },
                ]
            });
        });

        $('#dataTable').on('click', '#setStatusButton', function() {
            var data = $('#dataTable').DataTable().row($(this).parents('tr')).data();
            var status = data.is_active == 1 ? 0 : 1;
            $.ajax({
                url: "{{ route('admin.manage-users.set-status') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: data.id,
                    status: status
                },
                success: function(response) {
                    $('#dataTable').DataTable().ajax.reload();
                }
            });
        });
    </script>
@endpush