@extends('_layouts.app-layouts.index')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Cari Data Siswa</h5>
            </div>
            <div class="card-body">
                @if (\Session::has('token'))
                    <div class="alert alert-success mt-2">
                        <strong>Perizinan Berhasil di buat!</strong>
                        <br>Token Izin : <b>{{ \Session::get('token') }}</b>
                    </div>
                @endif  
                <form action="{{ route('staff.perizinan.handle.create') }}" method="POST" onsubmit="return processData(this)">
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
                            <label for="reason">Alasan atau tujuan</label>
                            <input type="text" class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" placeholder="Alasan atau tujuan izin" required>
                            @error('reason')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="pickup_by">Di jemput oleh</label>
                            <input type="text" class="form-control @error('pickup_by') is-invalid @enderror" id="pickup_by" name="pickup_by" required>
                            @error('pickup_by')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="from_date">Dari Tanggal & Jam</label>
                            <input type="datetime-local" class="form-control @error('from_date') is-invalid @enderror" id="from_date" name="from_date" required>
                            @error('from_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="to_date">Hingga Tanggal & Jam</label>
                            <input type="datetime-local" class="form-control @error('to_date') is-invalid @enderror" id="to_date" name="to_date" required>
                            @error('to_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="requested_by">Permohonan Oleh</label>
                            <select class="form-control @error('requested_by') is-invalid @enderror" id="requested_by" name="requested_by" required>
                                <option value="">Pilih</option>
                                <option value="siswa">Siswa</option>
                                <option value="wali">Wali</option>
                                <option value="orang_tua">Orang Tua</option>
                            </select>
                            @error('requested_by')
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
                <h5>Riwayat Izin</h5>
                <form action="{{ route('staff.perizinan.laporan.handle') }}" method="POST" onsubmit="processData(this);" id="form-report" class="d-none">
                    @csrf
                    <input type="hidden" class="form-control" id="report_by" name="report_by" value="nis_nisn" required>
                    <input type="hidden" class="form-control" id="id_siswa" name="id_siswa" value="" required>
                    <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-print"></i> Cetak Laporan</button>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm" id="dataTable" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Status</th>
                                <th>Alasan</th>
                                <th>Di Jemput Oleh</th>
                                <th>Dari Tanggal</th>
                                <th>Hingga Tanggal</th>
                                <th>Keluar Tanggal</th>
                                <th>Kembali Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/plugins/select2.full.min.js') }}"></script>
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
                    url: '{{ route("staff.perizinan.search") }}',
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

                            var tableBody = $('#dataTable tbody');
                            tableBody.empty();

                            $.each(response.data.student_permission_history, function(index, izin) {
                                var status = '';
                                if (izin.status == 'approved') {
                                    status = '<span class="badge badge-pill bg-success">Disetujui</span>';
                                } else if (izin.status == 'rejected') {
                                    status = '<span class="badge badge-pill bg-danger">Ditolak</span>';
                                } else if (izin.status == 'canceled') {
                                    status = '<span class="badge badge-pill bg-warning">Dibatalkan</span>';
                                } else if (izin.status == 'requested') {
                                    status = '<span class="badge badge-pill bg-secondary">Permohonan</span>';
                                } else if (izin.status == 'check_out') {
                                    status = '<span class="badge badge-pill bg-secondary">Sudah Keluar</span>';
                                } else if (izin.status == 'check_in') {
                                    status = '<span class="badge badge-pill bg-secondary">Sudah Kembali</span>';
                                }
                                tableBody.append(`
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${status}</td>
                                        <td>${izin.reason}</td>
                                        <td>${izin.pickup_by}</td>
                                        <td>${izin.from_date}</td>
                                        <td>${izin.to_date}</td>
                                        <td>${izin.checked_out_at ?? '-'}</td>
                                        <td>${izin.checked_in_at ?? '-'}</td>
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
    </script>
@endpush