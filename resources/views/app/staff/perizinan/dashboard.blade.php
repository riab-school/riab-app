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
            <div class="card-header">
                <h5>Sudah Check Out</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm table-borderless" id="dataTable" width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    <img class="rounded-circle" style="width:40px;" src="assets/images/user/avatar-1.jpg" alt="activity-user">
                                </td>
                                <td>
                                    <h6 class="mb-1">Nama Santri</h6>
                                    <p class="m-0">Alasan Izin
                                        <span class="text-c-green">Lama Hari</span>
                                    </p>
                                </td>
                                <td>Approved By</td>
                                <td><span class="text-c-green"> Status </span>
                                </td>
                                <td>PKD Check</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Sudah Check In</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm table-borderless" id="dataTable" width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    <img class="rounded-circle" style="width:40px;" src="assets/images/user/avatar-1.jpg" alt="activity-user">
                                </td>
                                <td>
                                    <h6 class="mb-1">Nama Santri</h6>
                                    <p class="m-0">Alasan Izin
                                        <span class="text-c-green">Lama Hari</span>
                                    </p>
                                </td>
                                <td>Approved By</td>
                                <td><span class="text-c-green"> Status </span>
                                </td>
                                <td>PKD Check</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection