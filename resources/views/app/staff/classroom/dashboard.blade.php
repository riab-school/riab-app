@extends('_layouts.app-layouts.index')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card table-card widget-primary-card bg-c-blue">
            <div class="row-table">
                <div class="col-4 card-body-big">
                    <h4 id="total_patient_count">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </h4>
                </div>
                <div class="col-8">
                    <h6>Total Classrooms</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card table-card widget-primary-card bg-c-green">
            <div class="row-table">
                <div class="col-4 card-body-big">
                    <h4 id="month_patient_count">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </h4>
                </div>
                <div class="col-8">
                    <h6>Total MAK</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card table-card widget-primary-card bg-c-red">
            <div class="row-table">
                <div class="col-4 card-body-big">
                    <h4 id="week_patient_count">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </h4>
                </div>
                <div class="col-8">
                    <h6>Total IPA</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card table-card widget-primary-card bg-c-yellow">
            <div class="row-table">
                <div class="col-4 card-body-big">
                    <h4 id="day_patient_count">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </h4>
                </div>
                <div class="col-8">
                    <h6>Hari Ini</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Top 10 Pesakit Sepanjang Masa</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm table-borderless" id="dataTable" width="100%">
                        <tbody id="top_patient_data">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Top 10 Pesakit Bulan Ini</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm table-borderless" id="dataTable" width="100%">
                        <tbody id="top_month_patient_data">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header row justify-content-between align-items-center">
                <div class="col-10">
                    <h5>Grafik Pesakit Per Bulan</h5>
                </div>
                <div class="col-2">
                    <select id="chart_years" class="form-select" onchange="getData(this.value)">
                        @foreach (App\Models\MasterTahunAjaran::get()->sortBy('tahun_ajaran') as $item)
                        <option value="{{ $item->tahun_ajaran }}" @if($item->tahun_ajaran == now()->year) selected @endif>{{ $item->tahun_ajaran}}</option>    
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-body">
                <canvas id="chart-bar-1" style="width: 100%; height: 350px"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection