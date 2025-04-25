<div class="offcanvas offcanvas-start suha-offcanvas-wrap" tabindex="-1" id="suhaOffcanvas" aria-labelledby="suhaOffcanvasLabel">
    <button class="btn-close btn-close-white" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    <div class="offcanvas-body">
        <div class="sidenav-profile">
            <div class="user-profile">
                <img src="{{ asset('mobile-assets') }}/img/bg-img/9.jpg" alt="">
            </div>
            <div class="user-info">
                <h5 class="user-name mb-1 text-white">{{ auth()->user()->myDetail->name }}</h5>
            </div>
        </div>
        <ul class="sidenav-nav ps-0">
        <li><a href="profile.html"><i class="fa-solid fa-user"></i>Profil Saya</a></li> 
        <li><a href="profile.html"><i class="fa-solid fa-user"></i>Anandaku</a></li> 
        <li><a href="settings.html"><i class="fa-solid fa-sliders"></i>Pengaturan</a></li>
        <li><a href="{{ route('logout') }}"><i class="fa-solid fa-toggle-off"></i>Keluar</a></li>
        </ul>
    </div>
</div>