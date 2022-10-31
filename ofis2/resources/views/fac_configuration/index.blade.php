@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Configuration FAC</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">Configuration FAC List</h4>
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
                                    <th class="text-left">IP FAC</th>
                                    <th class="text-left">Location</th>
                                    <th class="text-center text-nowrap">Status</th>
                                    <th class="text-left">Last Update</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1
                                @endphp

                                @foreach ( $data as $datas )
                                    <tr>
                                        <td class="">{{ $no++ }}</td>
                                        <td>{{ $datas->ip_fac}}:100</td>
                                        <td class="">{{ $datas->location}}</td>
                                        <td class="text-center text-success">
                                            <span class="btn btn-block btn-rounded {{$datas->status == 1 ? 'btn-success' : 'btn-danger' }}">
                                                {{$datas->status == 1 ? 'Active' : 'Inctive' }}
                                            </span>
                                        </td>
                                        <td class="text-nowrap">
                                            {{ date('M d Y, H:i', strtotime($datas->updated_at)) }}
                                        </td>
                                        <td class="text-center">
                                            {{-- <span data-toggle="modal" class="btn-view" id="{{ $datas->id}}" data-locker="{{ json_encode($datas) }}" data-target="#modalDs">
                                                <a href="#" class="btn-action" data-toggle="tooltip" data-placement="bottom" title="edit">
                                                    <i class="ti-pencil"></i>
                                                </a>
                                            </span> --}}

                                            <form action="{{ url('configuration_fac/edit/'.$datas->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="ml-3 btn-action" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                                    <i class="ti-pencil"></i>
                                                </button>
                                            </form>

                                            {{-- DELETE FAC --}}
                                            {{-- <form action="{{ url('configuration-fac/delete/'.$datas->id) }}" method="POST" onsubmit="return confirm('Are you sure? This digital signage user and details will be permanantly deleted!')" class="d-inline">
                                                @method('DELETE')
                                                @csrf
                                                <button class="ml-3 btn-action" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                                    <i class="ti-trash"></i>
                                                </button>
                                            </form> --}}

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

    {{-- <div class="modal" data-backdrop="false" id="modalDs" style="z-index: 9999">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title" id="exampleModalLabel">View FAC Configuration</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="ti-close"></span>
                    </button>
                </div>
                <div class="modal-body p-0 border-0">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box mb-0">
                                
                                <form action="{{ url('configuration-fac/update/'.$data[0]->id) }}" method="POST">
                                @csrf
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>IP FAC</label>
                                            <input name="ip_fac" type="text" class="form-control" value="" placeholder="" readonly>
                                            <input name="id" type="hidden" class="form-control" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Location</label>
                                            <input name="location" type="text" class="form-control" value="">
                                        </div>

                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" id="status" class="select2 form-control" style="width: 100%">
                                                <option value="" disabled>Select Status</option>
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
    </div> --}}

@endsection


@section('script')
    <script>
        $('.btn-view').on('click',function(){
            // alert('hello')
            console.log($(this).data('locker'));
            var item = $(this).data('locker')
            let idData = item.status;
            $('#modalDs').find('input[name=ip_fac]').val(item.ip_fac)
            $('#modalDs').find('input[name=id]').val(item.id)
            $('#modalDs').find('input[name=location]').val(item.location)
            let optionSelect = '';
            if(idData == 1){
                optionSelect = `<option value="1" selected>Active</option><option value="0">Inactive</option>`
            }else{
                optionSelect = `<option value="1">Active</option><option value="0" selected>Inactive</option>`
            }
            $('#modalDs').find('#status').append(optionSelect);
            // $('#modalDs').find('input[name=status]').val(item.status)
            // $('select[name=user_id]').val(item.user_id).trigger('change')
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
