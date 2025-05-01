@extends('_layouts.app-layouts.index')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card table-card widget-primary-card bg-c-blue">
            <div class="row-table">
                <div class="col-4 card-body-big">
                    <h4 id="requested_count">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </h4>
                </div>
                <div class="col-8">
                    <p>
                        Permohonan izin oleh
                        <br>
                        Wali atau Staff Kesehatan
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card table-card widget-primary-card bg-c-green">
            <div class="row-table">
                <div class="col-4 card-body-big">
                    <h4 id="approved_count">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </h4>
                </div>
                <div class="col-8">
                    <h6>Di Setujui</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card table-card widget-primary-card bg-c-red">
            <div class="row-table">
                <div class="col-4 card-body-big">
                    <h4 id="rejected_count">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </h4>
                </div>
                <div class="col-8">
                    <h6>Di Tolak</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card table-card widget-primary-card bg-c-yellow">
            <div class="row-table">
                <div class="col-4 card-body-big">
                    <h4 id="cancelled_count">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </h4>
                </div>
                <div class="col-8">
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
                <div id="checkout_count"></div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm table-borderless" id="dataTable" width="100%">
                        <tbody id="checkout_data">
                            
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
                <div id="checkin_count"></div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm table-borderless" id="dataTable" width="100%">
                        <tbody id="checkin_data">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Grafik Perizinan Per Bulan</h5>
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
            $.ajax({
                url: "{{ url()->current() }}",
                type: "GET",
                dataType: "json",
                success: function(res) {
                    $('#requested_count').html(res.data.requested_count);
                    $('#approved_count').html(res.data.approved_count);
                    $('#rejected_count').html(res.data.rejected_count);
                    $('#cancelled_count').html(res.data.cancelled_count);
                    renderTableOut(res.data.checkout_data, '#checkout_data', res.data.checkout_count);
                    renderTableIn(res.data.checkin_data, '#checkin_data', res.data.checkin_count);
                    renderChartPermission(res.data.chart_data);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        });

        function renderTableOut(data, id, count) {
            let html = '';
            if (data.length === 0) {
                html = `<tr><td colspan="3" class="text-center">Tidak ada data</td></tr>`;
            }
            data.forEach(function(item) {
                const student = item.detail.student_detail;
                const photoUrl = student.photo_url 
                    ? student.photo_url 
                    : `https://ui-avatars.com/api/?background=19BCBF&color=fff&name=${encodeURIComponent(student.name)}`;
                
                html += `
                    <tr>
                        <td>
                            <img class="rounded-circle" style="width:40px;" src="${photoUrl}" alt="activity-user">
                        </td>
                        <td>
                            <h6 class="mb-1">${student.name}</h6>
                            <p class="m-0">Alasan : ${item.reason}</p>
                            <span class="text-c-green">${item.from_date}</span> s/d <span class="text-c-green">${item.to_date}</span>
                        </td>
                        <td>
                            <p class="m-0">Izin Ke : ${item.approved_by.staff_detail.name}</p>
                            <p class="m-0">Check Out Oleh : ${item.checked_out_by.staff_detail.name}</p>
                            <p>Status : <span class="text-c-red">${item.status}</span></p>
                        </td>
                    </tr>
                `;
            });

            $(id).html(html);

            if (count > 5) {
                $('#checkout_count').html(`<tr><td colspan="3">5 dari ${count - 5} orang lainnya | Total ${count} orang</td></tr>`);
            }
        }

        function renderTableIn(data, id, count) {
            let html = '';
            if (data.length === 0) {
                html = `<tr><td colspan="3" class="text-center">Tidak ada data</td></tr>`;
            }
            data.forEach(function(item) {
                const student = item.detail.student_detail;
                const photoUrl = student.photo_url 
                    ? student.photo_url 
                    : `https://ui-avatars.com/api/?background=19BCBF&color=fff&name=${encodeURIComponent(student.name)}`;
                
                html += `
                    <tr>
                        <td>
                            <img class="rounded-circle" style="width:40px;" src="${photoUrl}" alt="activity-user">
                        </td>
                        <td>
                            <h6 class="mb-1">${student.name}</h6>
                            <p class="m-0">Alasan : ${item.reason}</p>
                            <span class="text-c-green">${item.from_date}</span> s/d <span class="text-c-green">${item.to_date}</span>
                        </td>
                        <td>
                            <p class="m-0">Izin Ke : ${item.approved_by.staff_detail.name}</p>
                            <p class="m-0">Check In Oleh : ${item.checked_in_by.staff_detail.name}</p>
                            <p>Status : <span class="text-c-green">${item.status}</span></p>
                        </td>
                    </tr>
                `;
            });

            $(id).html(html);

            if (count > 5) {
                $('#checkin_count').html(`<tr><td colspan="3">5 dari ${count - 5} orang lainnya | Total ${count} orang</td></tr>`);
            }
        }

        function renderChartPermission(res){
            const violations = res;

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
                const match = violations.find(v => v.year === monthData.year && v.month === monthData.month);
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
                        label: 'Perizinan Per Bulan',
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