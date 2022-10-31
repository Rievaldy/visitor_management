@extends('master')

@section('head')
    <link href='{{ asset('vendor/fullcalendar-3.10.2/fullcalendar.min.css') }}' rel='stylesheet' />
    <link href='{{ asset('vendor/bootstrap-datepicker/css/scheduler.min.css') }}' rel='stylesheet' />
    <link href='{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}' rel='stylesheet' />


@endsection

@section('content')
    <div class="modal" data-backdrop="false" tabindex="-1" id="exampleModal" style="z-index: 9999; background: #fff;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="box-shadow: none">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header">
                                    <h4 class="box-title">Change Password</h4>
                                </div>
                                <form action="{{ url('user/change-password/'.$user->id) }}" method="POST">
                                {{-- <form action="{{ route('addBookNow') }}" method="POST"> --}}
                                @csrf
                                    <div class="box-body">
                                        {{-- <div class="form-group">
                                            <label>Maximum Capacity</label>
                                            <div class="row align-items-center">
                                                <div class="col-sm-12 col-12">
                                                    <input name="" type="text" class="form-control" value="" placeholder="" readonly>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="form-group">
                                            <label>Old Password</label>
                                            <div class="row align-items-center">
                                                <div class="col-sm-12 col-12">
                                                    <input name="current_password" type="text" class="form-control" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>New Password</label>
                                            <div class="row align-items-center">
                                                <div class="col-sm-12 col-12">
                                                    <input name="new_password" type="text" class="form-control" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Retype new password</label>
                                            <div class="row align-items-center">
                                                <div class="col-sm-12 col-12">
                                                    <input name="confirm_new_password" class="form-control" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <div class="row">
                                            <div class="col-3">
                                                <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" data-dismiss="modal">Close</button>
                                            </div>
                                            <div class="col-3">
                                                <button type="submit" class="btn btn-bold btn-pure btn-info float-right btn-block">Next</button>
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

    {{-- modal here --}}
    <div class="modal" data-backdrop="false" tabindex="-1" id="modal-detail" style="z-index: 9999; background: #fff;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="box-shadow: none">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header">
                                    <h4 class="box-title">Review New Meeting</h4>
                                </div>
                                <form action="{{ route('addBook') }}" method="POST">
                                @csrf
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>Meeting Room Name</label>
                                            <div class="row align-items-center">
                                                <div class="col-sm-12 col-12">
                                                    <input name="room_id" type="hidden" class="form-control" value="" placeholder="" readonly>
                                                    <input name="room_name" type="text" class="form-control" value="" placeholder="" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Maximum Capacity</label>
                                            <div class="row align-items-center">
                                                <div class="col-sm-12 col-12">
                                                    <input name="room_capacity" type="text" class="form-control" value="" placeholder="" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Meeting date</label>
                                            <div class="row align-items-center">
                                                <div class="col-sm-12 col-12">
                                                    <input name="meeting_date" type="hidden" class="form-control" value="" placeholder="" readonly>
                                                    <input name="meeting_date_dom" type="text" class="form-control" value="" placeholder="" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Meeting time</label>
                                            <div class="row align-items-center">
                                                <div class="col-sm-5 col-5">
                                                    <input name="h_start_dom" type="text" class="form-control" value="" placeholder="">
                                                    <small>Minimum start time is 5 minutes from now</small>
                                                </div>
                                                <div class="col-sm-2 col-2 text-center">
                                                    <p class="mb-0">Until</p>
                                                    <small>&nbsp;</small>
                                                </div>
                                                <div class="col-sm-5 col-5">
                                                    <input name="h_end_dom" type="text" class="form-control" value="" placeholder="">
                                                    <small>&nbsp;</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <div class="row">
                                            <div class="col-3">
                                                <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" data-dismiss="modal">Close</button>
                                            </div>
                                            <div class="col-3">
                                                <button type="submit" class="btn btn-bold btn-pure btn-info float-right btn-block">Next</button>
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
    {{-- MODAL CANNOT SELECT --}}
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
    <script src='https://cdn.jsdelivr.net/npm/moment@2.24.0/min/moment.min.js'></script>
    <script src='{{ asset('vendor/fullcalendar-3.10.2/fullcalendar.min.js') }}'></script>
    {{-- <script src='{{ asset('vendor/fullcalendar-3.10.2/scheduler.min.js') }}'></script> --}}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@1.10.1/dist/scheduler.min.js'></script>
    <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#exampleModal').show();
        });
        function closeModal(){
            $('#exampleModal').hide();
        }
        
        function  _getEventList(date) {
            return $.ajax({
                type: 'GET',
                url: "<?= url('eventlist-api') ?>",
                async: !1,
                data: { date: date }
            });
        }

        function  _getResourceList(date) {
            return $.ajax({
                type: 'GET',
                url: "<?= url('resourcelist-api') ?>",
                async: !1,
                data: { date: date }
            });
        }

        window.addEventListener('load',
        function() {
            // var xxx = $("#datepickerModal").val()
            $.ajax({
                url:"{{route('listAvailRoom')}}",
                type: 'get',
                dataType: "json",
                data: {
                    date: $("#datepickerModal").val()
                },
                success: function(datas) {
                    $("#selectRoom").empty();
                    // console.log(datas);
                    var data = datas
                    $("#selectRoom").select2({data: data})
                }
            });

        }, false);
        document.addEventListener('DOMContentLoaded', async function() {
            $('#calendar').fullCalendar({
                defaultView: 'agendaDay',
                validRange: function(nowDate) {
                    return {
                        start: nowDate.clone().subtract(1, 'months'),
                        end: nowDate.clone().add(1, 'months')
                    };
                },
                nowIndicator: true,
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
                    // var check = $.fullCalendar.formatDate(startDate,'yyyy-MM-dd');
                    // var today = $.fullCalendar.formatDate(new Date(),'yyyy-MM-dd');
                    // console.log(moment(start))
                    // console.log('select: '+check)
                    if ( moment(start).isBefore(today) ) {
                        $('#calendar').fullCalendar('unselect');
                        $('#cantSelect').modal('show');
                        setTimeout(function(){
                            $("#cantSelect").modal('hide');
                        }, 3000);
                    }else {
                        // console.log('Date: '+ startDate.format('YYYY/MM/DD') +', Start: '+ startDate.format('HH:MM') + ' - ' + endDate.format('HH:MM') + ', room id: ' + resource.id + ', room name: ' + resource.title);
                        $('#modal-detail').modal('show');
                        $('#modal-detail').find('input[name=room_id]').val(resource.id)
                        $('#modal-detail').find('input[name=room_name]').val(resource.room_name)
                        $('#modal-detail').find('input[name=room_capacity]').val(resource.capacity)
                        $('#modal-detail').find('input[name=meeting_date]').val(startDate.format('YYYY/MM/DD'))
                        $('#modal-detail').find('input[name=meeting_date_dom]').val(startDate.format('MMM DD, YYYY'))
                        // $('#modal-detail').find('input[name=h_start]').val(startDate.format('YYYY/MM/DD HH:mm'))
                        $('#modal-detail').find('input[name=h_start_dom]').val(startDate.format('HH:mm'))
                        // $('#modal-detail').find('input[name=h_end]').val(endDate.format('YYYY/MM/DD HH:mm'))
                        $('#modal-detail').find('input[name=h_end_dom]').val(endDate.format('HH:mm'))
                    }
                },
                events: [],
                // viewRender: function(view, element) {
                //     $('.fc-prev-button').click(function(){
                //         var date1 = $('#calendar').fullCalendar( 'getDate' );
                //         var dayFormat = date1.format('dddd');
                //         var dateFormat = date1.format('YYYY-MM-DD');
                //         _getResourceList(dayFormat).then((res) => {
                //             $.each(res,(key,val) => {
                //                 $('#calendar').fullCalendar('addResource', val);
                //             })
                //         });
                //         _getEventList(dateFormat).then((res) => {
                //             $('#calendar').fullCalendar('removeEvents');
                //             $('#calendar').fullCalendar('addEventSource', res);
                //             $('#calendar').fullCalendar('rerenderEvents');
                //         });
                //         return false;
                //     });

                //     $('.fc-next-button').click(function(){
                //         var date1 = $('#calendar').fullCalendar( 'getDate' );
                //         var dayFormat = date1.format('dddd');
                //         var dateFormat = date1.format('YYYY-MM-DD')
                //         _getResourceList(dayFormat).then((res) => {
                //             $.each(res,(key,val) => {
                //                 $('#calendar').fullCalendar('addResource', val);
                //             })
                //         });
                //         _getEventList(dateFormat).then((res) => {
                //             $('#calendar').fullCalendar('removeEvents');
                //             $('#calendar').fullCalendar('addEventSource', res);
                //             $('#calendar').fullCalendar('rerenderEvents' );
                //         });
                //         return false;
                //     });
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
                var date1 = $('#calendar').fullCalendar( 'getDate' );
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

            var todayResource = await _getResourceList("<?=date('l')?>").then((res) => {
                $.each(res,(key,val) => {
                    $('#calendar').fullCalendar('addResource', val);
                })
            });

            var todayEvent = await _getEventList("<?=date('Y-m-d')?>").then((res) => {
                $('#calendar').fullCalendar('addEventSource', res);
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

        $(".alert").fadeTo(10000, 500).slideUp(500, function(){
            $(".alert").slideUp(500);
        });

        var now = new Date();
            var dd = String(now.getDate()).padStart(2, '0');
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
            var mm = month[now.getMonth()];
            var yyyy = now.getFullYear();

            now = mm + '/' + dd + '/' + yyyy;
        $('#datepickerModal').datepicker({
            format: "mm/dd/yyyy",
            dateFormat: "mm/dd/yyyy",
            todayHighlight: true,
            inline: true,
            autoclose: true,
            startDate: new Date(), // controll start date like startDate: '-2m' m: means Month
            endDate: '+30d'
        }).change(function (l) {
            $.ajax({
                url:"{{route('listAvailRoom')}}",
                type: 'get',
                dataType: "json",
                data: {
                    date: $("#datepickerModal").val(),
                },
                success: function(datas) {
                    // console.log(datas);
                    $("#selectRoom").empty();
                    var data = datas
                    $("#selectRoom").select2({data: data})
                }
            });
        });
        $('#datepickerModal').val(now);

        function AddMinutesToDate(date, minutes) {
            return new Date(date.getTime() + minutes*60000);
        }
        function DateFormat(date){
            var days = date.getDate();
            var year = date.getFullYear();
            var month = (date.getMonth()+1);
            var hours = date.getHours();
            var minutes = date.getMinutes();
            minutes = minutes < 10 ? '0' + minutes : minutes;
            var strTime = hours + ':' + minutes;
            return strTime;
        }
        var now = new Date();
        var next = AddMinutesToDate(now,5);
        $("#currentTime").val(DateFormat(next));
        // console.log(DateFormat(next))
    </script>
@endsection
