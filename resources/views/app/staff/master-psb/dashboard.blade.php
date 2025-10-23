@extends('_layouts.app-layouts.index')

@section('content')
    <p class="lead">Undangan</p>
    
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-blue">
                            <i class="anticon anticon-user"></i>
                        </div>
                        <div class="m-l-15">
                            <h2 class="m-b-0">{{ $undangan_mipa_pria }}</h2>
                            <p class="m-b-0 text-muted"><b>MIPA</b> - Pria</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-blue">
                            <i class="anticon anticon-user"></i>
                        </div>
                        <div class="m-l-15">
                            <h2 class="m-b-0">{{ $undangan_mipa_wanita }}</h2>
                            <p class="m-b-0 text-muted"><b>MIPA</b> - Wanita</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-green">
                            <i class="anticon anticon-user"></i>
                        </div>
                        <div class="m-l-15">
                            <h2 class="m-b-0">{{ $undangan_mak_pria }}</h2>
                            <p class="m-b-0 text-muted"><b>MAK</b> - Pria</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-green">
                            <i class="anticon anticon-user"></i>
                        </div>
                        <div class="m-l-15">
                            <h2 class="m-b-0">{{ $undangan_mak_wanita }}</h2>
                            <p class="m-b-0 text-muted"><b>MAK</b> - Wanita</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-cyan">
                            <i class="anticon anticon-user"></i>
                        </div>
                        <div class="m-l-15">
                            <h2 class="m-b-0">{{ $undangan_ipa }}</h2>
                            <p class="m-b-0 text-muted"><b>TOTAL</b> IPA</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-cyan">
                            <i class="anticon anticon-user"></i>
                        </div>
                        <div class="m-l-15">
                            <h2 class="m-b-0">{{ $undangan_mak }}</h2>
                            <p class="m-b-0 text-muted"><b>TOTAL</b> - MAK</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-cyan">
                            <i class="anticon anticon-user"></i>
                        </div>
                        <div class="m-l-15">
                            <h2 class="m-b-0">{{ $undangan }}</h2>
                            <p class="m-b-0 text-muted"><b>TOTAL</b> - ALL</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-cyan">
                            <i class="anticon anticon-user"></i>
                        </div>
                        <div class="m-l-15">
                            <h2 class="m-b-0">{{ $undangan_pindah }}</h2>
                            <p class="m-b-0 text-muted"><b>TOTAL</b> - PINDAH - REGULER</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5>Grafik Per Kota / Kabupaten</h5>
                    <div style="width: 100%; margin: auto;">
                        <canvas id="undanganChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <p class="lead">Reguler</p>
    
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-red">
                            <i class="anticon anticon-user"></i>
                        </div>
                        <div class="m-l-15">
                            <h2 class="m-b-0">{{ $reguler_mipa_pria }}</h2>
                            <p class="m-b-0 text-muted"><b>MIPA</b> - Pria</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-red">
                            <i class="anticon anticon-user"></i>
                        </div>
                        <div class="m-l-15">
                            <h2 class="m-b-0">{{ $reguler_mipa_wanita }}</h2>
                            <p class="m-b-0 text-muted"><b>MIPA</b> - Wanita</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-blue">
                            <i class="anticon anticon-user"></i>
                        </div>
                        <div class="m-l-15">
                            <h2 class="m-b-0">{{ $reguler_mak_pria }}</h2>
                            <p class="m-b-0 text-muted"><b>MAK</b> - Pria</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-blue">
                            <i class="anticon anticon-user"></i>
                        </div>
                        <div class="m-l-15">
                            <h2 class="m-b-0">{{ $reguler_mak_wanita }}</h2>
                            <p class="m-b-0 text-muted"><b>MAK</b> - Wanita</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-blue">
                            <i class="anticon anticon-calendar"></i>
                        </div>
                        <div class="m-l-15">
                            <h2 class="m-b-0">{{ $reguler_by_day_ujian['day_1'] }}</h2>
                            <p class="m-b-0 text-muted">Peserta Ujian <b>03 Jan 2026</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-blue">
                            <i class="anticon anticon-calendar"></i>
                        </div>
                        <div class="m-l-15">
                            <h2 class="m-b-0">{{ $reguler_by_day_ujian['day_2'] }}</h2>
                            <p class="m-b-0 text-muted">Peserta Ujian <b>04 Jan 2026</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-blue">
                            <i class="anticon anticon-calendar"></i>
                        </div>
                        <div class="m-l-15">
                            <h2 class="m-b-0">{{ $reguler_by_day_ujian['day_3'] }}</h2>
                            <p class="m-b-0 text-muted">Peserta Ujian <b>05 Jan 2026</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5>Grafik Per Kota / Kabupaten</h5>
                    <div style="width: 100%; margin: auto;">
                        <canvas id="regulerChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/chart-chartjs/js/Chart.min.js') }}"></script>
<script>
    const ctx1 = document.getElementById('undanganChart').getContext('2d');

    // Data from PHP
    const labelsUdg = @json($undangan_by_kota->keys()->toArray());
    const dataValuesUdg = @json($undangan_by_kota->values()->toArray());
    // Create Chart
    new Chart(ctx1, {
        type: 'bar', // You can change this to 'pie', 'line', etc.
        data: {
            labels: labelsUdg,
            datasets: [{
                label: 'Jumlah Pendaftar Undangan',
                data: dataValuesUdg,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        // format angka agar tanpa desimal
                        callback: function(value) {
                            return Number.isInteger(value) ? value : null;
                        }
                    }
                }
            }
        }
    });
</script>
<script>
    const ctx2 = document.getElementById('regulerChart').getContext('2d');

    // Data from PHP
    const labelsReg = @json($reguler_by_kota->keys()->toArray());
    const dataValuesReg = @json($reguler_by_kota->values()->toArray());
    // Create Chart
    new Chart(ctx2, {
        type: 'bar', // You can change this to 'pie', 'line', etc.
        data: {
            labels: labelsReg,
            datasets: [{
                label: 'Jumlah Pendaftar Reguler',
                data: dataValuesReg,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        // format angka agar tanpa desimal
                        callback: function(value) {
                            return Number.isInteger(value) ? value : null;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush