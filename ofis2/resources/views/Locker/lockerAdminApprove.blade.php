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
                                                    <li id="cash"><strong>Open Locker</strong></li>
                                                    <li id="confirm"><strong>Approved</strong></li>
                                                </ul>

                                                {{-- Admin approval verification --}}
                                                <fieldset>
                                                    <div class="form-group">
                                                        <div class="col-12">
                                                            <div class="panel panel-default">
                                                                <div class="panel-body btn-success">Administrator approve your request</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-card">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <p>Enter the code</p>
                                                                    <p>Enter the 5-digit verification code miled to this email address on <b>02-FEB-2022</b>Verify the code once</p>
                                                                </div><br>
                                                                <div class="form-group">
                                                                    <div class="col-6">
                                                                        <label for="">Email</label>
                                                                        <input type="text" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-6">
                                                                        <label for="">ID Lockers</label>
                                                                        <input type="text" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-6">
                                                                        <label for="">Verification Code</label>
                                                                        <input type="text" class="form-control">
                                                                        <span class="form-text text-muted font-size-12"><i class="fas fa-check-circle" style="font-size:15px;color:green;"></i>  The Verification code remains valid for one day and time use. Please dont share this code with other</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <a href="{{ url('locker-access/open-locker') }}" type="button" class="btn btn-primary">Verify</a>
                                                                </div><br>
                                                                <div class="form-group">
                                                                    <p>Having Problem? <a href=""> Resend Verification code</a></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </fieldset>
                                            </form>
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

