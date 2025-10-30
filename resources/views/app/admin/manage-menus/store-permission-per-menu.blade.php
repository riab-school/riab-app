@extends('_layouts.app-layouts.index')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Update or Set Permission
        <div>For Menu : {{ $menu->title }}</div>
        </h5>
        <div class="d-flex gap-2">
            <button class="btn btn-primary btn-sm m-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Set Users</button>
            <a href="{{ route('admin.manage-menu') }}" class="btn btn-outline-danger btn-sm m-0">
                <i class="feather icon-chevron-left"></i>
                Back
            </a>
        </div>
        <div class="card-header-right">
        </div>
    </div>
    <div class="card-body">
        <div class="collapse mb-2" id="collapseExample">
            <form class="row row-cols-md-auto g-3 align-items-center" action="{{ route('admin.manage-menu.permission.save') }}" method="POST" onsubmit="return processData(this)">
                @csrf
                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                <div class="col-md-3">
                    <select class="form-control form-control-sm" id="user_id" name="user_id" required>
                        <option selected="">Pilih User...</option>
                        @foreach ($userList as $item)
                        <option value="{{ $item->id }}">{{ $item->user_level == 'staff' ? $item->staffDetail->name : $item->adminDetail->name }} - {{ $item->username }}</option>    
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <div class="input-group">
                        <div class="input-group-text">From</div>
                        <input type="date" class="form-control form-control-sm" id="permited_start_at" name="permited_start_at" placeholder="Username">
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group">
                        <div class="input-group-text">To</div>
                        <input type="date" class="form-control form-control-sm" id="permited_end_at" name="permited_end_at" placeholder="Username">
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-sm my-0">Save</button>
                </div>
            </form>
            <hr>
        </div>
        <div class="table-responsive dt-responsive">
        </div>
            <table id="dataTable" class="table table-striped table-bordered table-sm nowrap compact" width="100%">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Child Menu</th>
                        <th>Access Time</th>
                        <th>Assigned at</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($permissions as $item)
                    <tr>
                        <td class="text-center">
                            <div class="btn-group">
                                <button id="deletePermission" data-id="{{ $item->id }}" class="btn btn-icon btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                        <td>{{ $item->userDetail->username }}</td>
                        @switch($item->userDetail->user_level)
                            @case('admin')
                            <td>{{ $item->userDetail->adminDetail->name }}</td>
                                @break
                            @case('staff')
                            <td>{{ $item->userDetail->staffDetail->name }}</td>
                                @break
                        @endswitch
                        <td>{{ $item->childMenuDetail->title }}</td>
                        <td>
                            {!! $item->is_permanent_access ? '<span class="badge badge-light-success">Unlimited</span>' : 'From : '.'<div class="fw-bold">'.$item->permited_start_at. '</div> To : <div class="fw-bold">' . $item->permited_end_at . '</div>' !!}
                        </td>
                        <td>{{ $item->assigned_at }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->updated_at }}</td>
                    </tr> 
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            var table = $('#dataTable').DataTable({
                "lengthMenu": [ [50, -1], [50, "All"] ],
                processing: true,
                serverSide: false,
                responsive: true,
                drawCallback: function() {
                    $('.pagination').addClass('pagination-sm');
                },
            });
        });

        $(document).on('click', '#deletePermission', function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('admin.manage-menu.permission.delete') }}",
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: $(this).data('id')
                },
                success: function(response) {
                    showSwal(response.status, response.message);
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            });
        });
    </script>
@endpush