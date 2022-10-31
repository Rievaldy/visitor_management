<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta http-equiv="refresh" content="1800">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('vendor/bootstrap/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-extend.css') }}">
        <link rel="stylesheet" href="{{ asset('css/meus.css') }}">
        <link rel="stylesheet" href="{{ asset('css/master_style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/skins/_all-skins.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/select2/select2.css') }}">
    </head>
    <?php
        $now = date('H:i', strtotime(now()));
        $timestamp = strtotime(now());
        $day = date('l', $timestamp);
        // echo $day;
    ?>
    @if ( $day = $getNewDay && $now >= date('H:i', strtotime($openTimes)) && $now <= date('H:i', strtotime($closeTimes)) )
        
        {{-- <body class="vms-body" data-overlay="1" onload="startTime()" style="background-image: url('{{ asset('img/vms2.jpg') }}');> --}}
        {{-- @if ($datas =! null)
            
        @endif --}}
            <body class="vms-body" data-overlay="1" onload="startTime()" 
            @if ($datas != null )
            style="background-image: url('{{ $datas }}');
            @endif
            >
            <input type="hidden" value="12345" name="help">
            <div class="row">
                <div class="col-12 text-right pr-30">
                    <h2 class="page-title border-0 pr-0 mr-0 text-white font-size-40" id="time"></h2>
                </div>
            </div>
            <div class="container p-80">
                <div class="row mb-90">
                    <div class="col-1"></div>
                    <div class="col-10 p-4 text-center welcome-wrapper">
                        <img src="{{ asset('img/logo.png') }}" style="max-width: 80%" alt="">
                        <h2 class="text-nowrap mb-0 font-size-26">Welcome to Smart Office MRT Jakarta</h2>
                    </div>
                </div>
                <div class="" style="margin-top: 10vh">
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
                                <?php
                                    // $now = '12:40';
                                    $morning = "05:42";
                                    $afternoon = "12:00";
                                    $night = "18:26";
                                    // $sekarang = date('H:i', strtotime($now));
                                    $sekarang = date('H:i', strtotime(now()));
                                    $pagi = date('H:i', strtotime($morning));
                                    $siang = date('H:i', strtotime($afternoon));
                                    $malam = date('H:i', strtotime($night));
                                ?>
                                @if ($sekarang >= $pagi && $sekarang <= $siang && $sekarang <= $malam )
                                    {{-- pagi --}}
                                    @if ($voice[0]->pagi != null)
                                        <audio controls autoplay class="d-none"><source src="{{ $voice[0]->pagi }}" type="audio/mpeg">Your browser does not support the audio element.</audio>
                                    @else
                                        <audio controls autoplay class="d-none"><source src="{{ asset('audio/ivr/01pagi.mp4') }}" type="audio/mpeg">Your browser does not support the audio element.</audio>
                                    @endif
                                @elseif ($sekarang >= $pagi && $sekarang >= $siang && $sekarang <= $malam)
                                    {{-- siang --}}
                                    @if ($voice[0]->siang != null)
                                        <audio controls autoplay class="d-none"><source src="{{ $voice[0]->siang }}" type="audio/mpeg">Your browser does not support the audio element.</audio>
                                    @else
                                        <audio controls autoplay class="d-none"><source src="{{ asset('audio/ivr/02siang.mp4') }}" type="audio/mpeg">Your browser does not support the audio element.</audio>
                                    @endif
                                @else
                                    {{-- malam --}}
                                    @if ($voice[0]->malam != null)
                                        <audio controls autoplay class="d-none"><source src="{{ $voice[0]->malam }}" type="audio/mpeg">Your browser does not support the audio element.</audio>
                                    @else
                                        <audio controls autoplay class="d-none"><source src="{{ asset('audio/ivr/03malam.mp4') }}" type="audio/mpeg">Your browser does not support the audio element.</audio>
                                    @endif
                                @endif
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

                    {{-- First Modal --}}
                    <div class="modal" id="firstModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="false" data-keyboard="false">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header" style="padding: 20px">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Safety Induction</h5>
                                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" class="ti-close"></span>
                                    </button> --}}
                                </div><br>
                                <div class="hold-transition bg-img text-center welcome-wrapper">
                                    <img src="{{ asset('img/Safety.jpg') }}" style="max-width: 90%" alt="">
                                </div>
                                <div class="col-12">
                                    <br><br><br>
                                </div>
                                <div class="col-12 text-center">
                                    <h3>SAFETY INDUCTION</h3>
                                    <h4>HEAD OFFICE PT MRT JAKARTA (PERSERODA)</h4>
                                    <h4>WISMA NUSANTARA LANTAI 21-22</h4>
                                </div>
                                <div class="col-12">
                                    <br>
                                </div>
                                <div class="col2"></div>
                                <div class="col-12 text-left">
                                    <ol type="1" style="padding-left: 15px;">
                                        <li><p>Tamu diharuskan melapor kebagian Resepsionis/<i>Security</i> apabila ingin berkunjung ke kantor PT MRT Jakarta (Perseroda).</p></li>
                                        <li><p>Dilarang merokok di lingkukan kerja PT MRT Jakarta (Perseroda).</p></li>
                                        <li><p>Apabila tamu ingin melakukan pekerjaan di area kerja PT MRT Jakarta (Perseroda), tamu/pengunjung dapat bekerja setelah ada surat <i>Permit to Work dan Job Safety Analysis</i>.</p></li>
                                        <li><p>Pakailah pakaian/APD yang diwajibkan untuk melakukan pekerjaan.</p></li>
                                        <li><p>Berjalanlah dengan aman di area kerja PT MRT Jakarta (Perseroda), perhatikanlah rambu-rambu yang ada di lingkungan kerja.</p></li>
                                        <li><p>Jagalah kebersihan di lingkungan kerja PT MRT Jakarta (Perseroda), buanglah sampah pada tempat yang sudah disediakan.</p></li>
                                        <li><p>Selalu menjaga kerapihan dan ketertiban area kerja PT MRT Jakarta (Perseroda).</p></li>
                                        <li> <p>Hemat dalam menggunakan sumber daya listrik dan air, matikan listrik dan air apabila tidak digunakan.</p></li>
                                        <li><p>Segera laporkan kepetugas apabila ada kejadian berbahaya. Untuk nomor darurat dapat menghubungi 112 atau call center 1500332.</p></li>
                                        <li><p>Apabila ada kondisi darurat, jangan panik. Ikuti petunjuk petugas untuk mencapai ke titik aman. </p></li>
                                        <li><p>Kantor Pusat PT MRT Jakarta (Perseroda) yang terletak di Gedung Wisma Nusantara lantai 21-22 dilengkapi dengan fasilitas keselamatan diantaranya; tangga darurat, APAR, sensor kebakaran, alarm kebakaran, sprinkle dan hydran.</p></li>
                                        <li> <p>PT MRT Jakarta (Perseroda) secara berkelanjutan meningkatkan Integrasi Sistem Manajemen Mutu, K3-KP, Lingkungan, dan Pengamanan di Lingkungan PT MRT Jakarta (Perseroda) menuju <b><i>“Zero Accident, Zero Discharge, Zero Defect, and Zero Delay”</i></b>.</p></li>
                                    </ul>
                                </div><br>
                                
                                {{-- button tanpa pop up --}}
                                <div class="col-12">
                                    <div class="col-12 text-right">
                                        <div class="row">
                                            <div class="col-12">
                                                <button class="btn btn-primary font-size-20" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">Close</span>
                                                </button>
                                            </div>  
                                        </div>
                                    </div>
                                </div>

                                {{-- button dengan pop up --}}
                                {{-- <div class="col-12">
                                    <div class="col-12 text-right">
                                        <div class="row">
                                            <div class="col-12">
                                                <a href="javascript:void(0);" class="btn btn-primary font-size-20" data-toggle="modal" data-target="#secondModal">
                                                    Close
                                                </a>
                                            </div>  
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- <div class="col-12">
                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <h2 class="text-grey text-left">Do you have an Invitation?</h2>
                                                <h2 class="text-grey text-left"><em>Apakah Anda memiliki undangan?</em></h2>
                                            </div>
                                        </div>
                                    <div class="col-12 text-right">
                                        <div class="row text-center">
                                            <div class="col-3 text-center">
                                                <a href="javascript:void(0);" class="btn-rounded btn-primary btn-visitor btn-block font-size-5" data-toggle="modal" data-target="#exampleModalCenter">
                                                    No, I don't have<br>
                                                    <em>Saya tidak punya</em>
                                                </a>
                                            </div>
                                            <div class="col-3 text-center">
                                                <a href="javascript:void(0);" id="btnModalScan" class="btn-primary btn-rounded btn-visitor btn-block font-size-5" onclick="_focus()" data-toggle="modal" data-target="#modalInvitation">
                                                    Yes, I have<br>
                                                    <em>Ya, saya punya</em>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                                <div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End First Modal --}}

                    <div class="row" style>
                        <div class="col-1"></div>
                        <div class="col-10 p-4 text-center" style="background: rgba(0, 0, 0, .5); border-radius: 16px;">
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h2 class="text-white text-left">Do you have an Invitation?</h2>
                                    <h2 class="text-white text-left"><em>Apakah Anda memiliki undangan?</em></h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);" class="btn btn-rounded btn-visitor btn-block font-size-20" data-toggle="modal" data-target="#exampleModalCenter">
                                        No, I don't have<br>
                                        <em>Saya tidak punya</em>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" id="btnModalScan" class="btn btn-rounded btn-visitor btn-block font-size-20" onclick="_focus()" data-toggle="modal" data-target="#modalInvitation">
                                        Yes, I have<br>
                                        <em>Ya, saya punya</em>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
            <div class="row">
                <div class="col-3" style=" position: absolute; right: 0.75rem; bottom: 2rem ">
                    <a href="javascript:void(0);" id="" class="btn btn-rounded btn-visitor btn-danger font-weight-500 btn-block font-size-20 pl-35 pr-35" onclick="_help()">
                        Help?
                    </a>
                </div>
            </div>
            {{-- MODAL HERE --}}
            {{-- MODAL REGISTER --}}
            <div class="modal" id="exampleModalCenter" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="padding: 20px">
                            <h5 class="modal-title" id="exampleModalLongTitle">Register Visitors</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="ti-close"></span>
                            </button>
                        </div>
                        <form action="{{ route('visitorStore') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="">
                                    <h5 class="mb-4">Visitor Information</h5>
                                    <div class="row">
                                        <div class="col-12 mb-4 text-center">
                                            <div id="my_camera" style=""></div>
                                            <div id="my_result" style=""></div>
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
                                            <div class="form-group mb-0">
                                                <label class="mb-0">Your Company</label>
                                                <small class="vms-text-subtitle">Dari Perusahaan</small>
                                                <input name="company" type="text" class="form-control" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer text-center" style="padding: 20px">
                                <a href="#" onclick="take_snapshot()" class="btn btn-info btn-rounded pr-4 pl-4">Take a Photo</a>
                                <button type="submit" class="btn btn-info btn-rounded pr-4 pl-4" id="btnNoInvite" disabled>Submit</button>
                            </div>
                        </form>
                   
                    </div>
                </div>
            </div>
            
            {{-- MODAL VISITOR INVITATION --}}
            <div class="modal" id="modalMeeting" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="padding: 20px">
                            <h5 class="modal-title" id="exampleModalLongTitle">Register Visitor</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('visitorStoreInvitation') }}" method="POST" enctype="multipart/form-data">
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
                                            <div class="form-group mb-0">
                                                <label class="mb-0">Your Company</label>
                                                <small class="vms-text-subtitle">Dari Perusahaan</small>
                                                <input name="company" type="text" class="form-control" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer text-center" style="padding: 20px">
                                <a href="#" onclick="take_snapshot_qr()" class="btn btn-info btn-rounded pr-4 pl-4">Take a Photo</a>
                                <button type="submit" class="btn btn-info btn-rounded pr-4 pl-4" id="btnHvInvite" disabled>Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal" id="modalMeetingNull" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h5 class="mb-0">
                                Sorry, <br><br>
                                we couldn't match your invitation, <br>maybe because it's expired or Your meeting has ended.
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="modalInvitation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h5 class="mb-0">
                                Please Scan Your QR Code
                            </h5>
                            <input type="text" name="scan" id="scanQr" class="form-control"  style="border: none; height: 0; padding: 0;" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="modalViewCamera" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h5 class="">
                                Please please look at the camera in the upper left corner
                            </h5>
                            <h5 class="mb-0">
                                <em>Silakan lihat kamera di sudut kiri atas</em>
                            </h5>
                            <h1 class="text-center mb-0" id="countdown"></h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="modalLoading"  data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h5 class="mb-0">
                                Please wait..
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="modalResponHelp" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <audio controls class="d-none" id="bellHelp"><source src="{{ asset('audio/alert/bell_3.mp3') }}" type="audio/mpeg"></audio>
                            <h5 class="">
                                Please wait for the receptionist to come to you soon. Please don't close this page until the receptionist comes to you
                            </h5>
                            <h5 class="mb-0">
                                <em>Harap menunggu resepsionis akan segera menghampiri Anda. Jangan tutup halaman ini hingga resepsionis menghampiri Anda</em>
                            </h5>
                            <div class="mt-4">
                                <button type="button" class="btn btn-secondary" onclick="pauseBell()" data-dismiss="modal">Close</button>
                            </div>
                        </div>
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
                var z = document.getElementById("bellHelp");
                function pauseBell() {
                    z.pause();
                }
            </script>
            <script>
                $('#btnNoInvite').on('click', function(){
                    $('#exampleModalCenter').modal('hide');
                    $('#modalLoading').modal('show');
                })
                $('#btnHvInvite').on('click', function(){
                    $('#modalMeeting').modal('hide');
                    $('#modalLoading').modal('show');
                })

                $('#btnModal1').on('click', function(){
                    $('#secondModal'.modal('hide'));
                    $('firstModal').modal('show');
                })
                $(document).ready(function (){
                    $('#firstModal').modal('show')
                    $('#secondModal').modal('hide')
                });

            </script>
            <script>
                function _help(){
                    $('#modalLoading').modal('show');
                    var help = $("input[name=help]").val();
                    $.ajax({
                        url:"{{route('visitorHelpApi')}}",
                        type: 'get',
                        dataType: "json",
                        data: {
                            help: help
                        },
                        success: function(datas) {
                            $('#modalLoading').modal('hide');
                            $('#modalResponHelp').modal('show');
                            var x = document.getElementById("bellHelp");
                            x.loop = true;
                            x.load();
                            function playbell() {
                                x.addEventListener('ended', function() {
                                    this.play();
                                }, false);
                            }
                            x.play();
                            // setTimeout(function(){
                            //     $('#modalResponHelp').modal('hide');
                            // }, 3000);
                        }
                    });
                }
            </script>
            <script>
                function _focus() {
                    console.log('hello');
                    $(this).find('input[name=scan]').focus();
                }
            </script>
            <script>
                var d = new Date();
                var n = d.toLocaleTimeString('en-GB');
                console.log(n);

                function startTime() {
                    var today = new Date();
                    var h = today.getHours();
                    var m = today.getMinutes();
                    var s = today.getSeconds();
                    m = checkTime(m);
                    document.getElementById('time').innerHTML =
                    // h + ":" + m + ":" + s;
                    h + ":" + m;
                    var t = setTimeout(startTime, 1000);
                }

                function checkTime(i) {
                    if (i < 10) {i = "0" + i};
                    return i;
                }
            </script>
            <script>
                $(".alert").fadeTo(4000, 500).slideUp(500, function(){
                    $(".alert").slideUp(500);
                });
            </script>
            <script language="JavaScript">
                var shutter = new Audio();
                shutter.autoplay = false;
                shutter.src = navigator.userAgent.match(/Firefox/) ? '{{ asset('vendor/webcamjs/shutter.ogg')}}' : '{{ asset('vendor/webcamjs/shutter.mp3') }}';

                Webcam.set({
                    width: 427,
                    height: 240,
                    dest_width: 1280,
                    dest_height: 720,
                    image_format: 'jpeg',
                    force_flash: false,
                    jpeg_quality: 80,
                    fps: 45
                });
                Webcam.attach( '#my_camera' );
                function take_snapshot() {
                    $('#modalViewCamera').modal('show');
                    var timeleft = 3;
                    var downloadTimer = setInterval(function(){
                        if(timeleft <= 0){
                            $('#modalViewCamera').modal('hide');
                            clearInterval(downloadTimer);
                        }
                        $('#countdown').html(timeleft);
                        timeleft -= 1;
                    }, 1000);
                    setTimeout(function(){
                        shutter.play();
                        Webcam.snap( function(data_uri) {
                            document.getElementById("imgHere").value=data_uri
                            document.getElementById('my_camera').innerHTML = '<img src="'+data_uri+'"/>';
                        });
                        $('#modalViewCamera').modal('hide');
                        $('#btnNoInvite').prop("disabled", false);
                    }, 4000);
                }
                Webcam.attach( '#my_camera_qr' );
                function take_snapshot_qr() {
                    $('#modalViewCamera').modal('show');
                    var timeleft = 3;
                    var downloadTimer = setInterval(function(){
                    if(timeleft <= 0){
                        $('#modalViewCamera').modal('hide');
                        clearInterval(downloadTimer);
                    }
                    $('#countdown').html(timeleft);
                    timeleft -= 1;
                    }, 1000);
                    setTimeout(function(){
                        shutter.play();
                        Webcam.snap( function(data_uri) {
                            document.getElementById("imgFromQr").value=data_uri
                            document.getElementById('my_camera_qr').innerHTML = '<img src="'+data_uri+'"/>';
                        });
                        $('#modalViewCamera').modal('hide');
                        $('#btnHvInvite').prop("disabled", false);
                    }, 4000);
                }
            </script>
            <script>
                $('#modalInvitation').on('shown.bs.modal', function () {
                    $('#scanQr').focus();
                })

                $(document).on('keydown', '#scanQr', function(e) {
                    $("#scanQr").attr("readonly", false);
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
                                if (!$.trim(datas)){
                                    $('#modalInvitation').modal('hide');
                                    $('#modalMeetingNull').modal('show');
                                    setTimeout(function(){
                                        $("#modalMeetingNull").modal('hide');
                                    }, 3000);
                                    $('#scanQr').val('');
                                    $("#scanQr").attr("readonly", true);
                                } else {
                                    console.log(datas);
                                    $('#modalInvitation').modal('hide');
                                    $('#modalMeeting').modal('show');
                                    $('#modalMeeting').find('input[name=phone]').val(datas[0].phone).attr("readonly", "readonly")
                                    $('#modalMeeting').find('input[name=name]').val(datas[0].name).attr("readonly", "readonly")
                                    $('#modalMeeting').find('input[name=company]').val(datas[0].company).attr("readonly", "readonly")
                                    $('#modalMeeting').find('input[name=pic_id]').val(datas[0].pic_id).attr("readonly", "readonly")
                                    $('#modalMeeting').find('input[name=pic_name]').val(datas[0].pic_name).attr("readonly", "readonly")
                                    $('#scanQr').val('');
                                    $("#scanQr").attr("readonly", true);
                                }
                            }
                        });
                    }
                });
            </script>
        </body>
    @else
        <body class="vms-body" data-overlay="1" onload="startTime()">
            <div class="row">
                <div class="col-12 text-right pr-30">
                    <h2 class="page-title border-0 pr-0 mr-0 text-white font-size-40" id="time"></h2>
                </div>
            </div>
            <div class="container p-80">
                <div class="row mb-90">
                    <div class="col-1"></div>
                    <div class="col-10 p-4 text-center welcome-wrapper">
                        <img src="{{ asset('img/logo.png') }}" style="max-width: 80%" alt="">
                        <h2 class="text-nowrap mb-0 font-size-26">Welcome to Smart Office MRT Jakarta</h2>
                    </div>
                </div>
                <div class="" style="margin-top: 10vh">
                    <div class="row" style>
                        <div class="col-1"></div>
                        <div class="col-10 p-4 text-center" style="background: rgba(0, 0, 0, .6); border-radius: 8px;">
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h2 class="text-white text-left mb-4">
                                        @if ($openTimes == null)
                                            Sorry, today MRT Jakarta Head Office is closed and cannot receive visitors. Please come back tomorrow.
                                        @else
                                            Sorry, currently the MRT Jakarta Head Office is Closed and cannot receive visitors. Please come back tomorrow. We open at {{ date('H:i', strtotime($openTimes))}} - {{ date('H:i', strtotime($closeTimes))}}  WIB.
                                        @endif
                                    </h2>
                                    <h2 class="text-white text-left mb-0">
                                        @if ($openTimes == null)
                                            <em>Mohon maaf, pada hari ini Kantor Pusat MRT Jakarta tutup dan tidak dapat menerima tamu. Mohon datang kembali besok.
                                        @else
                                            <em>Mohon maaf, saat ini Kantor Pusat MRT Jakarta sudah tutup dan tidak dapat menerima tamu. Mohon datang kembali besok. Kami buka pada pukul {{ date('H:i', strtotime($openTimes))}} - {{ date('H:i', strtotime($closeTimes))}} WIB</em>
                                        @endif
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- MODAL HERE --}}
        </body>
    @endif
</html>
