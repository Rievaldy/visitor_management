@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Purpose Category</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="flexbox flex-justified text-center mb-30 bg-primary">
                <div class="no-shrink py-30">
                    <span class="ti-hummer font-size-50"></span>
                </div>
                <div class="py-30 bg-white text-dark">
                    <div class="font-size-30">
                        <?php
                            $count = DB::table('purpose')->count();
                            echo $count;
                        ?>
                    </div>
                    <span>Total Purpose Category</span>
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
                            <h4 class="box-title">Purpose Category List</h4>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('purposeAdd') }}" class="btn btn-bold btn-pure btn-info">Add</a>
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
                                    <th class="text-left">Name</th>
                                    <th class="text-left">Description</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Last Update</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1
                                @endphp
                                @foreach ( $datas as $data )
                                    <tr>
                                        <td class="text-center">{{ $no++}}</td>
                                        <td class="text-left text-nowrap">{{ $data->name}}</td>
                                        <td class="text-left">{{ $data->description}}</td>
                                        <td class="text-center text-success">
                                            <span class="btn btn-block btn-rounded btn-primary">
                                            @switch($data->category)
                                                @case(1)
                                                    Visit Purpose
                                                    @break
                                                @case(2)
                                                    Area Purpose
                                                    @break
                                                @case(3)
                                                    Communication Purpose
                                                    @break
                                                @default
                                                    Visit Purpose
                                                    @break
                                            @endswitch
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            {{ date('M d Y, H:i', strtotime($data->updated_at)) }}
                                        </td>
                                        <td class="text-center">
                                            <span data-toggle="modal" class="btn-view" id="{{ $data -> id}}" data-purpose="{{ json_encode($data) }}" data-target="#modal-detail">
                                                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="View">
                                                    <i class="ti-eye"></i>
                                                </a>
                                            </span>
                                            <form action="{{ url('purpose/'.$data -> id) }}" method="POST" onsubmit="return confirm('Are you sure? This record and its details will be permanantly deleted!')" class="d-inline">
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

    {{-- MODAL HERE --}}
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
                                    <h4 class="box-title">View Tools</h4>
                                </div>
                                <form action="" method="GET" enctype="multipart/form-data">
                                @csrf
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>Tools Name</label>
                                            <input type="text" name="name" class="form-control" value="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Tools Description</label>
                                            <textarea rows="4" name="description" cols="4" class="form-control" readonly></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Category</label>
                                            <input name="category" type="text" class="form-control" readonly>
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
            var item = $(this).data('purpose')
            $('#modal-detail').find('input[name=name]').val(item.name)
            $('#modal-detail').find('textarea[name=description]').val(item.description)
            // console.log(item.id)
            $('#modal-detail').find('input[name=category]').val(item.category)
            if(item.category == 1){
                $('#modal-detail').find('input[name=category]').val('Visit Purpose');
            }else if(item.category == 2) {
                $('#modal-detail').find('input[name=category]').val('Area Purpose');
            }else{
                $('#modal-detail').find('input[name=category]').val('Communication Purpose');
            }
            $('#modal-detail').find('form').attr('action','/purpose/edit/'+item.id)
        })

        $(".alert").fadeTo(4000, 500).slideUp(500, function(){
            $(".alert").slideUp(500);
        });
    </script>
@endsection
