@extends('_layouts.app-layouts.index')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card table-card widget-primary-card bg-c-blue">
            <div class="row-table">
                <div class="col-4 card-body-big">
                    <i class="feather icon-link"></i>
                </div>
                <div class="col-8">
                    <h4>{{ $requested_count }}</h4>
                    <h6>Permohonan Izin Wali</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card table-card widget-primary-card bg-c-green">
            <div class="row-table">
                <div class="col-4 card-body-big">
                    <i class="feather icon-thumbs-up"></i>
                </div>
                <div class="col-8">
                    <h4>{{ $approved_count }}</h4>
                    <h6>Di Setujui</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card table-card widget-primary-card bg-c-red">
            <div class="row-table">
                <div class="col-4 card-body-big">
                    <i class="feather icon-thumbs-down"></i>
                </div>
                <div class="col-8">
                    <h4>{{ $rejected_count }}</h4>
                    <h6>Di Tolak</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card table-card widget-primary-card bg-c-yellow">
            <div class="row-table">
                <div class="col-4 card-body-big">
                    <i class="feather icon-x"></i>
                </div>
                <div class="col-8">
                    <h4>{{ $cancelled_count }}</h4>
                    <h6>Di Batalkan</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Sudah Check Out</h5>
                @if($checkout_count > 5)
                <div>Dan {{ $checkout_count - 5 }} orang lainnya</div>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm table-borderless" id="dataTable" width="100%">
                        <tbody>
                            @forelse ($checkout_data as $item)
                            <tr>
                                <td>
                                    <img class="rounded-circle" style="width:40px;" src="{{ $item->detail->studentDetail->studentDocument ? Storage::disk('s3')->url($item->detail->studentDetail->studentDocument->photo) : 'https://ui-avatars.com/api/?background=19BCBF&color=fff&name='.$item->detail->studentDetail->name }}" alt="activity-user">
                                </td>
                                <td>
                                    <h6 class="mb-1">{{ $item->detail->studentDetail->name }}</h6>
                                    <p class="m-0">Alasan : {{ $item->reason }}</p>
                                        <span class="text-c-green">{{ dateIndo($item->from_date) }}</span>
                                        s/d
                                        <span class="text-c-green">{{ dateIndo($item->to_date) }}</span>
                                    </p>
                                </td>
                                <td>
                                    <p class="m-0">
                                        Izin Ke : {{ $item->approvedBy->staffDetail->name }}
                                    </p>
                                    <p class="m-0">
                                        Check Out Oleh  : {{ $item->checkedOutBy->staffDetail->name }}
                                    </p>
                                    <p>
                                        Status : <span class="text-c-red">{{ ucwords($item->status) }}</span>
                                    </p>
                                </td>
                                <td>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <center>Tidak ada data</center>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Sudah Check In</h5>
                @if($checkin_count > 5)
                <div>Dan {{ $checkin_count - 5 }} orang lainnya</div>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm table-borderless" id="dataTable" width="100%">
                        <tbody>
                            @forelse ($checkin_data as $item)
                            <tr>
                                <td>
                                    <img class="rounded-circle" style="width:40px;" src="{{ $item->detail->studentDetail->studentDocument ? Storage::disk('s3')->url($item->detail->studentDetail->studentDocument->photo) : 'https://ui-avatars.com/api/?background=19BCBF&color=fff&name='.$item->detail->studentDetail->name }}" alt="activity-user">
                                </td>
                                <td>
                                    <h6 class="mb-1">{{ $item->detail->studentDetail->name }}</h6>
                                    <p class="m-0">Alasan : {{ $item->reason }}</p>
                                        <span class="text-c-green">{{ dateIndo($item->from_date) }}</span>
                                        s/d
                                        <span class="text-c-green">{{ dateIndo($item->to_date) }}</span>
                                    </p>
                                </td>
                                <td>
                                    <p class="m-0">
                                        Izin Ke : {{ $item->approvedBy->staffDetail->name }}
                                    </p>
                                    <p class="m-0">
                                        Check Out Oleh  : {{ $item->checkedInBy->staffDetail->name }}
                                    </p>
                                    <p>
                                        Status : <span class="text-c-green">{{ ucwords($item->status) }}</span>
                                    </p>
                                </td>
                                <td>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <center>Tidak ada data</center>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection