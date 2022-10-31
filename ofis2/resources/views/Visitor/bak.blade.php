<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('vendor/bootstrap/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-extend.css') }}">
        <link rel="stylesheet" href="{{ asset('css/meus.css') }}">
        <link rel="stylesheet" href="{{ asset('css/master_style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/skins/_all-skins.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/select2/select2.css') }}">
    </head>
    <body class="vms-body" data-overlay="1">
        <div class="container p-80">
            <div class="row mb-90">
                <div class="col-1"></div>
                <div class="col-10 p-4 text-center welcome-wrapper">
                    <img src="{{ asset('img/logo.png') }}" style="max-width: 80%" alt="">
                    <h2 class="text-nowrap mb-0 font-size-26">Welcome to Smart Office MRT Jakarta</h2>
                </div>
            </div>
            <div class="" style="margin-top: 30vh">
                <div class="row">
                    <div class="col-3"></div>
                    <div class="col-12">
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
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        @if (Session::has('error'))
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                {{ Session::get('error') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-3"></div>
                    <div class="col-6 p-4 text-center">
                        <a href="javascript:void(0);" class="btn btn-rounded btn-visitor btn-block font-size-20" data-toggle="modal" data-target="#exampleModalCenter">Visitor In</a>
                        <input type="text" name="scan" id="scanQr" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        {{-- MODAL HERE --}}
        {{-- MODAL REGISTER --}}
        <div class="modal" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="padding: 20px">
                        <h5 class="modal-title" id="exampleModalLongTitle">Register Visitor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{-- <form action="{{ route('visitorStore') }}" method="POST" enctype="multipart/form-data">
                    @csrf --}}
                        <div class="modal-body">
                            <div class="">
                                <h5>Visitor Information</h5>
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <div id="my_camera"></div>
                                        <input type="hidden" name="img" id="imgHere" value="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="mb-0">necessity</label>
                                            <small class="vms-text-subtitle">Keperluan</small>
                                            <select id="necessity" name="necessity" class="select2" style="width: 100%" id="" required>
                                                <option value="none" disabled selected>Please select Necessity</option>
                                                <option value="Meeting">Meeting</option>
                                                <option value="Delivery of goods/Documents">Delivery of goods/Documents</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Phone Number</label>
                                            <small class="vms-text-subtitle">Nomor Telepon</small>
                                            <input name="phone" type="number" class="form-control" value="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Your Name</label>
                                            <small class="vms-text-subtitle">Nama Anda</small>
                                            <input name="name" type="text" class="form-control" value="" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="mb-0">PIC Name</label>
                                            <small class="vms-text-subtitle">nama penanggung jawab</small>
                                            <select name="pic_id" class="select2" style="width: 100%" id="" required>
                                                <option value="none" disabled selected>Please select PIC Name</option>
                                                @foreach ( $pics as $pic)
                                                    <option value="{{ $pic->id }}">{{ $pic->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Your Company</label>
                                            <small class="vms-text-subtitle">Dari Perusahaan</small>
                                            <input name="company" type="text" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer text-center" style="padding: 20px">
                            <button type="submit" onclick="take_snapshot()" class="btn btn-info btn-rounded pr-4 pl-4">Take Photo and Submit</button>
                        </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>

        <div class="modal" id="modalMeeting" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="padding: 20px">
                        <h5 class="modal-title" id="exampleModalLongTitle">Register Visitor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('visitorStore') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div class="modal-body">
                            <div class="">
                                <h5>Visitor Information</h5>
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <div id="my_camera_qr"></div>
                                        <input type="hidden" name="img" id="imgFromQr" value="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="mb-0">necessity</label>
                                            <small class="vms-text-subtitle">Keperluan</small>
                                            <input name="necessity" type="text" class="form-control" value="Meeting" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Phone Number</label>
                                            <small class="vms-text-subtitle">Nomor Telepon</small>
                                            <input name="phone" type="number" class="form-control" value="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Your Name</label>
                                            <small class="vms-text-subtitle">Nama Anda</small>
                                            <input name="name" type="text" class="form-control" value="" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="mb-0">PIC Name</label>
                                            <small class="vms-text-subtitle">nama penanggung jawab</small>
                                            <input type="hidden" name="pic_id" class="form-control" value="" reaquired>
                                            <input type="text" name="pic_name" class="form-control" value="" reaquired>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Your Company</label>
                                            <small class="vms-text-subtitle">Dari Perusahaan</small>
                                            <input name="company" type="text" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer text-center" style="padding: 20px">
                            <button type="submit" onclick="take_snapshot_qr()" class="btn btn-info btn-rounded pr-4 pl-4">Take Photo and Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="{{ asset('vendor/jquery-3.3.1/jquery-3.3.1.js') }}"></script>
        <script src="{{ asset('vendor/popper/popper.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/bootstrap.js') }}"></script>
        <script src="{{ asset('vendor/moment/moment.min.js') }}"></script>
        <script src="{{ asset('vendor/fastclick/fastclick.js') }}"></script>
        <script src="{{ asset('vendor/select2/select2.full.js') }}"></script>
        <script src="{{ asset('vendor/webcamjs/webcam.min.js') }}"></script>
        <script src="{{ asset('js/meus.js') }}"></script>
        <script>
            $(".alert").fadeTo(4000, 500).slideUp(500, function(){
                $(".alert").slideUp(500);
            });
        </script>
        <script language="JavaScript">
            Webcam.set({
                width: 320,
                height: 240,
                image_format: 'jpeg',
                jpeg_quality: 90
            });
            Webcam.attach( '#my_camera' );
            function take_snapshot() {
                Webcam.snap( function(data_uri) {
                    document.getElementById("imgHere").value=data_uri
                } );
            }
        </script>
        <script>
            Webcam.set({
                width: 320,
                height: 240,
                image_format: 'jpeg',
                jpeg_quality: 90
            });
            Webcam.attach( '#my_camera_qr' );
            function take_snapshot_qr() {
                Webcam.snap( function(data_uri) {
                    document.getElementById("imgFromQr").value=data_uri
                } );
            }
        </script>
        <script>
            $(document).on('keydown', '#scanQr', function(e) {
                if (e.which == 13) {
                    var $targ = $(e.target);
                    // console.log($targ.val())
                    $.ajax({
                        url:"{{route('visitorApi')}}",
                        type: 'get',
                        dataType: "json",
                        data: {
                            email: $targ.val()
                        },
                        success: function(datas) {
                            console.log(datas);
                            $('#modalMeeting').modal('show');
                            $('#modalMeeting').find('input[name=phone]').val(datas[0].phone).attr("readonly", "readonly")
                            $('#modalMeeting').find('input[name=name]').val(datas[0].name).attr("readonly", "readonly")
                            $('#modalMeeting').find('input[name=company]').val(datas[0].company).attr("readonly", "readonly")
                            $('#modalMeeting').find('input[name=pic_id]').val(datas[0].pic_id).attr("readonly", "readonly")
                            $('#modalMeeting').find('input[name=pic_name]').val(datas[0].pic_name).attr("readonly", "readonly")
                        }
                    });
                }
            });
        </script>
    </body>
</html>
