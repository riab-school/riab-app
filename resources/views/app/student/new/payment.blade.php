@extends('_layouts.app-layouts.index')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/pages.css') }}">
    <style>
    /* existing print rules kept */
    @media print {
        #printTable, #printTable * {
            visibility: visible;
        }
        #btnPrint {
            display: none;
        }
        #printTable {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        @page { margin: 0; }

        .label {
            font-weight: 600;
            font-size: 14pt;
            color: #000 !important;
        }

        .paymentMethodSection {
            display: none;
            visibility: hidden;
        }

        /* ensure watermark sits behind text by forcing lower stacking for printed content */
        #printTable > * {
            position: relative;
            z-index: 10000;
        }
    }

    /* hide watermark on screen */
    .wm-print { display: none; }
    </style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="container">
            <div class="card" id="printTable">
                <div class="row invoice-contact">
                    <div class="col-md-12">
                        <div class="invoice-box row">
                            <div class="col-sm-10">
                                <table
                                    class="table table-responsive invoice-table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <img class="img-fluid"
                                                    src="{{ asset(appSet('APP_LOGO_DARK')) }}"
                                                    alt="Dasho logo" width="120px">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ appset('SCHOOL_NAME') }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ appset('SCHOOL_ADDRESS') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-2 text-end">
                                <button type="button" class="btn btn-success btn-sm" id="btnPrint">
                                    <i class="fas fa-print"></i> Cetak Invoice
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-body">
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-client-info">
                            <h6>Student Information:</h6>
                            <h6 class="m-0">{{ auth()->user()->myDetail->name }}</h6>
                            <p class="m-0">{{ auth()->user()->myDetail->phone }}</p>
                        </div>
                        <div class="col-sm-4 invoice-client-info">
                            <h6>Payment Information :</h6>
                            <table
                                class="table table-responsive invoice-table invoice-order table-borderless">
                                <tbody>
                                    <tr>
                                        <th>INV Number</th>
                                        <td>&nbsp;:&nbsp;</td>
                                        <td>{{ $manual_invoiceid }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td>&nbsp;:&nbsp;</td>
                                        <td>{{ dateIndo(auth()->user()->created_at->format('Y-m-d')) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>&nbsp;:&nbsp;</td>
                                        <td>
                                            @switch($payment_status)
                                                @case('paid')
                                                    <span class="label label-success">Lunas</span>
                                                    @break
                                                @case('unpaid')
                                                    <span class="label label-danger">Belum Bayar</span>
                                                    @break
                                                @case('pending')
                                                    <span class="label label-warning">Menunggu Verifikasi</span>
                                                    @break
                                            @endswitch
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-4 invoice-client-info" id="paymentMethodSection">
                            <h6>Metode Pembayaran :</h6>
                            <button type="button" class="btn btn-warning btn-sm" id="modalPaymentMethodButton">
                                Lihat Metode Pembayaran
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table invoice-detail-table">
                                    <thead>
                                        <tr class="thead-default">
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Amount</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h6>Biaya Pendaftaran</h6>
                                                <p class="m-0">Biaya pendaftaran untuk mengikuti proses penerimaan santri baru</p>
                                            </td>
                                            <td>1</td>
                                            <td>{{ rupiah(request()->psb_config->biaya_psb) }}</td>
                                            <td>{{ rupiah(request()->psb_config->biaya_psb) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-responsive invoice-table invoice-total">
                                <tbody>
                                    <tr>
                                        <th>Sub Total :</th>
                                        <td>{{ rupiah(request()->psb_config->biaya_psb) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Discount % :</th>
                                        <td>0</td>
                                    </tr>
                                    <tr>
                                        <th>Tax  :</th>
                                        <td>0</td>
                                    </tr>
                                    <tr class="text-info">
                                        <td>
                                            <hr />
                                            <h5 class="text-primary m-r-10">Total :</h5>
                                        </td>
                                        <td>
                                            <hr />
                                            <h5 class="text-primary">{{ rupiah(request()->psb_config->biaya_psb) }}</h5>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <h6>Terms and Condition :</h6>
                            <ol>
                                <li>Biaya yang telah di bayarkan, tidak dapat di kembalikan dengan alasan apapun.</li>
                                <li>Harap simpan bukti pembayaran dengan baik.</li>
                                <li>Segala bentuk penipuan yang mengatasnamakan pihak sekolah, bukan tanggung jawab sekolah.</li>
                                <li>Apabila ada pertanyaan, silahkan hubungi bagian administrasi sekolah.</li>
                            </ol>
                        </div>
                        @if($payment_status == 'unpaid')
                        <div class="col-md-4 m-auto text-end">
                            <button type="button" class="btn btn-primary m-b-10 btn-sm" id="modalConfirmButton">Konfirmasi Pembayaran</button>
                        </div>
                        @endif
                        @if($payment_status == 'pending')
                        <div class="col-md-4 m-auto text-end text-danger">
                            <p>Kami sudah menerima bukti transfer anda, namun berikan kami waktu untuk melakukan verifikasi</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($payment_status == 'unpaid')
<!-- Modal -->
<div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Pembayaran</h5>
            </div>
            <form action="{{ route('student.payment.new.action') }}" method="POST" enctype="multipart/form-data" onsubmit="return processDataWithLoading(this)">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="manual_bank_from" class="form-label">Transfer Via Bank</label>
                        <input type="text" class="form-control" name="manual_bank_from" placeholder="Bank BSI / Bank Aceh" required>
                    </div>
                    <div class="mb-3">
                        <label for="evidence" class="form-label">Bukti Transfer</label>
                        <input type="file" class="form-control" name="evidence" required accept="image/*">
                        <small class="text-muted">Max 1MB | JPG, JPEG, PNG</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Metode Pembayaran --}}
<div class="modal fade" id="modalPaymentMethod" tabindex="-1" role="dialog" aria-labelledby="modalPaymentMethodLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPaymentMethodLabel">Metode Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="accordion" id="accordionPaymentMethod">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading1">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                            <img src="{{ asset('assets/images/transfer.png') }}" alt="" width="20px" class="mx-2"> Transfer Bank (Verifikasi Manual)
                        </button>
                        </h2>
                        <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#accordionPaymentMethod">
                        <div class="accordion-body">
                            <p>Silahkan melakukan pembayaran ke rekening berikut:</p>
                            <ul>
                                <li>Bank : {{ request()->psb_config->nama_bank_rekening_psb }}</li>
                                <li>Atas Nama : {{ request()->psb_config->nama_rekening_psb }}</li>
                                <li>No. Rekening : {{ request()->psb_config->no_rekening_psb }}</li>
                            </ul>
                            <p>Setelah melakukan pembayaran, silahkan konfirmasi pembayaran dengan mengunggah bukti transfer pada tombol "Konfirmasi Pembayaran" di halaman invoice.</p>
                        </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                            <img src="{{ asset('assets/images/qr-code.png') }}" alt="" width="20px" class="mx-2"> QRIS
                        </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#accordionPaymentMethod">
                        <div class="accordion-body">
                            <center>
                                <h5 class="text-danger">Fitur ini Sedang dalam pengembangan</h5>
                            </center>
                        </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading3">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                            <img src="{{ asset('assets/images/virtual-card.png') }}" alt="" width="20px" class="mx-2"> Virtual Account
                        </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordionPaymentMethod">
                        <div class="accordion-body">
                            <center>
                                <h5 class="text-danger">Fitur ini Sedang dalam pengembangan</h5>
                            </center>
                        </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading4">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                            <img src="{{ asset('assets/images/outlet.png') }}" alt="" width="20px" class="mx-2"> Outlet
                        </button>
                        </h2>
                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionPaymentMethod">
                        <div class="accordion-body">
                            <center>
                                <h5 class="text-danger">Fitur ini Sedang dalam pengembangan</h5>
                                <img src="{{ asset('assets/images/indomaret.png') }}" alt="" width="100px" class="mx-2">
                                <img src="{{ asset('assets/images/alfa.png') }}" alt="" width="100px" class="mx-2">
                            </center>
                        </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading5">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                            <img src="{{ asset('assets/images/digital-wallet.png') }}" alt="" width="20px" class="mx-2"> E-Wallet
                        </button>
                        </h2>
                        <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordionPaymentMethod">
                        <div class="accordion-body">
                            <center>
                                <h5 class="text-danger">Fitur ini Sedang dalam pengembangan</h5>
                                <img src="{{ asset('assets/images/e-wallet.png') }}" alt="" width="100%" class="mx-2">
                            </center>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif
@endsection


@push('scripts')
    <script>
        $(document).ready(function () {
            $('#modalConfirmButton').on('click', function() {
                $('#modalConfirm').modal('show');
            });
            $('#modalPaymentMethodButton').on('click', function () {
                $('#modalPaymentMethod').modal('show');
            });
        });
        // Print area
        $('#btnPrint').on('click', function() {
            var printContents = document.getElementById('printTable').innerHTML;
            var originalContents = document.body.innerHTML;

            // Tulis ulang hanya bagian yang mau di-print
            document.body.innerHTML = printContents;

            // Jalankan print
            window.print();

            // Kembalikan konten asli setelah print
            document.body.innerHTML = originalContents;

            // Reload script agar tombol dll tetap berfungsi
            location.reload();
        });
    </script>
@endpush
