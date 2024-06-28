
<!DOCTYPE html>
<html>
    <head>
        @include('layouts.backend.head')
    </head>
    <body class="fix-header fix-sidebar card-no-border">
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper">
                @include('layouts.backend.header')
                @include('layouts.backend.sidebar')
                
                <div class="main-panel">
                    @yield('content')
                    @include('layouts.backend.footer')
                </div>
            </div>
        </div>
        @include('layouts.backend.script')
    </body>
</html>