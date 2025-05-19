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
            <div class="card-header row justify-content-between align-items-center">
                <div class="col-8">
                    <h5>Grafik Perizinan Per Bulan</h5>
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
                <canvas id="chart-bar-1" style="width: 100%; height: 400px"></canvas>
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
                data: { chart_years: chartYears },
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
        }

        function renderTableOut(data, id, count) {
            let html = '';
            if (data.length === 0) {
                html = `<tr><td colspan="3" class="text-center">Tidak ada data</td></tr>`;
            }
            data.forEach(function(item) {
                const student = item.detail.student_detail;
                const photoUrl = student.photo_url;
                
                html += `
                    <tr>
                        <td>
                            <img class="img-preview" style="width:40px; cursor:pointer;" src="${photoUrl}" data-src="${photoUrl}" alt="activity-user">
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
                            <img class="img-preview" style="width:40px; cursor:pointer;" src="${photoUrl}" data-src="${photoUrl}" alt="activity-user">
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

        function renderChartPermission(res) {
            const yearInput = document.getElementById("filter-year");
            const currentYear = yearInput ? parseInt(yearInput.value) : new Date().getFullYear();

            const monthLabels = Array.from({ length: 12 }, (_, i) => 
                new Date(0, i).toLocaleString('default', { month: 'long' })
            );

            // Peta kategori dengan label dan warna
            const categoryMap = {
                siswa: { label: 'Siswa', color: '#36A2EB' },
                orang_tua: { label: 'Orang Tua', color: '#FF6384' },
                wali: { label: 'Wali', color: '#FFCE56' },
                staff_kesehatan: { label: 'Staff Kesehatan', color: '#4BC0C0' }
            };

            // Siapkan datasets dengan label dan warna
            const datasets = Object.entries(categoryMap).map(([key, value]) => ({
                label: value.label,
                data: Array(12).fill(0),
                backgroundColor: value.color
            }));

            // Dataset untuk total bulanan
            const totalDataset = {
                label: 'Total',
                data: Array(12).fill(0),
                backgroundColor: '#6c757d' // warna abu-abu gelap
            };

            // Masukkan data ke masing-masing dataset
            res.forEach(item => {
                if (item.year === currentYear) {
                    const monthIndex = item.month - 1;
                    const label = categoryMap[item.requested_by]?.label;
                    const dataset = datasets.find(d => d.label === label);
                    if (dataset) {
                        dataset.data[monthIndex] = item.total;
                        totalDataset.data[monthIndex] += item.total; // Tambahkan ke total bulanan
                    }
                }
            });

            // Render chart
            const ctx = document.getElementById('chart-bar-1').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: monthLabels,
                    datasets: [...datasets, totalDataset]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: { stacked: false },
                        y: { beginAtZero: true, stacked: false }
                    }
                }
            });
        }
    </script>
@endpush