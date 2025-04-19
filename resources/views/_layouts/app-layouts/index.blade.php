<!DOCTYPE html>
<html lang="en">
    @include('_layouts.app-layouts.head')
    <body class="">
        <div class="loader-bg">
            <div class="loader-track">
                <div class="loader-fill"></div>
            </div>
        </div>
        @include('_layouts.app-layouts.navbar')
        @include('_layouts.app-layouts.header')
        <div class="pcoded-main-container">
            <div class="pcoded-wrapper">
                <div class="pcoded-content">
                    <div class="pcoded-inner-content">
                        <div class="main-body">
                            <div class="page-wrapper">
                                @if(!empty($title))
                                <div class="page-header">
                                    <div class="page-block">
                                        <div class="row align-items-center">
                                            <div class="col-md-12">
                                                <div class="page-header-title">
                                                    <h5>{{ $title }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif 
                                <div class="row">
                                    <div class="col-sm-12">
                                        @yield('content')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('_layouts.app-layouts.script')

        @if (\Session::has('status'))
        <script>
            showSwal('{{ Session::get('status') }}', '{{ Session::get('message') }}');
        </script>
        @endif
    </body>
</html>