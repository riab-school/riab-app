@extends('_layouts.auth-layouts.index')

@section('content')

<h4 class="f-w-400">Daftarkan akun anda</h4>

<span class="badge badge-light-primary mb-3 f-w-400">Akun Wali Santri</span>
<form action="{{ route('register.parent.action') }}" method="POST" onsubmit="return processDataWithLoading(this)">
    @csrf
    <input type="hidden" name="method" id="method" value="inv">
    <div class="form-group mb-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Username anda" pattern="[a-z0-9]+" title="Hanya boleh huruf kecil dan angka" required>
        @error('username')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nama Lengkap" required>
        @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label class="form-label">Whatsapp Number</label>
        <input type="text" class="form-control @error('whatsapp') is-invalid @enderror" id="whatsapp" name="whatsapp" placeholder="08123xxxxx" required>
        @error('whatsapp')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
        @error('password')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label class="form-label">Verify Password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
    </div>
    <button type="submit" class="btn btn-primary mb-4 btf">Daftar</button>
</form>


<p class="mb-2 text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="f-w-400">Masuk</a></p>
@endsection