@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Smart Locker</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            {{-- <h4 class="box-title">Attendance ({{$monthName}}, {{$year}})</h4> --}}
                            <h4 class="box-title">Smart Locker List</h4>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    {{-- <div class="box-header"> --}}
                        {{-- <div class="row">
                            <div class="col-sm-12 text-left">
                                <form action="" method="GET" class="form-inline">
                                    <div class="form-group">
                                        <input type="date" class="form-control form-control-sm" name="start_date" max="<?= date('Y-m-d'); ?>" value="{{ $sDate }}">
                                    </div>
                                    <div class="form-group">
                                        To
                                    </div>
                                    <div class="form-group">
                                        <input type="date" class="form-control form-control-sm" max="<?= date('Y-m-d'); ?>" name="end_date" value="{{ $eDate }}">
                                    </div>
                                    <button type="submit" class="btn btn-bold btn-pure btn-info">Filter</button>
                                </form>
                            </div>
                        </div><br> --}}
                    
                    <div class="table-responsive">
                        <table class="table dataTables">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">#</th>
                                    <th class="text-nowrap">Date</th>
                                    <th class="text-nowrap">Time</th>
                                    <th class="text-nowrap">Employee ID</th>
                                    <th class="text-nowrap">Employee Name</th>
                                    <th class="text-nowrap">ID Locker</th>
                                    <th class="text-nowrap">PIC</th>
                                    <th class="text-nowrap">Necessity</th>
                                    <th class="text-nowrap">Description</th>
                                    <th class="text-nowrap">Notes</th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="text-nowrap text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ( $data as $now )
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>
                                            {{ $now->date }}
                                        </td>
                                        <td>{{ date('H:i:s', strtotime($now->created_at)) }}</td>
                                        <td>{{ $now->employee_id }}</td>
                                        <td>{{ $now->name }}</td>
                                        <td>
                                            {{ $now->id_locker }}
                                        </td>
                                        @foreach ($pic as $name )
                                            @if ($now->pic_id == $name->id)
                                                <td>{{ $name->name }}</td>    
                                            @endif
                                        @endforeach
                                        {{-- {{ dd($pic) }} --}}
                                        <td>
                                            @if ($now->necessity != null)
                                                @if ($now->necessity == 1)
                                                    Document
                                                @elseif ($now->necessity == 2)
                                                    Stationary
                                                @elseif ($now->necessity == 3)
                                                    Apparel
                                                @elseif ($now->necessity == 4)
                                                    Others
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($now->description != null)
                                                {{ $now->description }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $now->notes }}</td>
                                                @if ($now->status === 1)
                                                    <td class="text-center text-success">
                                                        <span class="btn btn-block btn-rounded btn-warning">
                                                            Waiting
                                                        </span>
                                                    </td>
                                                @elseif ($now->status === 2)
                                                    <td class="text-center text-success">
                                                        <span class="btn btn-block btn-rounded btn-danger">
                                                            Reject
                                                        </span>
                                                    </td>
                                                @elseif ($now->status === 3)
                                                    <td class="text-center text-success">
                                                        <span class="btn btn-block btn-rounded btn-info">
                                                            Approve
                                                        </span>
                                                    </td>
                                                @endif
                                        <td class="text-nowrap text-center">
                                            <a href="{{ url('locker-list/view/'.$now->id,) }}" class="btn-action" data-toggle="tooltip" data-placement="bottom" title="View">
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
@endsection

