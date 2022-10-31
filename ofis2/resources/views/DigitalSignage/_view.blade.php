@extends('signage')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="refresh" content="60">
    <link href="{{ asset('vendor/webcodecamjs/css/style.css')}}" rel="stylesheet">
@endsection
@if ( $rooms->is_ds_reader == 2 )
    @section('content')
        @if ( $bg[0]->img != null )
            <div class="container-fluid" style="background: url({{ $bg[0]->img }}) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;">
        @else
            <div class="container-fluid" style="background: url({{ asset('img/bg-ds.jpeg')}}) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;">
        @endif
            <div class="row">
                <input type="hidden" name="is_ds_mirror" value="{{ $rooms->is_ds_mirror}}">
                {{-- <div class="col-8 p-30" style="background: rgba(148, 202, 193, .85); height: 100vh"> --}}
                <div class="col-8 p-30" style="background: rgba(0, 0, 0, .45); height: 100vh">
                    <div class="mb-4">
                        <img src="{{ asset('img/logo.png') }}" alt="" style="width: 30%">
                    </div>
                    <div class="mb-4 pt-30">
                        <p class="font-size-80">
                            {{ $rooms->name}}
                        </p>
                        <p class="font-size-24">
                            Capacity: {{ $rooms->capacity}} Persons
                        </p>
                        <input type="hidden" id="room_id" name="room_id" value="{{$rooms->id}}">
                    </div>
                    @if ( $activeBooks != null)
                        <div class="mb-4 pt-4">
                            <p class="font-size-20 mt-4">{{ $activeBooks[0]->pic_name }} has claimed this room</p>
                        </div>
                        <div class="mb-4">
                            <p class="font-size-18 mt-4">Meeting Title</p>
                            <p class="font-size-30">"{{ $activeBooks[0]->desc }}"</p>
                        </div>
                        <div class="mb-4">
                            <p class="font-size-30 font-weight-400">Expires in {{ date('H:i', strtotime($activeBooks[0]->h_end)) }}</p>
                        </div>
                    @else
                        <div class="pt-4">
                            <p class="font-size-24 mt-4">There is no meeting at this time.</p>
                        </div>
                    @endif
                    <div class="position-absolute" style="bottom: 15px;">
                        <div class="btn-group dropup">
                            <a href="#" class="text-white font-size-20" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ti-settings"></i>
                            </a>
                            <div class="dropdown-menu">
                                @if (Auth::user()->user_type == 99)
                                    <a class="dropdown-item font-size-1rem" href="javascript:void(0);" onclick="window.location.href='{{route('dashboard')}}'"><i class="ti-arrow-left"></i>Exit</a>
                                    <div class="dropdown-divider"></div>
                                @endif
                                <a class="dropdown-item font-size-1rem" href="javascript:void(0);" onclick="toggleFullScreen()"><i class="ti-fullscreen"></i>Full</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item font-size-1rem" href="{{ route('logout') }}"><i class="ti-power-off"></i>Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4 p-30" style="background: rgba(37, 42, 46, .75); height: 100vh">
                    <p class="page-title border-0 pr-0 mr-0 mt-0 text-center font-size-60 mb-4" id="time" style="line-height: 60px;"></p>
                    <div class="row pt-4">
                        <div class="col-6 pt-4 mb-4">
                            <p class="font-size-16 text-left">
                                Next Meeting
                            </p>
                        </div>
                        <div class="col-6 pt-4 mb-4">
                            <p class="font-size-16 text-right">
                                <?php echo date('D, M d, Y'); ?>
                            </p>
                        </div>
                    </div>
                    <div class="">
                        @if ($nextMeets != null)
                            @foreach ( $nextMeets as $nextMeet )
                                <div class="row">
                                    <div class="col-7 pr-0">
                                        <p class="font-size-16 text-left">
                                            {{ $nextMeet->desc }}
                                        </p>
                                    </div>
                                    <div class="col-5">
                                        <p class="font-size-16 text-right text-nowrap">
                                            {{ date('H:i', strtotime($nextMeet->h_start)) }}
                                            -
                                            {{ date('H:i', strtotime($nextMeet->h_end)) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>There is no meeting schedule for today</p>
                        @endif
                    </div>
                    <div class="text-right position-absolute" style="bottom: 34px; right: 21px">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#exampleModalCenter" id="start-button" class="text-white font-size-20" style="border: 1px solid #fff; border-radius: 50px; padding: 8px 48px;">
                            Touch Here to Scan QR
                        </a>
                    </div>
                </div>
            </div>
            {{-- MODDAL SCANNER START --}}
            <div class="modal" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h5 class="mb-0 text-dark">
                                Please Scan your invitation QR Code
                            </h5>
                            <input type="text" name="scan" id="scanQr" class="form-control"  style="border: none; height: 0; padding: 0;" readonly>
                            {{-- <input type="text" name="scan" id="scanQr" class="form-control"> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="welcomeModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-dark">
                            <p class="font-size-24" id="participant_title">welcome,</p>
                            <h4 class="font-size-30" id="participant_name">em</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="waitModal" role="dialog" aria-labelledby=""  data-keyboard="false" data-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-dark">
                            <h4 class="font-size-30" id="participant_name">Please Wait..</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('script')
        <script src="{{ asset('vendor/webcodecamjs/js/qrcodelib.js') }}"></script>
        <script src="{{ asset('vendor/webcodecamjs/js/webcodecamjs.js') }}"></script>
        <script src="{{ asset('vendor/webcodecamjs/js/main.js') }}"></script>
        <script>
            $('#exampleModalCenter').on('shown.bs.modal', function () {
                $('#scanQr').focus();
            })
            function _focus() {
                console.log('hello');
                $(this).find('input[name=scan]').focus();
            }
            $(document).on('keydown', '#scanQr', function(e) {
                $("#scanQr").attr("readonly", false);
                if (e.which == 13) {
                    var $targ = $(e.target);
                    console.log($targ.val())
                    $('#exampleModalCenter').modal('hide');
                    $('#waitModal').modal('show');
                    $.ajax({
                        url:"{{route('checkParty')}}",
                        type: 'get',
                        dataType: "json",
                        data: {
                            barcode: $targ.val(),
                            room_id: $('input[name="room_id"]').val()
                        },
                        success: function(datas) {
                            console.log(datas);
                            $("#waitModal").modal('hide');
                            $('#participant_title').html(datas.msg.title);
                            $('#participant_name').html(datas.msg.body);
                            $('#welcomeModal').modal('show');
                            setTimeout(function(){
                                $("#welcomeModal").modal('hide');
                                scanner.start();
                            }, 3000);
                            $('#scanQr').val('');
                            $("#scanQr").attr("readonly", true);
                        }
                    });
                }
            });
        </script>
        <script>
            function toggleFullScreen() {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen();
                } else {
                    if (document.exitFullscreen) {
                    document.exitFullscreen();
                    }
                }
            }
        </script>
        <script>
            // Show time
            function startTime() {
                var today = new Date();
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();
                m = checkTime(m);
                document.getElementById('time').innerHTML =
                h + ":" + m + ":" + s;
                var t = setTimeout(startTime, 1000);
            }

            function checkTime(i) {
                if (i < 10) {i = "0" + i};
                return i;
            }

            setTimeout(function(){
                $('#collapseExample').removeClass("show");
                $('#iconToogle').toggleClass("ti-angle-up ti-angle-down");
            }, 5000);

            $('#toogleDetails').on('click', function() {
                $('#iconToogle').toggleClass("ti-angle-up ti-angle-down");
            })
        </script>
    @endsection
@else
    @section('content')
        @if ( $bg[0]->img != null )
            <div class="container-fluid" style="background: url({{ $bg[0]->img }}) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;">
        @else
            <div class="container-fluid" style="background: url({{ asset('img/bg-ds.jpeg')}}) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;">
        @endif
            <div class="row">
                <input type="hidden" name="is_ds_mirror" value="{{ $rooms->is_ds_mirror}}">
                {{-- <div class="col-8 p-30" style="background: rgba(148, 202, 193, .85); height: 100vh"> --}}
                <div class="col-8 p-30" style="background: rgba(0, 0, 0, .45); height: 100vh">
                    <div class="mb-4">
                        <img src="{{ asset('img/logo.png') }}" alt="" style="width: 30%">
                    </div>
                    <div class="mb-4 pt-30">
                        <p class="font-size-80">
                            {{ $rooms->name}}
                        </p>
                        <p class="font-size-24">
                            Capacity: {{ $rooms->capacity}} Persons
                        </p>
                        <input type="hidden" id="room_id" name="room_id" value="{{$rooms->id}}">
                    </div>
                    @if ( $activeBooks != null)
                        <div class="mb-4 pt-4">
                            <p class="font-size-20 mt-4">{{ $activeBooks[0]->pic_name }} has claimed this room</p>
                        </div>
                        <div class="mb-4">
                            <p class="font-size-18 mt-4">Meeting Title</p>
                            <p class="font-size-30">"{{ $activeBooks[0]->desc }}"</p>
                        </div>
                        <div class="mb-4">
                            <p class="font-size-30 font-weight-400">Expires in {{ date('H:i', strtotime($activeBooks[0]->h_end)) }}</p>
                        </div>
                    @else
                        <div class="pt-4">
                            <p class="font-size-24 mt-4">There is no meeting at this time.</p>
                        </div>
                    @endif
                    <div class="position-absolute" style="bottom: 15px;">
                        {{-- <a href="javascript:void(0);" onclick="activeCamera()" data-toggle="modal" data-target="#exampleModalCenter" class="text-white font-size-20" style="border: 1px solid #fff; border-radius: 50px; padding: 8px 48px;"> --}}
                        <div class="btn-group dropup">
                            <a href="#" class="text-white font-size-20" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ti-settings"></i>
                            </a>
                            <div class="dropdown-menu">
                                @if (Auth::user()->user_type == 99)
                                    <a class="dropdown-item font-size-1rem" href="javascript:void(0);" onclick="window.location.href='{{route('dashboard')}}'"><i class="ti-arrow-left"></i>Exit</a>
                                    <div class="dropdown-divider"></div>
                                @endif
                                <a class="dropdown-item font-size-1rem" href="javascript:void(0);" onclick="toggleFullScreen()"><i class="ti-fullscreen"></i>Full</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item font-size-1rem" href="{{ route('logout') }}"><i class="ti-power-off"></i>Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4 p-30" style="background: rgba(37, 42, 46, .75); height: 100vh">
                    <p class="page-title border-0 pr-0 mr-0 mt-0 text-center font-size-60 mb-4" id="time" style="line-height: 60px;"></p>
                    <div class="row pt-4">
                        <div class="col-6 pt-4 mb-4">
                            <p class="font-size-16 text-left">
                                Next Meeting
                            </p>
                        </div>
                        <div class="col-6 pt-4 mb-4">
                            <p class="font-size-16 text-right">
                                <?php echo date('D, M d, Y'); ?>
                            </p>
                        </div>
                    </div>
                    <div class="">
                        @if ($nextMeets != null)
                            @foreach ( $nextMeets as $nextMeet )
                                <div class="row">
                                    <div class="col-7 pr-0">
                                        <p class="font-size-16 text-left">
                                            {{ $nextMeet->desc }}
                                        </p>
                                    </div>
                                    <div class="col-5">
                                        <p class="font-size-16 text-right text-nowrap">
                                            {{ date('H:i', strtotime($nextMeet->h_start)) }}
                                            -
                                            {{ date('H:i', strtotime($nextMeet->h_end)) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>There is no meeting schedule for today</p>
                        @endif
                    </div>
                    <div class="text-right position-absolute" style="bottom: 34px; right: 21px">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#exampleModalCenter" id="start-button" class="text-white font-size-20" style="border: 1px solid #fff; border-radius: 50px; padding: 8px 48px;">
                            Touch Here to Scan QR
                        </a>
                    </div>
                </div>
            </div>
            {{-- MODDAL SCANNER START --}}
            <div class="modal" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0 text-dark" id='dom'>
                            <div>
                                <video id="qr-video" style="width: 100%; margin-bottom: -5px"></video>
                            </div>
                            <span id="cam-qr-result" class="d-none">None</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="welcomeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-dark">
                            <p class="font-size-24" id="participant_title">welcome,</p>
                            <h4 class="font-size-30" id="participant_name">em</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="waitModal" role="dialog" aria-labelledby=""  data-keyboard="false" data-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-dark">
                            <h4 class="font-size-30" id="participant_name">Please Wait..</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('script')
        <script src="{{ asset('vendor/webcodecamjs/js/qrcodelib.js') }}"></script>
        <script src="{{ asset('vendor/webcodecamjs/js/webcodecamjs.js') }}"></script>
        <script src="{{ asset('vendor/webcodecamjs/js/main.js') }}"></script>
        <script type="module">
            import QrScanner from "{{ asset('vendor/qr-scanner/qr-scanner.min.js') }}";
            window.onload = (event) => {
                scanner.start();
            };

            const video = document.getElementById('qr-video');
            const camQrResult = document.getElementById('cam-qr-result');
            function setResult(label, result) {
                scanner.stop();
                $('#waitModal').modal('show');
                $.ajax({
                    url:"{{route('checkParty')}}",
                    type: 'get',
                    dataType: "json",
                    data: {
                        barcode: result,
                        room_id: $('input[name="room_id"]').val()
                    },
                    success: function(datas) {
                        console.log(datas);
                        $("#waitModal").modal('hide');
                        $('#exampleModalCenter').modal('hide');
                        $('#participant_title').html(datas.msg.title);
                        $('#participant_name').html(datas.msg.body);
                        $('#welcomeModal').modal('show');
                        setTimeout(function(){
                            $("#welcomeModal").modal('hide');
                            scanner.start();
                        }, 3000);
                    }
                });
                $('#exampleModalCenter').modal('hide');
            }

            const scanner = new QrScanner(video, result => setResult(camQrResult, result), error => {
                camQrResult.textContent = error;
                camQrResult.style.color = 'inherit';
            });
            // document.getElementById('start-button').addEventListener('click', () => {
            //     scanner.start();
            // });
            // window.scanner = scanner;
        </script>
        <script>
            function toggleFullScreen() {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen();
                } else {
                    if (document.exitFullscreen) {
                    document.exitFullscreen();
                    }
                }
            }
        </script>
        <script>
            // Show time
            function startTime() {
                var today = new Date();
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();
                m = checkTime(m);
                // s = checkTime(s);
                document.getElementById('time').innerHTML =
                h + ":" + m + ":" + s;
                // h + ":" + m;
                var t = setTimeout(startTime, 1000);
            }

            function checkTime(i) {
                if (i < 10) {i = "0" + i};
                return i;
            }

            setTimeout(function(){
                $('#collapseExample').removeClass("show");
                $('#iconToogle').toggleClass("ti-angle-up ti-angle-down");
            }, 5000);

            // setTimeout(function(){
            //     $('#collapseExample').addClass("show");
            //     $('#iconToogle').toggleClass("ti-angle-up ti-angle-down");
            // }, 3000);

            $('#toogleDetails').on('click', function() {
                $('#iconToogle').toggleClass("ti-angle-up ti-angle-down");
            })
        </script>

        {{-- btn show hide content --}}
        {{-- <script>
            $('#btnParticipants').on('click', function{
                $('#contentWrapper').removeClass('d-none')
            });
        </script> --}}
    @endsection
@endif


