@extends('master')

@section('head')
    <link rel="stylesheet" href="{{ asset('vendor/dropzone/dropzone.css') }}">
@endsection

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Edit Meeting Room</h3>
    </div>
@endsection

@section('content')
    <form action="{{ url('rooms/update/'.$rooms->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
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
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">Basic Info</h4>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Meeting Room Name</label>
                            <input name="name" type="text" class="form-control" value="{{ $rooms->name }}">
                        </div>
                        <div class="form-group">
                            <label>Capacity</label>
                            <input name="capacity" type="number" class="form-control" value="{{ $rooms->capacity }}">
                        </div>
                        <div class="form-group">
                            <label>Room Location</label>
                                <select name="id_loc" class="form-control select2">
                                    <option selected>Select Location</option>
                                    @foreach ( $locations as $location)
                                        <option value="{{ $location->id}}" {{$rooms->id_loc == $location->id  ? 'selected' : ''}}>{{ $location->name }}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="form-group">
                            <label>Hours Availability</label>
                            <select name="h_avail" class="form-control select2" id="selectHours" style="width: 100%;">
                                <option value="1" {{$rooms->h_avail == 1  ? 'selected' : ''}}>
                                    Full Day
                                </option>
                                <option value="2" {{$rooms->h_avail == 2  ? 'selected' : ''}}>
                                    Custom hour
                                </option>
                            </select>
                            <div id="showHour"></div>
                        </div>
                        <div class="form-group">
                            <label>Days Availability</label>
                            <select name="day_avail" class="form-control select2" id="selectDays" style="width: 100%;">
                                <option value="1" {{$rooms->day_avail == 1  ? 'selected' : ''}}>
                                    All Day
                                </option>
                                <option value="2" {{$rooms->day_avail == 2  ? 'selected' : ''}}>
                                    Weekday Only
                                </option>
                                <option value="3" {{$rooms->day_avail == 3  ? 'selected' : ''}}>
                                    Custom day
                                </option>
                            </select>
                            <div id="customDay"></div>
                        </div>
                        <div class="form-group">
                            <label>Room Use Approval</label>
                            <div class="c-inputs-stacked">
                                <input name="is_need_approve" type="radio" id="auto_approve" value="1" {{$rooms->is_need_approve == 1 ? 'checked' : '' }}>
                                <label for="auto_approve" class="mr-30">Auto Approve</label>
                                <input name="is_need_approve" type="radio" id="need_approve" value="2" {{$rooms->is_need_approve == 2 ? 'checked' : '' }}>
                                <label for="need_approve" class="mr-30">Need Approval</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Chat Secretary</label>
                            <div class="c-inputs-stacked">
                                <input name="room_call_id" type="radio" id="call_frontdesk" value="1" {{$rooms->room_call_id == 1 ? 'checked' : '' }}>
                                <label for="call_frontdesk" class="mr-30">NO</label>
                                <input name="room_call_id" type="radio" id="call_secretary" value="2" {{$rooms->room_call_id == 2 ? 'checked' : '' }}>
                                <label for="call_secretary" class="mr-30">YES</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Digital Signage Camera</label>
                            <div class="c-inputs-stacked">
                                <input name="is_ds_mirror" type="radio" id="ds_mirror_no" value="1" {{$rooms->is_ds_mirror == 1 ? 'checked' : '' }}>
                                <label for="ds_mirror_no" class="mr-30">Normal</label>
                                <input name="is_ds_mirror" type="radio" id="ds_mirror_yes" value="2" {{$rooms->is_ds_mirror == 2 ? 'checked' : '' }}>
                                <label for="ds_mirror_yes" class="mr-30">Miror</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Digital Signage Scanner</label>
                            <div class="c-inputs-stacked">
                                <input name="is_ds_reader" type="radio" id="ds_scnanner_camera" value="1" {{$rooms->is_ds_reader == 1 ? 'checked' : '' }}>
                                <label for="ds_scnanner_camera" class="mr-30">Use Camera</label>
                                <input name="is_ds_reader" type="radio" id="ds_scanner_reader" value="2" {{$rooms->is_ds_reader == 2 ? 'checked' : '' }}>
                                <label for="ds_scanner_reader" class="mr-30">QR Code Reader</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Meeting Room Status</label>
                            <div class="c-inputs-stacked">
                                <input name="status" type="radio" id="status_active" value="1" {{$rooms->status == 1 ? 'checked' : '' }}>
                                <label for="status_active" class="mr-30">Active</label>
                                <input name="status" type="radio" id="status_inactive" value="0" {{$rooms->status == 0 ? 'checked' : '' }}>
                                <label for="status_inactive" class="mr-30">Inactive</label>
                            </div>
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
                            <div class="row">
                                <div class="col-3">
                                    <label>Property Type</label>
                                </div>
                                <div class="col-3">
                                    <label>Property Name</label>
                                </div>
                                <div class="col-2">
                                    <label class="text-nowrap">Asset Code</label>
                                </div>
                                <div class="col-4">
                                    <label>Device ID</label>
                                </div>
                            </div>
                        </div>
                        <div id="oldFacility">
                            @foreach ( $activeFacility as $active )
                                <div class="form-group new-row">
                                    <div class="row">
                                        <div class="col-3">
                                            <select name="id_facility[]" class="select2" id="selectMRoom" style="width: 100%">
                                                {{-- <option selected disabled>Select Property</option> --}}
                                                    @foreach ( $facilities as $facility)
                                                        <option value="{{ $facility->id }}" {{$active->id_facility == $facility->id  ? 'selected' : ''}}>{{ $facility->name }}</option>
                                                    @endforeach
                                                </select>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" name="property_name[]" class="form-control text-left" value="{{ $active->property_name }}">
                                        </div>
                                        <div class="col-2">
                                            <input type="text" name="asset_code[]" class="form-control text-left" value="{{ $active->asset_code }}">
                                        </div>
                                        <div class="col-2">
                                            <input type="text" name="device_id[]" class="form-control text-left" value="{{ $active->device_id }}">
                                        </div>
                                        <div class="col-2">
                                            <a href="javascript:void(0);" class="btn btn-bold btn-pure btn-danger btn-block removeOld"><i class="ti-minus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <select name="id_facility[]" class="select2" id="selectMRoom" style="width: 100%">
                                        {{-- <option selected disabled>Select Property</option> --}}
                                        @foreach ( $facilities as $facility)
                                            <option value="{{ $facility->id }}">{{ $facility->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <input type="text" name="property_name[]" class="form-control text-left">
                                </div>
                                <div class="col-2">
                                    <input type="text" name="asset_code[]" class="form-control" value="">
                                </div>
                                <div class="col-2">
                                    <input type="text" name="device_id[]" class="form-control" value="">
                                </div>
                                <div class="col-2">
                                    <a href="javascript:void();" class="btn btn-bold btn-pure btn-info btn-block" id="addFacility">
                                        <i class="ti-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div id="facilityWrapper"></div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">Meeting Room Photo</h4>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            @if ( $room_image != null)
                                <img src="{{ $room_image[0]->img }}" alt="">
                            @else
                                No image uploaded
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="file" name="img" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="row">
                    <div class="col-3">
                        <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" onclick="window.location.href='{{route('rooms')}}'">Cancel</button>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <button type="submit" class="btn btn-bold btn-pure btn-info btn-block">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script src="{{ asset('vendor/dropzone/dropzone.js') }}"></script>
    <script>
        $('#selectHours').on('change', function() {
            if(this.value == 1) {
                $('#showHour').load('/hourFixed');
            } else {
                $('#showHour').load('/hourCustom', function () {
                    $('.select2').select2();
                });
            }
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

        $(document).ready(function(){
            var maxField = 999; //Input fields increment limitation
            var addButton = $('#addFacility'); //Add button selector
            var wrapper = $('#facilityWrapper'); //Input field wrapper
            var html = ''; //New input field html
                html +='<div class="form-group mb-0 mt-4 new-row">';
                    html +='<div class="row">';
                        html +='<div class="col-3">';
                            html +='<select name="id_facility[]" class="select2" id="selectMRoom" style="width: 100%">';
                                html +='@foreach ( $facilities as $facility)';
                                    html +='<option value="{{ $facility->id }}">{{ $facility->name }}</option>';
                                html +='@endforeach';
                            html +='</select>';
                        html +='</div>';
                        html +='<div class="col-3">';
                            html +='<input type="text" name="property_name[]" class="form-control text-left" value="">';
                        html +='</div>';
                        html +='<div class="col-2">';
                            html +='<input type="text" name="asset_code[]" class="form-control text-left" value="">';
                        html +='</div>';
                        html +='<div class="col-2">';
                            html +='<input type="text" name="device_id[]" class="form-control text-left" value="">';
                        html +='</div>';
                        html +='<div class="col-2">';
                            html +='<a href="javascript:void(0);" class="btn btn-bold btn-pure btn-danger btn-block" id="removeRow"><i class="ti-minus"></i></a>';
                        html +='</div>';
                    html +='</div>';
                html +='</div>';
            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function(){
                //Check maximum number of input fields
                if(x < maxField){
                    x++; //Increment field counter
                    $(wrapper).append(html); //Add field html
                } else {
                    Swal.fire('You have reached the maximum number of participants')
                }
                $('.select2').select2();
            });

            //On    ce remove button is clicked
            $(wrapper).on('click', '#removeRow', function(e){
                e.preventDefault();
                $(this).closest('.form-group').remove(); //Remove field html
                x--; //Decrement field counter
            });
            $('#oldFacility').on('click', '.removeOld', function(e){
                e.preventDefault();
                $(this).closest('.form-group').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
    </script>
@endsection

