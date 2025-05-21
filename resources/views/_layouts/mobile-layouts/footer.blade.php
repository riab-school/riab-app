
    <div class="footer-nav-area" id="footerNav">
        <div class="suha-footer-nav">
        <ul class="h-100 d-flex align-items-center justify-content-between ps-0 d-flex rtl-flex-d-row-r">
            <li><a href="{{ request()->home_url }}"><i class="fa-solid fa-house"></i>Beranda</a></li>
            <li><a href="#"><i class="fa-solid fa-comment-dots"></i>Chat</a></li>
            <li><a href="{{ route('parent.berita') }}"><i class="fa-solid fa-bullhorn"></i>Berita</a></li>
            <li><a href="{{ route('parent.settings') }}"><i class="fa-solid fa-sliders"></i>Pengaturan</a></li>
            <li><a href="{{ route('profile') }}"><i class="fa-solid fa-user"></i>Profil</a></li>
        </ul>
        </div>
    </div>

    <script src="{{ asset('mobile-assets') }}/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('mobile-assets') }}/js/jquery.min.js"></script>
    <script src="{{ asset('mobile-assets') }}/js/waypoints.min.js"></script>
    <script src="{{ asset('mobile-assets') }}/js/jquery.easing.min.js"></script>
    <script src="{{ asset('mobile-assets') }}/js/owl.carousel.min.js"></script>
    <script src="{{ asset('mobile-assets') }}/js/jquery.magnific-popup.min.js"></script>
    <script src="{{ asset('mobile-assets') }}/js/jquery.counterup.min.js"></script>
    <script src="{{ asset('mobile-assets') }}/js/jquery.countdown.min.js"></script>
    <script src="{{ asset('mobile-assets') }}/js/jquery.passwordstrength.js"></script>
    <script src="{{ asset('mobile-assets') }}/js/jquery.nice-select.min.js"></script>
    <script src="{{ asset('mobile-assets') }}/js/theme-switching.js"></script>
    <script src="{{ asset('mobile-assets') }}/js/no-internet.js"></script>
    <script src="{{ asset('mobile-assets') }}/js/active.js"></script>
    <script src="{{ asset('mobile-assets') }}/js/pwa.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/default.js') }}"></script>

    @stack('scripts-mobile')