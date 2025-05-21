@extends('_layouts.mobile-layouts.index')

@section('content')
    <div class="container">
        <div class="section-heading d-flex align-items-center justify-content-between rtl-flex-d-row-r">
            <h6>Riwayat Perizinan
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

                    let detailHtml = '';
                    if (item.status === 'rejected') {
                        detailHtml = `
                            <div class="product-rating">
                                <i class="fa-solid fa-comment-dots bg-danger"></i><b>Alasan ditolak :</b>&nbsp;${item.reject_reason}
                            </div>
                            <div class="product-rating">
                                <i class="fa-solid fa-comment-dots bg-danger"></i><b>Di tolak oleh :</b>&nbsp;${item.rejected_by.staff_detail.name}
                            </div>
                        `;
                    }

                    if (item.status === 'requested') {
                        detailHtml = `
                            <div class="product-rating">
                                <i class="fa-solid fa-comment-dots bg-danger"></i><b>Dimohon oleh :</b>&nbsp;${item.requested_by}
                            </div>
                            
                        `;
                    }

                    if (item.status === 'approved') {
                        detailHtml = `
                            <div class="product-rating">
                                <i class="fa-solid fa-comment-dots bg-danger"></i><b>Pemberi izin :</b>&nbsp;${item.approved_by.staff_detail.name}
                            </div>
                            <div class="product-rating">
                                <i class="fa-solid fa-key bg-danger"></i><b>Token :</b>&nbsp;<span class="fw-bold">${item.token ? item.token : '-'}</span> 
                            </div>
                        `;
                    }

                    if (item.status === 'check_in') {
                        detailHtml = `
                            <div class="product-rating">
                                <i class="fa-solid fa-comment-dots bg-danger"></i><b>Diterima Kembali Oleh :</b>&nbsp;${item.checked_in_by.staff_detail.name}
                            </div>
                        `;
                    }

                    if (item.status === 'check_out') {
                        detailHtml = `
                            <div class="product-rating">
                                <i class="fa-solid fa-comment-dots bg-danger"></i><b>Pemeriksaan POS Oleh :</b>&nbsp;${item.checked_out_by.staff_detail.name}
                            </div>
                        `;
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
                                        <div class="d-flex flex-column gap-1">
                                            <div class="product-rating">
                                                <i class="fa-solid fa-calendar bg-primary"></i>${item.from_date} s/d ${item.to_date}
                                            </div>
                                            <div class="product-rating">
                                                <i class="fa-solid fa-star"></i><b>Di Jemput Oleh :</b>&nbsp;${item.pickup_by}
                                            </div>
                                            ${detailHtml}
                                        </div>
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
</script>
@endpush
