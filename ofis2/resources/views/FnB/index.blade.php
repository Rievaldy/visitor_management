@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">F&B Dashboard</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        {{-- <div class="col-sm-3">
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title">Today, 2 Mei 2021</h4>
                </div>
                <div class="box-body pt-0 pb-0" style="margin-bottom: -1px">
                    <div class="row">
                        <div class="col-12">
                            <p class="text-left font-size-11 text-uppercase text-bold" style="margin-top: 1rem">Snack</p>
                        </div>
                        <div class="col-12">
                            <ul class="nav d-block nav-stacked border-bottom border-top" style="padding-top: 1rem">
                                <li class="nav-item">
                                    <p class="text-capitalize">French fries<span class="pull-right badge bg-warning">3</span></p>
                                </li>
                                <li class="nav-item">
                                    <p class="text-capitalize">Cheese toast<span class="pull-right badge bg-warning">2</span></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-12">
                            <p class="text-left font-size-11 text-uppercase text-bold" style="margin-top: 1rem">Hot drink</p>
                        </div>
                        <div class="col-12">
                            <ul class="nav d-block nav-stacked border-bottom border-top" style="padding-top: 1rem">
                                <li class="nav-item">
                                    <p class="text-capitalize">Hot water<span class="pull-right badge bg-warning">1</span></p>
                                </li>
                                <li class="nav-item">
                                    <p class="text-capitalize">Hot cappucino<span class="pull-right badge bg-warning">1</span></p>
                                </li>
                                <li class="nav-item">
                                    <p class="text-capitalize">Black Coffee<span class="pull-right badge bg-warning">3</span></p>
                                </li>
                                <li class="nav-item">
                                    <p class="text-capitalize">Hot Tea<span class="pull-right badge bg-warning">2</span></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-12">
                            <p class="text-left font-size-11 text-uppercase text-bold" style="margin-top: 1rem">Cold drink</p>
                        </div>
                        <div class="col-12">
                            <ul class="nav d-block nav-stacked border-bottom border-top" style="padding-top: 1rem">
                                <li class="nav-item">
                                    <p class="text-capitalize">Ice Chocolate<span class="pull-right badge bg-warning">3</span></p>
                                </li>
                                <li class="nav-item">
                                    <p class="text-capitalize">Thai tea<span class="pull-right badge bg-warning">2</span></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        {{-- <div class="col-sm-9"> --}}
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <ul class="nav nav-pills ml-4" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Today</a>
                            </li>
                            <li class="nav-item ml-4">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">All</a>
                            </li>
                        </ul>
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
                                <table class="table dataTables">
                                    <thead>
                                        <th>#</th>
                                        <th class="text-left text-nowrap">Meeting Room</th>
                                        <th class="text-left text-nowrap">Meeting Date</th>
                                        <th class="text-left text-nowrap">Meeting Time</th>
                                        <th class="text-left text-nowrap">PIC</th>
                                        <th class="text-center text-nowrap">Status</th>
                                        <th class="text-center text-nowrap">Action</th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ( $todayDatas as $today )
                                            <tr>
                                                <td>{{ $no++}}</td>
                                                <td class="text-left text-nowrap">
                                                    {{ $today->room_name }}
                                                </td>
                                                <td class="text-left text-nowrap">
                                                    {{ date('M d, Y', strtotime($today->date)) }}
                                                </td>
                                                <td class="text-left text-nowrap">
                                                    {{ date('H:i', strtotime($today->start)) }} - {{ date('H:i', strtotime($today->end)) }}
                                                </td>
                                                <td class="text-left text-nowrap">
                                                    {{ $today->pic_name }}
                                                </td>
                                                @if ( $today->food_done == 0 || $today->is_prepare_start == 0 || $today->is_prepare_end == 0 )
                                                    <td class="text-center text-success">
                                                        <span class="btn btn-block btn-rounded btn-warning">
                                                            Open
                                                        </span>
                                                    </td>
                                                @else
                                                    <td class="text-center text-success">
                                                        <span class="btn btn-block btn-rounded btn-success">
                                                            Done
                                                        </span>
                                                    </td>
                                                @endif
                                                <td class="text-center text-nowrap">
                                                    <a href="{{ url('foodandbaverages/view/'.$today->book_id) }}" class="btn-action" data-toggle="tooltip" data-placement="bottom" title="View">
                                                        <i class="ti-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="table-responsive">
                                <table class="table dataTables">
                                    <thead>
                                        <th>#</th>
                                        <th class="text-left text-nowrap">Meeting Room</th>
                                        <th class="text-left text-nowrap">Meeting Date</th>
                                        <th class="text-left text-nowrap">Meeting Time</th>
                                        <th class="text-left text-nowrap">PIC</th>
                                        <th class="text-center text-nowrap">Status</th>
                                        <th class="text-center text-nowrap">Action</th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ( $datas as $data )
                                            <tr>
                                                <td>{{ $no++}}</td>
                                                <td class="text-left text-nowrap">
                                                    {{ $data->room_name }}
                                                </td>
                                                <td class="text-left text-nowrap">
                                                    {{ date('M d, Y', strtotime($data->date)) }}
                                                </td>
                                                <td class="text-left text-nowrap">
                                                    {{ date('H:i', strtotime($data->start)) }} - {{ date('H:i', strtotime($data->end)) }}
                                                </td>
                                                <td class="text-left text-nowrap">
                                                    {{ $data->pic_name }}
                                                </td>
                                                @if ( $data->food_done == 0 || $data->is_prepare_start == 0 || $data->is_prepare_end == 0 )
                                                    <td class="text-center text-success">
                                                        <span class="btn btn-block btn-rounded btn-warning">
                                                            Open
                                                        </span>
                                                    </td>
                                                @else
                                                    <td class="text-center text-success">
                                                        <span class="btn btn-block btn-rounded btn-success">
                                                            Done
                                                        </span>
                                                    </td>
                                                @endif
                                                <td class="text-center text-nowrap">
                                                    <a href="{{ url('foodandbaverages/view/'.$data->book_id) }}" class="btn-action" data-toggle="tooltip" data-placement="bottom" title="View">
                                                        <i class="ti-eye"></i>
                                                    </a>
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

