@extends('_layouts.app-layouts.index')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Cari Data Siswa</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('staff.tahfidz.list.create.store') }}" method="POST" onsubmit="return processData(this)" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="nis_or_nisn">NIS / NISN / Nama</label>
                        <div class="input-group">
                            <select class="form-control" id="nis_or_nisn" name="nis_or_nisn" required></select>
                        </div>
                    </div>
                    <div class="d-none" id="input-section">
                        <input type="hidden" class="form-control" id="user_id" name="user_id" required>
                        <div class="form-group">
                            <label for="nama">Nama Siswa</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Nama Siswa" readonly>
                            @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="surah">Surah</label>
                            <select class="form-control" name="surah" id="surah" required>
                                <option>Pilih Surah</option>
                                @foreach (App\Models\MasterAlquran::all() as $surah)
                                    <option value="{{ $surah->nomor_surah }}">({{ $surah->nomor_surah }}) - {{ $surah->nama_surah }}</option>
                                @endforeach
                            </select>
                            @error('surah')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="to_ayat">Ayat</label>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">Dari</span>
                                    <input type="number" class="form-control" placeholder="Dari Ayat" name="from_ayat" id="from_ayat" required>
                                    <span class="input-group-text">Hingga</span>
                                    <input type="number" class="form-control" placeholder="Hingga Ayat" name="to_ayat" id="to_ayat" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="point_tahsin">Poin Tahsin</label>
                            <input type="number" class="form-control @error('point_tahsin') is-invalid @enderror" id="point_tahsin" min="7" max="9" name="point_tahsin" placeholder="Minimal 7 & Maksimal 9" required>
                            @error('point_tahsin')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="point_tahfidz">Poin Tahfidz</label>
                            <input type="number" class="form-control @error('point_tahfidz') is-invalid @enderror" id="point_tahfidz" min="7" max="9" name="point_tahfidz" placeholder="Minimal 7 & Maksimal 9" required>
                            @error('point_tahfidz')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="note">Catatan</label>
                            <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note" rows="3" placeholder="Catatan penguji" required></textarea>
                            @error('note')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="evidence">Bukti Setoran <span class="text-danger">(Tidak Wajib)</span></label>
                            <input type="file" class="form-control @error('evidence') is-invalid @enderror" id="evidence" name="evidence" accept="image/*">
                            @error('evidence')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="notify_parent" name="notify_parent" checked>
                                <label class="form-check-label" for="notify_parent">
                                    Notifikasi ke Orang Tua
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="feather icon-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Riwayat Hafalan</h5>
                {{-- <form action="#" method="POST" onsubmit="processData(this);" id="form-report" class="d-none">
                    @csrf
                    <input type="hidden" class="form-control" id="report_by" name="report_by" value="nis_nisn" required>
                    <input type="hidden" class="form-control" id="id_siswa" name="id_siswa" value="" required>
                    <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-print"></i> Cetak Laporan</button>
                </form> --}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm" id="dataTable" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Juz</th>
                                <th>Surat</th>
                                <th>Ayat</th>
                                <th>Point Tahsin</th>
                                <th>Point Tahfidz</th>
                                <th>Tasmik Oleh</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card d-none" id="chart-container">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Grafik Persentase Capaian Hafalan (%)</h5>
            </div>
            <div class="card-body">
                <canvas id="chart-bar-2" style="width: 100%; height: 300px"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/plugins/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/chart-chartjs/js/Chart.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#nis_or_nisn').select2({
                placeholder: 'Ketik NIS, NISN, atau Nama...',
                ajax: {
                    url: '{{ route("staff.search.student") }}', // route untuk search dropdown
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return { q: params.term };
                    },
                    processResults: function (data) {
                        return {
                            results: data.data.map(function (item) { // akses data.data
                                return {
                                    id: item.nis, // untuk value yang dikirim
                                    text: item.name + ' (' + item.nis + ')'
                                };
                            })
                        };
                    }
                },
                minimumInputLength: 2,
                width: '100%'
            });

            // Ketika user memilih siswa di dropdown
            $('#nis_or_nisn').on('select2:select', function(e) {
                var nisOrNisn = e.params.data.id;

                $.ajax({
                    url: '{{ route("staff.tahfidz.list.serach") }}',
                    type: 'GET',
                    data: { nis_or_nisn: nisOrNisn },
                    success: function(response) {
                        if (response.status) {
                            $('#dataTable').DataTable().destroy();
                            $('#dataTable tbody').empty();
                            showSwal('success', 'Data ditemukan');
                            $('#input-section').removeClass('d-none').show();
                            $('#user_id').val(response.data.user_id);
                            $('#nama').val(response.data.name);

                            $('#id_siswa').val(response.data.nis);
                            $('#report_by').val('nis_nisn');
                            $('#form-report').removeClass('d-none').show();

                            renderChart(response.data.progress);

                            // Populate the table with the user's izin history
                            var tableBody = $('#dataTable tbody');
                            tableBody.empty(); // Clear previous data
                            $.each(response.data.student_tahfidz_history, function(index, item) {
                                tableBody.append(`
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${item.juz}</td>
                                        <td>${item.surah_name}</td>
                                        <td>${item.ayat}</td>
                                        <td>${item.point_tahsin}</td>
                                        <td>${item.point_tahfidz}</td>
                                        <td>${item.process_by}</td>
                                        <td>${item.created_date}</td>
                                    </tr>
                                `);
                            });
                            $('#dataTable').DataTable({
                                destroy: true,
                                paging: true,
                                searching: true,
                                ordering: true,
                                info: true,
                                lengthChange: true,
                                pageLength: 10,
                                drawCallback: function() {
                                    $('.pagination').addClass('pagination-sm');
                                },
                            });
                            $('#dataTable').DataTable().draw();
                            $('#dataTable').DataTable().columns.adjust().responsive.recalc();
                        }
                    },
                    error: function() {
                        $('#form-report').addClass('d-none').hide();
                        $('#dataTable').DataTable().destroy();
                        $('#dataTable tbody').empty();
                        $('#input-section').addClass('d-none').hide();
                        showSwal('error', 'Terjadi kesalahan saat mencari data, atau data tidak ditemukan.');
                    }
                });
            });
        });

        function renderChart(res) {
            $('#chart-container').removeClass('d-none');
            const data = res;

            const labels = data.map(v => `Juz ${v.juz}`);
            const values = data.map(v => parseFloat(v.percent.toFixed(2))); // optional rounding

            const ctx = document.getElementById('chart-bar-2').getContext('2d');

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