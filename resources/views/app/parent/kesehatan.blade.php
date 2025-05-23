@extends('_layouts.mobile-layouts.index')
@section('title', 'Riwayat Kesehatan')
@section('content')
    <div class="container">
        <div class="section-heading d-flex align-items-center justify-content-between rtl-flex-d-row-r">
            <h6>Total Catatan Kesehatan
                <span id="totalCount"></span>
            </h6>
        </div>
        <div class="row g-2" id="renderRiwayatKesehatan">
            <div class="text-center d-flex justify-content-center align-items-center py-5" id="scrollLoader">	
                <div class="loaders"></div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Rekam Diganosa Kesehatan</h5>
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
            url: "{{ route('parent.kesehatan.history') }}",
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
                    $('#renderRiwayatKesehatan').append(html);
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
                                                <img src="{{ asset('mobile-assets/img/icons/health.png') }}" alt="icon_perizinan" class="img-fluid w-80">
                                            </a>
                                        `}
                                    </div>
                                    <div class="product-description">
                                        <div class="product-title d-block">${item.diagnose}</div>
                                        <button class="btn btn-sm btn-danger mt-1" id="btnModalDetail" data-id="${item.id}"><i class="fas fa-magnifying-glass"></i> Lihat Selengkapnya</button>
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

    // Modal Detail Riwayat Kesehatan on click
    $(document).on('click', '#btnModalDetail', function() {
        let id = $(this).data('id');
        $.ajax({
            url: "{{ route('parent.kesehatan.detail') }}",
            type: "GET",
            data: { id: id },
            dataType: "json",
            success: function(res) {
                let html = `
                    <div class="row">
                        <div class="col-12">
                            <h6>Diagnosa :</h6>
                            <p class="px-3">${res.data.diagnose}</p>
                        </div>
                        <div class="col-12">
                            <h6>Tindakan :</h6>
                            <p class="px-3">${res.data.treatment}</p>
                        </div>
                        <div class="col-12">
                            <h6>Obat diberikan :</h6>
                            <p class="px-3">${res.data.drug_given}</p>
                        </div>
                        <div class="col-12">
                            <h6>Catatan Dokter :</h6>
                            <p class="px-3">${res.data.note}</p>
                        </div>
                        <div class="col-12">
                            <h6>Di izinkan pulang :</h6>
                            <p class="px-3">${res.data.is_allow_home == "1" ? 'Ya, Boleh Pulang <br>Silahkan hubungi bagian perizinan untuk mendapatkan token izin pulang' : 'Tidak dibenarkan pulang, <br>Disarankan cukup istirahat di asrama'}</p>
                        </div>
                        <div class="col-12">
                            <h6>Di diagnosa Oleh :</h6>
                            <p class="px-3">${res.data.diagnozed_by.staff_detail.name}</p>
                        </div>
                        <div class="col-12">
                            <h6>Tanggal Kunjungan :</h6>
                            <p class="px-3">${res.data.createdAt}</p>
                        </div>
                    </div>
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
