<!DOCTYPE html>
<html lang="en">
    @include('_layouts.mobile-layouts.head')
    <body>
    
        <div class="preloader" id="preloader">
            <div class="spinner-grow text-secondary" role="status">
                <div class="sr-only"></div>
            </div>
        </div>
        <div class="intro-wrapper d-flex align-items-center justify-content-center text-center">
            <div class="container">
                <img class="big-logo" src="{{ asset('assets/images/logo.png') }}" alt="">
                <h2 style="color:aliceblue">Selamat Datang</h2>
                <h5 style="color:aliceblue">APLIKASI {{ appSet('APP_NAME') }}</h5>
                <h5 style="color:aliceblue">{{ appSet('SCHOOL_NAME') }}</h5>
            </div>
        </div>
        <div class="get-started-btn">
            <a class="btn btn-warning btn-lg w-100" href="{{ route('login') }}">Ayo Mulai</a>
        </div>
        
        <script src="{{ asset('mobile-assets') }}/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('mobile-assets') }}/js/jquery.min.js"></script>
        <script src="{{ asset('mobile-assets') }}/js/waypoints.min.js"></script>
        <script src="{{ asset('mobile-assets') }}/js/jquery.easing.min.js"></script>
        <script src="{{ asset('mobile-assets') }}/js/jquery.magnific-popup.min.js"></script>
        <script src="{{ asset('mobile-assets') }}/js/owl.carousel.min.js"></script>
        <script src="{{ asset('mobile-assets') }}/js/jquery.counterup.min.js"></script>
        <script src="{{ asset('mobile-assets') }}/js/jquery.countdown.min.js"></script>
        <script src="{{ asset('mobile-assets') }}/js/jquery.passwordstrength.js"></script>
        <script src="{{ asset('mobile-assets') }}/js/jquery.nice-select.min.js"></script>
        <script src="{{ asset('mobile-assets') }}/js/theme-switching.js"></script>
        <script src="{{ asset('mobile-assets') }}/js/active.js"></script>
        <script src="{{ asset('mobile-assets') }}/js/pwa.js"></script>

    </body>
</html>