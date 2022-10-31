@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">View</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header bg-danger">
                    <div class="row">
                        <div class="col-6 text-left">
                            <p class="font-size-11 text-uppercase text-bold mb-0">Room</p>
                            <h4 class="mb-0">{{ $books->room_name }}</h4>
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
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <th>#</th>
                                        <th class="text-left w-full">Message</th>
                                        <th class="text-center">Action</th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1
                                        @endphp
                                        @foreach ( $datas as $data )
                                            <tr>
                                                <td class="">{{ $no++ }}</td>
                                                <td class="">{{ $data->msg}}</td>
                                                <td class="text-center">
                                                    @if ( $data->status == 1 )
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <form action="{{ url('frontdesk/update/'.$data->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                                <input type="hidden" name="book_id" value={{ $data->book_id }}>
                                                                <button type="submit" class="btn btn-bold btn-sm btn-pure btn-block btn-info">Confirm</button>
                                                            </form>
                                                        </div>
                                                    @elseif ( $data->status == 2 )
                                                        Done
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
                <div class="box-footer" style="margin-bottom: -1px">
                    <div class="row">
                        <div class="col-3">
                            <a href="{{ url('frontdesk') }}" class="btn btn-bold btn-sm btn-pure btn-block btn-secondary">
                                Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
