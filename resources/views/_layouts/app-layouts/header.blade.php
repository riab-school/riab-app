<header class="navbar pcoded-header navbar-expand-lg navbar-light headerpos-fixed">
    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse1" href="#!"><span></span></a>
        <a href="" class="b-brand">

            <img src="{{ asset(appSet('APP_LOGO_LIGHT')) }}" alt="logo" class="logo images" style="max-height: 35px">
            <img src="{{ asset(appSet('SCHOOL_LOGO')) }}" alt="logo" class="logo-thumb images" style="max-height: 45px">
        </a>
    </div>
    <a class="mobile-menu" id="mobile-header" href="#!">
        <i class="feather icon-more-horizontal"></i>
    </a>
    <div class="collapse navbar-collapse d-none d-lg-block">
        <a href="#!" class="mob-toggler"></a>
        <ul class="navbar-nav ms-auto">
            <li>
                <div class="dropdown drp-user">
                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="icon feather icon-settings"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end profile-notification">
                        <div class="pro-head">
                            <img src="https://ui-avatars.com/api/?background=19BCBF&color=fff&name={{ auth()->user()->myDetail->name }}" class="img-radius"
                                alt="User-Profile-Image">
                            <span>
                                <span class="text-muted">{{ auth()->user()->myDetail->name }}</span>
                                <span class="h6">{{ ucfirst(auth()->user()->user_level) }}</span>
                            </span>
                        </div>
                        <ul class="pro-body">
                            <li>
                                <a href="{{ route('profile') }}" class="dropdown-item">
                                    <i class="feather icon-user text-danger"></i>
                                    My Profile
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}" class="dropdown-item">
                                    <i class="feather icon-power text-danger"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>