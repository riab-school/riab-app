@extends('_layouts.app-layouts.index')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Update User</h5>
                <a href="{{ route('admin.manage-users') }}" class="btn btn-outline-danger btn-sm m-0">
                    <i class="feather icon-chevron-left"></i>
                    Back
                </a>
                <div class="card-header-right">
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.manage-users.update') }}" method="POST" onsubmit="return processData(this)">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <div class="form-group mb-3">
                        <label class="form-label">Enter Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ $user->username }}" required>
                        @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Enter Fullname</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $detail->name }}" required>
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Select User Level</label>
                        <select class="form-control @error('user_level') is-invalid @enderror" name="user_level" id="user_level" value="" required>
                            <option value="admin" {{ $user->user_level == 'admin' ? 'selected' : ''  }}>Admin</option>
                            <option value="staff" {{ $user->user_level == 'staff' ? 'selected' : ''  }}>Staff</option>
                            <option value="parent" {{ $user->user_level == 'parent' ? 'selected' : ''  }}>Parent</option>
                            <option value="student" {{ $user->user_level == 'student' ? 'selected' : ''  }}>Student</option>
                        </select>
                        @error('user_level')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mb-4 btf">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection