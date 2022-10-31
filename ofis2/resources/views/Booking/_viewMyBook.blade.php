@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">View My Booking</h3>
    </div>
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}">
@endsection


@section('content')
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
                            <div class="col-sm-12 col-12">
                                <input type="text" class="form-control" value="{{ date('M d, Y', strtotime($books->meeting_date))}}" placeholder="" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Meeting time</label>
                        <div class="row align-items-center">
                            <div class="col-sm-5 col-5">
                                <input type="text" class="form-control" value="{{ date('H:i', strtotime($books->h_start))}}" placeholder="" readonly>
                            </div>
                            <div class="col-sm-2 col-2 text-center">
                                <p class="mb-0">Until</p>
                            </div>
                            <div class="col-sm-5 col-5">
                                <input type="text" class="form-control" value="{{ date('H:i', strtotime($books->h_end))}}" placeholder="" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Meeting Title</label>
                        <div class="row align-items-center">
                            <div class="col-sm-12 col-12">
                                <input type="text" class="form-control" value="{{ $books->desc }}" placeholder="" readonly>
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
                    @foreach ( $participants as $participant )
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <input type="text" name="guest_email" class="form-control" readonly value="{{ $participant->email }}" >
                                </div>
                                <div class="col-3">
                                    <input type="text" name="guest_name" class="form-control" readonly value="{{ $participant->name }}" >
                                </div>
                                <div class="col-3">
                                    <input type="text" name="guest_company" class="form-control" readonly value="{{ $participant->company }}" >
                                </div>
                                <div class="col-3">
                                    <input type="number" name="guset_phone" class="form-control" readonly value="{{ $participant->phone }}" >
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @if ($fnbs != null)
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
                                <div class="col-3">
                                    <label>Qty</label>
                                </div>
                                <div class="col-5">
                                    <label>Notes</label>
                                </div>
                            </div>
                        </div>
                        @foreach ( $fnbs as $fnb )
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-4">
                                        <input type="text" name="" class="form-control" readonly value="{{ $fnb->name }}" >
                                    </div>
                                    <div class="col-3">
                                        <input type="number" name="" class="form-control" readonly value="{{ $fnb->qty }}" >
                                    </div>
                                    <div class="col-5">
                                        <input type="text" name="" class="form-control" readonly value="{{ $fnb->notes }}" >
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
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
                                <p class="text-left font-size-11 text-uppercase text-bold">{{ $room[0]->room_name }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-4">
                                <img src="{{ $room[0]->img }}" alt="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <p class="text-left font-size-11 text-uppercase text-bold">Capacity</p>
                                <p class="text-left">{{ $room[0]->capacity}} Participants</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-left font-size-11 text-uppercase text-bold" style="margin-top: 1rem">Room Facility</p>
                                        {{-- <div class="form-group mb-0">
                                            <div class="row">
                                                <div class="col-8">
                                                    <label>Property Name</label>
                                                </div>
                                                <div class="col-4">
                                                    <label>Device ID</label>
                                                </div>
                                            </div>
                                        </div> --}}
                                        @foreach ( $facilities as $facility )
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <input type="text" name="guest_name" class="form-control" readonly value="{{ $facility->name }}" >
                                                    </div>
                                                    {{-- <div class="col-4">
                                                        <input type="text" name="guest_email" class="form-control" readonly value="{{ $facility->device_id }}" >
                                                    </div> --}}
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
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <a href="{{ url('/my-booking') }}" class="btn btn-bold btn-pure btn-secondary btn-block">BACK</a>
                    </div>
                </div>

                    {{-- validasi memajukan meeting --}}

                    {{-- @if ($tis == null && $date == $now && $nows <= $h_time )
                        <div class="col-3">
                            <a href="{{ url('my-booking/view-mybooking/'.$books->id) }}" type="button" class="btn btn-bold btn-pure btn-primary btn-block">Edit</a>
                        </div>
                    @endif --}}

                    @if ( $now = date('Y-m-d H:i:s') <= $books->h_start  && $books->status != 0 && $books->status != 3  )
                    @if ($books->status != 3 && $books->status < 4 && $books->status != 0)
                        <div class="col-3">
                            <div class="form-group">
                                <a href="{{ url('my-booking/edit/'.$books->id) }}" class="btn btn-bold btn-pure btn-info btn-block">Edit</a>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                {{-- <a href="{{ url('my-booking/edit/'.$books->id) }}" class="btn btn-bold btn-pure btn-danger btn-block">Cancel</a> --}}
                                {{-- <a href="" type="button" class="btn btn-primary">Edit</a> --}}
                                <form action="{{ url('my-booking/cancel/'.$books -> id) }}" method="POST" onsubmit="return confirm('Are you sure? This record and its details will be permanantly deleted!')" class="d-inline">
                                @csrf
                                    <button class="btn btn-bold btn-pure btn-danger btn-block">Cancel</button>
                                </form>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    {{-- modal start --}}

@endsection

@section('script')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>
        // dynamic input meeting participants
        $(document).ready(function(){
            var maxField = 24; //Input fields increment limitation
            var addButton = $('#addRow'); //Add button selector
            var wrapper = $('#field_wrapper'); //Input field wrapper
            var html = ''; //New input field html
                html +='<div class="form-group mb-0 mt-4 new-row">';
                    html +='<div class="row">';
                        html +='<div class="col-3">';
                            html +='<input type="text" name="guest_name" class="form-control">';
                        html +='</div>';
                        html +='<div class="col-3">';
                            html +='<input type="text" name="guest_email" class="form-control">';
                        html +='</div>';
                        html +='<div class="col-3">';
                            html +='<input type="text" name="guest_company" class="form-control">';
                        html +='</div>';
                        html +='<div class="col-2">';
                            html +='<input type="text" name="guset_phone" class="form-control">';
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
