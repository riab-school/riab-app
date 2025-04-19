@extends('_layouts.auth-layouts.index')

@section('content')

<h4 class="mb-3 f-w-400">Atur kembali sandi anda</h4>
<form action="{{ route('reset-password.action') }}" method="POST" onsubmit="return processDataWithLoading(this)">
    @csrf
    <div class="form-group mb-3">
        <label class="form-label">Token Reset Password</label>
        <input type="number" class="form-control @error('token') is-invalid @enderror" id="token" name="token" value="{{ old('token') }}" required>
        @error('token')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label class="form-label">New Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
        @error('password')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label class="form-label">Verify New Password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
    </div>
    <button type="submit" class="btn btn-primary mb-4 btf">Reset Password</button>
</form>

@endsection