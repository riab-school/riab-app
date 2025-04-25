@extends('_layouts.mobile-layouts.index')

@section('content')
<div class="hero-wrapper">
    <div class="container">
        <div class="pt-3">
            <div class="hero-slides owl-carousel">
            
            <div class="single-hero-slide" style="background-image: url('{{ asset('mobile-assets') }}/img/bg-img/1.jpg')">
                <div class="slide-content h-100 d-flex align-items-center">
                    <div class="slide-text">
                        <h4 class="text-white mb-0" data-animation="fadeInUp" data-delay="100ms" data-duration="1000ms">Selamat Datang</h4>
                        <p class="text-white" data-animation="fadeInUp" data-delay="400ms" data-duration="1000ms">Aplikasi {{ appSet('APP_NAME') }} {{ appSet('SCHOOL_SHORT_NAME') }}</p>
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

<div class="product-catagories-wrapper py-3">
    <div class="container">
        <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
            <h6>Menu Orang Tua</h6>
        </div>
        <div class="row g-2 rtl-flex-d-row-r">
            <div class="col-3">
                <div class="card catagory-card h-100">
                    <div class="card-body px-2"><a href="#"><img src="{{ asset('mobile-assets') }}/img/core-img/price-tag.png" alt=""><span>Anandaku</span></a></div>
                </div>
            </div>
            <div class="col-3">
                <div class="card catagory-card h-100">
                    <div class="card-body px-2"><a href="#"><img src="{{ asset('mobile-assets') }}/img/core-img/woman-clothes.png" alt=""><span>Perizinan</span></a></div>
                </div>
            </div>
            <div class="col-3">
                <div class="card catagory-card h-100">
                    <div class="card-body px-2"><a href="#"><img src="{{ asset('mobile-assets') }}/img/core-img/grocery.png" alt=""><span>Pelanggaran</span></a></div>
                </div>
            </div>
            <div class="col-3">
                <div class="card catagory-card h-100">
                    <div class="card-body px-2"><a href="#"><img src="{{ asset('mobile-assets') }}/img/core-img/shampoo.png" alt=""><span>Prestasi</span></a></div>
                </div>
            </div>
            <div class="col-3">
                <div class="card catagory-card h-100">
                    <div class="card-body px-2"><a href="#"><img src="{{ asset('mobile-assets') }}/img/core-img/rowboat.png" alt=""><span>Tahfidz</span></a></div>
                </div>
            </div>
            <div class="col-3">
                <div class="card catagory-card h-100">
                    <div class="card-body px-2"><a href="#"><img src="{{ asset('mobile-assets') }}/img/core-img/tv-table.png" alt=""><span>Kesehatan</span></a></div>
                </div>
            </div>
            <div class="col-3">
                <div class="card catagory-card h-100">
                    <div class="card-body px-2"><a href="#"><img src="{{ asset('mobile-assets') }}/img/core-img/beach.png" alt=""><span>SPP Sekolah</span></a></div>
                </div>
            </div>
            <div class="col-3">
                <div class="card catagory-card h-100">
                    <div class="card-body px-2"><a href="#"><img src="{{ asset('mobile-assets') }}/img/core-img/baby-products.png" alt=""><span>Tasri</span></a></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="cta-text dir-rtl p-4 p-lg-5">
        <div class="row">
            <div class="col-9">
                <h4 class="text-white mb-1">Dapatkan Informasi</h4>
                <p class="text-white mb-2 opacity-75">{{ appSet('SCHOOL_NAME') }}</p>
                <a class="btn btn-warning" href="{{ appSet('SCHOOL_WEBSITE') }}" target="_blank">Selengkapnya</a>
            </div>
        </div>
        <img src="img/bg-img/make-up.png" alt="">
    </div>
</div>

<div class="weekly-best-seller-area py-3">
    <div class="container">
        <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
            <h6>Hafalan Minggu Ini</h6>
        </div>
        <div class="row g-2">
            <div class="col-12">
                <div class="horizontal-product-card bg-light rounded-2 shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="product-thumbnail-side">
                            <a class="product-thumbnail shadow-sm d-block" href="#"><img src="{{ asset('mobile-assets') }}/img/product/18.png" alt=""></a>
                        </div>
                        <div class="product-description">
                            <a class="product-title d-block" href="#">Ryan Achdiadsyah</a>
                            <div class="row">
                                <div class="col-6">
                                    <p class="sale-price">
                                        <i class="fa-solid fa-book"></i>1 Juz</span>
                                    </p>
                                    <div class="product-rating">
                                        <i class="fa-solid fa-star"></i>Kelas XI
                                    </div>
                                </div>
                                <div class="col-6">
                                    <p class="sale-price">
                                        <i class="fa-solid fa-book"></i>1 Juz</span>
                                    </p>
                                    <div class="product-rating">
                                        <i class="fa-solid fa-star"></i>Kelas XI
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container pb-3">
    <div class="discount-coupon-card p-4 p-lg-5 dir-rtl">
        <div class="d-flex align-items-center">
            <div class="discountIcon">
                <img class="w-100" src="{{ asset('mobile-assets') }}/img/core-img/discount.png" alt="">
            </div>
            <div class="text-content">
                <h4 class="text-white mb-1">Get 20% discount!</h4>
                <p class="text-white mb-0">To get discount, enter the<span class="px-1 fw-bold">GET20</span>code on the checkout page.</p>
            </div>
        </div>
    </div>
</div>
@endsection