@extends('master')

{{-- @section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Locker List</h3>
    </div>
@endsection --}}

@section('head')
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
@endsection


@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            {{-- <h4 class="box-title">Attendance ({{$monthName}}, {{$year}})</h4> --}}
                            <h4 class="box-title">Smart Locker</h4>
                        </div>
                    </div>
                </div>
                {{-- <div class="box-body"> --}}
                    {{-- <div class="container"> --}}
                        {{-- <div class=""> --}}
                            {{-- <div class="col-11 col-sm-9 col-md-7 col-lg-6 text-center p-0 mt-3 mb-2"> --}}
                                {{-- <div class=""> --}}
                                <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-12 mx-0">
                                            <form id="msform">
                                                <ul id="progressbar">
                                                    <li class="active" id="account"><strong>Request Order</strong></li>
                                                    <li class="active" id="personal"><strong>Waiting for Approval</strong></li>
                                                    <li class="active" id="payment"><strong>Admin Approval Verification</strong></li>
                                                    <li class="active" id="cash"><strong>Open Locker</strong></li>
                                                    <li id="confirm"><strong>Approved</strong></li>
                                                    
                                                </ul>
                                            </form>
                                            <fieldset>
                                            {{-- <form action="{{ url('locker-access/open-lockers') }}" method="POST"> --}}
                                                {{-- @csrf --}}
                                                <div class="form-card">
                                                    @if(session('errors'))
                                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                            Something it's wrong:
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                        </button>
                                                        <ul>
                                                        @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                        @endforeach
                                                        </ul>
                                                        </div>
                                                        @endif
                                                        @if (Session::has('success'))
                                                        <div class="alert alert-success">
                                                        {{ Session::get('success') }}
                                                        </div>
                                                        @endif
                                                        @if (Session::has('errors'))
                                                            <div class="alert alert-danger">
                                                                {{ Session::get('errors') }}
                                                            </div>
                                                        @endif
                                                        <div class="box-body">
                                                            <div class="form-group">
                                                                    <div class="panel panel-primary">
                                                                        <div class="panel-heading text-center">Verification has been successfully</div>
                                                                    </div>
                                                            </div>
                                                                <div class="form-group">
                                                                    <div class="col-12">
                                                                        <b><p>Open Locker</p></b>
                                                                    <p>This software will quickly open locker from your ID locker</p><br><br>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-3">
                                                                        {{-- {{ dd($rata) }} --}}
                                                                        <form action="{{ url('locker-access/open-lockers/'.$rata[0]->id) }}" method="POST">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-bold btn-pure btn-primary btn-block">Open Locker</button>
                                                                        </form>
                                                                    </div><br>
                                                                    <div class="col-7">
                                                                        <span class="form-text text-muted font-size-12"><i class="fas fa-check-circle" style="font-size:15px;color:green;"></i>  Open Locker button will automatically unlock your ID locker. Please confirmation your PIC before click.</span>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                </div>
                                            {{-- </form> --}}
                                        </fieldset>
                                                {{-- <fieldset>
                                                    <div class="form-group">
                                                        <div class="col-12">
                                                            <div class="panel panel-default">
                                                                <div class="panel-body btn-primary">Verification has been successfully</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-card">
                                                        <div class="form-group">
                                                            <div class="col-6">
                                                                <h2 class="fs-title text-left">Approved !</h2>
                                                                <p>Your ID Locker has been unlocked. Click the approved button to complete the order request</p>  
                                                            </div>
                                                        </div><br><br>
                                                        <div class="form-group">
                                                                <div class="bd-example" style="padding-left: 10px;">
                                                                    <button type="button" class="btn btn-primary">Approved</button>
                                                                    <button type="button" class="btn btn-light">Back</button>
                                                                </div>
                                                            <span class="form-text text-muted font-size-12"><i class="fas fa-check-circle" style="font-size:15px;color:green; padding-left: 10px;"></i>Approved button will automatically fulfil your request.</span>

                                                        </div>
                                                    </div>
                                                </fieldset> --}}
                                        </div>
                                    </div>
                                </div>
                            {{-- </div> --}}
                        {{-- </div> --}}
                    {{-- </div> --}}
                {{-- </div> --}}
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"> --}}
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <script>
        var x = document.getElementById("demo");

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }

        function showPosition(position) {
            $('#lat').val(position.coords.latitude)
            $('#long').val(position.coords.longitude)

            // x.innerHTML = "Latitude: " + position.coords.latitude +
            // "<br>Longitude: " + position.coords.longitude;
        }
    </script>
    <script>
        $(document).ready(function(){

        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;

        $(".next").click(function(){

        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        //Add Class Active
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
        step: function(now) {
        // for making fielset appear animation
        opacity = 1 - now;

        current_fs.css({
        'display': 'none',
        'position': 'relative'
        });
        next_fs.css({'opacity': opacity});
        },
        duration: 600
        });
        });

        $(".previous").click(function(){

        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();

        //Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        //show the previous fieldset
        previous_fs.show();

        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
        step: function(now) {
        // for making fielset appear animation
        opacity = 1 - now;

        current_fs.css({
        'display': 'none',
        'position': 'relative'
        });
        previous_fs.css({'opacity': opacity});
        },
        duration: 600
        });
        });

        $('.radio-group .radio').click(function(){
        $(this).parent().find('.radio').removeClass('selected');
        $(this).addClass('selected');
        });

        $(".submit").click(function(){
        return false;
        })

        });2
    </script>
@endsection

