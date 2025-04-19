@extends('_layouts.auth-layouts.index')

@section('content')

<h4 class="mb-3 f-w-400">Masuk ke akun anda</h4>
<form action="{{ route('login.action') }}" method="POST" onsubmit="return processDataWithLoading(this)">
    @csrf
    <div class="form-group mb-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" required>
        @error('username')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary mb-4 btf">Login</button>
</form>
<p class="mb-2 text-muted">Lupa password? <a href="{{ route('forgot-password') }}" class="f-w-400">Reset</a></p>
@endsection