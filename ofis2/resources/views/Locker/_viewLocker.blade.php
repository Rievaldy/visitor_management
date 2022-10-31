@extends('master')

@section('head')
    <link rel="stylesheet" href="{{ asset('vendor/dropzone/dropzone.css') }}">
@endsection

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Smart Lockers</h3>
    </div>
@endsection

@section('content')
    {{-- <form action="{{ url('rooms/update/'.$rooms->id) }}" method="POST" enctype="multipart/form-data"> --}}
        {{-- @csrf --}}
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
                            <label>Pick up location</label>
                            <div class="row">
                                <div class="col-6">
                                    <input name="name" type="text" class="form-control" disabled value="{{ $data[0]->lat }}">
                                </div>
                                <div class="col-6">
                                    <input name="name" type="text" class="form-control" disabled value="{{ $data[0]->longs }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>ID Locker</label>
                            <div class="row">
                                <div class="col-6">
                                    <input name="capacity" type="text" class="form-control" disabled value="{{ $data[0]->id_locker }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>PIC</label>
                            @foreach ($pic as $name )
                                @if ($data[0]->pic_id == $name->id)
                                    <input type="text" class="form-control" disabled value="{{ $name->name }}">
                                @endif
                            @endforeach
                        </div>
                        <div class="form-group">
                            <label>Pick up necessity</label>
                            <div class="c-inputs-stacked">
                                <input name="is_ds_reader" type="radio" id="document" value="1" disabled {{ $data[0]->necessity==1?'checked':'' }}>
                                <label for="document" class="mr-30">Document</label><br>
                                <input name="is_ds_reader" type="radio" id="stationary" value="2" disabled {{ $data[0]->necessity==2?'checked':'' }}>
                                <label for="stationary" class="mr-30">Stationary</label><br>
                                <input name="is_ds_reader" type="radio" id="apparel" value="3" disabled {{ $data[0]->necessity==3?'checked':'' }}>
                                <label for="apparel" class="mr-30">Document</label><br>
                                <input name="is_ds_reader" type="radio" id="other" value="4" disabled {{ $data[0]->necessity==4?'checked':'' }}>
                                <label for="other" class="mr-30">Others</label>

                            </div><br>
                            <div class="row">
                                <div class="col-10">
                                    @if ($data[0]->description != null)
                                        <input type="text" class="form-control" value="{{ $data[0]->description }}" disabled>
                                    @else
                                        <input type="text" class="form-control" disabled>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Open Method</label>
                            <div class="row">
                                <div class="col-3">
                                    <input type="radio" id="method" name="method"  disabled {{ $data[0]->method==1?'checked':'' }}>
                                    <label for="method">Application</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Notes</label>
                            <input type="text" name="" class="form-control" disabled value="{{ $data[0]->notes }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">Meeting Room Photo</h4>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-10">
                                @if ($data[0]->img != null)
                                    <img src="{{ $data[0]->img }}" alt="">
                                @else
                                    No image uploaded
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-10">
                                <input type="file" name="img" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                    <div class="col-sm-6">
                        <div class="row">
                            @if ($data[0]->status == 1)
                                <div class="col-3">
                                    <div class="form-group">
                                        <a href="{{ url('locker-list') }}" type="button" class="btn btn-bold btn-pure btn-secondary btn-block">Back</a>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <form action="{{ url('locker-list/view/reject/'.$data[0]->id) }}" method="POST">
                                        @csrf
                                            <button type="submit" class="btn btn-bold btn-pure btn-danger btn-block">Reject</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <form action="{{ url('locker-list/view/approved/'.$data[0]->id) }}" method="POST">
                                        @csrf
                                            <button type="submit" class="btn btn-bold btn-pure btn-success btn-block">Approve</button>
                                        </form>
                                    </div>
                                </div>
                                
                                {{-- <div class="col-3">
                                    <div class="form-group">
                                        <form action="{{ url('locker-list/view/approved/'.$data[0]->id) }}" method="POST">
                                        @csrf
                                            <button type="submit" class="btn btn-bold btn-pure btn-info btn-block">Approve</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <form action="{{ url('locker-list/view/reject/'.$data[0]->id) }}" method="POST" onsubmit="return confirm('Are you sure? This record and its details will be rejected!')">
                                        @csrf
                                            <button type="submit" class="btn btn-bold btn-pure btn-danger btn-block">Reject</button>
                                        </form>
                                    </div>
                                </div> --}}
                            @elseif ($data[0]->status == 3)
                               <div class="col-3">
                                    <div class="form-group">
                                        <a href="{{ url('locker-list') }}" type="button" class="btn btn-bold btn-pure btn-secondary btn-block">Back</a>
                                    </div>
                                </div> 
                            @else
                                <div class="col-3">
                                    <div class="form-group">
                                        <a href="{{ url('locker-list') }}" type="button" class="btn btn-bold btn-pure btn-secondary btn-block">Back</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
        </div>
    {{-- </form> --}}
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

