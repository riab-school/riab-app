<head>

	<title>{{ appSet('APP_NAME') }} - {{ appSet('SCHOOL_NAME') }}</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="Aplikasi {{ appSet('APP_NAME') }} {{ appSet('SCHOOL_CATEGORY')." ".appSet('SCHOOL_NAME') }}" />
	<meta name="keywords" content="SIAKAD, Aplikasi, Sistem Informasi, SisAkademik, Siakad, Sisfo, Kesantrian, Pesantren Digital">
	<meta name="author" content="Achdiadsyah" />

	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="icon" href="{{ asset(appSet('SCHOOL_ICON')) }}" type="image/x-icon">
	<link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome/css/fontawesome-all.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/plugins/animation/css/animate.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

	@stack('styles')
	
</head>