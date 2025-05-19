<!DOCTYPE html>
<html lang="en">
	@include('_layouts.mobile-layouts.head')
	<body>

		<div class="preloader" id="preloader">
			<div class="spinner-grow text-secondary" role="status">
				<div class="sr-only"></div>
			</div>
		</div>

		<div class="header-area" id="headerArea">
			<div class="container h-100 d-flex align-items-center justify-content-between d-flex rtl-flex-d-row-r">
				@if(Route::is('parent.home'))
				<div class="logo-wrapper">
					<a href="{{ request()->home_url }}">
						<img src="{{ asset('assets/images/logo.png') }}" alt="logo" class="logo" style="width: 35px; height: auto;">
					</a>
				</div>
				@else
				<div class="back-button me-2">
					<a href="{{ url()->previous() }}">
						<i class="fa-solid fa-arrow-left-long"></i>
					</a>
				</div>
				@endif
				<div class="navbar-logo-container d-flex align-items-center">
					<div class="suha-navbar-toggler ms-2" data-bs-toggle="offcanvas" data-bs-target="#suhaOffcanvas" aria-controls="suhaOffcanvas">
						<div>
							<span></span>
							<span></span>
							<span></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		@include('_layouts.mobile-layouts.navbar')

		<div class="page-content-wrapper py-3">
			@yield('content')
		</div>
		
		<div class="internet-connection-status" id="internetStatus"></div>

		@include('_layouts.mobile-layouts.footer')

	</body>
</html>