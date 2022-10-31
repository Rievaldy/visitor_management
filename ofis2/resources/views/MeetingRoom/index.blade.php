@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Meeting Room</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="flexbox flex-justified text-center mb-30 bg-primary">
                <div class="no-shrink py-30">
                    <span class="ti-blackboard font-size-50"></span>
                </div>
                <div class="py-30 bg-white text-dark">
                    <div class="font-size-30">
                        <?php
                            $count = DB::table('rooms')->count();
                            echo $count;
                        ?>
                    </div>
                    <span>Total Room</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="flexbox flex-justified text-center mb-30 bg-danger">
                <div class="no-shrink py-30">
                    <span class="ti-link font-size-50"></span>
                </div>
                <div class="py-30 bg-white text-dark">
                    <div class="font-size-30">
                        <?php
                            $total = DB::table('rooms')->where('status', 1)->count();
                            echo $total.'/';
                        ?>
                        <span class="font-size-18">
                            <?php
                                $count = DB::table('rooms')->count();
                                echo $count;
                            ?>
                        </span>
                    </div>
                    <span>Active Room</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">Meeting Room List</h4>
                        </div>
                        {{-- Button add room meeting --}}
                        @if (Auth::user()->user_type == 99)
                            <div class="col-6 text-right">
                                <a href="{{ route('roomsAdd') }}" class="btn btn-bold btn-pure btn-info">Add New Meeting Room</a>
                            </div>
                        @else

                        @endif
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
                    <div class="table-responsive">
                        <table class="table table-striped dataTables">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-left">Name</th>
                                    <th class="text-center text-nowrap">Capacity</th>
                                    <th class="text-left text-nowrap">Hours Availability</th>
                                    <th class="text-left text-nowrap">Days Availability </th>
                                    <th class="text-center">Last Update</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1
                                @endphp
                                @foreach ( $rooms as $room )
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td class="text-left text-nowrap">{{ $room->name }}</td>
                                        <td class="text-right">{{ $room->capacity }}</td>
                                        <td class="text-left">
                                            @if ($room->h_avail == 1)
                                                Full Days
                                            @elseif ($room->h_avail == 2)
                                                {{date('H:i', strtotime($room->h_start))}} - {{ date('H:i', strtotime($room->h_end))}}
                                            @endif
                                        </td>
                                        <td class="text-left">
                                            @if ($room->day_avail === 1)
                                                Alldays
                                            @elseif ($room->day_avail === 2)
                                                Weekdays
                                            @elseif ($room->day_avail === 3)
                                                <?php
                                                    $days = DB::table('room_days')->where('room_days.room_id', $room->id)->pluck('day_name');
                                                    foreach ($days as $day_name => $day) {
                                                        echo $day,', ';
                                                    }
                                                ?>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">
                                            {{ date('M d Y, H:i', strtotime($room->updated_at)) }}
                                        </td>
                                        <td class="text-center text-success">
                                            <span class="btn btn-block btn-rounded {{$room->status == 1 ? 'btn-success' : 'btn-danger' }}">
                                                {{$room->status == 1 ? 'Active' : 'Inctive' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ url('rooms/edit/'.$room -> id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="ml-3 btn-action" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                                    <i class="ti-pencil"></i>
                                                </button>
                                            </form>
                                            <form action="{{ url('rooms/'.$room -> id) }}" method="POST" onsubmit="return confirm('Are you sure? This record and its details will be permanantly deleted!')" class="d-inline">
                                            @method('DELETE')
                                            @csrf
                                                <button class="ml-3 btn-action" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                                    <i class="ti-trash"></i>
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

    {{-- modal here --}}
    {{-- <div class="modal modal-fill fade" data-backdrop="false" id="modal-detail" tabindex="-1" style="z-index: 9999">
        <div class="modal-dialog modal-lg"">
            <div class="modal-content" style="max-width: 1024px">
                <div class="modal-header">
                    <button type="button" class="close" style="padding-right: 28px" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="box">
                                <div class="box-header">
                                    <h4 class="box-title">Basic Info</h4>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Meeting Room Name</label>
                                        <input name="name" type="text" class="form-control" value="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Capacity</label>
                                        <input name="capacity" type="number" class="form-control" value="12" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Room Location</label>
                                        <textarea rows="4" cols="4" class="form-control" readonly>Jl. Letjen M.T. Haryono No.kav 20, RT.4/RW.1, Cawang, Kec. Kramat jati, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13630.</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Hours Availability</label>
                                        <input type="text" class="form-control" value="Full Days" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Days Availability</label>
                                        <input type="text" class="form-control" value="All Days" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Meeting Room Status</label>
                                        <input type="text" class="form-control" value="Active" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="box">
                                <div class="box-header">
                                    <h4 class="box-title">Meeting Room Property</h4>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Property</label>
                                        <textarea rows="4" cols="4" class="form-control" readonly>Infocus, Screen, Glass board, Sound system, Pencils and memos, Internet connection.</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="box">
                                <div class="box-header">
                                    <h4 class="box-title">Meeting Room Photo</h4>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-sm-6 col-6 mb-4">
                                            <img src="{{url('img/meeting-room/meeting_room_1.jpeg')}}" alt="">
                                        </div>
                                        <div class="col-sm-6 col-6 mb-4">
                                            <img src="{{url('img/meeting-room/meeting_room_2.jpeg')}}" alt="">
                                        </div>
                                        <div class="col-sm-6 col-6">
                                            <img src="{{url('img/meeting-room/meeting_room_3.jpeg')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <a href="{{ url('/meeting-room/details/edit') }}" class="btn btn-bold btn-pure btn-info float-right btn-block">Edit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@section('script')
    <script src='https://cdn.jsdelivr.net/npm/moment@2.24.0/min/moment.min.js'></script>
    <script>
        $(".alert").fadeTo(4000, 500).slideUp(500, function(){
            $(".alert").slideUp(500);
        });
    </script>
@endsection
