@extends('master')

{{-- @section('breadcrumb')
<div class="mr-auto w-p50">
    <h3 class="page-title border-0">Locker List</h3>
</div>
@endsection --}}

@section('head')
{{--
<meta name="csrf-token" content="{{ csrf_token() }}"> --}}
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
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                <div class="row">
                    <div class="col-md-12 mx-0">
                        <form id="msform">
                            <ul id="progressbar">
                                <li class="active" id="account"><strong>Request Order</strong></li>
                                <li id="personal"><strong>Waiting for Approval</strong></li>
                                <li id="payment"><strong>Admin Approval Verification</strong></li>
                                <li id="cash"><strong>Open Locker</strong></li>
                                <li id="confirm"><strong>Approved</strong></li>

                            </ul>
                        </form>
                        <fieldset>
                            <form action="{{ route('addRequest') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-card">
                                    @if (session('errors'))
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
                                    @if (Session::has('error'))
                                    <div class="alert alert-danger">
                                        {{ Session::get('error') }}
                                    </div>
                                    @endif
                                    <div class="box-body">
                                        <h2 class="fs-title">Request Order</h2>
                                        <div class="form-group">
                                            <label>Pick up location select one</label>
                                            <div class="row">
                                                <div class="col-5">
                                                    <input type="text" name="lat" id="lat" class="form-control" value=""
                                                        readonly required>
                                                </div>
                                                <div class="col-5">
                                                    <input type="text" name="longs" id="long" class="form-control"
                                                        value="" readonly required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-5">

                                                    {{-- @foreach ($data as $datas) --}}
                                                    @if ($selectedIdx != -1)
                                                    <label>ID Locker</label>
                                                    <input type="text" name="id_locker" class="form-control"
                                                        value="{{ $data[$selectedIdx]->device_id }}" readonly>
                                                    @else
                                                    <label>ID Locker</label>
                                                    <input type="text" name="id_locker" class="form-control" value="You dont have a locker"
                                                        disabled>
                                                    @endif
                                                    {{-- @endforeach --}}
                                                    {{-- @if (in_array(Auth::user()->id, $data, true))
                                                    <label>ID Locker</label>
                                                    <input type="text" name="id_locker" class="form-control"
                                                        value="{{ $data['user_id']->device_id }}" readonly>
                                                    @endif --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>PIC</label>
                                            <div class="row">
                                                <div class="col-10">
                                                    <select name="pic_id" id="" class="form-control select2">
                                                        @foreach ($pic as $pic)
                                                        <option value="{{ $pic->id }}">{{ $pic->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Pick up your necessity</label>
                                            <div class="c-inputs-stacked">
                                                <input type="radio" id="age1" name="necessity" value="1"
                                                    onclick="show1();" checked>
                                                <label for="age1">Document</label><br>

                                                <input type="radio" id="age2" name="necessity" value="2"
                                                    onclick="show2();">
                                                <label for="age2">Stationary</label><br>

                                                <input type="radio" id="age3" name="necessity" value="3"
                                                    onclick="show3();">
                                                <label for="age3">Apparel</label><br>

                                                <input type="radio" id="age4" name="necessity" value="4"
                                                    onclick="show4();">
                                                <label for="age4">Others</label>


                                                <div id="div1" class="hide col-5">
                                                    <input type="text" class="form-control" maxlength="20"
                                                        name="description">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Open Method</label>
                                            <div class="row">
                                                <div class="col-3">
                                                    <input type="radio" id="method" name="method" value="1" checked>
                                                    <label for="method">ID Face
                                                        Recognition</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Notes</label>
                                            <div class="row">
                                                <div class="col-10">
                                                    <input type="text" class="form-control" name="notes" maxlength="20">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Image</span></label>
                                            <div class="row">
                                                <div class="col-10">
                                                    <input type="file" name="img" class="form-control" value="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-3">
                                                    <button type="submit"
                                                        class="btn btn-bold btn-pure btn-primary float-right btn-block">Get
                                                        Code</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
{{--
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"> --}}
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
    function show1() {
            document.getElementById('div1').style.display = 'none';
        }

        function show2() {
            document.getElementById('div1').style.display = 'none';
        }

        function show3() {
            document.getElementById('div1').style.display = 'none';
        }

        function show4() {
            document.getElementById('div1').style.display = 'block';
        }
</script>
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

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    x.innerHTML = "User denied the request for Geolocation."
                    break;
                case error.POSITION_UNAVAILABLE:
                    x.innerHTML = "Location information is unavailable."
                    break;
                case error.TIMEOUT:
                    x.innerHTML = "The request to get user location timed out."
                    break;
                case error.UNKNOWN_ERROR:
                    x.innerHTML = "An unknown error occurred."
                    break;
            }
        }
</script>
<script>
    $(document).ready(function() {

            var current_fs, next_fs, previous_fs; //fieldsets
            var opacity;

            $(".next").click(function() {

                current_fs = $(this).parent();
                next_fs = $(this).parent().next();

                //Add Class Active
                $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                //show the next fieldset
                next_fs.show();
                //hide the current fieldset with style
                current_fs.animate({
                    opacity: 0
                }, {
                    step: function(now) {
                        // for making fielset appear animation
                        opacity = 1 - now;

                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        next_fs.css({
                            'opacity': opacity
                        });
                    },
                    duration: 600
                });
            });

            $(".previous").click(function() {

                current_fs = $(this).parent();
                previous_fs = $(this).parent().prev();

                //Remove class active
                $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

                //show the previous fieldset
                previous_fs.show();

                //hide the current fieldset with style
                current_fs.animate({
                    opacity: 0
                }, {
                    step: function(now) {
                        // for making fielset appear animation
                        opacity = 1 - now;

                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        previous_fs.css({
                            'opacity': opacity
                        });
                    },
                    duration: 600
                });
            });

            $('.radio-group .radio').click(function() {
                $(this).parent().find('.radio').removeClass('selected');
                $(this).addClass('selected');
            });

            $(".submit").click(function() {
                return false;
            })

        });
        2
</script>
@endsection