@extends('master')

@section('head')
    <link rel="stylesheet" href="{{ asset('vendor/dropzone/dropzone.css') }}">
@endsection

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Add New Meeting Room</h3>
    </div>
@endsection

@section('content')
    <form action="{{ route('roomsStore') }}" method="POST" enctype="multipart/form-data">
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
                            <input name="name" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Capacity</label>
                            <input name="capacity" type="number" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Room Location</label>
                            <select name="id_loc" id="" class="form-control select2">
                                <option selected disabled>Select Location</option>
                                @foreach ( $locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Hours Availability</label>
                            <select name="h_avail" class="form-control select2" id="selectHours" style="width: 100%;">
                                <option selected disabled>Select Hour Availability</option>
                                <option value="1">Full Day</option>
                                <option value="2">Custom hour</option>
                            </select>
                            <div id="showHour"></div>
                        </div>
                        <div class="form-group">
                            <label>Days Availability</label>
                            <select name="day_avail" class="form-control select2" id="selectDays" style="width: 100%;">
                                <option value="" selected disabled>Select Day Availability</option>
                                <option value="1">All Day</option>
                                <option value="2">Weekday Only</option>
                                <option value="3">Custom day</option>
                            </select>
                            <div id="customDay"></div>
                        </div>
                        <div class="form-group">
                            <label>Room Use Approval</label>
                            <div class="c-inputs-stacked">
                                <input name="is_need_approve" type="radio" id="auto_approve" value="1" checked>
                                <label for="auto_approve" class="mr-30">Auto Approve</label>
                                <input name="is_need_approve" type="radio" id="need_approve" value="2">
                                <label for="need_approve" class="mr-30">Need Approval</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Chat Secretary</label>
                            <div class="c-inputs-stacked">
                                <input name="room_call_id" type="radio" id="call_frontdesk" value="1" checked>
                                <label for="call_frontdesk" class="mr-30">NO</label>
                                <input name="room_call_id" type="radio" id="call_secretary" value="2">
                                <label for="call_secretary" class="mr-30">YES</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Digital Signage Camera</label>
                            <div class="c-inputs-stacked">
                                <input name="is_ds_mirror" type="radio" id="ds_mirror_no" value="1" checked>
                                <label for="ds_mirror_no" class="mr-30">Normal</label>
                                <input name="is_ds_mirror" type="radio" id="ds_mirror_yes" value="2">
                                <label for="ds_mirror_yes" class="mr-30">Miror</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Meeting Room Status</label>
                            <div class="c-inputs-stacked">
                                <input name="status" type="radio" id="status_active" value="1" checked>
                                <label for="status_active" class="mr-30">Active</label>
                                <input name="status" type="radio" id="status_inactive" value="0">
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
                            <div class="row">
                                <div class="col-3">
                                    <select name="id_facility[]" class="select2" id="selectMRoom" style="width: 100%">
                                        <option selected disabled>Select Property</option>
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
                                    <a href="javascript:void();" class="btn btn-bold btn-pure btn-info btn-block" id="addMenu">
                                        <i class="ti-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div id="menu_wrapper"></div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">Meeting Room Photo</h4>
                    </div>
                    <div class="box-body">
                        {{-- <form  action="" class="dropzone dz-clickable">
                            <div class="dz-default dz-message"><span>Click or drop files here to upload</span></div>
                        </form> --}}
                        <input type="file" name="img" class="form-control">
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="row">
                    <div class="col-3">
                        <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" onclick="window.location.href='{{route('rooms')}}'">Cancel</button>
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-bold btn-pure btn-info float-right btn-block">Create</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script src="{{ asset('vendor/dropzone/dropzone.js') }}"></script>
    <script>
        // $('#showHour').load('/hourFixed');
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
            var addButton = $('#addMenu'); //Add button selector
            var wrapper = $('#menu_wrapper'); //Input field wrapper
            var html = ''; //New input field html
                html +='<div class="form-group mb-0 mt-4 new-row">';
                    html +='<div class="row">';
                        html +='<div class="col-3">';
                            html +='<select name="id_facility[]" class="select2" id="selectMRoom" style="width: 100%">';
                                html +='<option selected disabled>Select Property</option>';
                                    html +='@foreach ( $facilities as $facility)';
                                        html +='<option value="{{ $facility->id }}">{{ $facility->name }}</option>';
                                    html +='@endforeach';
                                html +='</select>';
                        html +='</div>';
                        html +='<div class="col-3">';
                            html +='<input type="text" name="property_name[]" class="form-control text-left" value="" required>';
                        html +='</div>';
                        html +='<div class="col-2">';
                            html +='<input type="text" name="asset_code[]" class="form-control text-left" value="" required>';
                        html +='</div>';
                        html +='<div class="col-2">';
                            html +='<input type="text" name="device_id[]" class="form-control text-left" value="" required>';
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
        });

        $('select .select2').select2();
    </script>
@endsection

