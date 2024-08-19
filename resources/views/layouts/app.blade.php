<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('includes.head')
</head>
<body id="page-top" class="@yield('class')">
    <div id="wrapper">
         @if(Route::current()->getName()!='login'  AND Route::current()->getName()!='register' AND Route::current()->getName()!='password.reset' AND Route::current()->getName()!='password.request')
         @include('includes.sidebar')
         @endif
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <div id="app">
                    @include('includes.header')
                    @yield('content')
                </div>
            </div>
            @include('includes.footer')
        </div>
    </div>
</body>
</html>