<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="{{ asset('img/favicon.png') }}">
        <title>Smart Office</title>
        @include('Layouts._head')
        @yield('head')

    </head>
    <body class="skin-dark dark bg-img pt-0" data-overlay="1" onload="startTime()">
        @yield('content')
        @include('Layouts._script')
        @yield('script')
    </body>
</html>
