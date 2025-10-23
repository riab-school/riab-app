@extends('_layouts.app-layouts.index')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Psb Payment</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTable" class="table table-sm table-hover" width="100%">
                <thead>
                    <tr>
                        <th>Aksi</th>
                        <th>Invoice ID</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>No HP</th>
                        <th>Jumlah</th>
                        <th>Transfer Via</th>
                    </tr>
                </thead>                
                <tbody>
                    @forelse ($dataPayment as $item)
                    <tr>
                        <td>
                            <div class="btn-group">
                                <button 
                                    data-id="{{ $item->id }}"
                                    data-student-id="{{ $item->user_id }}"
                                    data-invoice="{{ $item->manual_invoiceid }}"
                                    data-nama="{{ $item->userDetail->studentDetail->name }}"
                                    data-jumlah="{{ rupiah($item->amount) }}"
                                    data-bank="{{ $item->manual_bank_from }}"
                                    data-image="{{ Storage::disk('s3')->url($item->evidence) }}"
                                    class="btn btn-outline-info btn-verifikasi">
                                    <i class="fas fa-edit"></i> Verifikasi
                                </button>
                            </div>
                        </td>
                        <td>{{ $item->manual_invoiceid }}</td>
                        <td>{{ $item->userDetail->username }}</td>
                        <td>{{ $item->userDetail->studentDetail->name }}</td>
                        <td>{{ $item->userDetail->studentDetail->phone }}</td>
                        <td>{{ rupiah($item->amount) }}</td>
                        <td>{{ $item->manual_bank_from }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data pembayaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="verifikasiModal" tabindex="-1" aria-labelledby="verifikasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="row g-3 p-3">
            <div class="col-6">
                <form id="formVerifikasi" method="POST" action="{{ route('staff.master-psb.payment.handle') }}" onsubmit="return processData(this);"">
                    @csrf
                    <input type="hidden" name="id" id="verifikasi_id">
                    <input type="hidden" name="student_id" id="student_id">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="verifikasiModalLabel">Verifikasi Pembayaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-2">
                                <label class="form-label">Invoice ID</label>
                                <input type="text" class="form-control" id="verifikasi_invoice" readonly disabled>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" id="verifikasi_nama" readonly disabled>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Jumlah</label>
                                <input type="text" class="form-control" id="verifikasi_jumlah" readonly disabled>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Transfer Via</label>
                                <input type="text" class="form-control" id="verifikasi_bank" readonly disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status Verifikasi</label>
                                <select class="form-select" name="status" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="verified">Terima Verifikasi</option>
                                    <option value="rejected">Ditolak</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Verifikasi</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <img id="verifikasi_evidence" src="" alt="Bukti Transfer" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
$(document).ready(function() {
    // ketika tombol verifikasi diklik
    $('.btn-verifikasi').on('click', function() {
        let id = $(this).data('id');
        let student_id = $(this).data('student-id');
        let invoice = $(this).data('invoice');
        let nama = $(this).data('nama');
        let jumlah = $(this).data('jumlah');
        let bank = $(this).data('bank');
        let evidence = $(this).data('image');

        // isi data ke dalam modal
        $('#verifikasi_id').val(id);
        $('#student_id').val(student_id);
        $('#verifikasi_invoice').val(invoice);
        $('#verifikasi_nama').val(nama);
        $('#verifikasi_jumlah').val(jumlah);
        $('#verifikasi_bank').val(bank);
        $('#verifikasi_evidence').attr('src', evidence);

        // tampilkan modal
        $('#verifikasiModal').modal('show');
    });
});
</script>
@endpush
