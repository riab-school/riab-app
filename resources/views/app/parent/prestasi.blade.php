@extends('_layouts.mobile-layouts.index')
@section('title', 'Riwayat Prestasi')
@section('content')
    <div class="container">
        <div class="section-heading d-flex align-items-center justify-content-between rtl-flex-d-row-r">
            <h6>Total Catatan Prestasi
                <span id="totalCount"></span>
            </h6>
        </div>
        <div class="row g-2" id="renderRiwayatPrestasi">
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
            url: "{{ route('parent.prestasi.history') }}",
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
                    $('#renderRiwayatPrestasi').append(html);
                }
                $.each(res.data, function(index, item) {
                    html += `
                        <div class="col-12">
                            <div class="horizontal-product-card">
                                <div class="d-flex align-items-center">
                                    <div class="product-thumbnail-side">
                                        ${item.evidence ? `
                                            <a class="product-thumbnail shadow-sm d-block" href="javascript:void(0);">
                                                <img src="${item.evidence}" data-src="${item.evidence}" alt="icon_perizinan" class="img-preview img-fluid w-80">
                                            </a>
                                        ` : `
                                            <a class="product-thumbnail shadow-sm d-block" href="javascript:void(0);">
                                                <img src="{{ asset('mobile-assets/img/icons/achiev.png') }}" alt="icon_perizinan" class="img-fluid w-80">
                                            </a>
                                        `}
                                    </div>
                                    <div class="product-description">
                                        <div class="product-title d-block">${item.detail}</div>
                                        <div class="d-flex flex-column gap-1">
                                            <div class="product-rating">
                                                <i class="fa-solid fa-key bg-danger"></i><b>Tindakan :</b>&nbsp;${item.action_taked}
                                            </div>
                                            <div class="product-rating">
                                                <i class="fa-solid fa-star"></i><b>Di catat oleh :</b>&nbsp;${item.process_by.staff_detail.name}
                                            </div>
                                            <div class="product-rating">
                                                <i class="fa-solid fa-calendar bg-primary"></i>${item.createdAt}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                $('#renderRiwayatPrestasi').append(html);
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
