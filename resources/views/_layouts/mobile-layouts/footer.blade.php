
    <div class="footer-nav-area" id="footerNav">
        <div class="suha-footer-nav">
        <ul class="h-100 d-flex align-items-center justify-content-between ps-0 d-flex rtl-flex-d-row-r">
            <li><a href="{{ request()->home_url }}"><i class="fa-solid fa-house"></i>Beranda</a></li>
            <li><a href="{{ route('parent.chat') }}"><i class="fa-solid fa-comment-dots"></i>Chat</a></li>
            <li><a href="{{ route('parent.berita') }}"><i class="fa-solid fa-bullhorn"></i>Berita</a></li>
            <li><a href="{{ route('parent.settings') }}"><i class="fa-solid fa-sliders"></i>Pengaturan</a></li>
            <li><a href="{{ route('parent.profile') }}"><i class="fa-solid fa-user"></i>Profil</a></li>
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
    
    <script>
        $(document).on('click', '.img-preview', function () {
            const src = $(this).data('src');
            $('#previewImage').attr('src', src);
            $('#imagePreviewModal').modal('show');
        });
    </script>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/68e5cc1011d1b11954cbcc0e/1j70qa8h6';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
    <!--End of Tawk.to Script-->

    @stack('scripts-mobile')

    @if (\Session::has('status'))
    <script>
        showSwal('{{ Session::get('status') }}', '{{ Session::get('message') }}');
    </script>
    @endif