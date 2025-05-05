@extends('_layouts.app-layouts.index')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Menu and Permission</h5>
        <div>
            <a href="{{ route('admin.manage-menu.parent') }}" class="btn btn-outline-primary btn-sm m-0">
                <i class="feather icon-plus"></i>
                Create Parent Menu
            </a>
            <a href="{{ route('admin.manage-menu.permission') }}" class="btn btn-outline-warning btn-sm m-0">
                <i class="fas fa-key"></i>
                Set All Permission
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive dt-responsive">
            <table id="dataTable" class="table table-bordered table-sm nowrap compact" width="100%">
                <thead>
                    <tr>
                        <th class="text-center">Action</th>
                        <th>Menu Parent Name</th>
                        <th>Menu Child Content</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menus->sortBy('order') as $item)
                    <tr>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('admin.manage-menu.parent') }}?id={{ $item->id }}" type="button" class="btn btn-icon btn-outline-info"><i class="fas fa-edit"></i></a>
                                <button id="setParentMenuStatusButton" data-id="{{ $item->id }}" class="btn btn-icon btn-outline-{{ $item->is_active ? 'danger' : 'success' }}"><i class="fas fa-power-off"></i></button>
                                <button id="deleteParentMenuButton" data-id="{{ $item->id }}" class="btn btn-icon btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                        <td>
                            <h5><i class="{{ $item->icon }}"></i> {{ $item->title }}</h5>
                            <div>Level : {{ $item->level }}</div>
                            <div>{!! $item->is_active ? '<span class="badge badge-light-success">Aktif</span>' : '<span class="badge badge-light-danger">Tidak Aktif</span>' !!}</div>
                        </td>
                        <td>
                            <a href="{{ route('admin.manage-menu.child') }}?parent_id={{ $item->id }}" class="btn btn-outline-primary btn-sm">
                                <i class="feather icon-plus"></i>
                                Create Child Menu
                            </a>
                            <a href="{{ route('admin.manage-menu.permission') }}?menu_id={{ $item->id }}" class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-key"></i>
                                Set Bulk Permission
                            </a>
                            @if ($item->children)
                            <div class="table-responsive dt-responsive">
                                <table class="table table-bordered table-sm nowrap compact" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Action</td>
                                            <th>Order</td>
                                            <th>Menu Child Name</th>
                                            <th>Has Access</td>
                                            <th>Route</td>
                                            <th>Status</th>    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($item->children->sortBy('order') as $child)
                                            <tr>
                                                <td class="w-25 text-center">
                                                    <div class="btn-group">
                                                        <a href="{{ route('admin.manage-menu.child') }}?parent_id={{ $item->id }}&id={{ $child->id }}" type="button" class="btn btn-icon btn-outline-info"><i class="fas fa-edit"></i></a>
                                                        <a href="{{ route('admin.manage-menu.permission') }}?child_id={{ $child->id }}" type="button" class="btn btn-icon btn-outline-warning"><i class="fas fa-key"></i></a>
                                                        <button id="setChildMenuStatusButton" data-id="{{ $child->id }}" class="btn btn-icon btn-outline-{{ $child->is_active ? 'danger' : 'success' }}"><i class="fas fa-power-off"></i></button>
                                                        <button id="deleteChildMenuButton" data-id="{{ $child->id }}" class="btn btn-icon btn-outline-danger"><i class="fas fa-trash"></i></button>
                                                    </div>
                                                </td>
                                                <td>{{ $child->order }}</td>
                                                <td>
                                                    <div class="fw-bold">{{ $child->title }}</div>
                                                </td>
                                                <td>{{ $child->hasAccess->count() }} User</td>
                                                <td class="w-25">{{ $child->route }}</td>
                                                <td>
                                                    <div>{!! $child->is_active ? '<span class="badge badge-light-success">Aktif</span>' : '<span class="badge badge-light-danger">Tidak Aktif</span>' !!}</div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No Child Menu Found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </td>
                    </tr>    
                    @endforeach
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
                "lengthMenu": [ [2, 5, 15, 50, -1], [2, 5, 15, 50, "All"] ],
                processing: true,
                serverSide: false,
                responsive: true,
                drawCallback: function() {
                    $('.pagination').addClass('pagination-sm');
                },
            });
        });

        // Set Parent Menu Status
        $(document).on('click', '#setParentMenuStatusButton', function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('admin.manage-menu.set-status') }}",
                type: 'POST',
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

        // Delete Parent Menu 
        $(document).on('click', '#deleteParentMenuButton', function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('admin.manage-menu.delete') }}",
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

        $(document).on('click', '#setChildMenuStatusButton', function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('admin.manage-menu.child.set-status') }}",
                type: 'POST',
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

        $(document).on('click', '#deleteChildMenuButton', function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('admin.manage-menu.child.delete') }}",
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