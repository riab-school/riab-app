@extends('_layouts.app-layouts.index')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Create User</h5>
                <a href="{{ route('admin.manage-users') }}" class="btn btn-outline-danger btn-sm m-0">
                    <i class="feather icon-chevron-left"></i>
                    Back
                </a>
                <div class="card-header-right">
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.manage-users.save') }}" method="POST" onsubmit="return processData(this)">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label">Enter Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" required>
                        @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Enter Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Enter Fullname</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Select User Level</label>
                        <select class="form-control @error('user_level') is-invalid @enderror" name="user_level" id="user_level" required>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                            <option value="parent">Parent</option>
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