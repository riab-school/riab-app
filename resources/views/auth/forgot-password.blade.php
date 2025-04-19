@extends('_layouts.auth-layouts.index')

@section('content')

<h4 class="mb-3 f-w-400">Atur kembali sandi anda</h4>
<form action="{{ route('forgot-password.action') }}" method="POST" onsubmit="return processDataWithLoading(this)">
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
    <button type="submit" class="btn btn-primary mb-4 btf">Kirim Permintaan</button>
</form>

@endsection