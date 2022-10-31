@extends('master')

{{-- @section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Locker List</h3>
    </div>
@endsection --}}

@section('head')
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    @if ($data[0]->status == 1)
        <meta http-equiv="refresh" content="10">
    @endif
    <meta name="_token" content="{{ csrf_token() }}">
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css"> --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"> --}}
@endsection


@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">Smart Locker waiting</h4>
                        </div>
                    </div>
                </div>
                <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-12 mx-0">
                                            @if ($data[0]->status == 1)
                                            <form id="msform">
                                                <ul id="progressbar">
                                                    <li class="active" id="account"><strong>Request Order</strong></li>
                                                    <li class="active" id="personal"><strong>Waiting for Approval</strong></li>
                                                    <li id="payment"><strong>Admin Approval Verification</strong></li>
                                                    <li id="cash"><strong>Open Locker</strong></li>
                                                    <li id="confirm"><strong>Approved</strong></li>
                                                </ul>
                                            </form>
                                                                <div class="form-group">
                                                                    <div class="col-12">
                                                                        <div class="panel panel-warning">
                                                                            <div class="panel-heading text-center">Administrator approve your request</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <fieldset>
                                                                    <form action="">
                                                                        <div class="box-body">
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
                                                                                <div class="form-group">
                                                                                    <label>Pick up location select one</label>
                                                                                    <div class="row">
                                                                                        <div class="col-5">
                                                                                            <input type="text" name="lat" id="lat" class="form-control" value="{{ $data[0]->lat }}" readonly required>
                                                                                        </div>
                                                                                        <div class="col-5">
                                                                                            <input type="text" name="long" id="long" class="form-control" value="{{ $data[0]->longs}}" readonly required>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>ID Locker</label>
                                                                                    <div class="row">
                                                                                        <div class="col-5">
                                                                                            <input type="text" class="form-control" value="{{ $data[0]->id_locker }}" readonly>
                                                                                            {{-- <input type="text" class="form-control" value="{{ $data[0]->status }}" readonly> --}}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>PIC</label>
                                                                                    <div class="row">
                                                                                        <div class="col-10">
                                                                                            <select name="" id="" class="form-control select2" disabled>
                                                                                                @foreach ( $getID as $getIDS)
                                                                                                    <option value="{{ $getIDS->id }}" {{ $data[0]->pic_id == $getIDS->id?'selected':'' }}>{{ $getIDS->name }}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Pick up necessity</label>
                                                                                    <div class="c-inputs-stacked">
                                                                                        <input name="is_ds_reader" type="radio" id="document" value="1" disabled {{ $data[0]->necessity==1?'checked':'' }}>
                                                                                        <label for="document" class="mr-30">Document</label><br>
                                                                                        <input name="is_ds_reader" type="radio" id="stationary" value="2" disabled {{ $data[0]->necessity==2?'checked':'' }}>
                                                                                        <label for="stationary" class="mr-30">Stationary</label><br>
                                                                                        <input name="is_ds_reader" type="radio" id="apparel" value="3" disabled {{ $data[0]->necessity==3?'checked':'' }}>
                                                                                        <label for="apparel" class="mr-30">Document</label><br>
                                                                                        <input name="is_ds_reader" type="radio" id="other" value="4" disabled {{ $data[0]->necessity==4?'checked':'' }}>
                                                                                        <label for="other" class="mr-30">Others</label>
            
                                                                                    </div><br>
                                                                                    <div class="row">
                                                                                        <div class="col-10">
                                                                                            @if ($data[0]->description != null)
                                                                                                <input type="text" class="form-control" value="{{ $data[0]->description }}" disabled>
                                                                                            @else
                                                                                                <input type="text" class="form-control" disabled>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="">Open Method</label>
                                                                                    <div class="row">
                                                                                        <div class="col-3">
                                                                                            <input type="radio" id="method" name="" value="1" disabled {{ $data[0]->method == 1 ?'checked':'' }}>
                                                                                            <label for="method">ID Face
                                                                                                Recognition</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="row">
                                                                                        {{-- {{ dd($data) }} --}}
                                                                                        <div class="col-10">
                                                                                            <label>Notes</label>
                                                                                            <input type="text" class="form-control" value="{{ $data[0]->notes }}" readonly>
                                                                                        </div><br>
                                                                                    </div>
                                                                                </div><br>
                                                                                <div class="form-group">
                                                                                    <label>Image</label>
                                                                                    <div class="row">
                                                                                        <div class="col-10">
                                                                                            @if ($data[0]->img != null)
                                                                                                <img src="{{ $data[0]->img }}" alt="" class="shadow" style="width: 100%; object-fit: cover">
                                                                                            @else
                                                                                                No image uploaded
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="row">
                                                                                        <div class="col-10">
                                                                                            <input type="file" name="img" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                    </fieldset>
                                                            @elseif ($data[0]->status == 2)
                                                                {{-- Status 2 --}}
                                                                <form id="msform">
                                                                    <ul id="progressbar">
                                                                        <li class="active" id="account"><strong>Request Order</strong></li>
                                                                        <li class="active" id="personal"><strong>Waiting for Approval</strong></li>
                                                                        <li class="active" id="payment"><strong>Admin Approval Verification</strong></li>
                                                                        <li id="cash"><strong>Open Locker</strong></li>
                                                                        <li id="confirm"><strong>Approved</strong></li>
                                                                        
                                                                    </ul>
                                                                </form>
                                                                <div class="form-group">
                                                                    <div class="col-12">
                                                                        <div class="panel panel-danger">
                                                                            <div class="panel-heading text-center">Administrator reject your request</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <fieldset>
                                                                    <form action="{{ url('locker-access/request-again/'.$data[0]->id) }}" method="POST">
                                                                        @csrf
                                                                        <div class="box-body">
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
                                                                            <div class="form-card">
                                                                                <div class="form-group">
                                                                                    <h4>Reject Order!</h4>
                                                                                    <p>Sorry we could not verify your request. Note that this will clear your request details.</p>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="row">
                                                                                        <div class="col-10">
                                                                                            <label>Notes</label>
                                                                                            <textarea name="notes" id="" cols="30" rows="10" class="form-control" required></textarea>
                                                                                            <span class="form-text text-muted font-size-12"><i class="fas fa-exclamation-circle" style="font-size:15px;color:red;"></i> Please comment with any additional information</span>
                                                                                        </div>
                                                                                    </div><br>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="row">
                                                                                        <div class="col-3">
                                                                                            <button type="submit" class="btn btn-bold btn-pure btn-primary float-right btn-block">Confirmation</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                            </fieldset>
                                                        {{-- </form> --}}
                                                    @else
                                                    <form id="msform">
                                                        <ul id="progressbar">
                                                            <li class="active" id="account"><strong>Request Order</strong></li>
                                                            <li class="active" id="personal"><strong>Waiting for Approval</strong></li>
                                                            <li class="active" id="payment"><strong>Admin Approval Verification</strong></li>
                                                            <li id="cash"><strong>Open Locker</strong></li>
                                                            <li id="confirm"><strong>Approved</strong></li>
                                                        </ul>
                                                    </form>
                                                        {{-- Admin approval verification --}}
                                                        <fieldset>
                                                            <form action="{{ url('locker-access/confirmed-code/'.$data[0]->id) }}" method="POST" enctype="multipart/form-data">
                                                            {{-- <form action="{{ url('locker-access/confirmed-code/'.$data[0]->id) }}" method="POST" enctype="multipart/form-data"> --}}
                                                                @csrf
                                                                <div class="form-card">
                                                                    <div class="box-body">
                                                                        {{-- @if (session('errors'))
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
                                                                        @endif --}}
                                                                        <div class="form-group">
                                                                            <div class="col-12">
                                                                                <div class="panel panel-success">
                                                                                    <div class="panel-heading text-center">Administrator approve your request</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                            {{-- <div class="form-card"> --}}
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <div class="col-6">
                                                                                            <p>Enter the code</p>
                                                                                            <p>Enter the verification code miled to email <b>{{ Auth::user()->email }}</b> on <b>{{ $date }}.</b> Verify the code once</p><br>
                                                                                            <label for="">Email</label>
                                                                                            <input type="text" class="form-control" name="email" disabled value="{{ $data[0]->email }}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <div class="col-6">
                                                                                            <label for="">ID Lockers</label>
                                                                                            <input type="text" class="form-control" name="id_locker" disabled value="{{ $data[0]->id_locker }}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <div class="col-6">
                                                                                            <label for="">Verification Code</label>
                                                                                            <input type="text" class="form-control" name="code">
                                                                                            <span class="form-text text-muted font-size-12"><i class="fas fa-check-circle" style="font-size:15px;color:green;"></i>  The Verification code remains valid for one day and time use. Please dont share this code with other</span>
                                                                                        </div><br>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <div class="col-3">
                                                                                            <button type="submit" class="btn btn-bold btn-pure btn-primary float-right btn-block">Verify</button>
                                                                                        </div>
                                                                                    </div>
                                                                                    {{-- <div class="col-6">
                                                                                        <a href="{{ url('locker-access/open-locker') }}" type="button" class="btn btn-primary">Verify</a>
                                                                                    </div><br> --}}
                                                                                    {{-- <div class="form-group">
                                                                                        <div class="col-6">
                                                                                            <p>Having Problem? <a href=""> Resend Verification code</a></p>
                                                                                        </div>
                                                                                    </div> --}}
                                                                                </div>
                                                                            </div>
                                                                            {{-- </div> --}}
                                                                    </div> 
                                                                </div>
                                                            </form>
                                                                <div class="form-card">
                                                                    <div class="box-body">
                                                                        <div class="form-group">
                                                                            <div class="col-6">
                                                                                <p>Having problem? <a href="javascript:void(0)" onclick="resendEmail()"> Resend verification code</a></p>
                                                                                {{-- <p>Having Problem? <a href=""> Resend Verification code</a></p> --}}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </fieldset>
                                                                {{-- <fieldset>
                                                                    <form action="{{ url('locker-access/confirmed-code/'.$data[0]->id) }}" method="POST">
                                                                        @csrf
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
                                                                                <div class="col-12">
                                                                                    <div class="panel panel-success">
                                                                                        <div class="panel-heading text-center">Administrator approve your request</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                                <div class="row">
                                                                                    <div class="col-12">
                                                                                        <div class="form-group">
                                                                                            <div class="col-6">
                                                                                                <p>Enter the code</p>
                                                                                                <p>Enter the verification code miled to email <b>{{ Auth::user()->email }}</b> on <b>{{ $date }}.</b> Verify the code once</p><br>
                                                                                                <label for="">Email</label>
                                                                                                <input type="text" class="form-control" name="email" disabled value="{{ $data[0]->email }}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <div class="col-6">
                                                                                                <label for="">ID Lockers</label>
                                                                                                <input type="text" class="form-control" name="id_locker" disabled value="{{ $data[0]->id_locker }}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <div class="col-6">
                                                                                                <label for="">Verification Code</label>
                                                                                                <input type="text" class="form-control" name="code">
                                                                                                <span class="form-text text-muted font-size-12"><i class="fas fa-check-circle" style="font-size:15px;color:green;"></i>  The Verification code remains valid for one day and time use. Please dont share this code with other</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <div class="col-3">
                                                                                                <button type="submit" class="btn btn-bold btn-pure btn-primary float-right btn-block">Verify</button>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <div class="col-6">
                                                                                                <p>Having Problem? <a href=""> Resend Verification code</a></p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                        </div> 
                                                                        </div>
                                                                    </form>
                                                                </fieldset> --}}
                                                    @endif
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
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>
        function resendEmail() {
            console.log('Send');
            let id = "{{ $data[0]->id }}";
            $.ajax({
                type: "POST",
                url: "{{ url('locker-access/resend-verification-code') }}" + '/'+ id,
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content'),
                    'Access-Control-Allow-Origin' : '*'
                },
                // success: function (response) {
                //     console.log(response);
                // }
                dataType: "JSON",
                success: function(response) {
                    if(response.status == true){
                        Swal.fire('Success',response.data,'success');
                    }else{
                        Swal.fire('Error',response.data,'error');
                    }
                }
            });
        }
        // function resetPassword() {
        //     $.ajax({
        //         type: "POST",
        //         url: "{{ url('user/change-password/') }}" + '/' + $('#user_id').val(),
        //         data: $('#frmChangePassword').serialize(),
        //         success: function(response) {
        //             if(response.status == true){
        //                 Swal.fire('Success',response.data,'success');
        //                 $('#modal-detail').modal('hide');
        //             }else{
        //                 Swal.fire('Error',response.data,'error');
        //             }
        //         }
        //     });
        // }
    </script>
    <script>
        // var x = document.getElementById("demo");

        // if (navigator.geolocation) {
        //     navigator.geolocation.getCurrentPosition(showPosition, showError);
        // } else {
        //     x.innerHTML = "Geolocation is not supported by this browser.";
        // }

        // function showPosition(position) {
        //     $('#lat').val(position.coords.latitude)
        //     $('#long').val(position.coords.longitude)

            // x.innerHTML = "Latitude: " + position.coords.latitude +
            // "<br>Longitude: " + position.coords.longitude;
        // }
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

