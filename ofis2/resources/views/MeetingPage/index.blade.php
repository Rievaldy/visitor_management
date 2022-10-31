@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Automation Control</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">Automation Control List</h4>
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
                    <div class="table-responsive">
                        <table class="table table-striped dataTables">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-left w-500">Room Name</th>
                                    <th class="text-left  w-500 text-nowrap">Automation Control User</th>
                                    <th class="text-center">Last Update</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1
                                @endphp
                                @foreach ( $rooms as $room )
                                    <tr>
                                        <td class="">{{ $no++ }}</td>
                                        <td class="">
                                            {{ $room->room_name}}
                                        </td>
                                        <td class="">
                                            @if ( $room->user_name != null)
                                                {{ $room->user_name}}
                                            @else
                                                <span class="text-danger">User has not been added</span>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">
                                            {{ date('M d Y, H:i', strtotime($room->updated_at)) }}
                                        </td>
                                        <td class="text-center">
                                            <span data-toggle="modal" class="btn-view" id="{{ $room->room_id}}" data-locker="{{ json_encode($room) }}" data-target="#modalDs">
                                                <a href="#" class="btn-action" data-toggle="tooltip" data-placement="bottom" title="edit">
                                                    <i class="ti-pencil"></i>
                                                </a>
                                            </span>
                                            {{-- <a href="{{ url('device-control/edit/'.$room->room_id) }}" class="btn-action" data-toggle="tooltip" data-placement="bottom" title="edit">
                                                <i class="ti-pencil"></i>
                                            </a> --}}
                                            <form action="{{ url('device-control/'.$room->room_id) }}" method="GET" class="d-inline">
                                            @csrf
                                                <button class="ml-3 btn-action" data-toggle="tooltip" data-placement="bottom" title="view">
                                                    <i class="ti-eye"></i>
                                                </button>
                                            </form>
                                            @if ( $room->id_automation != null )
                                                <form action="{{ url('device-control/delete/'.$room->id_automation) }}" method="POST" onsubmit="return confirm('Are you sure? This automation control user and details will be permanantly deleted!')" class="d-inline">
                                                    @csrf
                                                    <button class="ml-3 btn-action" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                                        <i class="ti-trash"></i>
                                                    </button>
                                                </form>
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
    </div>

    <div class="modal" data-backdrop="false" id="modalDs" style="z-index: 9999">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title" id="exampleModalLabel">View Automation Control</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="ti-close"></span>
                    </button>
                </div>
                <div class="modal-body p-0 border-0">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box mb-0">
                                <form action="{{ route('storeAutomationControl') }}" method="POST">
                                @csrf
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>Room Name</label>
                                            <input name="room_name" type="text" class="form-control" value="" placeholder="" readonly>
                                            <input name="room_id" type="hidden" class="form-control" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Digital Signage User</label>
                                            <select name="user_id" class="select2 form-control" style="width: 100%">
                                                <option value="" disabled selected>Select Automation Control User</option>
                                                @foreach ( $users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <div class="row">
                                            <div class="col-3">
                                                <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" data-dismiss="modal">Close</button>
                                            </div>
                                            <div class="col-3">
                                                <button type="submit" class="btn btn-bold btn-pure btn-info float-right btn-block">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
        $('.btn-view').on('click',function(){
            // alert('hello')
            console.log($(this).data('locker'));
            var item = $(this).data('locker')
            $('#modalDs').find('input[name=room_name]').val(item.room_name)
            $('#modalDs').find('input[name=room_id]').val(item.room_id)
            $('#modalDs').find('input[name=employee_name]').val(item.employee_name)
            $('select[name=user_id]').val(item.user_id).trigger('change')
            // $('#modalDs').find('form').attr('action','/digital-signage/edit/'+item.id)
        })

        $(".alert").fadeTo(4000, 500).slideUp(500, function(){
            $(".alert").slideUp(500);
        });

        $('.dataTables').DataTable({
            "pageLength": 50
        });
    </script>
@endsection

