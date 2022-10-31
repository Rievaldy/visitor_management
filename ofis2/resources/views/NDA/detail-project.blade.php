@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">View Detail Project</h3>
    </div>
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}">
@endsection


@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title">Basic Info</h4>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label>Project Name</label>
                        <div class="row align-items-center">
                            <div class="col-sm-12 col-12">
                                <input type="text" class="form-control" value="{{$project['name']}}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label>Location Meet</label>
                    </div>
                    <div class="form-group mb-0">
                        <div class="row">
                            <div class="col-4">
                                <label>Site</label>
                            </div>
                            <div class="col-4">
                                <label>Location</label>
                            </div>
                            <div class="col-4">
                                <label>Area</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <input type="text" name="guest_name" class="form-control" readonly value="{{ $location_meet[0]['site']['name'] }}" >
                            </div>
                            <div class="col-4">
                                <input type="text" name="guest_email" class="form-control" readonly value="{{ $location_meet[0]['location']['name'] }}" >
                            </div>
                            <div class="col-4">
                                <input type="text" name="guest_company" class="form-control" readonly value="{{ $location_meet[0]['area']['name'] }}" >
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Meet Date</label>
                        <div class="row align-items-center">
                            <div class="col-sm-5 col-5">
                                <input type="text" class="form-control" value="{{$location_meet[0]['date_start']}}" readonly>
                            </div>
                            <div class="col-sm-2 col-2 text-center">
                                <p class="mb-0">Until</p>
                            </div>
                            <div class="col-sm-5 col-5">
                                <input type="text" class="form-control" value="{{$location_meet[0]['date_start']}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Meet Time</label>
                        <div class="row align-items-center">
                            <div class="col-sm-5 col-5">
                                <input type="text" class="form-control" value="{{date(('H:m'), strtotime($location_meet[0]['time_start']))}}" readonly>
                            </div>
                            <div class="col-sm-2 col-2 text-center">
                                <p class="mb-0">Until</p>
                            </div>
                            <div class="col-sm-5 col-5">
                                <input type="text" class="form-control" value="{{date(('H:m'), strtotime($location_meet[0]['time_end']))}}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label>Employee To Meet</label>
                    </div>
                    <div class="form-group mb-0">
                        <div class="row">
                            <div class="col-3">
                                <label>Employee ID</label>
                            </div>
                            <div class="col-3">
                                <label>Name</label>
                            </div>
                            <div class="col-3">
                                <label>Email</label>
                            </div>
                            <div class="col-3">
                                <label>Phone</label>
                            </div>
                        </div>
                    </div>
                    @foreach ( $employee_to_meet as $employee )
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <input type="text" name="guest_name" class="form-control" readonly value="{{ $employee['employee']['employee_id'] }}" >
                                </div>
                                <div class="col-3">
                                    <input type="text" name="guest_email" class="form-control" readonly value="{{ $employee['employee']['name'] }}" >
                                </div>
                                <div class="col-3">
                                    <input type="text" name="guest_company" class="form-control" readonly value="{{ $employee['employee']['email'] }}" >
                                </div>
                                <div class="col-3">
                                    <input type="number" name="guset_phone" class="form-control" readonly value="{{ $employee['employee']['phone'] }}" >
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-12 text-left">
                            <h4 class="box-title">Visitor Data</h4>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group mb-0">
                        <label>Visitor Category</label>
                    </div>
                    <div class="form-group mb-0">
                        <div class="row">
                            <div class="col-4">
                                <label>Visitor Type</label>
                            </div>
                            <div class="col-4">
                                <label>Supplier Type</label>
                            </div>
                            <div class="col-4">
                                <label>Purpose</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <input type="text" name="guest_name" class="form-control" readonly value="{{ $project['visitor_type']['name'] }}" >
                            </div>
                            <div class="col-4">
                                <input type="text" name="guest_email" class="form-control" readonly value="{{ $project['supplier']['name'] }}" >
                            </div>
                            <div class="col-4">
                                <input type="text" name="guest_company" class="form-control" readonly value="{{ $project['purpose']['name'] }}" >
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label>Visitor Leader</label>
                    </div>
                    <div class="form-group mb-0">
                        <div class="row">
                            <div class="col-4">
                                <label>ID Number</label>
                            </div>
                            <div class="col-4">
                                <label>Name</label>
                            </div>
                            <div class="col-4">
                                <label>Email</label>
                            </div>
                        </div>
                    </div>
                    @foreach ( $visitor_PIC as $visitor_PIC )
                        <div class="form-group">
                            <div class="row">
                                <div class="col-4">
                                    <input type="text" name="guest_name" class="form-control" readonly value="{{ $visitor_PIC['visitor']['ktp'] }}" >
                                </div>
                                <div class="col-4">
                                    <input type="text" name="guest_email" class="form-control" readonly value="{{ $visitor_PIC['visitor']['name'] }}" >
                                </div>
                                @if($visitor_PIC['visitor']['email'] != null)
                                    <div class="col-4">
                                        <input type="text" name="guest_company" class="form-control" readonly value="{{ $visitor_PIC['visitor']['email'] }}" >
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <div class="form-group mb-0">
                        <label>Visitor Member</label>
                    </div>
                    <div class="form-group mb-0">
                        <div class="row">
                            <div class="col-6">
                                <label>ID Number</label>
                            </div>
                            <div class="col-6">
                                <label>Name</label>
                            </div>
                        </div>
                    </div>
                    @foreach ( $visitor_member as $visitor_member )
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" name="guest_name" class="form-control" readonly value="{{ $visitor_member['visitor']['ktp'] }}" >
                                </div>
                                <div class="col-6">
                                    <input type="text" name="guest_email" class="form-control" readonly value="{{ $visitor_member['visitor']['name'] }}" >
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="form-group mb-0">
                        <label>Visitor Device</label>
                    </div>
                    <div class="form-group mb-0">
                        <div class="row">
                            <div class="col-3">
                                <label>Device Category</label>
                            </div>
                            <div class="col-3">
                                <label>Purpose</label>
                            </div>
                            <div class="col-3">
                                <label>Quantity</label>
                            </div>
                            <div class="col-3">
                                <label>Owner</label>
                            </div>
                        </div>
                    </div>
                    @foreach ( $project['visitor_project'] as $visitor )
                        @foreach($visitor['visitor_project_device'] as $visitor_device)
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-3">
                                        <input type="text" name="guest_name" class="form-control" readonly value="{{ $visitor_device['device']['name'] }}" >
                                    </div>
                                    <div class="col-3">
                                        <input type="text" name="guest_email" class="form-control" readonly value="{{ $visitor_device['purpose']['name'] }}" >
                                    </div>
                                    <div class="col-3">
                                        <input type="text" name="guest_email" class="form-control" readonly value="{{ $visitor_device['qty'] }}" >
                                    </div>
                                    <div class="col-3">
                                        <input type="text" name="guest_email" class="form-control" readonly value="{{ $visitor['visitor']['name'] }}" >
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach

                    <div class="form-group mb-0">
                        <label>Restricted Area</label>
                    </div>
                    <div class="form-group mb-0">
                        <div class="row">
                            <div class="col-3">
                                <label>Site</label>
                            </div>
                            <div class="col-3">
                                <label>Location</label>
                            </div>
                            <div class="col-3">
                                <label>Area</label>
                            </div>
                            <div class="col-3">
                                <label>Purpose</label>
                            </div>
                        </div>
                    </div>
                    @foreach ( $location_restricted as $location )
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <input type="text" name="guest_name" class="form-control" readonly value="{{ $location['site']['name'] }}" >
                                </div>
                                <div class="col-3">
                                    <input type="text" name="guest_email" class="form-control" readonly value="{{ $location['location']['name'] }}" >
                                </div>
                                <div class="col-3">
                                    <input type="text" name="guest_company" class="form-control" readonly value="{{ $location['area']['name'] }}" >
                                </div>
                                <div class="col-3">
                                    <input type="text" name="guset_phone" class="form-control" readonly value="{{ $location['purpose']['name'] }}" >
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="form-group mb-0">
                        <label>Strictly Area</label>
                    </div>
                    <div class="form-group mb-0">
                        <div class="row">
                            <div class="col-3">
                                <label>Site</label>
                            </div>
                            <div class="col-3">
                                <label>Location</label>
                            </div>
                            <div class="col-3">
                                <label>Area</label>
                            </div>
                            <div class="col-3">
                                <label>Purpose</label>
                            </div>
                        </div>
                    </div>
                    @foreach ( $location_strictly as $location )
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <input type="text" name="guest_name" class="form-control" readonly value="{{ $location['site']['name'] }}" >
                                </div>
                                <div class="col-3">
                                    <input type="text" name="guest_email" class="form-control" readonly value="{{ $location['location']['name'] }}" >
                                </div>
                                <div class="col-3">
                                    <input type="text" name="guest_company" class="form-control" readonly value="{{ $location['area']['name'] }}" >
                                </div>
                                <div class="col-3">
                                    <input type="text" name="guset_phone" class="form-control" readonly value="{{ $location['purpose']['name'] }}" >
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <a href="{{ url('/nda') }}" class="btn btn-bold btn-pure btn-secondary btn-block">Cancel</a>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <form action="{{ url('purchasing/finish/'.$project['id']) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-bold btn-pure btn-primary btn-block">Finish</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>

    </script>
@endsection
