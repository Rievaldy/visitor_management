@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Visitor Managament System</h3>
    </div>
@endsection

@section('content')
    {{-- <div class="row">
        <div class="col-12 col-sm-6">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-12 text-left">
                            <h4 class="box-title">VMS Info</h4>
                        </div>
                    </div>
                </div>
                <form action="{{ url('vms-parameter/update/'.$parameters[0]->id) }}" method="POST" >
                @csrf
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
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Days Availability</label>
                                    <select name="day_avail" class="form-control select2" id="selectDays" style="width: 100%;">
                                        <option value="" selected disabled>Select Day Availability</option>
                                        <option value="1" {{$day_avail == 1  ? 'selected' : ''}}>
                                            All Day
                                        </option>
                                        <option value="2" {{$day_avail == 2  ? 'selected' : ''}}>
                                            Weekday Only
                                        </option>
                                        <option value="3" {{$day_avail == 3  ? 'selected' : ''}}>
                                            Custom day
                                        </option>
                                    </select>
                                    <div id="customDay"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group mb-0">
                                    <label>OPEN TIME</label>
                                    <input type="text" name="h_start" class="form-control" value="{{ date('H:i', strtotime($openTime))}}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group mb-0">
                                    <label>CLOSE TIME</label>
                                    <input type="text" name="h_end" class="form-control" value="{{ date('H:i', strtotime($closeTime))}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-3">
                                <button type="submit" class="btn btn-bold btn-pure btn-info float-right btn-block">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-12 text-left">
                            <h4 class="box-title">VMS Info</h4>
                        </div>
                    </div>
                </div>
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
                        <table class="table">
                            <thead>
                                <tr>
                                    {{-- <th class="">#</th> --}}
                                    <th class="w-full">Day Name</th>
                                    <th class="text-nowrap text-center">Status</th>
                                    <th class="text-nowrap text-center">Open Time</th>
                                    <th class="text-nowrap text-center">Close Time</th>
                                    <th class="text-nowrap text-center">Backround</th>
                                    <th class="text-nowrap text-center">Voice pagi</th>
                                    <th class="text-nowrap text-center">Voice siang</th>
                                    <th class="text-nowrap text-center">Voice malam</th>
                                    <th class="text-nowrap text-center">Last update</th>
                                    <th class="text-nowrap text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @php
                                    $no = 1;
                                @endphp --}}
                                @foreach ( $vmsdays as $data )
                                    <tr>
                                        {{-- <td class="">{{ $no++}}</td> --}}
                                        <td class="">{{ $data->days}}</td>
                                        <td class="text-center pt-2 pb-0">
                                            <span class="btn btn-block btn-rounded {{$data->status == 1 ? 'btn-success' : 'btn-danger' }}">
                                                {{$data->status == 1 ? 'Open' : 'Close' }}
                                            </span>
                                        </td>
                                        @if ($data->open_time != null)
                                            <td class="text-center">{{ date('H:i', strtotime($data->open_time)) }}</td>
                                        @else ()
                                            <td class="text-center">-</td>
                                        @endif

                                        @if ($data->close_time != null)
                                            <td class="text-center">{{ date('H:i', strtotime($data->close_time)) }}</td>
                                        @else ()
                                            <td class="text-center">-</td>
                                        @endif
                                        <td class="text-center pt-2 pb-0">
                                            <span class="btn btn-block btn-rounded {{$data->img != null ? 'btn-primary' : 'btn-light' }}">
                                                {{$data->img != null ? 'Changed' : 'Original' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if ($data->pagi != null)
                                                <audio controls>
                                                    <source src="{{ $data->pagi }}" type="audio/ogg">
                                                </audio>
                                            @else
                                            <span class="btn btn-block btn-rounded btn-light">Original</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($data->siang != null)
                                                <audio controls>
                                                    <source src="{{ $data->siang }}" type="audio/ogg">
                                                </audio>
                                            @else
                                                <span class="btn btn-block  btn-rounded btn-light">Original</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($data->malam != null)
                                                <audio controls>
                                                    <source src="{{ $data->malam }}" type="audio/ogg">
                                                </audio>
                                            @else
                                                <span class="btn btn-block btn-rounded btn-light">Original</span>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">
                                            {{ date('M d Y, H:i', strtotime($data->updated_at)) }}
                                        </td>
                                        <td class="text-center">
                                            <span data-toggle="modal" class="btn-view" id="{{ $data->id}}" data-days="{{ json_encode($data) }}" data-target="#modal-detail">
                                                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Edit">
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
            </div>
        </div>
    </div>

    {{-- modal here --}}
    {{-- <div class="modal" data-backdrop="false" id="modal-detail" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body p-0 border-0">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box mb-0">
                                <form action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>Day Name</label>
                                            <input name="days" type="text" class="form-control" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>VMS Status</label>
                                            <select name="status" id="setStatus" class="select2" style="width: 100%">
                                                <option value="1">Open</option>
                                                <option value="0">Close</option>
                                            </select>
                                        </div>
                                        <div id="time-wrappers">
                                            <div id="time-wrapper">
                                                <div class="form-group">
                                                    <label>Open time</label>
                                                    <input name="open_time" type="time" class="form-control" value="" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Close Time</label>
                                                    <input name="close_time" type="time" class="form-control" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Image</label>
                                            <input name="img" type="file" class="form-control" value="" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <Label>Voice Command</Label>
                                            <select name="audio" id="audioCommand" class="select2" style="width: 100%">
                                                <option value="1">Pagi</option>
                                                <option value="2">Siang</option>
                                                <option value="3">Malam</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="audioFile1">
                                            <label>Audio pagi</label>
                                            <input name="pagi" type="file" class="form-control" cols="30" rows="10" maxlength="20">
                                        </div>
                                        <div class="form-group" id="audioFile2">
                                            <label>Audio siang</label>
                                            <input name="siang" type="file" class="form-control" cols="30" rows="10" maxlength="20">
                                        </div>
                                        <div class="form-group" id="audioFile3">
                                            <label>Audio malam</label>
                                            <input name="malam" type="file" class="form-control" cols="30" rows="10" maxlength="20">
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <div class="row">
                                            <div class="col-3">
                                                <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" data-dismiss="modal">Close</button>
                                            </div>
                                            <div class="col-3">
                                                <button type="submit" class="btn btn-bold btn-pure btn-info float-right btn-block">Save</button>
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
    
    {{-- Modal here --}}
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
                        <div class="col-12">
                            <div class="box mb-0">
                                <form action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>Day Name</label>
                                            <input name="days" type="text" class="form-control" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>VMS Status</label>
                                            <select name="status" id="setStatus" class="select2" style="width: 100%">
                                                <option value="1">Open</option>
                                                <option value="0">Close</option>
                                            </select>
                                        </div>
                                        <div id="time-wrappers">
                                            <div id="time-wrapper">
                                                <div class="form-group">
                                                    <label>Open time</label>
                                                    <input name="open_time" type="time" class="form-control" value="" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Close Time</label>
                                                    <input name="close_time" type="time" class="form-control" value="" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Image</label>
                                                    <input name="img" type="file" class="form-control" value="" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <Label>Voice Command</Label>
                                                    <select name="audio" id="audioCommand" class="select2" style="width: 100%">
                                                        <option value="1">Pagi</option>
                                                        <option value="2">Siang</option>
                                                        <option value="3">Malam</option>
                                                    </select>
                                                </div>
                                                <div class="form-group" id="audioFile1">
                                                    <label>Audio pagi</label>
                                                    <input name="pagi" type="file" class="form-control" cols="30" rows="10" maxlength="20">
                                                </div>
                                                <div class="form-group" id="audioFile2">
                                                    <label>Audio siang</label>
                                                    <input name="siang" type="file" class="form-control" cols="30" rows="10" maxlength="20">
                                                </div>
                                                <div class="form-group" id="audioFile3">
                                                    <label>Audio malam</label>
                                                    <input name="malam" type="file" class="form-control" cols="30" rows="10" maxlength="20">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <div class="row">
                                            <div class="col-3">
                                                <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" data-dismiss="modal">Close</button>
                                            </div>
                                            <div class="col-3">
                                                <button type="submit" class="btn btn-bold btn-pure btn-info float-right btn-block">Save</button>
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
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $('#audioFile1').show();
        $('#audioFile2').hide();
        $('#audioFile3').hide();
    });

    $('#audioCommand').on('change',function() {
        if (this.value == 2) {
            $('#audioFile1').hide();
            $('#audioFile2').show();
            $('#audioFile3').hide();
        }else if(this.value == 3){
            $('#audioFile1').hide();
            $('#audioFile2').hide();
            $('#audioFile3').show();
        }else{
            $('#audioFile1').show();
            $('#audioFile2').hide();
            $('#audioFile3').hide();
        }
    });
</script>
    <script>
        $('#dataTables').DataTable();
        $(".alert").fadeTo(4000, 500).slideUp(500, function(){
            $(".alert").slideUp(500);
        });

        $('#selectDays').on('change', function() {
            if (this.value == 3) {
                $('#customDay').load('/dayCustom', function () {
                    $('.select2').select2();
                });
            } else {
                $("#customDay").empty();
            }
        });

        $('.btn-view').on('click',function(){
            // alert('hello')
            var item = $(this).data('days')
            console.log(item);
            $('#modal-detail').find('input[name=days]').val(item.days)
            if(item.status == 1){
                $('#modal-detail').find('input[name=status]').val('Open');
            } else {
                $('#modal-detail').find('input[name=status]').val('No');
            }
            $('#modal-detail').find('input[name=open_time]').val(item.open_time)
            $('#modal-detail').find('input[name=close_time]').val(item.close_time)
            // console.log(item.id)
            $('#modal-detail').find('form').attr('action','/vms-parameter2/update/'+item.id)
        })

        $('#setStatus').on('change', function() {
            var data = $("#setStatus option:selected").val();
            if(data == 1){
                $('#time-wrappers').before('<div id="time-wrapper"><div class="form-group"><label>Open time</label><input name="open_time" type="time" class="form-control" value="" required></div><div class="form-group"><label>Close Time</label><input name="close_time" type="time" class="form-control" value="" required></div></div>');
            } else {
                $('#time-wrapper').remove();
            }
        })
    </script>
@endsection
