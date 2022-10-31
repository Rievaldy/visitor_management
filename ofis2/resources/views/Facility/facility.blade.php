@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Property Type</h3>
    </div>
@endsection

@section('content')
    <div class="row">
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
    </div>
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">Property Type List</h4>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('facilitiesAdd') }}" class="btn btn-bold btn-pure btn-info">Add New Property</a>
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
                                    <th class="text-left">Code</th>
                                    <th class="text-left">Name</th>
                                    <th class="text-left text-nowrap">Category</th>
                                    {{-- <th class="text-left text-nowrap">Asset Code</th>
                                    <th class="text-left text-nowrap">Quantity</th> --}}
                                    <th class="text-left text-nowrap">Controllable</th>
                                    <th class="text-left text-nowrap">Device Type</th>
                                    <th class="text-left w-full">Description</th>
                                    <th class="text-center">Last Update</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ( $datas as $data )
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td class="text-left text-nowrap">{{ $data->code }}</td>
                                        <td class="text-left text-nowrap">{{ $data->name }}</td>
                                        <td class="text-left text-nowrap">{{ $data->cat_name}}</td>
                                        {{-- <td class="text-left">{{ $data->code_asset}}</td>
                                        <td class="text-left">{{ $data->qty}}</td> --}}
                                        <td class="text-left">
                                            {{$data->is_control == 1 ? 'Yes' : 'No' }}
                                        </td>
                                        <td class="text-left text-capitalize">
                                            @if ($data->control_id == 1)
                                                Switch
                                            @elseif ($data->control_id == 2)
                                                Slide
                                            @else

                                            @endif
                                        </td>
                                        <td class="text-left">{{ $data->description }}</td>
                                        <td class="text-nowrap">
                                            {{ date('M d Y, H:i', strtotime($data->updated)) }}
                                        </td>
                                        <td class="text-center text-success">
                                            <span class="btn btn-block btn-rounded {{$data->status == 1 ? 'btn-success' : 'btn-danger' }}">
                                                {{$data->status == 1 ? 'Active' : 'Inctive' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span data-toggle="modal" class="btn-view" id="{{ $data -> id}}" data-facilities="{{ json_encode($data) }}" data-target="#modal-detail">
                                                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="View">
                                                    <i class="ti-eye"></i>
                                                </a>
                                            </span>
                                            <form action="{{ url('facilities/'.$data -> id) }}" method="POST" onsubmit="return confirm('Are you sure? This record and its details will be permanantly deleted!')" class="d-inline">
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
    <div class="modal modal-fill fade" data-backdrop="false" id="modal-detail" tabindex="-1" style="z-index: 9999">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h5 class="modal-title">Large Meeting Room	</h5> --}}
                    <button type="button" class="close" style="padding-right: 28px" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box">
                                <div class="box-header">
                                    <h4 class="box-title">View Property</h4>
                                </div>
                                <form action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>Property Code</label>
                                            <input name="code" type="text" class="form-control" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Property Name</label>
                                            <input name="name" type="text" class="form-control" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Category</label>
                                            <input name="cat_name" type="text" class="form-control" value="" placeholder="" readonly>
                                        </div>
                                        {{-- <div class="form-group">
                                            <label>Asset Code</label>
                                            <input name="code_asset" type="text" class="form-control" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Quantity</label>
                                            <input name="qty" type="text" class="form-control" value="" placeholder="" readonly>
                                        </div> --}}
                                        <div class="form-group">
                                            <label>Controllable</label>
                                            <input name="is_control" type="text" class="form-control" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Device Type</label>
                                            <input name="control_id" type="text" class="form-control" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea name="description" rows="4" cols="4" class="form-control" placeholder="" readonly></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Property Status</label>
                                            <input name="status" type="text" class="form-control" value="Active" placeholder="" readonly>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <div class="row">
                                            <div class="col-3">
                                                <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" data-dismiss="modal">Close</button>
                                            </div>
                                            <div class="col-3">
                                                <button type="submit" class="btn btn-bold btn-pure btn-info float-right btn-block">Edit</button>
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
            var item = $(this).data('facilities')
            $('#modal-detail').find('input[name=code]').val(item.code)
            $('#modal-detail').find('input[name=name]').val(item.name)
            $('#modal-detail').find('input[name=cat_name]').val(item.cat_name)
            // $('#modal-detail').find('input[name=code_asset]').val(item.code_asset)
            // $('#modal-detail').find('input[name=qty]').val(item.qty)
            $('#modal-detail').find('input[name=is_control]').val(item.status)
            if(item.is_control == 1){
                $('#modal-detail').find('input[name=is_control]').val('Yes');
            } else {
                $('#modal-detail').find('input[name=is_control]').val('No');
            }
            $('#modal-detail').find('input[name=control_id]').val(item.status)
            if(item.control_id == 1){
                $('#modal-detail').find('input[name=control_id]').val('Switch');
            } else if (item.control_id == 2) {
                $('#modal-detail').find('input[name=control_id]').val('Slide');
            }
            $('#modal-detail').find('textarea[name=description]').val(item.description)
            $('#modal-detail').find('input[name=status]').val(item.status)
            if(item.status == 1){
                $('#modal-detail').find('input[name=status]').val('Active');
            } else {
                $('#modal-detail').find('input[name=status]').val('Inactive');
            }
            // console.log(item.id)
            $('#modal-detail').find('form').attr('action','/facilities/edit/'+item.id)
        })

        $(".alert").fadeTo(4000, 500).slideUp(500, function(){
            $(".alert").slideUp(500);
        });
    </script>
@endsection

