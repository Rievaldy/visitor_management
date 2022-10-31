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
    <body class="skin-dark dark" onload="startTime()" data-overlay="7" style="background: url({{ asset('img/bg-ds.jpeg')}}) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;"">
        {{-- <div class="wrapper"> --}}
            {{-- @include('Layouts._navbarDevice') --}}

            <!-- Left side column. contains the logo and sidebar -->
            {{-- @include('Layouts._sidebar') --}}

            <!-- Content Wrapper. Contains page content -->
            {{-- <div class="content-wrapper"> --}}
                <div class="container-fluid" style="min-height: 100vh">
                    <div class="content-header">
                        <div class="d-flex align-items-center">
                            @yield('breadcrumb')
                        </div>
                    </div>
                    <!-- Main content -->
                    <section class="content">
                        @yield('content')
                    </section>
                    <!-- /.content -->
                </div>
            {{-- </div> --}}
            {{-- <footer class="main-footer">
                <?php
                    echo "&copy;" . date("Y") . " All Rights Reserved";
                ?>
            </footer> --}}
        {{-- </div> --}}
        @include('Layouts._script')
        @yield('script')
    </body>
</html>
