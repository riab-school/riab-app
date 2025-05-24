@extends('_layouts.mobile-layouts.index')
@section('title', 'Kartu Siswa')
@section('content')
    <div class="d-flex flex-column py-3 gap-2">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="lead">Kartu Tanda Siswa</div>
                        @if($data && $data->nis_file !== NULL)
                        <a href="{{ Storage::disk('s3')->url($data->nis_file) }}" class="btn btn-primary btn-sm" target="_blank">
                            <i class="fas fa-download"></i> Unduh
                        </a>
                        @endif
                    </div>
                    @if($data && $data->nis_file !== NULL)
                    <div class="horizontal-product-card">
                        <div class="d-flex flex-column align-items-center justify-content-center text-center">
                            <img 
                                src="{{ Storage::disk('s3')->url($data->nis_file) }}"
                                data-src="{{ Storage::disk('s3')->url($data->nis_file) }}"
                                alt="nis_file"
                                class="img-fluid img-preview"
                                style="max-width: 100%; height: auto;">
                        </div>
                    </div>
                    @else
                    <div class="horizontal-product-card">
                        <div class="d-flex flex-column align-items-center justify-content-center text-center py-5">
                            Kartu Siswa Belum Tersedia
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>   
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="lead">Kartu Tanda Siswa Nasional</div>
                        @if($data && $data->nisn_file !== NULL)
                        <a href="{{ Storage::disk('s3')->url($data->nisn_file) }}" class="btn btn-primary btn-sm" target="_blank">
                            <i class="fas fa-download"></i> Unduh
                        </a>
                        @endif
                    </div>
                    @if($data && $data->nisn_file !== NULL)
                    <div class="horizontal-product-card">
                        <div class="d-flex flex-column align-items-center justify-content-center text-center">
                            <img 
                                src="{{ Storage::disk('s3')->url($data->nisn_file) }}"
                                data-src="{{ Storage::disk('s3')->url($data->nisn_file) }}"
                                alt="nisn_file"
                                class="img-fluid img-preview"
                                style="max-width: 100%; height: auto;">
                        </div>
                    </div>
                    @else
                    <div class="horizontal-product-card">
                        <div class="d-flex flex-column align-items-center justify-content-center text-center py-5">
                            Kartu Siswa Nasional Belum Tersedia
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>   
    </div>
@endsection