@extends('_layouts.mobile-layouts.index')

@section('title', 'Raport Dayah')

@section('content')
    <div class="d-flex flex-column py-3 gap-2">
        @if(empty($data))
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="horizontal-product-card">
                        <div class="d-flex flex-column align-items-center justify-content-center text-center py-5">
                            <h1><i class="fas fa-cog fa-bounce" style="--fa-bounce-land-scale-x: 1.2;--fa-bounce-land-scale-y: .8;--fa-bounce-rebound: 5px;"></i></h1>
                            <h5>Data Raport Tidak ditemukan</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="container">
            <div class="card">
                <div class="card-header fw-bold">
                    Riwayat Raport Dayah
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" width="100%">
                            <tbody>
                                <tr>
                                    <td>Kelas X <span class="fw-bold">(SM-1)</span></td>
                                    <td class="text-end">
                                        @if($data && $data->report_dayah_4_1 !== NULL)
                                            <a href="{{ Storage::disk('s3')->url($data->report_dayah_4_1) }}" class="btn btn-sm btn-primary" download>Download</a>
                                        @else
                                            Belum Tersedia
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kelas X <span class="fw-bold">(SM-2)</span></td>
                                    <td class="text-end">
                                        @if($data && $data->report_dayah_4_2 !== NULL)
                                            <a href="{{ Storage::disk('s3')->url($data->report_dayah_4_2) }}" class="btn btn-sm btn-primary" download>Download</a>
                                        @else
                                            Belum Tersedia
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kelas XI <span class="fw-bold">(SM-1)</span></td>
                                    <td class="text-end">
                                        @if($data && $data->report_dayah_5_1 !== NULL)
                                            <a href="{{ Storage::disk('s3')->url($data->report_dayah_5_1) }}" class="btn btn-sm btn-primary" download>Download</a>
                                        @else
                                            Belum Tersedia
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kelas XI <span class="fw-bold">(SM-2)</span></td>
                                    <td class="text-end">
                                        @if($data && $data->report_dayah_5_2 !== NULL)
                                            <a href="{{ Storage::disk('s3')->url($data->report_dayah_5_2) }}" class="btn btn-sm btn-primary" download>Download</a>
                                        @else
                                            Belum Tersedia
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kelas XII <span class="fw-bold">(SM-1)</span></td>
                                    <td class="text-end">
                                        @if($data && $data->report_dayah_6_1 !== NULL)
                                            <a href="{{ Storage::disk('s3')->url($data->report_dayah_6_1) }}" class="btn btn-sm btn-primary" download>Download</a>
                                        @else
                                            Belum Tersedia
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kelas XII <span class="fw-bold">(SM-2)</span></td>
                                    <td class="text-end">
                                        @if($data && $data->report_dayah_6_2 !== NULL)
                                            <a href="{{ Storage::disk('s3')->url($data->report_dayah_6_2) }}" class="btn btn-sm btn-primary" download>Download</a>
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