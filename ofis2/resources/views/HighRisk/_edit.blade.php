@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Edit Tool</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title">Tool Info</h4>
                </div>
                <form action="{{ url('high-risk/update/'.$highRisk->id) }}" method="POST" enctype="multipart/form-data" >
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
                            <label>Tool Name</label>
                            <input type="text" name="name" class="form-control" value="{{$highRisk->name}}" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>Tool Description</label>
                            <textarea rows="4" name="description" cols="4" class="form-control" placeholder="">{{$highRisk->description}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Tool Required</label>
                            <select class="form-control select2 tools-select2" name="tools[]" multiple="multiple">
                                @foreach($tools as $tool)
                                    <option value="{{$tool->id}}"
                                    @foreach($highRiskTools as $highRiskTool)
                                        {{($tool->id == $highRiskTool->id_tools ? 'selected': '')}}
                                    @endforeach

                                    >{{$tool->name}}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-3">
                                <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" onclick="window.location.href='{{route('tools')}}'">Cancel</button>
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

