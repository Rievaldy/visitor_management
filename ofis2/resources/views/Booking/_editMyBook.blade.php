@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">View My Booking</h3>
    </div>
@endsection

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='{{ asset('vendor/fullcalendar-3.10.2/fullcalendar.min.css') }}' rel='stylesheet' />
    <link href='{{ asset('vendor/bootstrap-datepicker/css/scheduler.min.css') }}' >
    <link href='{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}' rel='stylesheet' />
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
@endsection


@section('content')
    <form action="{{ route('myBookingUpdate')}}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="row">
            <input type="hidden" name="room_id" id="room_id" value="{{ $room[0]->room_id }}">
            <input type="hidden" name="book_id" id="book_id" value="{{ $book_id }}">
            <input type="hidden" name="meeting_date" id="meeting_date" value="{{ date('Y-m-d', strtotime($books->meeting_date))}}">
            <input type="hidden" name="room_name" id="room_name" value="{{ $room[0]->room_name }}">
            <input type="hidden" name="room_capacity" id="room_capacity" value="{{ $room[0]->capacity}}">
            <input type="hidden" name="user_id" id="user_id" value="{{ $pic[0]->pic_id }}">
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">Basic Info</h4>
                    </div>
                    <div class="box-body">
                        <div class="form-group mb-0">
                            <label>Meeting PIC</label>
                            <div class="row align-items-center">
                                <div class="col-sm-4 col-12 mb-4">
                                    <input type="text" class="form-control" value="{{ $pic[0]->pic_name }}" placeholder="" readonly>
                                </div>
                                <div class="col-sm-4 col-12 mb-4">
                                    <input type="text" class="form-control" value="{{ $pic[0]->pic_email }}" placeholder="" readonly>
                                </div>
                                <div class="col-sm-4 col-12 mb-4">
                                    <input type="text" class="form-control" value="{{ $pic[0]->pic_phone }}" placeholder="" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Meeting date</label>
                            <div class="row align-items-center">
                                <div class="col-sm-10 col-8">
                                    <input type="text" class="form-control" id="meeting_date_dom" value="{{ date('M d, Y', strtotime($books->meeting_date))}}" placeholder="" readonly>
                                </div>
                                <div class="col-sm-2 col-4">
                                    <a href="#" data-toggle="modal" class="btn btn-bold btn-pure btn-info btn-block " data-target="#modalCalendar">
                                        Change Date
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Meeting time</label>
                            <div class="row align-items-center">
                                <div class="col-sm-5 col-5">
                                    <input type="text" name="h_start" class="form-control" id="h_start" value="{{ date('H:i', strtotime($books->h_start))}}" placeholder="">
                                </div>
                                <div class="col-sm-2 col-2 text-center">
                                    <p class="mb-0">Until</p>
                                </div>
                                <div class="col-sm-5 col-5">
                                    <input type="text" name="h_end" class="form-control" id="h_end" value="{{ date('H:i', strtotime($books->h_end))}}" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Meeting Title</label>
                            <div class="row align-items-center">
                                <div class="col-sm-12 col-12">
                                    <input type="text" name="desc" class="form-control" value="{{ $books->desc }}" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label>Meeting Participants</label>
                        </div>
                        <div class="form-group mb-0">
                            <div class="row">
                                <div class="col-3">
                                    <label>Email address</label>
                                </div>
                                <div class="col-3">
                                    <label>Name</label>
                                </div>
                                <div class="col-3">
                                    <label>Company</label>
                                </div>
                                <div class="col-3">
                                    <label>Phone</label>
                                </div>
                            </div>
                        </div>
                        <div id="oldFacility">
                            @foreach ( $participants as $participant )
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-3">
                                            <input type="email" name="guest_email[]" class="form-control email" id="email" value="{{ $participant->email }}" required>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" name="guest_name[]" class="form-control" id="name" value="{{ $participant->name }}" required>
                                            <input type="hidden" name="status[]" class="form-control" value="1">
                                        </div>
                                        <div class="col-3">
                                            <input type="text" name="guest_company[]" class="form-control" id="company" value="{{ $participant->company }}" required>
                                        </div>
                                        <div class="col-2">
                                            <input type="number" name="guest_phone[]" class="form-control" id="phone" value="{{ $participant->phone }}" required>
                                        </div>
                                        <div class="col-1">
                                            <a href="javascript:void(0);" class="btn btn-bold btn-pure btn-danger btn-block removeOld"><i class="ti-minus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group mb-0">
                            <div class="row">
                                <div class="col-3">
                                    <input type="email" name="guest_email[]" class="form-control email" id="email" value="" required>
                                </div>
                                <div class="col-3">
                                    <input type="text" name="guest_name[]" id="name" class="form-control" value="" required>
                                    <input type="hidden" name="status[]" class="form-control" value="1">
                                </div>
                                <div class="col-3">
                                    <input type="text" name="guest_company[]" id="company" class="form-control" value="" required>
                                </div>
                                <div class="col-2">
                                    <input type="text" name="guest_phone[]" id="phone" class="form-control" value="" required>
                                </div>
                                <div class="col-1">
                                    <a href="javascript:void();" class="btn btn-bold btn-pure btn-info btn-block" id="addRow">
                                        <i class="ti-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div id="field_wrapper"></div>
                    </div>
                </div>
                <div class="box">
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
                                <div class="col-6">
                                    <label>Notes</label>
                                </div>
                            </div>
                        </div>
                        <div id="oldFnb">
                            @foreach ( $fnbs as $fnb )
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-4">
                                            <select name="menu_id[]" class="select2" id="selectMRoom" style="width: 100%">
                                                <option value="none" selected disabled>Select Menu</option>
                                                @foreach ( $menus as $menu)
                                                    <option value="{{ $menu->id }}" {{$menu->id == $fnb->menu_id  ? 'selected' : ''}}>{{ $menu->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="status[]" class="form-control" value="1">
                                        </div>
                                        <div class="col-2">
                                            <input type="number" name="qty[]" class="form-control text-right" value="{{ $fnb->qty }}" >
                                        </div>
                                        <div class="col-5">
                                            <input type="text" name="notes[]" class="form-control" value="{{ $fnb->notes }}" >
                                        </div>
                                        <div class="col-1">
                                            <a href="javascript:void(0);" class="btn btn-bold btn-pure btn-danger btn-block removeOld"><i class="ti-minus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group mb-0">
                            <div class="row">
                                <div class="col-4">
                                    <select name="menu_id[]" class="select2" id="selectMRoom" style="width: 100%">
                                        <option value="none" selected disabled>Select Menu</option>
                                        @foreach ( $menus as $menu)
                                            <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="status[]" class="form-control" value="1">
                                </div>
                                <div class="col-2">
                                    <input type="number" name="qty[]" class="form-control text-right" value="">
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
                </div>
            </div>
            <div class="col-sm-4">
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">Room Info</h4>
                    </div>
                    <div class="box-body">
                        <div class="">
                            <div class="row">
                                <div class="col-12">
                                    <p id="room_name_view" class="text-left font-size-11 text-uppercase text-bold">{{ $room[0]->room_name }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <img id="room_img" src="{{ $room[0]->img }}" alt="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="text-left font-size-11 text-uppercase text-bold">Capacity</p>
                                    <p class="text-left" id="room_capacity_view">{{ $room[0]->capacity}} Participants</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="text-left font-size-11 text-uppercase text-bold" style="margin-top: 1rem">Room Facility</p>
                                            <div class="form-group mb-0">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <label>Property Name</label>
                                                    </div>
                                                    <div class="col-4">
                                                        <label>Device ID</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="facility">
                                                @foreach ( $facilities as $facility )
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-8">
                                                                <input type="text" name="" class="form-control" readonly value="{{ $facility->name }}" >
                                                            </div>
                                                            <div class="col-4">
                                                                <input type="text" name="" class="form-control" readonly value="{{ $facility->device_id }}" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
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
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <a href="{{ url('/my-booking') }}" class="btn btn-bold btn-pure btn-secondary btn-block">BACK</a>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <button type="submit" class="btn btn-bold btn-pure btn-info btn-block">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    {{-- MODAL SATART --}}
    <div class="modal fade" id="modalCalendar" tabindex="-1"  data-backdrop="false" aria-hidden="true" style="z-index: 9999">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> --}}
                    <button type="button" class="close" style="padding-right: 28px" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="box mb-0">
                                <div class="box-header">
                                    <div class="row">
                                        <div class="col-sm-3 col-6">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right" id="datepicker">
                                            </div>
                                        </div>
                                    </div>
                                </div class="box-body">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="cantSelect" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-dark">
                    <h4 class="" id="">Oops</h4>
                    <h4 class="mb-0 font-size-20" id="">you can't choose the past date or time.</h4>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src='https://cdn.jsdelivr.net/npm/moment@2.24.0/min/moment.min.js'></script>
    <script src='{{ asset('vendor/fullcalendar-3.10.2/fullcalendar.min.js') }}'></script>
    {{-- <script src='{{ asset('vendor/fullcalendar-3.10.2/scheduler.min.js') }}'></script> --}}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@1.10.1/dist/scheduler.min.js'></script>
    <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script>
        function  _getEventList(date) {
            return $.ajax({
                type: 'GET',
                url: "<?= url('eventlist-api') ?>",
                // async: !1,
                data: { date: date }
            });
        }

        function  _getResourceList(date) {
            return $.ajax({
                type: 'GET',
                url: "<?= url('resourcelist-api') ?>",
                // async: !1,
                data: { date: date }
            });
        }
        $('#modalCalendar').on('shown.bs.modal', function () {
            console.log('hello')
                $('#calendar').fullCalendar({
                    defaultView: 'agendaDay',
                    // validRange: function(nowDate) {
                    //     return {
                    //         start: nowDate.clone().subtract(nowDate),
                    //         end: nowDate.clone().add(1, 'months')
                    //     };
                    // },
                    // nowIndicator: true,
                    groupByResource: true,
                    resources: [],
                    timeFormat: 'H:mm',
                    timeZone: 'local',
                    titleFormat: 'ddd, MMM DD, YYYY',
                    editable: false,
                    selectable: true,
                    refetchResourcesOnNavigate: true,
                    // businessHours: true,
                    allDaySlot: false,
                    slotLabelFormat:"HH:mm",
                    selectOverlap: false,

                    eventColor: '#faa700',
                    select: function(startDate, endDate, jsEvent, view, resource) {
                        var now = new Date();
                        var today = moment(now).format('YYYY/MM/DD HH:mm:ss');
                        var start = moment(startDate).format('YYYY/MM/DD HH:mm:ss');

                        console.log(moment(start))
                        if ( moment(start).isBefore(today) ) {
                            $('#calendar').fullCalendar('unselect');
                            $('#modalCalendar').modal('hide');
                            $('#cantSelect').modal('show');
                            setTimeout(function(){
                                $("#cantSelect").modal('hide');
                            }, 3000);
                        }else {
                            $('#modalCalendar').hide()
                            $('body').removeClass('modal-open')
                            $('#meeting_date').val(startDate.format('YYYY-MM-DD'))
                            $('#meeting_date_dom').val(startDate.format('MMM DD, YYYY'))
                            $('#h_start').val(startDate.format('HH:mm'))
                            $('#h_end').val(endDate.format('HH:mm'))
                            $('#room_img').attr('src',resource.img)
                            $('#room_name_view').html(resource.room_name)
                            $('#room_id').val(resource.id)
                            $('#room_name').val(resource.room_name)
                            $('#room_capacity').val(resource.capacity)
                            $('#room_capacity_view').html(resource.capacity+' Participants')
                            var html = '';
                            for( var i of JSON.parse(resource.facility)){
                                html +='<div class="form-group">';
                                    html +='<div class="row">';
                                        html +='<div class="col-8">';
                                            html +='<input type="text" class="form-control" readonly value="'+i.name+'" >';
                                        html +='</div>';
                                        html +='<div class="col-4">';
                                            html +='<input type="text" class="form-control" readonly value="'+i.deviceId+'" >';
                                        html +='</div>';
                                    html +='</div>';
                                html +='</div>';
                            }
                            $('#facility').html(html)
                        }
                    },
                    events: [],
                    // viewRender: function(view, element) {

                    // }
                });
                $('.fc-prev-button').click(function(){
                    var date1 = $('#calendar').fullCalendar( 'getDate' );
                    var dayFormat = date1.format('dddd');
                    var dateFormat = date1.format('YYYY-MM-DD');
                    _getResourceList(dayFormat).then((res) => {
                        $.each(res,(key,val) => {
                            $('#calendar').fullCalendar('addResource', val);
                        })
                    });
                    _getEventList(dateFormat).then((res) => {
                        $('#calendar').fullCalendar('removeEvents');
                        $('#calendar').fullCalendar('addEventSource', res);
                        $('#calendar').fullCalendar('rerenderEvents');
                    });
                    return false;
                });
                $('.fc-today-button').click(function() {
                    var date1 = $('#calendar').fullCalendar('getDate');
                    var dayFormat = date1.format('dddd');
                    var dateFormat = date1.format('YYYY-MM-DD')
                    _getResourceList(dayFormat).then((res) => {
                        $.each(res,(key,val) => {
                            $('#calendar').fullCalendar('addResource', val);
                        })
                    });
                    _getEventList(dateFormat).then((res) => {
                        $('#calendar').fullCalendar('removeEvents');
                        $('#calendar').fullCalendar('addEventSource', res);
                        $('#calendar').fullCalendar('rerenderEvents' );
                    });
                    return false;
                });
                $('.fc-next-button').click(function(){
                    console.log('clicked')
                    var date1 = $('#calendar').fullCalendar( 'getDate' );
                    var dayFormat = date1.format('dddd');
                    var dateFormat = date1.format('YYYY-MM-DD')
                    _getResourceList(dayFormat).then((res) => {
                        $.each(res,(key,val) => {
                            $('#calendar').fullCalendar('addResource', val);
                        })
                        return false
                    });
                    _getEventList(dateFormat).then((res) => {
                        $('#calendar').fullCalendar('removeEvents');
                        $('#calendar').fullCalendar('addEventSource', res);
                        $('#calendar').fullCalendar('rerenderEvents' );
                    });
                    return false;
                });

                var todayResource = _getResourceList("<?=date('l')?>").then((res) => {
                    $.each(res,(key,val) => {
                        $('#calendar').fullCalendar('addResource', val);
                    })
                });

                var todayEvent = _getEventList("<?=date('Y-m-d')?>").then((res) => {
                    $('#calendar').fullCalendar('removeEvents');
                    $('#calendar').fullCalendar('addEventSource', res);
                    $('#calendar').fullCalendar('rerenderEvents' );
                });



                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var month = new Array();

                month[0] = "01";
                month[1] = "02";
                month[2] = "03";
                month[3] = "04";
                month[4] = "05";
                month[5] = "06";
                month[6] = "07";
                month[7] = "08";
                month[8] = "09";
                month[9] = "10";
                month[10] = "11";
                month[11] = "12";
                var mm = month[today.getMonth()];
                var yyyy = today.getFullYear();

                today = mm + '/' + dd + '/' + yyyy;

                $('#datepicker').val(today);
                $('#datepicker').datepicker({
                    format: "mm/dd/yyyy",
                    dateFormat: "mm/dd/yyyy",
                    todayHighlight: true,
                    inline: true,
                    autoclose: true,
                }).change(function (e) {
                    var mydate = moment($(this).val(),'MM/DD/YYYY').format('YYYY-MM-DD')
                    $("#calendar").fullCalendar('gotoDate', mydate);
                    var date1 = $('#calendar').fullCalendar( 'getDate' );
                    var dayFormat = date1.format('dddd');
                    _getResourceList(dayFormat).then((res) => {
                        $.each(res,(key,val) => {
                            $('#calendar').fullCalendar('addResource', val);
                        })
                    });
                    var dateFormat = date1.format('YYYY-MM-DD')
                    _getEventList(dateFormat).then((res) => {
                        $('#calendar').fullCalendar('removeEvents');
                        $('#calendar').fullCalendar('addEventSource', res);
                        $('#calendar').fullCalendar('rerenderEvents' );
                    });
                });
        });
    </script>
    <script>
        $('#oldFacility').on('click', '.removeOld', function(e){
            e.preventDefault();
            $(this).closest('.form-group').remove(); //Remove field html
            x--; //Decrement field counter
        });
        $('#oldFnb').on('click', '.removeOld', function(e){
            e.preventDefault();
            $(this).closest('.form-group').remove(); //Remove field html
            x--; //Decrement field counter
        });
    </script>
    <script type="text/javascript">
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).on('keydown.autocomplete', '.email', function() {
            var parent  = $(this).closest('.form-group')
            console.log(parent)
            $( this ).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('autocomplete')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            cari: request.term
                        },
                        success: function( data ) {
                            response( data );
                        }
                    });
                },
                select: (event, ui) => {
                    parent.find('#email').val(ui.item.email);
                    parent.find('#name').val(ui.item.name);
                    parent.find('#company').val(ui.item.company);
                    parent.find('#phone').val(ui.item.phone);
                    // console.log(parent)
                    return false;
                }
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            var maxField = 999; //Input fields increment limitation
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
                    Swal.fire('You have reached the maximum number of participants')
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
        // dynamic input meeting participants
        $(document).ready(function(){
            var maxField = <?= $room[0]->capacity ?>; //Input fields increment limitation
            var addButton = $('#addRow'); //Add button selector
            var wrapper = $('#field_wrapper'); //Input field wrapper
            var html = ''; //New input field html
                html +='<div class="form-group mb-0 mt-4 new-row">';
                    html +='<div class="row">';
                        html +='<div class="col-3">';
                            html +='<input type="text" name="guest_email[]" id="email" class="form-control email">';
                            html +='<input type="hidden" name="status[]" class="form-control" value="1">';
                        html +='</div>';
                        html +='<div class="col-3">';
                            html +='<input type="text" name="guest_name[]" id="name" class="form-control">';
                        html +='</div>';
                        html +='<div class="col-3">';
                            html +='<input type="text" name="guest_company[]" id="company" class="form-control">';
                        html +='</div>';
                        html +='<div class="col-2">';
                            html +='<input type="text" name="guest_phone[]" id="phone" class="form-control">';
                        html +='</div>';
                        html +='<div class="col-1">';
                            html +='<button class="btn btn-bold btn-pure btn-danger btn-block" id="removeRow"><i class="ti-minus"></i></button>';
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
                    Swal.fire('You have reached the maximum number of participants')
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '#removeRow', function(e){
                e.preventDefault();
                $(this).closest('.form-group').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });

        // table f&b
        var groupColumn = 2;
        var table = $('#groupTables').DataTable({
            "columnDefs": [
                { "visible": false, "targets": groupColumn }
            ],
            "order": [[ groupColumn, 'asc' ]],
            // "displayLength": 25,
            "searching": false,
            "paging": false,
            "info": false,
            // "sort": false,
            "ordering": false,
            "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;

                api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group"><td colspan="5">'+group+'</td></tr>'
                        );

                        last = group;
                    }
                } );
            }
        } );
    </script>
@endsection
