<div class="offcanvas offcanvas-start suha-offcanvas-wrap" tabindex="-1" id="suhaOffcanvas" aria-labelledby="suhaOffcanvasLabel">
    <button class="btn-close btn-close-white" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    <div class="offcanvas-body">
        <div class="sidenav-profile">
            <div class="user-profile">
                <img class="img-fluid" src="{{ auth()->user()->myDetail->photo == 'default.png' ? asset('assets/images/blank_person.jpg') : Storage::disk('s3')->url(auth()->user()->myDetail->photo)  }}" alt="img_thumb">
            </div>
            <div class="user-info">
                <h5 class="user-name mb-1 text-white">{{ auth()->user()->myDetail->name }}</h5>
            </div>
        </div>
        <ul class="sidenav-nav ps-0">
            <li>
                <a href="{{ route('parent.profile') }}">
                    <i class="fa-solid fa-user"></i>Profil Saya
                </a>
            </li> 
            <li>
                <a href="{{ route('parent.anandaku') }}">
                    <i class="fa-solid fa-user"></i>Anandaku
                </a>
            </li> 
            <li>
                <a href="{{ route('parent.settings') }}">
                    <i class="fa-solid fa-sliders"></i>Pengaturan
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}">
                    <i class="fa-solid fa-toggle-off"></i>Keluar
                </a>
            </li>
        </ul>
    </div>
</div>