@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Add New F&B Category</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title">Category Info</h4>
                </div>
                <form action="{{ route('fnbStoreCat') }}" method="POST">
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
                            <label>Category Name</label>
                            <input type="text" name="name" class="form-control" value="" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea rows="4" name="desc" cols="4" class="form-control" placeholder=""></textarea>
                        </div>
                        <div class="form-group">
                            <label>Category Status</label>
                            <div class="c-inputs-stacked">
                                <input name="status" type="radio" id="status_active" value="1" checked>
                                <label for="status_active" class="mr-30">Active</label>
                                <input name="status" type="radio" id="status_inactive" value="0">
                                <label for="status_inactive" class="mr-30">Inactive</label>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-3">
                                <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" onclick="window.location.href='{{route('fnbCat')}}'">Cancel</button>
                            </div>
                            <div class="col-3">
                                <button type="submit" class="btn btn-bold btn-pure btn-info float-right btn-block">Create</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

