@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Visitor Management</h3>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-9 text-left">
                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link btn-tabs-custom active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Today Visitors</a>
                                </li>
                                <li class="nav-item ml-4">
                                    <a class="nav-link btn-tabs-custom" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">All Visitors</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-3 text-right">
                            <a href="{{ route('visitorView') }}" target="_blank" class="btn btn-bold btn-pure btn-info">View VMS</a>
                        </div>
                    </div><br>
                    {{-- <div class="row">
                        <div class="col-sm-12 text-left">
                            <form action="" method="GET" class="form-inline">
                                <div class="form-group">
                                    <input type="date" class="form-control form-control-sm" name="start_date" max="<?= date('Y-m-d'); ?>" value="{{ $sDate }}">
                                </div>
                                <div class="form-group">
                                    To
                                </div>
                                <div class="form-group">
                                    <input type="date" class="form-control form-control-sm" max="<?= date('Y-m-d'); ?>" name="end_date" value="{{ $eDate }}">
                                </div>
                                <button type="submit" class="btn btn-bold btn-pure btn-info">Filter</button>
                            </form>
                        </div>
                    </div> --}}
                </div>
                <div class="box-body">
                    <a href="{{url('visitor-export')}}">export</a>
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
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            {{ Session::get('error') }}
                        </div>
                    @endif
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="table-responsive">
                                <table class="table table-striped dataTables">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-left text-nowrap">Date</th>
                                            <th class="text-left text-nowrap">Visitor ID</th>
                                            <th class="text-left text-nowrap">Visit Purpose</th>
                                            <th class="text-left text-nowrap">Project Detail</th>
                                            <th class="text-left text-nowrap">Work Area</th>
                                            <th class="text-left text-nowrap">Number Of Worker</th>
                                            <th class="text-left text-nowrap">Findings</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="table-responsive">
                                <table class="table table-striped dataTables">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-left text-nowrap">Date</th>
                                            <th class="text-left text-nowrap">Visitor ID</th>
                                            <th class="text-left text-nowrap">Visit Purpose</th>
                                            <th class="text-left text-nowrap">Project Detail</th>
                                            <th class="text-left text-nowrap">Work Area</th>
                                            <th class="text-left text-nowrap">Number Of Worker</th>
                                            <th class="text-left text-nowrap">Findings</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal here --}}
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
                        <div class="col-sm-12">
                            <div class="box">
                                <div class="box-header">
                                    <h4 class="box-title">View Visitor</h4>
                                </div>
                                <form action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                    <div class="box-body">
                                        <div class="form-group">
                                            <img src="" alt="" id="imgVisitor" class="shadow" style="width: 200px">
                                        </div>
                                        <div class="form-group">
                                            <label>Visitor Name</label>
                                            <input name="name" type="text" class="form-control" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Company</label>
                                            <input name="company" type="text" class="form-control" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Necessity</label>
                                            <input name="necessity" type="text" class="form-control" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>PIC</label>
                                            <input name="pic_name" type="text" class="form-control" value="" placeholder="" readonly>
                                        </div>
                                        {{-- <div class="form-group">
                                            <label>Date TIme</label>
                                            <input name="created_at" type="text" class="form-control" value="" placeholder="" readonly>
                                        </div> --}}
                                    </div>
                                    <div class="box-footer">
                                        <div class="row">
                                            <div class="col-3">
                                                <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" data-dismiss="modal">Close</button>
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
    <script>

    </script>
@endsection

