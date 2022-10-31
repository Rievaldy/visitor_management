@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Vistor Management</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">List Visitor</h4>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{route('spc.index')}}" target="_blank" class="btn btn-bold btn-pure btn-info">Special Visitor</a>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="mb-4">
                        <div class="form-inline">
                            <div class="form-group">
                                <input type="date" class="form-control form-control-sm" name="t0" id="t0" value="{{ date('Y-m-d')}}">
                            </div>
                            <div class="form-group">
                                To
                            </div>
                            <div class="form-group">
                                <input type="date" class="form-control form-control-sm" name="t1" id="t1" value="{{ date('Y-m-d')}}">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr class="">
                                    <th class="text-center">#</th>
                                    <th class="text-left text-nowrap">Date</th>
                                    <th class="text-left text-nowrap">Time</th>
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
                                {{-- <tr class="">
                                    <td class="text-center">#</td>
                                    <td class="text-left text-nowrap">Date</td>
                                    <td class="text-left text-nowrap">Time</td>
                                    <td class="text-left text-nowrap">Visitor ID</td>
                                    <td class="text-left text-nowrap">Visit Purpose</td>
                                    <td class="text-left text-nowrap">Project Detail</td>
                                    <td class="text-left text-nowrap">Work Area</td>
                                    <td class="text-left text-nowrap">Number Of Worker</td>
                                    <td class="text-left text-nowrap">Findings</td>
                                    <td class="text-center">Action</td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endsection

@section('script')
    <script>
        $('#dataTable').DataTable();
    </script>
@endsection
