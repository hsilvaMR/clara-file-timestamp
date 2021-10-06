<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>

        @include('pages/timestamp/includes/head')

        @yield('css')
    </head>
    <body>


        @yield('content')



        @yield('javascript')
    </body>
</html>