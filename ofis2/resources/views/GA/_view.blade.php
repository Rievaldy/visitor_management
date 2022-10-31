@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">View Detail Project
            @if ($project['type'] == '1')
                (Visitor Normal)
            @elseif ($project['type'] == '2')
                (Vendor/Contractor)
            @elseif ($project['type'] == '3')
                (Special Visitor)
            @endif
        </h3>
    </div>
@endsection

@section('content')
    <div class="row content-row">
        <div class="col-sm-6 d-flex align-self-stretch">
            <div class="box">
                <div class="box-body">
                    <div class="row mb-4">
                        <div class="{{ ($project['type'] != 3) ? 'col-sm-12':'col-sm-6' }}">
                        {{-- <div class="col-sm-6"> --}}
                            <div class="row">
                                <div class="col-sm-12">
                                    <h3 class="mt-0">Project Info</h3>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-4">
                                        <label class="control-label">Project Name</label>
                                        <h5 class="font-weight-400">{{$project['name']}}</h5>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-4">
                                        <label class="control-label">Date</label>
                                        <h5 class="font-weight-400">{{ date('M d, Y', strtotime($location_meet[0]['date_start'])) }} @if ($location_meet[0]['date_start'] != $location_meet[0]['date_end'])
                                            - {{ date('M d, Y', strtotime($location_meet[0]['date_end'])) }}
                                        @endif</h5>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="">
                                        <label class="control-label">Time</label>
                                        <h5 class="font-weight-400">{{date(('H:m'), strtotime($location_meet[0]['time_start']))}} - {{date(('H:m'), strtotime($location_meet[0]['time_end']))}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($project['type'] != 3)
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h3 class="mt-0">Location</h3>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mb-4">
                                            <label class="control-label">Site</label>
                                            <h5 class="font-weight-400">{{$location_meet[0]['site']['name']}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mb-4">
                                            <label class="control-label">Location</label>
                                            <h5 class="font-weight-400">{{$location_meet[0]['location']['name']}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="">
                                            <label class="control-label">Area</label>
                                            <h5 class="font-weight-400">{{$location_meet[0]['area']['name']}}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="mt-0">Employee To Meet</h3>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-striped mb-0">
                                    <thead>
                                        <tr class="">
                                            <th class="">Employee ID</th>
                                            <th class="w--50">Name</th>
                                            <th class="w--50">Email</th>
                                            <th class="">Phone</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $employee_to_meet as $employee )
                                            <tr class="">
                                                <td class="">{{ $employee['employee']['employee_id'] }}</td>
                                                <td class="">{{ $employee['employee']['name'] }}</td>
                                                <td class="">{{ $employee['employee']['email'] }}</td>
                                                <td class="">{{ $employee['employee']['phone'] }}</td>
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
        <div class="col-sm-6 d-flex align-self-stretch">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="mt-0">Visitor Info</h3>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-4">
                                        <label class="control-label">Company Name</label>
                                        <h5 class="font-weight-400">
                                            {{$project['company']['name']}}
                                            @if ($project['type'] != '3')
                                                ({{($project['type'] == '1') ? 'VS' : 'VSN' }}{{ str_pad( $project['company']['id'], 4, "0", STR_PAD_LEFT ) }})
                                            @endif
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-4">
                                        <label class="control-label">Company Address</label>
                                        <h5 class="font-weight-400">{{$project['company']['address']}}</h5>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-4">
                                        <label class="control-label">Phone</label>
                                        <h5 class="font-weight-400 mb-0">{{$project['company']['phone']}}</h5>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-4">
                                        <label class="control-label">Visitor Type</label>
                                        <h5 class="font-weight-400 mb-0">{{ $project['visitor_type']['name'] }}</h5>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-4">
                                        <label class="control-label">Supplier Type</label>
                                        <h5 class="font-weight-400 mb-0">{{ $project['supplier']['name'] }}</h5>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-0">
                                        <label class="control-label">Purpose</label>
                                        <h5 class="font-weight-400 mb-0">{{ $project['purpose']['name'] }}</h5>
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
        <div class="col-sm-12">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="mt-0">Visitor Guest</h3>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <div class="mb-0">
                                <label class="control-label">VISITOR LEADER</label>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="">
                                            <th class="">Name</th>
                                            <th class="">ID Number</th>
                                            <th class="">Email</th>
                                            <th class="">Phone</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $visitor_PIC as $visitor_PIC )
                                            <tr class="">
                                                <td class="">{{ $visitor_PIC['visitor']['name'] }}</td>
                                                <td class="">{{ $visitor_PIC['visitor']['ktp'] }}</td>
                                                <td class="">
                                                    @if($visitor_PIC['visitor']['email'] != null)
                                                        {{ $visitor_PIC['visitor']['email'] }}
                                                    @endif
                                                </td>
                                                <td class="">{{ $visitor_PIC['visitor']['number'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="mb-0">
                                <label class="control-label">MEMBER, DEVICE, & EQUPIMENT </label>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="">
                                            <th class="">Name</th>
                                            <th class="">Safety Equipment</th>
                                            <th class="">Device Category</th>
                                            <th class="">ID Number</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $visitor_device as $v )
                                            <tr class="">
                                                <td class="">{{ $v['visitor']['name'] }}</td>
                                                <td class=""></td>
                                                <td class="">
                                                    @foreach ( $v['visitor_project_device'] as $d )
                                                        {{ $d['device']['name'] }}
                                                        @if ($d['qty'] != '')
                                                            ({{ $d['qty'] }})
                                                        @endif
                                                        @if ($d['purpose'] != '')
                                                            <span class="pull-right">{{ $d['purpose']['name']}}</span><br/>
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td class="">{{ $v['visitor']['ktp'] }}</td>
                                                <td class="text-center">
                                                    @if ($v['visitor_visit'] != [])
                                                        Approved by {{$v['visitor_visit'][0]['user']['name']}}<br/>
                                                        <small><em>{{ date('M d, Y H:i:s', strtotime($v['visitor_visit'][0]['approved_at'])) }}</em></small>
                                                    @else
                                                        <a href="javascript:void(0)" data-vproject=" {{$v['id']}}" class="btn btn-sm btn-success btnApprove">Approve</a>
                                                        <a href="javascript:void(0)" class="btn btn-sm btn-danger">Decline</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
                        <a href="{{ url('/factory-director') }}" class="btn btn-bold btn-pure btn-secondary btn-block">Cancel</a>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <form action="{{ url('factory-director/approve/'.$project['id']) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-bold btn-pure btn-primary btn-block">Finish</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('script')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('.btnApprove').on('click', function(e){
            let a = ($(this).data("vproject"))
            console.log(a)
            $.ajax({
                url: "{{ route('ga.approve') }}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    idvp: a
                },
                success: function( data ) {
                    console.log(data)
                    location.reload();
                    // response( data );
                }
            })
        })
    </script>
@endsection
