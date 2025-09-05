@extends('_layouts.mobile-layouts.index')
@section('title', 'Riwayat Perizinan')
@section('content')
    <div class="container">
        <div class="section-heading d-flex align-items-center justify-content-between rtl-flex-d-row-r">
            <h6>Total Perizinan
                <span id="totalCount"></span>
            </h6>
            <a href="{{ route('parent.perizinan.request') }}" class="btn btn-warning btn-sm">Ajukan Perizinan Mandiri</a>
        </div>
        <div class="row g-2" id="renderRiwayatPerizinan">
            <div class="text-center d-flex justify-content-center align-items-center py-5" id="scrollLoader">	
                <div class="loaders"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Perizinan</h5>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                <div class="modal-body">
                    
                </div>
            </div>
        </div>
    </div>   
@endsection

@push('scripts-mobile')
<script>
    let page = 1;
    let isLoading = false;
    let hasMorePages = true;

    function loadRiwayat() {
        if (isLoading || !hasMorePages) return;
        isLoading = true;
        $.ajax({
            url: "{{ route('parent.perizinan.history') }}",
            type: "GET",
            data: { page: page },
            dataType: "json",
            success: function(res) {
                let html = '';
                $('#totalCount').text(`(${res.total})`);
                if (res.data.length === 0) {
                    let html = `
                        <div class="horizontal-product-card">
                            <div class="d-flex align-items-center justify-content-center text-center py-5">
                                <h5>Tidak ada data</h5>
                            </div>
                        </div>
                    `;
                    $('#scrollLoader').addClass('d-none');
                    $('#renderRiwayatPerizinan').append(html);
                }
                $.each(res.data, function(index, item) {
                    let statusBadge = '';
                    switch (item.status) {
                        case 'requested':
                            statusBadge = '<span class="badge rounded-pill badge-warning">Menunggu</span>';
                            break;
                        case 'approved':
                            statusBadge = '<span class="badge rounded-pill badge-primary">Diizinkan</span>';
                            break;
                        case 'check_out':
                            statusBadge = '<span class="badge rounded-pill badge-info">Sudah Keluar</span>';
                            break;
                        case 'check_in':
                            statusBadge = '<span class="badge rounded-pill badge-success">Selesai</span>';
                            break;
                        case 'rejected':
                            statusBadge = '<span class="badge rounded-pill badge-danger">Ditolak</span>';
                            break;
                        case 'canceled':
                            statusBadge = '<span class="badge rounded-pill badge-secondary">Dibatalkan</span>';
                            break;
                        default:
                            statusBadge = '<span class="badge rounded-pill badge-light">N/A</span>';
                            break;
                    }
                    html += `
                        <div class="col-12">
                            <div class="horizontal-product-card">
                                <div class="d-flex align-items-center">
                                    <div class="product-thumbnail-side">
                                        <a class="product-thumbnail shadow-sm d-block" href="javascript:void(0);">
                                            <img src="{{ asset('mobile-assets/img/icons/permission.png') }}" alt="icon_perizinan" class="img-fluid w-80">
                                        </a>
                                    </div>
                                    <div class="product-description">
                                        <a class="badge-btn" href="javascript:void(0);">
                                            ${statusBadge}
                                        </a>
                                        <div class="product-title d-block">${item.reason}</div>
                                        <div class="product-rating">
                                            Dari Tgl : ${item.from_date}
                                        </div>
                                        <div class="product-rating">
                                            Hingga Tgl : ${item.to_date}
                                        </div>
                                        <button class="btn btn-sm btn-danger mt-1" id="btnModalDetail" data-id="${item.id}"><i class="fas fa-magnifying-glass"></i> Lihat Selengkapnya</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                $('#renderRiwayatPerizinan').append(html);
                page = res.next_page ?? page;
                hasMorePages = res.next_page !== null;
                isLoading = false;
                $('#scrollLoader').addClass('d-none');
            },
            error: function(xhr, status, error) {
                console.error(error);
                isLoading = false;
                $('#scrollLoader').removeClass('d-none');
            }
        });
    }

    $(document).ready(function () {
        $('#scrollLoader').removeClass('d-none');
        loadRiwayat(); // initial load
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                loadRiwayat();
            }
        });
    });

    $(document).on('click', '#btnModalDetail', function() {
        let id = $(this).data('id');
        $.ajax({
            url: "{{ route('parent.perizinan.detail') }}",
            type: "GET",
            data: { id: id },
            dataType: "json",
            success: function(res) {
                let detailHtml = '';
                if (res.data.status === 'rejected') {
                    detailHtml = `
                        <div class="row">
                            <div class="col-12">
                                <h6>Alasan Penolakan :</h6>
                                <p class="px-3">${res.data.reject_reason}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h6>Ditolak Oleh :</h6>
                                <p class="px-3">${res.data.rejected_by.staff_detail.name}</p>
                            </div>
                        </div>
                    `;
                }

                if (res.data.status === 'requested') {
                    detailHtml = `
                        <div class="row">
                            <div class="col-12">
                                <h6>Di mohon oleh :</h6>
                                <p class="px-3">${res.data.requested_by}</p>
                            </div>
                        </div>
                    `;
                }

                if (res.data.status === 'approved') {
                    detailHtml = `
                        <div class="row">
                            <div class="col-12">
                                <h6>Pemberi izin :</h6>
                                <p class="px-3">${res.data.approved_by.staff_detail.name}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h6>Token izin :</h6>
                                <h4 class="px-3"><span class="fw-bold">${res.data.token ? res.data.token : '-'}</span></h4>
                                <span class="text-muted px-3">*Tunjukan token ini kepada petugas pos saat keluar atau kembali</span>
                            </div>
                        </div>
                    `;
                }

                if (res.data.status === 'check_in') {
                    detailHtml = `
                        <div class="row">
                            <div class="col-12">
                                <h6>Pemberi izin :</h6>
                                <p class="px-3">${res.data.approved_by.staff_detail.name}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h6>Petugas Pos Check In :</h6>
                                <p class="px-3">${res.data.checked_in_by.staff_detail.name}</p>
                            </div>
                        </div>
                    `;
                }

                if (res.data.status === 'check_out') {
                    detailHtml = `
                        <div class="row">
                            <div class="col-12">
                                <h6>Pemberi izin :</h6>
                                <p class="px-3">${res.data.approved_by.staff_detail.name}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h6>Petugas Pos Check Out :</h6>
                                <p class="px-3">${res.data.checked_out_by.staff_detail.name}</p>
                            </div>
                        </div>
                    `;
                }
                let html = `
                    <div class="row">
                        <div class="col-12">
                            <h6>Tujuan Izin :</h6>
                            <p class="px-3">${res.data.reason}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h6>Pemohon Izin :</h6>
                            <p class="px-3">${res.data.applicantDetailtext}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h6>Dari Tanggal :</h6>
                            <p class="px-3">${res.data.from_date}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h6>Hingga Tanggal :</h6>
                            <p class="px-3">${res.data.to_date}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h6>Di Jemput Oleh :</h6>
                            <p class="px-3">${res.data.pickup_by}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h6>Status :</h6>
                            <p class="px-3">${res.data.statusText}</p>
                        </div>
                    </div>
                    ${detailHtml}
                `;
                $('#modalDetail .modal-body').html(html);
                $('#modalDetail').modal('show');
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
</script>
@endpush
