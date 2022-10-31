@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Dashboard</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="{{ asset('img/under-construction.jpg') }}" class="" style="height: 400px; object-fit: cover" alt="User Image">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script src="{{asset('vendor/highchartjs/highcharts.js')}}"></script>
    <script src="{{asset('vendor/highchartjs/exporting.js')}}"></script>
    <script src="{{asset('vendor/highchartjs/export-data.js')}}"></script>
    <script src="{{asset('vendor/highchartjs/accessibility.js')}}"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
@endsection
