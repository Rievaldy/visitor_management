@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Edit Property</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title">Property Info</h4>
                </div>
                <form action="{{ url('facilities/update/'.$facilities->id) }}" method="POST">
                @csrf
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
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        @if (Session::has('error'))
                            <div class="alert alert-danger">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                        <div class="form-group">
                            <label>Property Code</label>
                            <input name="code" type="text" class="form-control" value="{{$facilities->code}}" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>Property Name</label>
                            <input name="name" type="text" class="form-control" value="{{$facilities->name}}" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select name="id_cat" class="form-control select2">
                                <option value="" selected disabled>Select Category</option>
                                @foreach($cats as $cat)
                                    <option value="{{ $cat->id}}" {{$facilities->id_cat == $cat->id  ? 'selected' : ''}}>{{ $cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="form-group">
                            <label>Asset Code</label>
                            <input name="code_asset" type="text" class="form-control" value="{{ $facilities->code_asset}}" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input name="qty" type="number" class="form-control" value="{{ $facilities->qty}}" placeholder="">
                        </div> --}}
                        <div class="form-group">
                            <label>Controllable</label>
                            <select name="is_control" id="selectControl" class="form-control select2">
                                <option value="1" {{$facilities->is_control == 1  ? 'selected' : ''}}>Yes</option>
                                <option value="0" {{$facilities->is_control == 0  ? 'selected' : ''}}>No</option>
                            </select>
                            <div id="showControl"></div>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="desc" rows="4" cols="4" class="form-control" placeholder="">{{$facilities->desc}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Property Status</label>
                            <div class="c-inputs-stacked">
                                <input name="status" type="radio" id="status_active" value="1" {{$facilities->status == 1 ? 'checked' : '' }}>
                                <label for="status_active" class="mr-30">Active</label>
                                <input name="status" type="radio" id="status_inactive" value="0" {{$facilities->status == 0 ? 'checked' : '' }}>
                                <label for="status_inactive" class="mr-30">Inactive</label>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-3">
                                <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" onclick="window.location.href='{{route('facilities')}}'">cancel</button>
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
@endsection

@section('script')
    <script>
        $('#selectControl').on('change', function() {
            if(this.value == 1) {
                $('#showControl').load('/control-type', function () {
                    $('.select2').select2();
                });
            } else {
                $("#showControl").empty();
            }
        });
    </script>
@endsection

