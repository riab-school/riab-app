<!DOCTYPE html>
<html lang="en">

@include('_layouts.auth-layouts.head')

<div class="auth-wrapper" style="background: url('{{ asset('assets/images/auth/bg-auth.jpg') }}') repeat fixed center; background-color: rgba(255,255,255,0.8); background-blend-mode: lighten;">
	<div class="auth-content container">
		<div class="card">
			<div class="row align-items-center">
				<div class="col-md-6">
					<div class="card-body">
						<div class="text-center pb-5">
							<img src="{{ asset(appSet('APP_LOGO_DARK')) }}" alt="" class="img-fluid mb-4" width="50%">
						</div>
						@yield('content')
					</div>
				</div>
				<div class="col-md-6 d-none d-md-block">
					<img src="{{ asset('assets/images/auth/auth-img.jpg') }}" alt="" class="img-fluid">
				</div>
			</div>
		</div>
	</div>
</div>

@include('_layouts.auth-layouts.script')
@if (\Session::has('status'))
<script>
	showSwal('{{ Session::get('status') }}', '{{ Session::get('message') }}');
</script>
@endif
</body>

</html>