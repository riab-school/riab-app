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
                    <h6>Total Keluhan</h6>
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
                    <h6>Bulan Ini</h6>
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
                    <h6>Minggu Ini</h6>
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
                <div class="col-8">
                    <h5>Grafik Pesakit Per Bulan</h5>
                </div>
                <div class="col-4">
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

@push('scripts')
    <script src="{{ asset('assets/plugins/chart-chartjs/js/Chart.min.js') }}"></script>
    <script>

        $(document).ready(function() {
            getData();
        });

        function getData(chartYears){
            $.ajax({
                url: "{{ url()->current() }}",
                type: "GET",
                dataType: "json",
                data: {
                    chart_years: chartYears
                },
                success: function(res) {
                    $('#total_patient_count').html(res.data.total_patient_count);
                    $('#month_patient_count').html(res.data.month_patient_count);
                    $('#week_patient_count').html(res.data.week_patient_count);
                    $('#day_patient_count').html(res.data.day_patient_count);
                    renderTable(res.data.top_patient_count, '#top_patient_data');
                    renderTable(res.data.top_month_patient, '#top_month_patient_data');
                    renderChartPatient(res.data.chart_patient);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        }

        function renderTable(data, id) {
            let html = '';
            if (data.length === 0) {
                html = `<tr><td colspan="3" class="text-center">Tidak ada data</td></tr>`;
            }
            data.forEach(function(item) {
                const student = item.user_detail.student_detail;
                const photoUrl = student.photo_url;
                html += `
                    <tr>
                        <td>
                            <img class="img-preview" style="width:40px; cursor:pointer;" src="${photoUrl}" data-src="${photoUrl}" alt="activity-user">
                        </td>
                        <td>
                            <h6 class="mb-1">${student.name}</h6>
                            <div>NISN : <span class="text-c-green">${student.nisn}</span> | NIS : <span class="text-c-green">${student.nis}</span></div>
                        </td>
                        <td>
                            <h6 class="mb-1">${item.total} Keluhan</h6>
                        </td>
                    </tr>
                `;
            });

            $(id).html(html);
        }

        function renderChartPatient(res){
            const patients = res;

            // Buat daftar semua bulan dalam rentang tahun
            const allMonths = [];
            const currentYear = new Date().getFullYear(); // Tahun saat ini
            for (let i = 0; i < 12; i++) {
                allMonths.push({
                    year: currentYear,
                    month: i + 1, // Januari = 1
                    total: 0 // Default total = 0
                });
            }

            // Warna untuk setiap bulan (sesuaikan warna sesuai kebutuhan)
            const backgroundColors = [
                '#FF6384', '#36A2EB', '#FFCE56', // Januari, Februari, Maret
                '#4BC0C0', '#FF9F40', '#F7464A', // April, Mei, Juni
                '#46BFBD', '#FDB45C', '#949FB1', // Juli, Agustus, September
                '#4D5360', '#BDBDBD', '#19BCBF'  // Oktober, November, Desember
            ];

            // Gabungkan data yang diterima dengan daftar semua bulan
            const mergedData = allMonths.map(monthData => {
                const match = patients.find(v => v.year === monthData.year && v.month === monthData.month);
                return match || monthData;
            });

            // Pisahkan bulan dan total setelah data digabungkan
            const months = mergedData.map(v => 
                new Date(v.year, v.month - 1).toLocaleString('default', { month: 'long' })
            );
            const totals = mergedData.map(v => Math.round(v.total)); // Hapus desimal dengan Math.round

            // Render Chart.js
            const ctx = document.getElementById('chart-bar-1').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Keluhan Per Bulan',
                        data: totals,
                        backgroundColor: mergedData.map((v, i) => backgroundColors[i % backgroundColors.length]),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>
@endpush