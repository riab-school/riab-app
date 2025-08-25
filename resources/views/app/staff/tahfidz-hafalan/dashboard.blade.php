@extends('_layouts.app-layouts.index')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card table-card widget-primary-card bg-c-blue">
            <div class="row-table">
                <div class="col-4 card-body-big">
                    <h4 id="over_5">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </h4>
                </div>
                <div class="col-8">
                    <h6>Diatas 5 juz</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card table-card widget-primary-card bg-c-green">
            <div class="row-table">
                <div class="col-4 card-body-big">
                    <h4 id="over_10">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </h4>
                </div>
                <div class="col-8">
                    <h6>Diatas 10 Juz</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card table-card widget-primary-card bg-c-red">
            <div class="row-table">
                <div class="col-4 card-body-big">
                    <h4 id="over_20_under_30">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </h4>
                </div>
                <div class="col-8">
                    <h6>Di Atas 20 Juz</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card table-card widget-primary-card bg-c-yellow">
            <div class="row-table">
                <div class="col-4 card-body-big">
                    <h4 id="30_juz">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </h4>
                </div>
                <div class="col-8">
                    <h6>30 Juz</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card" id="chart-container">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Grafik Jumlah Siswa per Juz</h5>
    </div>
    <div class="card-body">
        <canvas id="chart-bar-1" style="width: 100%; height: 300px"></canvas>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/chart-chartjs/js/Chart.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $.get("{{ route('staff.tahfidz.dashboard.card') }}", function(data){
                $.each(data,function(key,value){
                    $('#'+key).html(value);
                })
            });

            $.ajax({
                url: "{{ route('staff.tahfidz.dashboard.chart-1') }}",
                type: 'GET',
                success: function (response) {
                    renderChart1(response);
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });

        function renderChart1(res) {
            const data = res;

            const labels = data.map(v => `Juz ${v.juz}`);
            const values = data.map(v => parseFloat(v.student_count.toFixed(2))); // optional rounding

            const ctx = document.getElementById('chart-bar-1').getContext('2d');

            const backgroundColors = [
                '#4BC0C0', '#FF9F40', '#F7464A', 
                '#4D5360', '#BDBDBD', '#19BCBF', 
                '#46BFBD', '#FDB45C', '#949FB1', 
                '#FF6384', '#36A2EB', '#FFCE56',
                '#7D3C98', '#E74C3C', '#2ECC71',
                '#3498DB', '#9B59B6', '#F1C40F',
                '#E67E22', '#1ABC9C', '#34495E',
                '#2C3E50', '#8E44AD', '#D35400',
                '#C0392B', '#27AE60', '#2980B9',
                '#8E44AD', '#F39C12', '#2ECC71'
            ];

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Persentase Hafalan per Juz',
                        data: values,
                        backgroundColor: labels.map((_, i) => backgroundColors[i % backgroundColors.length]),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            title: {
                                display: true,
                                text: '%'
                            }
                        }
                    }
                }
            });
        }
    </script>
@endpush