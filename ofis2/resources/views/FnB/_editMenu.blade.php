@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Edit Menu</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title">Menu Info</h4>
                </div>
                <form method="POST" action="{{ url('foodandbaverages/menu/update/'.$menus->id) }}">
                @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $menus->name}}" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select name="id_cat" class="form-control select2">
                                <option value="" selected disabled>Select Category</option>
                                @foreach($cats as $cat)
                                    <option value="{{ $cat->id}}" {{$menus->id_cat == $cat->id  ? 'selected' : ''}}>{{ $cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea rows="4" cols="4" name="desc" class="form-control" placeholder="">{{$menus->desc}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Menu Status</label>
                            <div class="c-inputs-stacked">
                                <input name="status" type="radio" id="status_active" value="1" {{$menus->status == 1 ? 'checked' : '' }}>
                                <label for="status_active" class="mr-30">Active</label>
                                <input name="status" type="radio" id="status_inactive" value="0" {{$menus->status == 0 ? 'checked' : '' }}>
                                <label for="status_inactive" class="mr-30">Inactive</label>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-3">
                                <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" onclick="window.location.href='{{route('fnbMenu')}}'">Cancel</button>
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

