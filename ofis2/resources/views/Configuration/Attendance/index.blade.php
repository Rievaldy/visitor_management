@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Set FAC Attendance</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-12 text-left">
                            <h4 class="box-title">Set FAC</h4>
                        </div>
                    </div>
                </div>
                {{-- <form action="{{ url('set-reminder-parameter/update/'.$configs[0]->id) }}" method="POST" >
                @csrf --}}
                    <div class="box-body">
                        @if(session('errors'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Something it's wrong:
                                <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        @if (Session::has('error'))
                            <div class="alert alert-danger">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped dataTable no-footer dataTables">
                                <thead>
                                    <tr class="">
                                        <th class="">#</th>
                                        <th class="">FAC IP</th>
                                        <th class="">FAC No.</th>
                                        <th class="">FAC Config</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1 ?>
                                    @foreach ( $facs as $fac )
                                        <tr class="">
                                            <td class="">{{ $no++ }}</td>
                                            <td class="">{{ $fac->fac_ip }}</td>
                                            <td class="">{{ $fac->fac_no }}</td>
                                            <td class="">
                                                {{ $fac->is_checkin == 1 ? 'Check In' : 'Check Out' }}
                                            </td>
                                            <td class="text-center">
                                                <span data-toggle="modal" class="btn-view" id="{{ $fac->id}}" data-fac="{{ json_encode($fac) }}" data-target="#modalfac">
                                                <a href="#" class="btn-action" data-toggle="tooltip" data-placement="bottom" title="edit">
                                                    <i class="ti-pencil"></i>
                                                </a>
                                            </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                {{-- </form> --}}
            </div>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal" data-backdrop="false" id="modalfac" style="z-index: 9999">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title" id="exampleModalLabel">View Automation Control</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="ti-close"></span>
                    </button>
                </div>
                <div class="modal-body p-0 border-0">
                    <div class="box mb-0">
                        <form method="POST" action="" enctype="multipart/form-data">
                        @csrf
                            <div class="box-body">
                                <div class="form-group">
                                    <label>FAC IP</label>
                                    <input name="fac_ip" type="text" class="form-control" value="" placeholder="" readonly>
                                </div>
                                <div class="form-group">
                                    <label>FAC No.</label>
                                    <input name="fac_no" type="text" class="form-control" value="" placeholder="" readonly>
                                </div>
                                <div class="form-group">
                                    <label>FAC Config</label>
                                    <select name="is_checkin" style="width: 100%" class="form-control select2">
                                        <option value="none" selected disabled>Select FAC config</option>
                                        <option value="1">Check In</option>
                                        <option value="0">Check Out</option>
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
@endsection

@section('script')
    <script>
        $(".alert").fadeTo(4000, 500).slideUp(500, function(){
            $(".alert").slideUp(500);
        });

        $('.btn-view').on('click',function(){
            // console.log($(this).data('fac'));
            var item = $(this).data('fac')
            $('#modalfac').find('input[name=fac_ip]').val(item.fac_ip)
            $('#modalfac').find('input[name=fac_no]').val(item.fac_no)
            $('#modalfac').find('select[name=is_checkin]').val(item.is_checkin).trigger('change')
            // console.log(item.id)
            $('#modalfac').find('form').attr('action','/set-fac-attendance/update/'+item.id)
        });
    </script>
@endsection
