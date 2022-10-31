@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Locker</h3>
    </div>
@endsection

@section('content')
    {{-- <div class="row">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="flexbox flex-justified text-center mb-30 bg-primary">
                <div class="no-shrink py-30">
                    <span class="ti-panel font-size-50"></span>
                </div>
                <div class="py-30 bg-white text-dark">
                    <div class="font-size-30">
                        <?php
                            $count = DB::table('facilities')->count();
                            echo $count;
                        ?>
                    </div>
                    <span>Total Property</span>
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
                            $total = DB::table('facilities')->where('status', 1)->count();
                            echo $total.'/';
                        ?>
                        <span class="font-size-18">
                            <?php
                                $count = DB::table('facilities')->count();
                                echo $count;
                            ?>
                        </span>
                    </div>
                    <span>Active Property</span>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <ul class="nav nav-pills ml-4" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link btn-tabs-custom active" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Wisma Nusantara Lt. 21</a>
                            </li>
                            <li class="nav-item ml-4">
                                <a class="nav-link btn-tabs-custom" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Wisma Nusantara LT. 22</a>
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
                                <table class="table dataTables".dataTable({

                                })>
                                    <thead>
                                        <tr>
                                            <th class="">#</th>
                                            <th class="text-left">Locker Name</th>
                                            <th class="text-left">Employee Name</th>
                                            <th class="text-left">Employee ID</th>
                                            <th class="text-center">Last Update</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($lockers21 as $locker21)
                                            <tr>
                                                <td>{{ $no++}}</td>
                                                <td>{{ $locker21->name}}</td>
                                                <td>{{ $locker21->employee_name}}</td>
                                                <td>{{ $locker21->employee_id}}</td>
                                                <td>
                                                    {{ date('M d Y, H:i', strtotime($locker21->updated_at)) }}
                                                </td>
                                                <td class="text-center text-success">
                                                    <span class="btn btn-block btn-rounded {{$locker21->status == 0 ? 'btn-success' : 'btn-danger' }}">
                                                        {{$locker21->status == 0 ? 'Avail' : 'Not Avail' }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <span data-toggle="modal" class="btn-view" id="{{ $locker21->id}}" data-locker="{{ json_encode($locker21) }}" data-target="#modalLocker">
                                                        <a href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="View">
                                                            <i class="ti-pencil"></i>
                                                        </a>
                                                    </span>
                                                    @if ($locker21->status != 0)
                                                        <form action="{{ url('locker/delete/'.$locker21->id) }}" method="POST" onsubmit="return confirm('Are you sure? This locker user and details will be permanantly deleted!')" class="d-inline">
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
                        <div class="tab-pane fade show" id="pills-profile" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="table-responsive">
                                <table class="table dataTables".dataTable({

                                })>
                                    <thead>
                                        <tr>
                                            <th class="">#</th>
                                            <th class="text-left">Locker Name</th>
                                            <th class="text-left">Employee Name</th>
                                            <th class="text-left">Employee ID</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Last Update</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($lockers22 as $locker22)
                                            <tr>
                                                <td>{{ $no++}}</td>
                                                <td>{{ $locker22->name}}</td>
                                                <td>{{ $locker22->employee_name}}</td>
                                                <td>{{ $locker22->employee_id}}</td>
                                                <td class="text-center text-success">
                                                    <span class="btn btn-block btn-rounded {{$locker22->status == 0 ? 'btn-success' : 'btn-danger' }}">
                                                        {{$locker22->status == 0 ? 'Avail' : 'Not Avail' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ date('M d Y, H:i', strtotime($locker22->updated_at)) }}
                                                </td>
                                                <td class="text-center">
                                                    <span data-toggle="modal" class="btn-view" id="{{ $locker22->id}}" data-locker="{{ json_encode($locker22) }}" data-target="#modalLocker">
                                                        <a href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="View">
                                                            <i class="ti-pencil"></i>
                                                        </a>
                                                    </span>
                                                    <form action="{{ url('locker/delete/'.$locker22->id) }}" method="POST" onsubmit="return confirm('Are you sure? This locker user and details will be permanantly deleted!')" class="d-inline">
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
        </div>
    </div>
    {{-- MODAL HERE --}}
    <div class="modal" data-backdrop="false" id="modalLocker" style="z-index: 9999">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title" id="exampleModalLabel">View Locker</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="ti-close"></span>
                    </button>
                </div>
                <div class="modal-body p-0 border-0">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box mb-0">
                                <form action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>Locker Code</label>
                                            <input name="device_id" type="hidden" class="form-control" value="" placeholder="">
                                            <input name="loc_name" type="text" class="form-control" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Employee</label>
                                            <select name="user_id" class="select2 form-control" style="width: 100%">
                                                <option value="" disabled selected>Select Employee</option>
                                                @foreach ( $employees as $employee)
                                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
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
            $('#modalLocker').find('input[name=device_id]').val(item.device_id)
            $('#modalLocker').find('input[name=loc_name]').val(item.name)
            $('#modalLocker').find('input[name=employee_name]').val(item.employee_name)
            $('select[name=user_id]').val(item.user_id).trigger('change')
            $('#modalLocker').find('form').attr('action','/locker/update/'+item.id)
        })

        $(".alert").fadeTo(4000, 500).slideUp(500, function(){
            $(".alert").slideUp(500);
        });

        $('.dataTables').DataTable({
            "pageLength": 50
        });
    </script>
@endsection

