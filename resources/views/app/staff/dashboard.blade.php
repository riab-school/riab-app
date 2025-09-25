@extends('_layouts.app-layouts.index')

@section('content')
<div class="row">
    @if(auth()->user()->is_need_to_update_profile)
    <div class="col-12">
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Lengkapi Profil Anda!</h4>
            <p>Anda di haruskan untuk melengkapi beberapa form sebelum melanjutkan menggunakan aplikasi ini. Demi kesinambungan dan sikronisasi data anda dengan database</p>
            <hr/>
            <a href="{{ route('profile') }}" class="btn btn-danger btn-sm">Lengkapi Sekarang</a>
        </div>
    </div>
    @endif
    <div class="col-md-3">
        <div class="card comp-card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-b-20">Siswa Aktif</h6>
                        <h3 class="text-c-user" id="totalStudents">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </h3>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users bg-c-blue"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card comp-card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-b-20">Staff, Guru, atau Ustad</h6>
                        <h3 class="text-c-user" id="totalTeachers">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </h3>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-list bg-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card comp-card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-b-20">Kelas</h6>
                        <h3 class="text-c-user" id="totalClassrooms">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </h3>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chalkboard-teacher bg-secondary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card comp-card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-b-20">Asrama</h6>
                        <h3 class=text-c-user" id="totalDormitories">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </h3>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-bed bg-c-blue"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>
<h5 class="text-center m-auto pb-3">
    Grafik Tahun Ajaran {{ Session::get('tahun_ajaran_aktif')."/".Session::get('tahun_ajaran_aktif')+1 }}
</h5>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Grafik Jenis Kelamin</h5>
                <h6>{{ Session::get('tahun_ajaran_aktif')."/".Session::get('tahun_ajaran_aktif')+1 }}</h6>
            </div>
            <div class="card-body">
                <canvas id="chart-pie-1" style="width: 100%; height: 300px"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Grafik Kelas</h5>
                <h6>{{ Session::get('tahun_ajaran_aktif')."/".Session::get('tahun_ajaran_aktif')+1 }}</h6>
            </div>
            <div class="card-body">
                <canvas id="chart-pie-2" style="width: 100%; height: 300px"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Grafik Pelanggaran</h5>
                <h6>{{ Session::get('tahun_ajaran_aktif')."/".Session::get('tahun_ajaran_aktif')+1 }}</h6>
            </div>
            <div class="card-body">
                <canvas id="chart-bar-1" style="width: 100%; height: 300px"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Grafik Prestasi</h5>
                <h6>{{ Session::get('tahun_ajaran_aktif')."/".Session::get('tahun_ajaran_aktif')+1 }}</h6>
            </div>
            <div class="card-body">
                <canvas id="chart-bar-2" style="width: 100%; height: 300px"></canvas>
            </div>
        </div>
    </div>

    {{-- <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Grafik Hafalan & Tahfidz</h5>
                <h6>{{ Session::get('tahun_ajaran_aktif')."/".Session::get('tahun_ajaran_aktif')+1 }}</h6>
            </div>
            <div class="card-body">
                <canvas id="chart-bar-3" style="width: 100%; height: 300px"></canvas>
            </div>
        </div>
    </div> --}}

    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Grafik Perizinan</h5>
                <h6>{{ Session::get('tahun_ajaran_aktif')."/".Session::get('tahun_ajaran_aktif')+1 }}</h6>
            </div>
            <div class="card-body">
                <canvas id="chart-bar-4" style="width: 100%; height: 300px"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/chart-chartjs/js/Chart.min.js') }}"></script>
    <script>
    $(document).ready(function() {

        $.get("{{ url()->current() }}?for=card_count", function(data){
            $.each(data,function(key,value){
                $('#'+key).html(value);
            })
        });

        $.ajax({
            url: '{{ url()->current() }}',
            type: 'GET',
            data: { for: 'grafik' },
            success: function (response) {
                renderChartViolation(response.studentViolation);
                renderChartAchievement(response.studentAchievement);
                renderChartByGender(response.byGender);
                renderChartByClassroom(response.byClassroom);
                renderChartPermission(response.byPermission);
            },
            error: function (xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    });

    function renderChartByGender(res){
        const byGender = res;
        // Ganti nilai NULL dengan 'N/A' dan pastikan nilai tetap muncul
        const labels = byGender.map(v => v.gender ? v.gender.charAt(0).toUpperCase() + v.gender.slice(1) : 'N/A'); // Capitalize or 'N/A' if null
        const data = byGender.map(v => v.total);

        const ctx = document.getElementById('chart-pie-1').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Pelanggaran by Gender',
                    data: data,
                    backgroundColor: ['#FF6384', '#36A2EB'], // Customize colors as needed
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    }

    function renderChartByClassroom(res) {
        const classroomData = res;
        const grades = classroomData.map(item => item.grade); // X, XI, XII
        const totals = classroomData.map(item => item.total); // Jumlah siswa per grade

        const ctx = document.getElementById('chart-pie-2').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: grades,
                datasets: [{
                    data: totals,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    }

    function renderChartViolation(res){
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
                    label: 'Pelanggaran',
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

    function renderChartAchievement(res){
        const achievement = res;

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
            '#4BC0C0', '#FF9F40', '#F7464A', 
            '#4D5360', '#BDBDBD', '#19BCBF', 
            '#46BFBD', '#FDB45C', '#949FB1', 
            '#FF6384', '#36A2EB', '#FFCE56'
        ];

        // Gabungkan data yang diterima dengan daftar semua bulan
        const mergedData = allMonths.map(monthData => {
            const match = achievement.find(v => v.year === monthData.year && v.month === monthData.month);
            return match || monthData;
        });

        // Pisahkan bulan dan total setelah data digabungkan
        const months = mergedData.map(v => 
            new Date(v.year, v.month - 1).toLocaleString('default', { month: 'long' })
        );
        const totals = mergedData.map(v => Math.round(v.total)); // Hapus desimal dengan Math.round

        // Render Chart.js
        const ctx = document.getElementById('chart-bar-2').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Prestasi',
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

    function renderChartMemorization(res){
        
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
        const ctx = document.getElementById('chart-bar-4').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Perizinan',
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