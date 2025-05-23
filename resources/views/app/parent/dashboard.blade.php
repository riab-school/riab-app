@extends('_layouts.mobile-layouts.index')

@section('content')
<div class="hero-wrapper">
    <div class="container">
        <div class="pt-1">
            <div class="hero-slides owl-carousel" id="heroSlides">
            
                <div class="single-hero-slide" style="background-image: url('{{ asset('mobile-assets') }}/img/bg-img/1.jpg')">
                    <div class="slide-content h-100 d-flex align-items-center">
                        <div class="slide-text">
                            <h4 class="text-white mb-0" data-animation="fadeInUp" data-delay="100ms" data-duration="1000ms">Selamat Datang</h4>
                            <p class="text-white" data-animation="fadeInUp" data-delay="400ms" data-duration="1000ms">Aplikasi Kesantrian {{ appSet('SCHOOL_SHORT_NAME') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="single-hero-slide" style="background-image: url('{{ asset('mobile-assets') }}/img/bg-img/2.jpg')">
                    <div class="slide-content h-100 d-flex align-items-center">
                        <div class="slide-text">
                            <h4 class="text-white mb-0" data-animation="fadeInUp" data-delay="100ms" data-duration="1000ms">Light Candle</h4>
                            <p class="text-white" data-animation="fadeInUp" data-delay="400ms" data-duration="1000ms">Now only $22</p><a class="btn btn-success" href="#" data-animation="fadeInUp" data-delay="500ms" data-duration="1000ms">Buy Now</a>
                        </div>
                    </div>
                </div>
                
                <div class="single-hero-slide" style="background-image: url('{{ asset('mobile-assets') }}/img/bg-img/3.jpg')">
                    <div class="slide-content h-100 d-flex align-items-center">
                        <div class="slide-text">
                            <h4 class="text-white mb-0" data-animation="fadeInUp" data-delay="100ms" data-duration="1000ms">Best Furniture</h4>
                            <p class="text-white" data-animation="fadeInUp" data-delay="400ms" data-duration="1000ms">3 years warranty</p><a class="btn btn-danger" href="#" data-animation="fadeInUp" data-delay="800ms" data-duration="1000ms">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="product-catagories-wrapper py-3">
    <div class="container">
        <div class="row g-2 rtl-flex-d-row-r">
            <div class="col-3">
                <div class="card catagory-card h-100">
                    <div class="card-body px-2">
                        <a href="{{ route('parent.anandaku') }}">
                            <img src="{{ asset('mobile-assets') }}/img/icons/parent-kid.png" alt="">
                            <span>Anandaku</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card catagory-card h-100">
                    <div class="card-body px-2">
                        <a href="{{ route('parent.perizinan') }}">
                            <img src="{{ asset('mobile-assets') }}/img/icons/permission.png" alt="">
                            <span>Perizinan</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card catagory-card h-100">
                    <div class="card-body px-2">
                        <a href="{{ route('parent.pelanggaran') }}">
                            <img src="{{ asset('mobile-assets') }}/img/icons/violation.png" alt="">
                            <span>Pelanggaran</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card catagory-card h-100">
                    <div class="card-body px-2">
                        <a href="{{ route('parent.prestasi') }}">
                            <img src="{{ asset('mobile-assets') }}/img/icons/achiev.png" alt="">
                            <span>Prestasi</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card catagory-card h-100">
                    <div class="card-body px-2">
                        <a href="{{ route('parent.tahfidz') }}">
                            <img src="{{ asset('mobile-assets') }}/img/icons/quran.png" alt="">
                            <span>Tahfidz</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card catagory-card h-100">
                    <div class="card-body px-2">
                        <a href="{{ route('parent.kesehatan') }}">
                            <img src="{{ asset('mobile-assets') }}/img/icons/health.png" alt="">
                            <span>Kesehatan</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card catagory-card h-100">
                    <div class="card-body px-2">
                        <a href="{{ route('parent.spp') }}">
                            <img src="{{ asset('mobile-assets') }}/img/icons/spp.png" alt="">
                            <span>SPP Sekolah</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card catagory-card h-100">
                    <div class="card-body px-2">
                        <a href="{{ route('parent.tasri') }}">
                            <img src="{{ asset('mobile-assets') }}/img/icons/saving.png" alt="">
                            <span>Tasri</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card catagory-card h-100">
                    <div class="card-body px-2">
                        <a href="{{ route('parent.raport.sekolah') }}">
                            <img src="{{ asset('mobile-assets') }}/img/icons/certificate.png" alt="">
                            <span>Raport Sekolah</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card catagory-card h-100">
                    <div class="card-body px-2">
                        <a href="{{ route('parent.raport.dayah') }}">
                            <img src="{{ asset('mobile-assets') }}/img/icons/certificate2.png" alt="">
                            <span>Raport Dayah</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card catagory-card h-100">
                    <div class="card-body px-2">
                        <a href="{{ route('parent.document') }}">
                            <img src="{{ asset('mobile-assets') }}/img/icons/document.png" alt="">
                            <span>Dokumen Santri</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card catagory-card h-100">
                    <div class="card-body px-2">
                        <a href="{{ route('parent.card') }}">
                            <img src="{{ asset('mobile-assets') }}/img/icons/card.png" alt="">
                            <span>Kartu Santri</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container pb-3">
    <div class="cta-text dir-rtl p-4 p-lg-5">
        <div class="row">
            <div class="col-auto mx-auto text-center">
                <h4 class="text-white mb-1">Dapatkan Informasi dan Berita Terbaru</h4>
                <p class="text-white mb-2 opacity-75">{{ appSet('SCHOOL_NAME') }}</p>
                <a class="btn btn-warning" href="{{ appSet('SCHOOL_WEBSITE') }}" target="_blank">Kunjungi Laman</a>
            </div>
        </div>
    </div>
</div>

<div class="blog-wrapper pb-3">
    <div class="container">
        <div class="section-heading d-flex align-items-center justify-content-between rtl-flex-d-row-r">
            <h6>Berita Terbaru</h6>
            <a href="{{ route('parent.berita') }}" class="btn btn-primary btn-sm">Lihat Semua</a>
        </div>
        <div class="row gy-3 rtl-flex-d-row-r" id="renderBlog">
            <div class="text-center d-flex justify-content-center align-items-center py-5">
                <div class="loaders"></div>
            </div>
        </div>
    </div>
</div>

<div class="container pb-3">
    <div class="discount-coupon-card p-4 p-lg-5 dir-rtl">
        <div class="d-flex align-items-center">
            <div class="discountIcon">
                <img class="w-100" src="{{ asset('mobile-assets') }}/img/core-img/megaphone.png" alt="">
            </div>
            <div class="text-content">
                <h4 class="text-white mb-1">Info PSB RIAB</h4>
                <p class="text-white mb-2">Informasi Penerimaan Santri Baru dapat di akses melalui link di bawah</p>
                <a class="btn btn-warning" href="{{ appSet('SCHOOL_PSB_WEBSITE') }}" target="_blank">Kunjungi Laman</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts-mobile')
<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ route('parent.berita.get') }}",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                let blogHtml = '';
                $.each(data.blog, function(index, item) {
                    // akses thumbnail
                    let thumbUrl = '{{ asset('mobile-assets') }}/img/bg-img/default.png';
                        if (item._embedded 
                            && item._embedded['wp:featuredmedia'] 
                            && item._embedded['wp:featuredmedia'][0] 
                            && item._embedded['wp:featuredmedia'][0].media_details 
                            && item._embedded['wp:featuredmedia'][0].media_details.sizes 
                            && item._embedded['wp:featuredmedia'][0].media_details.sizes["Blog Column Thumbnail"]) {
                            thumbUrl = item._embedded['wp:featuredmedia'][0].media_details.sizes["Blog Column Thumbnail"].source_url;
                        }

                    let authorName = '';
                    if (item._embedded 
                        && item._embedded['author'] 
                        && item._embedded['author'][0] 
                        && item._embedded['author'][0].name ) {
                        authorName = item._embedded['author'][0].name;
                    }
                    
                    blogHtml += `
                        <div class="col-12">
                            <div class="single-vendor-wrap bg-img p-4 bg-overlay" style="background-image: url('${thumbUrl}')">
                                <h6 class="vendor-title text-white">${item.title.rendered}</h6>
                                <div class="vendor-info">
                                    <p class="mb-1 text-white">
                                        ${authorName} | ${indoDateTime(item.date)}
                                    </p>                                    
                                </div>
                                <a class="btn btn-warning btn-sm mt-3" href="${item.link}" target="_blank">Baca Selengkapnya<i class="fa-solid fa-arrow-right-long ms-1"></i></a>
                            </div>
                        </div>
                    `;
                });
                $('#renderBlog').html(blogHtml);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
</script>
@endpush