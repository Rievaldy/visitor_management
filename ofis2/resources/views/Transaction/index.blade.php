@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Booking List</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title">Booking List</h4>
                </div>
                <div class="box-header">
                    <div class="row">
                        <div class="col-9 text-left">
                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link btn-tabs-custom active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">All Booking List</a>
                                </li>
                                <li class="nav-item ml-4">
                                    <a class="nav-link btn-tabs-custom" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Need to Approve &nbsp;&nbsp
                                        @if ($approveCount[0]->count != 0)
                                            <span class="badge badge-danger ml-3">{{$approveCount[0]->count}}</span>
                                        @endif
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="box-body">
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
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="dataTables1">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-nowrap">#</th>
                                            <th class="text-left text-nowrap">Date</th>
                                            <th class="text-left text-nowrap">Time</th>
                                            <th class="text-left text-nowrap">Room</th>
                                            <th class="text-left text-nowrap">Meeting Title</th>
                                            <th class="text-left text-nowrap">PIC Name</th>
                                            <th class="text-left text-nowrap">PIC Email</th>
                                            <th class="text-center text-nowrap">Status</th>
                                            <th class="text-center text-nowrap">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ( $transactions as $trx )
                                            <tr>
                                                <td class="text-center">{{ $no++ }}</td>
                                                <td class="text-left text-nowrap">
                                                    {{ date('M d, Y', strtotime($trx->date)) }}
                                                </td>
                                                <td class="text-left text-nowrap">
                                                    {{ date('H:i', strtotime($trx->start)) }}
                                                    -
                                                    {{ date('H:i', strtotime($trx->end)) }}
                                                </td>
                                                <td class="text-left text-nowrap">{{ $trx->room }}</td>
                                                <td class="text-left text-nowrap">{{ $trx->desc }}</td>
                                                <td class="text-left text-nowrap">{{ $trx->pic_name }}</td>
                                                <td class="text-left text-nowrap">{{ $trx->pic_email }}</td>
                                                @if ($trx->status === 1)
                                                    <td class="text-center">
                                                        <span class="btn btn-block btn-rounded btn-warning">
                                                            Waiting
                                                        </span>
                                                    </td>
                                                @elseif ($trx->status === 2 || $trx->status === 9 )
                                                    <td class="text-center">
                                                        <span class="btn btn-block btn-rounded btn-success">
                                                            Approve
                                                        </span>
                                                    </td>
                                                @elseif ($trx->status === 3)
                                                    <td class="text-center">
                                                        <span class="btn btn-block btn-rounded btn-danger">
                                                            Reject
                                                        </span>
                                                    </td>
                                                @elseif ($trx->status === 4)
                                                    <td class="text-center">
                                                        <span class="btn btn-block btn-rounded btn-purple">
                                                            Meeting Start
                                                        </span>
                                                    </td>
                                                @elseif ($trx->status === 5)
                                                    <td class="text-center">
                                                        <span class="btn btn-block btn-rounded btn-info">
                                                            Done
                                                        </span>
                                                    </td>
                                                @endif
                                                <td class="text-center">
                                                    <form action="{{ url('booking-list/view/'.$trx->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn-action" data-toggle="tooltip" data-placement="bottom" title="View">
                                                            <i class="ti-eye"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="dataTables2">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-nowrap">#</th>
                                            <th class="text-left text-nowrap">Date</th>
                                            <th class="text-left text-nowrap">Time</th>
                                            <th class="text-left text-nowrap">Room</th>
                                            <th class="text-left text-nowrap">Meeting Title</th>
                                            <th class="text-left text-nowrap">PIC Name</th>
                                            <th class="text-left text-nowrap">PIC Email</th>
                                            <th class="text-center text-nowrap">Status</th>
                                            <th class="text-center text-nowrap">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ( $approve as $app )
                                            <tr>
                                                <td class="text-center">{{ $no++ }}</td>
                                                <td class="text-left text-nowrap">
                                                    {{ date('M d, Y', strtotime($app->date)) }}
                                                </td>
                                                <td class="text-left text-nowrap">
                                                    {{ date('H:i', strtotime($app->start)) }}
                                                    -
                                                    {{ date('H:i', strtotime($app->end)) }}
                                                </td>
                                                <td class="text-left text-nowrap">{{ $app->room }}</td>
                                                <td class="text-left text-nowrap">{{ $app->desc }}</td>
                                                <td class="text-left text-nowrap">{{ $app->pic_name }}</td>
                                                <td class="text-left text-nowrap">{{ $app->pic_email }}</td>
                                                @if ($app->status === 1)
                                                    <td class="text-center">
                                                        <span class="btn btn-block btn-rounded btn-warning">
                                                            Waiting
                                                        </span>
                                                    </td>
                                                @elseif ($app->status === 2 || $app->status === 9 )
                                                    <td class="text-center">
                                                        <span class="btn btn-block btn-rounded btn-success">
                                                            Approve
                                                        </span>
                                                    </td>
                                                @elseif ($app->status === 3)
                                                    <td class="text-center">
                                                        <span class="btn btn-block btn-rounded btn-danger">
                                                            Reject
                                                        </span>
                                                    </td>
                                                @elseif ($app->status === 4)
                                                    <td class="text-center">
                                                        <span class="btn btn-block btn-rounded btn-purple">
                                                            Meeting Start
                                                        </span>
                                                    </td>
                                                @elseif ($app->status === 5)
                                                    <td class="text-center">
                                                        <span class="btn btn-block btn-rounded btn-info">
                                                            Done
                                                        </span>
                                                    </td>
                                                @endif
                                                <td class="text-center">
                                                    <form action="{{ url('booking-list/view/'.$app->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn-action" data-toggle="tooltip" data-placement="bottom" title="View">
                                                            <i class="ti-eye"></i>
                                                        </button>
                                                    </form>
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
@endsection

@section('script')
    <script>
        $('#dataTables1').DataTable( {
            // "columnDefs" : [{"targets":1, "type":"eu"}],
            // "order": [[ 3, "desc" ]]
        } );
        $('#dataTables2').DataTable( {
            // "columnDefs" : [{"targets":1, "type":"eu"}],
            // "order": [[ 3, "desc" ]]
        } );
    </script>
@endsection
