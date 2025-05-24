@extends('_layouts.mobile-layouts.index')

@section('title', 'Dokumen & Berkas Siswa')

@section('content')
    <div class="d-flex flex-column py-3 gap-2">
        @if(empty($data))
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="horizontal-product-card">
                        <div class="d-flex flex-column align-items-center justify-content-center text-center py-5">
                            <h1><i class="fas fa-cog fa-bounce" style="--fa-bounce-land-scale-x: 1.2;--fa-bounce-land-scale-y: .8;--fa-bounce-rebound: 5px;"></i></h1>
                            <h5>Dokumen tidak ditemukan</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" width="100%">
                            <tbody>
                                <tr>
                                    <td>Pas Photo</td>
                                    <td class="text-end">
                                        @if($data && $data->photo !== NULL)
                                            <a href="{{ Storage::disk('s3')->url($data->photo) }}" class="btn btn-sm btn-primary" download>Download</a>
                                        @else
                                            Belum Tersedia
                                        @endif
                                    </td>
                                </tr>                            
                                <tr>
                                    <td>KTP</td>
                                    <td class="text-end">
                                        @if($data && $data->ktp_file !== NULL)
                                            <a href="{{ Storage::disk('s3')->url($data->ktp_file) }}" class="btn btn-sm btn-primary" download>Download</a>
                                        @else
                                            Belum Tersedia
                                        @endif
                                    </td>
                                </tr>                            
                                <tr>
                                    <td>Kartu Keluarga</td>
                                    <td class="text-end">
                                        @if($data && $data->kk_file !== NULL)
                                            <a href="{{ Storage::disk('s3')->url($data->kk_file) }}" class="btn btn-sm btn-primary" download>Download</a>
                                        @else
                                            Belum Tersedia
                                        @endif
                                    </td>
                                </tr>                            
                                <tr>
                                    <td>Akte Kelahiran</td>
                                    <td class="text-end">
                                        @if($data && $data->akte_file !== NULL)
                                            <a href="{{ Storage::disk('s3')->url($data->akte_file) }}" class="btn btn-sm btn-primary" download>Download</a>
                                        @else
                                            Belum Tersedia
                                        @endif
                                    </td>
                                </tr>                            
                                <tr>
                                    <td>Kartu BPJS</td>
                                    <td class="text-end">
                                        @if($data && $data->bpjs !== NULL)
                                            <a href="{{ Storage::disk('s3')->url($data->bpjs) }}" class="btn btn-sm btn-primary" download>Download</a>
                                        @else
                                            Belum Tersedia
                                        @endif
                                    </td>
                                </tr>                            
                                <tr>
                                    <td>Kartu Indonesia Sehat</td>
                                    <td class="text-end">
                                        @if($data && $data->kis !== NULL)
                                            <a href="{{ Storage::disk('s3')->url($data->kis) }}" class="btn btn-sm btn-primary" download>Download</a>
                                        @else
                                            Belum Tersedia
                                        @endif
                                    </td>
                                </tr>                            
                                <tr>
                                    <td>Kartu Indonesia Pintar</td>
                                    <td class="text-end">
                                        @if($data && $data->kip !== NULL)
                                            <a href="{{ Storage::disk('s3')->url($data->kip) }}" class="btn btn-sm btn-primary" download>Download</a>
                                        @else
                                            Belum Tersedia
                                        @endif
                                    </td>
                                </tr>                            
                                <tr>
                                    <td>Surat Peresetujuan Membiayai</td>
                                    <td class="text-end">
                                        @if($data && $data->letter_of_promise_to_financing !== NULL)
                                            <a href="{{ Storage::disk('s3')->url($data->letter_of_promise_to_financing) }}" class="btn btn-sm btn-primary" download>Download</a>
                                        @else
                                            Belum Tersedia
                                        @endif
                                    </td>
                                </tr>                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
        @endif   
    </div>
@endsection