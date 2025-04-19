@extends('_layouts.auth-layouts.index')

@section('content')

<h4 class="f-w-400">Daftarkan akun anda</h4>

@if(date('Y-m-d') >= $psbData->buka_daftar_undangan && date('Y-m-d') <= $psbData->tutup_daftar_undangan)

<span class="badge badge-light-primary mb-3 f-w-400">Jalur Undangan</span>
<form action="{{ route('register.student.action') }}" method="POST" onsubmit="return processDataWithLoading(this)">
    @csrf
    <input type="hidden" name="method" id="method" value="inv">
    <div class="form-group mb-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="NISN/NIK (KTP)" pattern="[0-9]+" title="Hanya boleh angka" required>
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
    <hr>
    <div class="form-group mb-3">
        <label class="form-label">Kode Undangan</label>
        <input type="text" class="form-control @error('invite_code') is-invalid @enderror" id="invite_code" name="invite_code" required>
        @error('invite_code')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary mb-4 btf">Daftar</button>
</form>

@elseif(date('Y-m-d') >= $psbData->buka_daftar_reguler && date('Y-m-d') <= $psbData->tutup_daftar_reguler)

<span class="badge badge-light-warning mb-3 f-w-400">Jalur Reguler</span>
<form action="{{ route('register.student.action') }}" method="POST" onsubmit="return processDataWithLoading(this)">
    @csrf
    <input type="hidden" name="method" id="method" value="reg">
    <div class="form-group mb-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="NISN/NIK (KTP)" required>
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
        <input type="password" class="form-control" id="verify_password" name="verify_password" required>
    </div>
    <button type="submit" class="btn btn-primary mb-4 btf">Login</button>
</form>

@else

<div class="alert alert-danger" role="alert">
    Pendaftaran tidak dapat dilakukan saat ini. Silahkan cek kembali jadwal pendaftaran.
</div>

@endif



<p class="mb-2 text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="f-w-400">Masuk</a></p>
@endsection