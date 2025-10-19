@extends('_layouts.app-layouts.index')

@section('content')
<div class="row">
    <div class="col-md-4 mx-auto">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Konfirmasi Pembayaran Daftar Ulang</h5>
                </div>
                <div class="m-t-30">
                    @if(!request()->psb_reregister)
                    <form action="{{ route('student.new.daftar-ulang.upload-bukti.action') }}" method="POST" enctype="multipart/form-data" onsubmit="return processDataWithLoading(this);">
                        @csrf
                        <div class="form-group">
                            <label for="">Slip / Bukti Transfer (Max 1 Mb)</label>
                            <div class="custom-file">
                                <input type="file" class="form-control @error('paid_verification_file') is-invalid @enderror" id="paid_verification_file" name="paid_verification_file" accept=".jpg, .jpeg" required>
                            </div>
                            @error('paid_verification_file')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="paid_via">Transfer Via</label>
                            <input type="text" class="form-control @error('paid_via') is-invalid @enderror" id="paid_via" name="paid_via" placeholder="Ex : BSI / Bank Aceh / Dana / GoPay" required>
                            @error('paid_via')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="paid_amount">Jumlah Transfer</label>
                            <input type="number" class="form-control @error('paid_amount') is-invalid @enderror" id="paid_amount" name="paid_amount" required>
                            @error('paid_amount')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm" id="btn-process">Konfirmasi</button>
                    </form>
                    @elseif(request()->psb_reregister)
                    <div class="alert alert-primary">
                        <div class="d-flex justify-content-start">
                            <span class="alert-icon m-r-20 font-size-30">
                                <i class="anticon anticon-info-circle"></i>
                            </span>
                            <div>
                                <h5 class="alert-heading">Upload Berhasil</h5>
                                <p class="m-b-10">Bukti Transfer Anda Telah Berhasil dikirimkan ke Panitia, Harap Bapak/Ibu Dapat Menunggu Proses Konfirmasi.
                                    Untuk Melanjutkan Proses Pendaftaran, Silahkan Bapak/Ibu Cek Secara Berkala di Akun Masing-Masing.</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

@endsection