@extends('_layouts.app-layouts.index')

@push('styles')
<style>
.td-pre-wrap {
    white-space: pre-wrap;
}
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Cari Data Siswa</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('staff.kesehatan.handle.create') }}" method="POST" onsubmit="return processData(this)" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="nis">NIS / NISN</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="nis_or_nisn" name="nis_or_nisn" placeholder="Masukkan NIS / NISN" required>
                            <button type="button" class="btn btn-primary" id="search-button">
                                <i class="feather icon-search"></i> Cari
                            </button>
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
                            <label for="diagnose">Diagnosa</label>
                            <textarea class="form-control @error('diagnose') is-invalid @enderror" id="diagnose" name="diagnose" rows="3" required></textarea>
                            @error('diagnose')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="treatment">Tindakan / Treatment</label>
                            <textarea class="form-control @error('treatment') is-invalid @enderror" id="treatment" name="treatment" rows="3" required></textarea>
                            @error('treatment')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="drug_given">Obat Yang Diberikan</label>
                            <textarea class="form-control @error('drug_given') is-invalid @enderror" id="drug_given" name="drug_given" rows="3" required></textarea>
                            @error('drug_given')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="note">Catatan Dokter</label>
                            <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note" rows="3"></textarea>
                            @error('note')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="evidence">Bukti / Lampiran Foto<span class="text-danger">(Tidak Wajib)</span></label>
                            <input type="file" class="form-control @error('evidence') is-invalid @enderror" id="evidence" name="evidence" accept="image/*">
                            @error('evidence')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="allow_home" name="allow_home">
                                <label class="form-check-label" for="allow_home">
                                    Izinkan Pulang Ke Rumah ?
                                </label>
                            </div>
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
                <h5>Riwayat Kesehatan</h5>
                <form action="{{ route('staff.kesehatan.laporan.handle') }}" method="POST" onsubmit="processData(this);" id="form-report" class="d-none">
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
                                <th>Diagnosa</th>
                                <th>Treatment</th>
                                <th>Obat diberikan</th>
                                <th>Catatan</th>
                                <th>Diagnosa Oleh</th>
                                <th>Tanggal Rekam</th>
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
    <script>
        $(document).ready(function() {
            $('#search-button').on('click', function() {
                var nisOrNisn = $('#nis_or_nisn').val();
                if (nisOrNisn.length >= 3) {
                    $.ajax({
                        url: '{{ route('staff.kesehatan.search') }}',
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

                                // Populate the table with the user's izin history
                                var tableBody = $('#dataTable tbody');
                                tableBody.empty(); // Clear previous data
                                $.each(response.data.student_medical_check_history, function(index, item) {
                                    tableBody.append(`
                                        <tr>
                                            <td>${index + 1}</td>
                                            <td class="td-pre-wrap">${item.diagnose}</td>
                                            <td class="td-pre-wrap">${item.treatment}</td>
                                            <td class="td-pre-wrap">${item.drug_given}</td>
                                            <td class="td-pre-wrap">${item.note}</td>
                                            <td>${item.diagnozed_by.staff_detail.name}</td>
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
                } else {
                    $('#form-report').addClass('d-none').hide();
                    $('#input-section').hide();
                    showSwal('error', 'Jumlah NIS / NISN yang ada masukkan tidak cukup.');
                }
            });
        });
    </script>
@endpush