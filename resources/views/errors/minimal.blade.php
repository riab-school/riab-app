<!DOCTYPE html>
<html lang="en">
    @include('_layouts.app-layouts.head')
    <body>
        
        <div class="auth-wrapper error">
            <div id="container" class="container">
                <h1>@yield('code')</h1>
                @yield('message')
            </div>
        </div>
    </body>
</html>
