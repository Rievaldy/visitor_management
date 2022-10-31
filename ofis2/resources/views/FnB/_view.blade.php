@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">View Order</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header bg-danger">
                    <div class="row mb-4">
                        <div class="col-6 text-left">
                            <p class="font-size-11 text-uppercase text-bold mb-0">Room</p>
                            <h4 class="">{{ $books->room_name }}</h4>
                        </div>
                        <div class="col-6 text-right">
                            <h4 class="box-title mb-0">
                                {{ date('M d, Y', strtotime($books->meeting_date)) }}
                            </h4>
                            <h4 class="box-title mb-0">
                                {{ date('H:i', strtotime($books->h_start)) }}
                            </h4>
                        </div>
                    </div>
                    @if ( $pics != null )
                        <div class="row">
                            <div class="col-12">
                                <p class="font-size-11 text-uppercase text-bold mb-0">PIC</p>
                                <h4 class="mb-0">{{ $pics[0]->pic_name }}</h4>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="box-body p-0" style="margin-bottom: -1px">
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
                    <div class="row">
                        <div class="col-12">
                                <div class="m-4 ml-5">
                                    <h5 class="ml-15">Room Preparation</h5>
                                </div>
                            </div>
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <th class="">#</th>
                                        <th class="w-full">Task</th>
                                        <th class="">Action</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="">1</td>
                                            <td class="">Room Preparation Start</td>
                                            <td>
                                                @if ( $prepare[0]->start== 0)
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <form action="{{ url('foodandbaverages/updatePreparedStart/'.$books->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="booking_id" value={{ $books->id }}>
                                                                <button type="submit" class="btn btn-bold btn-sm btn-pure btn-block btn-info">Confirm</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @else
                                                    Prepared
                                                @endif
                                            </td>
                                        <tr>
                                        <tr>
                                            <td class="">2</td>
                                            <td class="">Room Preparation End</td>
                                            <td>
                                                @if ( $prepare[0]->end== 0)
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <form action="{{ url('foodandbaverages/updatePreparedEnd/'.$books->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="booking_id" value={{ $books->id }}>
                                                                <button type="submit" class="btn btn-bold btn-sm btn-pure btn-block btn-info">Confirm</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @else
                                                    Prepared
                                                @endif
                                            </td>
                                        <tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @if ( $fnbs != null)
                        <div class="row" >
                            <div class="col-12">
                                {{-- <div class="border-top"></div> --}}
                                <div class="m-4 ml-5">
                                    <h5 class="ml-15">Food & Baverages Order</h5>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <th>#</th>
                                            <th>Menu</th>
                                            <th>Notes</th>
                                            <th>Qty</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1
                                            @endphp
                                            @foreach ( $fnbs as $fnb )
                                                <tr>
                                                    <td class="">{{ $no++ }}</td>
                                                    <td class="">{{ $fnb->name}}</td>
                                                    <td>{{ $fnb->notes }}</td>
                                                    <td>
                                                        <span class="pull-right badge bg-dark">{{ $fnb->qty }}</span>
                                                    </td>
                                                    <td>
                                                        @if ( $fnb->status == 1 || $fnb->status == 2)
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <form action="{{ url('foodandbaverages/updateTake/'.$fnb->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <input type="hidden" name="booking_id" value={{ $books->id }}>
                                                                        <button type="submit" class="btn btn-bold btn-sm btn-pure btn-block btn-info">Confirm</button>
                                                                    </form>
                                                                </div>
                                                                <div class="col-6">
                                                                    <form action="{{ url('foodandbaverages/updateReject/'.$fnb->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                        <input type="hidden" name="booking_id" value={{ $books->id }}>
                                                                        <button class="btn btn-bold btn-sm btn-pure btn-block btn-danger">Reject</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        @elseif ( $fnb->status == 3 )
                                                            Done
                                                        @elseif ( $fnb->status == 0 )
                                                            Reject
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

