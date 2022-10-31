@extends('device')

@section('breadcrumb')
    <div class="mr-auto w-p100">
        <div class="row">
            <div class="col-6">
                <h2 class="page-title border-0">Automation Control</h2>
            </div>
            <div class="col-6 text-right">
                <h2 class="page-title border-0 pr-0 mr-0" id="time"></h2>
            </div>
        </div>
    </div>
@endsection

@section('head')
    <meta http-equiv="refresh" content="60">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="box devices-control-dark mb-0">
                <div class="box-header pt-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <h1 class="font-weight-500">{{ $rooms->name}}</h1>
                            </div>
                        </div>
                        <div class="col-6 text-left">
                            <a class="text-white" data-toggle="collapse" href="#collapseExample" id="toogleDetails" role="button" aria-expanded="false" aria-controls="collapseExample">
                                <h4 class="box-title mr-4">Meeting Info</h4>
                                <i class="ti-angle-up text-white" id="iconToogle" ></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="box-body pt-0 collapse show" id="collapseExample">
                    @if ( $activeBooks != null)
                        <div class="">
                            <input type="hidden" class="book_id" id="book_id" value="{{ $activeBooks[0]->id }}">
                            <input type="hidden" class="room_id" id="room_id" value="{{ $activeBooks[0]->room_id }}">
                            <input type="hidden" class="room_id" id="newh_end" value="{{ date('H:i:0', strtotime($activeBooks[0]->h_end) - ($setReminder[0]->min * 60)) }}">
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group mb-4">
                                    <label for="">meeting title</label>
                                    <h5 class="font-weight-300 mb-0">{{ $activeBooks[0]->desc }}</h5>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="form-group mb-4">
                                    <label for="">meeting time</label>
                                    <h5 class="font-weight-300 mb-0">
                                        {{ date('H:i', strtotime($activeBooks[0]->h_start)) }}
                                                    -
                                        {{ date('H:i', strtotime($activeBooks[0]->h_end)) }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="">meeting pic</label>
                                    <h5 class="font-weight-300">
                                        {{ $activeBooks[0]->pic_name }}
                                    </h5>
                                    <div id="dom"></div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="">meeting participants</label>
                                    <h5 class="font-weight-300"><?php
                                            $participantsTtl = DB::table('t_booking_participants')->where('book_id', $activeBooks[0]->id)->count();
                                            echo $participantsTtl;
                                        ?> People
                                    </h5>
                                </div>
                            </div>
                        </div>
                    @else
                        <h3>
                            There is no meeting this room
                        </h3>
                    @endif
                </div>
            </div>
        </div>
        @if ( $activeBooks != null)
            <div class="col-12">
                <h4 class="box-title mb-4">Devices Control</h4>
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    @if ( $rooms->room_call_id == 2)
                        <li class="nav-item mr-4 mb-4">
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#modalSecretary">
                                <div class="device-control-icon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <p class="text-center text-white font-size-14">Secretary</p>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item mr-4 mb-4">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#modalFrontdesk12">
                            <div class="device-control-icon">
                                <i class="fa fa-desktop"></i>
                            </div>
                            <p class="text-center text-white font-size-14">Frontdesk</p>
                        </a>
                    </li>
                    <li class="nav-item mr-4 mb-4">
                        <a class="pl-0" data-toggle="pill" href="#pills-fnb" role="tab" aria-selected="false">
                            <div class="device-control-icon">
                                <i class="fa fa-user"></i>
                            </div>
                            <p class="text-center text-white font-size-14">Room Service</p>
                        </a>
                    </li>
                    <li class="nav-item mr-4 mb-4">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#modalParticipant" data-participants="{{ json_encode($participants) }}">
                            <div class="device-control-icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <p class="text-center text-white font-size-14">Participants</p>
                        </a>
                    </li>
                    @if ( $controlDoors != null )
                        <li class="nav-item mr-4 mb-4">
                            <a class=" pl-0" data-toggle="pill" href="#pills-security" role="tab" aria-selected="false">
                                <div class="device-control-icon">
                                    <i class="fa fa-shield"></i>
                                </div>
                                <p class="text-center text-white font-size-14">Security</p>
                            </a>
                        </li>
                    @endif
                    @foreach ( $catFacilities as $cat)
                    <li class="nav-item mr-4 mb-4">
                        <a data-toggle="pill" href="#{{$cat->name_cat}}" role="tab" aria-selected="false">
                            <div class="device-control-icon">
                                <i class="fa fa-bolt"></i>
                            </div>
                            <p class="text-center text-white font-size-14">{{ $cat->name_cat }}</p>
                        </a>
                    </li>
                    @endforeach
                    <li class="nav-item mr-4 mb-4" style="position: absolute; right: 0;">
                        <a data-toggle="pill" href="#pills-action" role="tab" aria-selected="false">
                            <div class="device-control-icon">
                                <i class="fa fa-bell"></i>
                            </div>
                            <p class="text-center text-white font-size-14">Action</p>
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent" style="margin-bottom: 5.5rem">
                    {{-- <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">1...</div> --}}
                    <div class="tab-pane fade" id="pills-fnb" role="tabpanel">
                        <div class="border p-4" style="border-radius: .675rem">
                                <div class="devices-control-dark mb-0" style="border-radius: .675rem">
                                    <div class="box-header p-0">
                                        <div class="row">
                                            <div class="col-12 text-left">
                                                <h4 class="box-title mr-4">Room Service</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-body pb-0">
                                        <div class="row">
                                            <div class="col-auto">
                                                <a class="javascript:void(0);" onclick="_callHouseKeeper()">
                                                    <div class="device-control-icon">
                                                        <i class="fa fa-sign-language"></i>
                                                    </div>
                                                    <p class="text-center text-white font-size-14">Cleaning Service</p>
                                                </a>
                                            </div>

                                            <div class="col-auto">
                                                <a class="javascript:void(0);" data-toggle="modal" data-target="#modalFnB">
                                                    <div class="device-control-icon">
                                                        <i class="fa fa-coffee"></i>
                                                    </div>
                                                    <p class="text-center text-white font-size-14">Food and Baverages</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="tab-pane fade show active" id="pills-security" role="tabpanel">
                        @if ( $controlDoors != null )
                            <div class="border p-4" style="border-radius: .675rem">
                                <div class="devices-control-dark mb-0" style="border-radius: .675rem">
                                    <div class="box-header p-0">
                                        <div class="row">
                                            <div class="col-12 text-left">
                                                <h4 class="box-title mr-4">Security</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-body pb-0">
                                        @foreach ( $controlDoors as $door )
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12 control-wrapper">
                                                        <input type="text" value="{{ $door->name }}" name="name" readonly class="bg-transparent border-0 form-control text-white pl-0">
                                                        <input type="hidden" value="{{ $door->devices_id }}" name="device_id" readonly class="bg-transparent border-0 form-control text-white pl-0 deviceName">
                                                        @if ( $door->control_id == 1 )
                                                            <form class="d-inline">
                                                                <div class="float-right">
                                                                    <label class="toggle-control">
                                                                        <input type="checkbox" class="controlDoorLock">
                                                                        <span class="control"></span>
                                                                    </label>
                                                                </div>
                                                            </form>
                                                        @else
                                                            <form>
                                                                <div class="float-right">
                                                                    <input type="range" class="form-control-range" id="formControlRange">
                                                                </div>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if( $catFacilities != null)
                        @foreach ( $controls as $control )
                            <div class="tab-pane fade" id="{{$cat->name_cat}}" role="tabpanel">
                                <div class="border p-4" style="border-radius: .675rem">
                                    <div class="devices-control-dark mb-0" style="border-radius: .675rem">
                                        <div class="box-header p-0">
                                            <div class="row">
                                                <div class="col-12 text-left">
                                                    <h4 class="box-title mr-4">{{$cat->name_cat}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-body pb-0">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12 control-wrapper">
                                                        <input type="text" value="Turn ON/OFF All" name="name" readonly class="bg-transparent border-0 form-control text-white pl-0">
                                                        <input type="hidden" value="124" name="device_id" readonly class="bg-transparent border-0 form-control text-white pl-0 deviceName">
                                                        <form class="d-inline">
                                                            <div class="float-right">
                                                                <label class="toggle-control">
                                                                    <input type="checkbox" id="controlAll">
                                                                    <span class="control"></span>
                                                                </label>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @foreach ( $controls as $control )
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12 control-wrapper">
                                                            <input type="text" value="{{ $control->name }}" name="name" readonly class="bg-transparent border-0 form-control text-white pl-0">
                                                            <input type="hidden" value="{{ $control->devices_id }}" name="device_id" readonly class="bg-transparent border-0 form-control text-white pl-0 deviceName">
                                                            @if ( $control->control_id == 1 )
                                                                <form class="d-inline">
                                                                    <div class="float-right">
                                                                        <label class="toggle-control">
                                                                            <input type="checkbox" class="controlSwitch">
                                                                            <span class="control"></span>
                                                                        </label>
                                                                    </div>
                                                                </form>
                                                            @else
                                                                <form>
                                                                    <div class="float-right">
                                                                        <input type="range" class="form-control-range" id="formControlRange">
                                                                    </div>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <div class="tab-pane fade" id="pills-action" role="tabpanel">
                        <div class="border p-4" style="border-radius: .675rem">
                                <div class="devices-control-dark mb-0" style="border-radius: .675rem">
                                    <div class="box-header p-0">
                                        <div class="row">
                                            <div class="col-12 text-left">
                                                <h4 class="box-title mr-4">Action</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-body pb-0">
                                        <div class="row">
                                            <div class="col-auto">
                                                <a class="javascript:void(0);" onclick="activeCamera()" data-toggle="modal" data-target="#exampleModalCenter">
                                                    <div class="device-control-icon">
                                                        <i class="ti-hand-stop"></i>
                                                    </div>
                                                    <p class="text-center text-white font-size-14">Attendance</p>
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <a class="javascript:void(0);" data-toggle="modal" data-target="#modalConfirmExtend">
                                                    <div class="device-control-icon">
                                                        <i class="ti-time"></i>
                                                    </div>
                                                    <p class="text-center text-white font-size-14">Extend Meeting</p>
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <a class="javascript:void(0);" data-toggle="modal" data-target="#modalConfirmEnd">
                                                    <div class="device-control-icon">
                                                        <i class="ti-power-off"></i>
                                                    </div>
                                                    <p class="text-center text-white font-size-14">End Meeting</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <header class="main-header">
                <nav class="navbar navbar-static-bottom ml-0">
                    <div class="navbar-custom-menu r-side">
                        <ul class="nav navbar-nav">
                            <!-- User Account-->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle p-0" data-toggle="dropdown">
                                    <i class="ti-settings"></i>
                                </a>
                                <ul class="dropdown-menu animated flipInX dropdown-show-top"  style="border-radius: 6px">
                                    <!-- Menu Body -->
                                    <li class="user-body" style="border-radius: 6px">
                                        {{-- <a class="dropdown-item font-size-1rem" href="{{ url('/') }}"><i class="ti-close"></i>Exit</a> --}}
                                        @if (Auth::user()->user_type == 99)
                                            <a class="dropdown-item font-size-1rem" href="javascript:void(0);" onclick="window.location.href='{{route('dashboard')}}'"><i class="ti-arrow-left"></i>Exit</a>
                                            <div class="dropdown-divider"></div>
                                        @endif
                                        <a class="dropdown-item font-size-1rem" href="{{ route('logout') }}"><i class="ti-power-off"></i>Log Out</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            {{-- MODAL --}}
            {{-- MODAL CONFIRM EXTEND --}}
            <div class="modal" id="modalConfirmExtend" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="box border-0 mb-0">
                                        <div class="box-body">
                                            <h5 class="modal-title text-dark">Extend Meeting</h5>
                                            <h3 class="mb-0 text-dark">Do you want to extend the meeting time by 30 minutes?</h3>
                                        </div>
                                        <div class="box-footer">
                                            <div class="row">
                                                <div class="col-3">
                                                    <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" data-dismiss="modal">Close</button>
                                                </div>
                                                <div class="col-3">
                                                    <button type="submit" onclick="_extendApi()" class="btn btn-bold btn-pure btn-info float-right btn-block">Yes, right</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- MODAL CONFIRM END MEETING --}}
            <div class="modal" id="modalConfirmEnd" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="box border-0 mb-0">
                                        <div class="box-body">
                                            <h5 class="modal-title text-dark">End Meeting</h5>
                                            <h3 class="mb-0 text-dark">Do you want to end the meeting now?</h3>
                                        </div>
                                        <div class="box-footer">
                                            <div class="row">
                                                <div class="col-3">
                                                    <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" data-dismiss="modal">Close</button>
                                                </div>
                                                <div class="col-3">
                                                    <button type="submit" onclick="_endNowApi()" class="btn btn-bold btn-pure btn-info float-right btn-block">Yes, right</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- MODAL PARTICIPANTS --}}
            <div class="modal" id="modalParticipant" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="box border-0 mb-0">
                                <div class="box-body">
                                    <h5 class="modal-title text-dark mb-4">List Participants</h5>
                                    <div class="table-responsive">
                                        <table class="table border-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Participant name</th>
                                                    <th>Present</th>
                                                    <th>Present At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @foreach ( $participants as $participant )
                                                    <tr>
                                                        <td>{{ $no++}}</td>
                                                        <td>{{ $participant->name }}</td>
                                                        <td>
                                                            {{ ($participant->is_present == 1) ?'Present' : 'Absent' }}
                                                        </td>
                                                        <td>
                                                            @if ($participant->present_at != null)
                                                                {{ date('H:i:s', strtotime($participant->present_at)) }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="modalExtendTime" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-dark">
                            <h3 id="resMsg"></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="modalEndMeeting" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-dark">
                            <h3 id="participant_name">
                                The meeting has been successfully ended
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <canvas style="width: 100%; height: 100%; margin-bottom: -5px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="welcomeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-dark">
                            <p class="font-size-24" id="participant_title12">welcome,</p>
                            <h4 class="font-size-30" id="participant_name12">em</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="afterOrderFnB" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-dark">
                            <h3 class="" id="">Your order has been delivered to food and beverage.</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="callFrontdesk" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-dark">
                            <h4 class="" id="">Please wait a moment, Frontdesk will soon carry out your instructions</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="callSecretary" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-dark">
                            <h4 class="" id="">Please wait a moment, Secretary will soon carry out your instructions</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="callHouseKeeper" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-dark">
                            <h3 class="" id="">Please wait a moment, the cleaning service is on its way here</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="alertMeeting" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="box border-0 mb-0">
                                        <div class="box-body">
                                            <h5 class="modal-title text-dark">The meeting will end soon</h5>
                                            <h3 class="mb-0 text-dark">Your meeting will be end in 10 minutes. Do you want to extend the meeting time by 30 minutes?</h3>
                                        </div>
                                        <div class="box-footer">
                                            <div class="row">
                                                <div class="col-3">
                                                    <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" data-dismiss="modal">Close</button>
                                                </div>
                                                <div class="col-3">
                                                    <button type="submit" onclick="_extendApi()" class="btn btn-bold btn-pure btn-info float-right btn-block">Yes, right</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- MODAL F&B --}}
            <div class="modal" id="modalFnB" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-dark p-0">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form id="foodForm">
                                        <div class="box border-0 mb-0">
                                            <div class="box-header">
                                                <div class="row">
                                                    <div class="col-12 text-left">
                                                        <h4 class="box-title">Food & Beverage</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="box-body">
                                                <div class="form-group mb-0">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <label>Name</label>
                                                        </div>
                                                        <div class="col-2">
                                                            <label>Qty</label>
                                                        </div>
                                                        <div class="col-5">
                                                            <label>Notes</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-0">
                                                    <div class="row">
                                                        <div class="col-4 bg-white">
                                                            <select name="menu_id[]" class="select2 text-dark" id="selectMRoom" style="width: 100%">
                                                                <option value="none" selected disabled>Select Menu</option>
                                                                @foreach ( $menus as $menu)
                                                                    <option class="text-dark" value="{{ $menu->id }}">{{ $menu->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" name="status[]" class="form-control" value="1">
                                                        </div>
                                                        <div class="col-2">
                                                            <input type="number" min="1" name="qty[]" class="form-control text-right" value="1">
                                                        </div>
                                                        <div class="col-5">
                                                            <input type="text" name="notes[]" class="form-control" value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <a href="javascript:void();" class="btn btn-bold btn-pure btn-info btn-block" id="addMenu">
                                                                <i class="ti-plus"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="menu_wrapper"></div>
                                            </div>
                                            <div class="box-footer">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" data-dismiss="modal">Close</button>
                                                    </div>
                                                    <div class="col-3">
                                                        <button type="submit" class="btn btn-bold btn-pure btn-info float-right btn-block btn-order">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="modalSecretary" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-dark p-0">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="box border-0 mb-0">
                                        <div class="box-header">
                                            <div class="row">
                                                <div class="col-12 text-left">
                                                    <h4 class="box-title">Secretary</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="">
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="">Message</label>
                                                            <textarea name="message" id="helpSecretary" cols="30" rows="3" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto pr-0">
                                                        <a href="javascript:void(0);" class="btn btn-bold btn-pure btn-warning float-right btn-block btn-order" id="btnDokumenSec">Document</a>
                                                    </div>
                                                    <div class="col-auto pr-0">
                                                        <a href="javascript:void(0);" class="btn btn-bold btn-pure btn-warning float-right btn-block btn-order" id="btnTamuSec">Guest</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="box-footer">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" data-dismiss="modal">Close</button>
                                                    </div>
                                                    <div class="col-3">
                                                        <a href="javascript:void(0);" onclick="_sendInstructionSecretary()" class="btn btn-bold btn-pure btn-info float-right btn-block btn-order">Submit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="modalFrontdesk12" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-dark p-0">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="box border-0 mb-0">
                                        <div class="box-header">
                                            <div class="row">
                                                <div class="col-12 text-left">
                                                    <h4 class="box-title">Frontdesk</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="">
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="">Message</label>
                                                            <textarea name="message" id="helpFrontDesk" cols="30" rows="3" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto pr-0">
                                                        <a href="javascript:void(0);" class="btn btn-bold btn-pure btn-warning float-right btn-block btn-order" id="btnDokumen">Document</a>
                                                    </div>
                                                    <div class="col-auto pr-0">
                                                        <a href="javascript:void(0);" class="btn btn-bold btn-pure btn-warning float-right btn-block btn-order" id="btnTamu">Guest</a>
                                                    </div>
                                                    {{-- <div class="col-auto pr-0">
                                                        <a href="javascript:void(0);" class="btn btn-bold btn-pure btn-warning float-right btn-block btn-order" id="btnRemote">Remote</a>
                                                    </div> --}}
                                                </div>
                                            </div>
                                            <div class="box-footer">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" data-dismiss="modal">Close</button>
                                                    </div>
                                                    <div class="col-3">
                                                        <a href="javascript:void(0);" onclick="_sendInstruction()" class="btn btn-bold btn-pure btn-info float-right btn-block btn-order">Submit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class=""></div>
        @endif
    </div>
@endsection

@section('script')

    <script src="{{ asset('vendor/webcodecamjs/js/qrcodelib.js') }}"></script>
    <script src="{{ asset('vendor/webcodecamjs/js/webcodecamjs.js') }}"></script>
    <script src="{{ asset('vendor/webcodecamjs/js/main.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>
        $("#btnDokumen").click(function () {
            $("#helpFrontDesk").val('Please take the document ');
        });
        $("#btnTamu").click(function () {
            $("#helpFrontDesk").val('Please pick up my guest at the Lobby ');
        });
        $("#btnDokumenSec").click(function () {
            $("#helpSecretary").val('Please take the document ');
        });
        $("#btnTamuSec").click(function () {
            $("#helpSecretary").val('Please pick up my guest at the Lobby ');
        });
    </script>
    <script>
        function _sendInstructionSecretary() {
            return $.ajax({
                url: "<?= url('secretary-instruction-api') ?>",
                type: 'GET',
                data: {
                    book_id: $("#book_id").val(),
                    room_id: $("#room_id").val(),
                    msg: $("#helpSecretary").val()
                },
                success: function( res ) {
                    console.log(res)
                    $('#modalSecretary').modal('hide');
                    $('#helpSecretary').val('');
                    $('#callSecretary').modal('show');
                    setTimeout(function(){
                        $("#callSecretary").modal('hide');
                    }, 3000);
                },
                error: function (res) {
                    alert('Canot submit your instruction.');
                }
            });
        }
    </script>
    <script>
        function _sendInstruction() {
            return $.ajax({
                url: "<?= url('frontdesk-instruction-api') ?>",
                type: 'GET',
                data: {
                    book_id: $("#book_id").val(),
                    room_id: $("#room_id").val(),
                    msg: $("#helpFrontDesk").val()
                },
                success: function( res ) {
                    console.log(res)
                    $('#modalFrontdesk12').modal('hide');
                    $('#helpFrontDesk').val('');
                    $('#callFrontdesk').modal('show');
                    setTimeout(function(){
                        $("#callFrontdesk").modal('hide');
                    }, 3000);
                }
            });
        }
    </script>
    <script>
        function _callHouseKeeper() {
            return $.ajax({
                url: "<?= url('call-housekeeper-api') ?>",
                type: 'GET',
                data: {
                    book_id: $("#book_id").val(),
                    room_id: $("#room_id").val()
                },
                success: function( fnbs ) {
                    console.log(fnbs)
                    $('#callHouseKeeper').modal('show');
                    setTimeout(function(){
                        $("#callHouseKeeper").modal('hide');
                    }, 3000);
                }
            });
        }
    </script>
    <script>
        $('#foodForm').on('submit', function(e){
            e.preventDefault();
            var data = $(this).serialize()
            $.ajax({
                url:"{{ url('new-order-fnb') }}",
                method:'post',
                data:{
                    _token: CSRF_TOKEN,
                    book_id: $("#book_id").val(),
                    order: data
                },
                dataType:'json',
                success:function(data)
                {
                    $('#modalFnB').modal('hide');
                    $('#afterOrderFnB').modal('show');
                    setTimeout(function(){
                        $("#afterOrderFnB").modal('hide');
                    }, 3000);
                }
            })
            // stay.preventDefault();
        });
    </script>
    <script>
        var controlList = <?= json_encode($controls) ?>;
        var securityList = <?= json_encode($controlDoors) ?>;
        $("#controlAll").change(function () {
            console.log(controlList);
            console.log(security);
            for ( var security of securityList){
                console.log(security)
                $.ajax({
                    url: "{{ url('late-panda-device') }}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        "deviceId": security.devices_id,
                        "activityId": (this.checked) ? '3' : '4' //ON
                    },
                    success: function( data ) {
                        console.log(data)
                    }
                });
            }
            for ( var control of controlList){
                console.log(control)
                $.ajax({
                    url: "{{ url('late-panda-device') }}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        "deviceId": control.devices_id,
                        "activityId": (this.checked) ? '1' : '0' //ON
                    },
                    success: function( data ) {
                        console.log(data)
                    }
                });
            }
            $("input:checkbox.controlSwitch").prop('checked',this.checked);
        });
    </script>
    <script>
        $('.btn-participant').on('click',function(){
            var item = $(this).data('participants');
            console.log(item);
        })
    </script>
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        // Show time
        var hEnd = $("#newh_end").val();
        console.log(hEnd);
        function startTime() {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            m = checkTime(m);
            var timeNow = h + ":" + m + ":" + s;
            document.getElementById('time').innerHTML =timeNow;
            if (timeNow == hEnd) {
                $('#alertMeeting').modal('show');
                // setTimeout(function(){
                //     $("#alertMeeting").modal('hide');
                // }, 30000);
            }
            var t = setTimeout(startTime, 1000);
        }

        function checkTime(i) {
            if (i < 10) {i = "0" + i};
            return i;
        }

        setTimeout(function(){
            $('#collapseExample').removeClass("show");
            $('#iconToogle').toggleClass("ti-angle-up ti-angle-down");
        }, 5000000);

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        // LAMP CONTROL 0 - 1
        $('.controlSwitch').click(function(){
            if($(this).prop("checked") == true){
                var parent  = $(this).closest('.control-wrapper')
                console.log(parent.find('.deviceName').val()+' ON (1)')
                $.ajax({
                    url: "{{ url('late-panda-device') }}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        "deviceId": parent.find('.deviceName').val(),
                        "activityId": "1" //ON
                    },
                    success: function( data ) {
                        console.log(data)
                    }
                });
            }
            else if($(this).prop("checked") == false){
                var parent  = $(this).closest('.control-wrapper')
                console.log(parent.find('.deviceName').val()+' OFF (0)')
                $.ajax({
                    url: "{{ url('late-panda-device') }}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        "deviceId": parent.find('.deviceName').val(),
                        "activityId": "0" //y
                    },
                    success: function( data ) {
                        console.log(data)
                    }
                });
            }
        });
    </script>
    <script>
        // DOOR LOCK CONTROL 3 - 4
        $('.controlDoorLock').click(function(){
            if($(this).prop("checked") == true){
                var parent  = $(this).closest('.control-wrapper')
                console.log(parent.find('.deviceName').val()+' OPEN (4)')
                $.ajax({
                    url: "{{ url('late-panda-device') }}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        "deviceId": parent.find('.deviceName').val(),
                        "activityId": "4" //OPEN
                    },
                    success: function( data ) {
                        console.log(data)
                    }
                });
            }
            else if($(this).prop("checked") == false){
                var parent  = $(this).closest('.control-wrapper')
                console.log(parent.find('.deviceName').val()+' LOCK (3)')
                $.ajax({
                    url: "{{ url('late-panda-device') }}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        "deviceId": parent.find('.deviceName').val(),
                        "activityId": "3" //LOCK
                    },
                    success: function( data ) {
                        console.log(data)
                    }
                });
            }
        });
    </script>
    <script>
        function  _extendApi() {
            return $.ajax({
                url: "<?= url('device-control-extend-api') ?>",
                type: 'GET',
                data: {
                    book_id: $("#book_id").val()
                },
                success: function( res ) {
                    console.log(res)
                    $('#modalConfirmExtend').modal('hide');
                    $('#modalExtendTime').modal('show');
                    $('#resMsg').html(res.message);
                    setTimeout(function(){
                        $("#modalExtendTime").modal('hide');
                    }, 3000);
                }
            });
        }

        function  _endNowApi() {
            return $.ajax({
                url: "<?= url('device-control-endnow-api') ?>",
                type: 'GET',
                data: {
                    book_id: $("#book_id").val(),
                    room_id: $("#room_id").val()
                },
                success: function( datas ) {
                    console.log(datas)
                    $('#modalConfirmEnd').modal('hide');
                    $('#modalEndMeeting').modal('show');
                    setTimeout(function(){
                        $("#modalEndMeeting").modal('hide');
                    }, 3000);
                    location.reload();
                }
            });
        }
    </script>
    <script>
        function activeCamera(){
            console.log('hello')
            if ('mediaDevices' in navigator && 'getUserMedia' in navigator.mediaDevices) {
                console.log("Let's get this party started")
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var txt = "innerText" in HTMLElement.prototype ? "innerText" : "textContent";
            var arg = {
                DecodeQRCodeRate: 5,                    // null to disable OR int > 0 !
                DecodeBarCodeRate: 5,                   // null to disable OR int > 0 !
                // successTimeout: 3000,                    // delay time when decoding is succeed
                codeRepetition: false,                   // accept code repetition true or false
                tryVertical: true,                      // try decoding vertically positioned barcode true or false
                frameRate: 15,                          // 1 - 25
                constraints: {                          // default constraints
                    video: {
                        mandatory: {
                            maxWidth: 1920,
                            maxHeight: 1080
                        },
                        optional: [{
                            sourceId: true
                        }]
                    },
                    audio: false
                },
                flipVertical: false,                    // boolean
                flipHorizontal: false,                  // boolean
                zoom: -1,                               // if zoom = -1, auto zoom for optimal resolution else int
                beep: '{{ asset('vendor/webcodecamjs/audio/beep.mp3') }}',                 // string, audio file location
                decoderWorker: '{{ asset('vendor/webcodecamjs/js/DecoderWorker.js') }}',   // string, DecoderWorker file location
                brightness: 0,                          // int
                autoBrightnessValue: 100,             // functional when value autoBrightnessValue is int
                grayScale: false,                       // boolean
                contrast: 0,                            // int
                threshold: 0,                           // int
                sharpness: [],      // to On declare matrix, example for sharpness ->  [0, -1, 0, -1, 5, -1, 0, -1, 0]                   // delay time when decoding is succeed
                resultFunction: function(res) {
                    $.ajax({
                        url:"{{route('checkParty')}}",
                        type: 'get',
                        dataType: "json",
                        data: {
                            barcode: res.code,
                            room_id: $("#room_id").val()
                        },
                        success: function(datas) {
                            // console.log(datas);
                            $('#exampleModalCenter').modal('hide');
                            $('#participant_title12').html(datas.msg.title);
                            $('#participant_name12').html(datas.msg.body);
                            $('#welcomeModal').modal('show');
                            setTimeout(function(){
                                $("#welcomeModal").modal('hide');
                            }, 3000);
                        }
                    });
                }
            };
            new WebCodeCamJS("canvas").init(arg).play();
        }
    </script>
    <script>
        $(document).ready(function(){
            var maxField = <?php
                            $count = DB::table('menus')->count();
                            echo $count;
                        ?>; //Input fields increment limitation
            var addButton = $('#addMenu'); //Add button selector
            var wrapper = $('#menu_wrapper'); //Input field wrapper
            var html = ''; //New input field html
                html +='<div class="form-group mb-0 mt-4 new-row">';
                    html +='<div class="row">';
                        html +='<div class="col-4">';
                            html +='<select name="menu_id[]" class="select2" id="selectMRoom" style="width: 100%">';
                                html +='<option selected disabled>Select Menu</option>';
                                    html +='@foreach ( $menus as $menu)';
                                        html +='<option value="{{ $menu->id }}">{{ $menu->name }}</option>';
                                    html +='@endforeach';
                                html +='</select>';
                            html +='<input type="hidden" name="status[]" class="form-control" value="1">';
                        html +='</div>';
                        html +='<div class="col-2">';
                            html +='<input type="number" name="qty[]" class="form-control text-right" value="">';
                        html +='</div>';
                        html +='<div class="col-5">';
                            html +='<input type="text" name="notes[]" class="form-control" value="">';
                        html +='</div>';
                        html +='<div class="col-1">';
                            html +='<a href="javascript:void(0);" class="btn btn-bold btn-pure btn-danger btn-block" id="removeRow"><i class="ti-minus"></i></a>';
                        html +='</div>';
                    html +='</div>';
                html +='</div>';
            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function(){
                //Check maximum number of input fields
                if(x < maxField){
                    x++; //Increment field counter
                    $(wrapper).append(html); //Add field html
                } else {
                    Swal.fire('You have reached the maximum number of menus available')
                }
                $('.select2').select2();
            });

            //On    ce remove button is clicked
            $(wrapper).on('click', '#removeRow', function(e){
                e.preventDefault();
                $(this).closest('.form-group').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
    </script>
    <script>
        $('#toogleDetails').on('click', function() {
            $('#iconToogle').toggleClass("ti-angle-up ti-angle-down");
        })
    </script>
@endsection

