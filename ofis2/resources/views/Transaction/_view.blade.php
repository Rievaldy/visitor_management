@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">View Booking</h3>
    </div>
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}">
@endsection


@section('content')
    <div class="col-12">
        <div class="row">
            <div class="col-8">

                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">Basic Info</h4>
                    </div>
                    <div class="box-body">
                        <div class="form-group mb-0">
                            <label>Meeting PIC</label>
                                <div class="row">
                                    <div class="col-12">
                                        <input type="text" class="form-control" value="{{ $pic[0]->pic_name }}" readonly>
                                    </div><br>
                                </div><br>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" value="{{  $pic[0]->pic_email }}" readonly>
                                    </div><br>
                                    <div class="col-6">
                                        <input type="text" class="form-control" value="{{ $pic[0]->pic_phone }}" readonly>
                                    </div><br>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-12">
                                <label>Meeting date</label>
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <input type="text" class="form-control" value="{{ date('M d, Y', strtotime($books->meeting_date)) }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-12">
                                <label>Meeting time</label>
                                <div class="row">
                                    <div class="col-5">
                                        <input type="text" class="form-control" value="{{ date('H:i', strtotime($books->h_start))}}" readonly>
                                    </div>
                                    <div class="col-2 text-center">
                                        <p class="mb-0">Until</p>
                                    </div>
                                    <div class="col-5">
                                        <input type="text" class="form-control" value="{{date('H:i', strtotime($books->h_end))}}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-12">
                                <label>Meeting Description</label>
                                <div class="row align-items-center">
                                    <div class="col-sm-12 col-12">
                                        <textarea class="form-control" rows="3" cols="3" readonly>{{ $books->desc}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="col-12">
                                <label>Meeting Participants</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-0">
                                <div class="row">
                                    <div class="col-3">
                                        <label>Name</label>
                                    </div>
                                    <div class="col-3">
                                        <label>Email address</label>
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
                                            <input type="text" name="guest_name" class="form-control" readonly value="{{ $participant->name }}" >
                                        </div>
                                        <div class="col-3">
                                            <input type="text" name="guest_email" class="form-control" readonly value="{{ $participant->email }}" >
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
                </div>
                <div class="col-4">
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
                </div>
        </div>
        {{-- <div class="col-sm-4">
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title">Room Info</h4>
                </div>
                <div class="box-body">
                    <div class="">
                        <div class="row">
                            <div class="col-12">
                                <p class="text-left font-size-11 text-uppercase text-bold">{{ $books->room_name }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-4">
                                <img src="{{ asset('img/meeting-room/meeting_room_1.jpeg') }}" alt="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <p class="text-left font-size-11 text-uppercase text-bold">Capacity</p>
                                <p class="text-left">{{ $books->room_capacity }} Participants</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left font-size-11 text-uppercase text-bold" style="margin-top: 1rem">Room Facility</p>

                                        <ol class="nav d-block nav-stacked">
                                            <li class="nav-item">
                                                <p class="text-capitalize mb-0">1. Infocus</p>
                                            </li>
                                            <li class="nav-item">
                                                <p class="text-capitalize mb-0">2. Screen</p>
                                            </li>
                                            <li class="nav-item">
                                                <p class="text-capitalize mb-0">3. Glass board</p>
                                            </li>
                                            <li class="nav-item">
                                                <p class="text-capitalize mb-0">4. Sound system</p>
                                            </li>
                                            <li class="nav-item">
                                                <p class="text-capitalize mb-0">5. Pencils and memos</p>
                                            </li>
                                            <li class="nav-item">
                                                <p class="text-capitalize mb-0">6. Internet connection</p>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <a href="{{ url('/booking-list') }}" class="btn btn-bold btn-pure btn-secondary btn-block">Cancel</a>
                        </div>
                    </div>
                    @if ( $now = date('Y-m-d H:i:s') <= $books->h_start )
                        @if ($books->status == 1)
                            <div class="col-3">
                                <div class="form-group">
                                    <form action="{{ url('send-email/approve/'.$books->id) }}" method="POST">
                                    @csrf
                                        <button type="submit" class="btn btn-bold btn-pure btn-success btn-block">Approve</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <form action="{{ url('send-email/reject/'.$books->id) }}" method="POST">
                                    @csrf
                                        <button type="submit" class="btn btn-bold btn-pure btn-danger btn-block">Reject</button>
                                    </form>
                                </div>
                            </div>
                        @elseif ($books->status == 2 || $books->status == 9)
                            {{-- reject setelah approve --}}
                            <div class="col-3">
                                <div class="form-group">
                                    <form action="{{ url('send-email/rejectapprove/'.$books->id) }}" method="POST">
                                    @csrf
                                        <button type="submit" class="btn btn-bold btn-pure btn-danger btn-block">Reject</button>
                                    </form>
                                </div>
                            </div>
                        @elseif ($books->status == 3)
                            <div class="col-3">
                                <div class="form-group">
                                    <form action="{{ url('send-email/approve/'.$books->id) }}" method="POST">
                                    @csrf
                                        <button type="submit" class="btn btn-bold btn-pure btn-success btn-block">Approve</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

    {{-- modal start --}}
    <div class="modal" data-backdrop="false" tabindex="-1" id="modalReason" style="z-index: 9999;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">The Reason For This Action</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-0">
                                <label>Explanation</label>
                                <textarea class="form-control" rows="5" cols="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-4">
                    <div class="row">
                        <div class="col-3">
                            <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" data-dismiss="modal">Cancel</button>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-bold btn-pure btn-info btn-block" data-dismiss="modal">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
