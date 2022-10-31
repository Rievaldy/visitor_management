@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Edit Purpose Category</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title">Purpose Category Info</h4>
                </div>
                <form action="{{ url('purpose/update/'.$purpose->id) }}" method="POST">
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
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{$purpose->name}}" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea rows="4" name="description" cols="4" class="form-control" placeholder="">{{$purpose->description}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <div class="row align-items-center">
                                <div class="col-sm-12 col-12">
                                    <select name="category" class="select2" style="width: 100%">
                                        <option value="none" disabled>Purpose Category</option>
                                        <option value="1" {{ $purpose->category == 1 ? 'selected' : '' }}>Normal Visitor</option>
                                        <option value="2" {{ $purpose->category == 2 ? 'selected' : '' }}>Vendor/Contractor</option>
                                        <option value="3" {{ $purpose->category == 3 ? 'selected' : ''}}>Special Visitor</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-3">
                                <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" onclick="window.location.href='{{route('purpose')}}'">Cancel</button>
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

