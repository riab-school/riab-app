<nav class="pcoded-navbar menupos-fixed menu-dark menu-item-icon-style6 ">
    <div
        class="navbar-wrapper ">
        <div class="navbar-brand header-logo">
            <a href="{{ request()->home_url }}" class="b-brand">
                <img src="{{ asset(appSet('APP_LOGO_LIGHT')) }}" alt="logo" class="logo images" style="max-height: 35px">
                <img src="{{ asset(appSet('SCHOOL_LOGO')) }}" alt="logo" class="logo-thumb images" style="max-height: 45px">
            </a>
            <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
        </div>
        <div class="navbar-content scroll-div" id="layout-sidenav">
            <ul class="nav pcoded-inner-navbar sidenav-inner">

                @if(auth()->user()->user_level == 'admin')
                    @include('_layouts.app-layouts.menu-list.admin')
                @endif

                @if(auth()->user()->user_level == 'staff')
                    @include('_layouts.app-layouts.menu-list.staff')
                @endif

                @if(auth()->user()->user_level == 'student' && auth()->user()->myDetail->status == 'new')
                    @include('_layouts.app-layouts.menu-list.student-new')
                @endif

                @if(auth()->user()->user_level == 'student' && auth()->user()->myDetail->status == 'active')
                    @include('_layouts.app-layouts.menu-list.student-active')
                @endif


                {{-- Only show on mobile --}}
                <li class="nav-item pcoded-menu-caption d-lg-none">
                    <label>Others</label>
                </li>
                <li data-username="animations" class="nav-item d-lg-none">
                    <a href="{{ route('profile') }}" class="nav-link">
                        <span class="pcoded-micon">
                            <i class="feather icon-user"></i>
                        </span>
                        <span class="pcoded-mtext">My Profile</span>
                    </a>
                </li>
                <li data-username="animations" class="nav-item d-lg-none">
                    <a href="{{ route('logout') }}" class="nav-link">
                        <span class="pcoded-micon">
                            <i class="feather icon-power"></i>
                        </span>
                        <span class="pcoded-mtext">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        
    </div>
</nav>