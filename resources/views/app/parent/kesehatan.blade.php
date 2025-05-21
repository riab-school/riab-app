@extends('_layouts.mobile-layouts.index')

@section('content')
    <div class="container">
        <div class="section-heading d-flex align-items-center justify-content-between rtl-flex-d-row-r">
            <h6>Riwayat Kesehatan
                <span id="totalCount"></span>
            </h6>
        </div>
        <div class="row g-2" id="renderRiwayatKesehatan">
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
            url: "{{ route('parent.kesehatan.history') }}",
            type: "GET",
            data: { page: page },
            dataType: "json",
            success: function(res) {
                let html = `<div class="horizontal-product-card">
                                <div class="d-flex align-items-center justify-content-center text-center py-5">
                                    <h5>Tidak ada data</h5>
                                </div>
                            </div>`;
                $('#totalCount').text(`(${res.total})`);
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
                                                <img src="{{ asset('mobile-assets/img/icons/health.png') }}" alt="icon_perizinan" class="img-fluid w-80">
                                            </a>
                                        `}
                                    </div>
                                    <div class="product-description">
                                        <div class="product-title d-block">${item.diagnose}</div>
                                        <div class="d-flex flex-column gap-1">
                                            <div class="product-rating">
                                                <i class="fa-solid fa-hand-holding-medical bg-danger"></i><b>Tindakan : </b>&nbsp;${item.treatment}
                                            </div>
                                            <div class="product-rating">
                                                <i class="fa-solid fa-pills bg-danger"></i><b>Obat : </b>&nbsp;${item.drug_given}
                                            </div>
                                            <div class="product-rating">
                                                <i class="fa-solid fa-notes-medical bg-danger"></i><b>Catatan Dokter  : </b>&nbsp;${item.note}
                                            </div>
                                            <div class="product-rating">
                                                <i class="fa-solid fa-home bg-info"></i><b>Di izinkan pulang : </b>&nbsp;${item.is_allow_home ? '<span class="badge rounded-pill badge-success">Ya</span>' : '<span class="badge rounded-pill badge-danger">Tidak</span>'}
                                            </div>
                                            <div class="product-rating">
                                                <i class="fa-solid fa-star"></i><b>Di diagnosa Oleh : </b>&nbsp;${item.diagnozed_by.staff_detail.name}
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
                $('#renderRiwayatKesehatan').append(html);
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
