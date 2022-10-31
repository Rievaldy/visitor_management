<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        {{-- <link rel="icon" href="{{ asset('img/favicon.png') }}"> --}}
        <title></title>
        @include('Layouts._head')
        @yield('head')
    </head>
    <body class="pt-0" style="background: #f0f0f0">
        @yield('content')
        @include('Layouts._script')
        @yield('script')
        @yield('script2')
    </body>
</html>
