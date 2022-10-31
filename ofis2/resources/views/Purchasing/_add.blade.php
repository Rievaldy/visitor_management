@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Add</h3>
    </div>
@endsection

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href='{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}' rel='stylesheet' />
    <link rel="stylesheet" href={{ asset('vendor/kukrik/bootstrap-clockpicker/assets/css/bootstrap-clockpicker.min.css') }}>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title">Add New Project</h4>
                </div>
                <form action="{{ route('purchasingStore') }}" method="POST">
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
                            <label>Project Name</label>
                            <input type="text" name="name" class="form-control" value="" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>Company Name</label>
                            <input type="text" name="name_company" id="companyName" class="form-control" value="" placeholder="">
                            <input type="hidden" class="" name="id_company" id="companyId">
                        </div>
                        <div class="form-group">
                            <label>email</label>
                            <input type="email" name="visitor_email" class="form-control" value="" placeholder="">
                        </div>
                        <div class="form-group" >
                            <label>Form Category</label>
                            <select name="type" class="form-control select2"  data-tags="true">
                                <option value="none" disabled selected>Select Category</option>
                                <option value="1" >Normal Visitor</option>
                                <option value="2" >Vendor/Contractor</option>
                                <option value="3" >Special Visitor</option>
                            </select>
                        </div>
                        <div class="form-group" >
                            <label>Site Name</label>
                            <select name="id_site" class="form-control select2"  data-tags="true">
                                <option value="none" selected disabled>Select Site</option>
                            </select>
                        </div>
                        <div class="form-group" >
                            <label>Location Name</label>
                            <select name="id_location" class="form-control select2"  data-tags="true">
                                <option value="none" selected disabled>Select Location</option>
                            </select>
                        </div>
                        <div class="form-group" >
                            <label>Area Name</label>
                            <select name="id_area" class="form-control select2"  data-tags="true">
                                <option value="none" selected disabled>Select Area</option>
                            </select>
                        </div>
                        <div hidden id="date_template_single" class="form-group">
                            <label>Date</label>
                            <input id="calendar" name="date_start" type="date" class="form-control form-control-sm" name="date_meet" value="{{ date('Y-m-d')}}">
                        </div>
                        <div hidden id="date_template_double">
                            <label>Date</label>
                            <div class="row align-items-center">
                                <div class="col-sm-5 col-5">
                                    <input id="calendar" name="date_start" type="date" class="form-control form-control-sm" name="date_meet" value="{{ date('Y-m-d')}}">
                                </div>
                                <div class="col-sm-2 col-2 align-center">
                                    <p class="mb-0">Until</p>
                                </div>
                                <div class="col-sm-5 col-5">
                                    <input id="calendar" name="date_end" type="date" class="form-control form-control-sm" name="date_meet" value="{{ date('Y-m-d')}}">
                                </div>
                            </div>
                        </div>
                        <div hidden id="time_template">
                            <label>Meeting time</label>
                            <div class="row align-items-center">
                                <div class="col-sm-5 col-5">
                                    <div class="input-group clockpicker" data-placement="right" data-align="top" data-autoclose="true">
                                        <input name="time_start" type="text" class="form-control" value="{{ date('H:i')}}">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-2 align-center">
                                    <p class="mb-0">Until</p>
                                </div>
                                <div class="col-sm-5 col-5">
                                    <div class="input-group clockpicker" data-placement="right" data-align="top" data-autoclose="true">
                                        <input name="time_end" type="text" class="form-control" value="{{ date('H:i')}}">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-3">
                                <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" onclick="window.location.href='{{route('purchasing')}}'">Cancel</button>
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
@section('script')

    <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script  src="{{ asset('vendor/kukrik/bootstrap-clockpicker/assets/js/bootstrap-clockpicker.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{route('getsitesSelect2')}}",
                type: 'get',
                dataType: "json",
                success: function (datas) {
                    var data = datas
                    $('select[name=id_site]').select2({data: data}).trigger('change')
                }
            });
            $.ajax({
                url: "{{route('getCompanySelect2')}}",
                type: 'get',
                dataType: "json",
                data: {
                    id: this.value
                },
                success: function (datas) {
                    var data = datas;
                    $('select[name=id_company]').select2({data: data});
                },
            });
        });

        $('select[name=type]').on('change',function(){
            let val = $('select[name=type]').find(':selected').val();
            console.log(val);
            if(val == 1){
                $("#date_template_single").attr("hidden",true);
                $("#date_template_double").attr("hidden",true);
                $("#time_template").attr("hidden",true);
            }else if(val == 2){
                $("#date_template_single").attr("hidden",true);
                $("#date_template_double").attr("hidden",false);
                $("#time_template").attr("hidden",true);
            }else{
                $("#date_template_single").attr("hidden",false);
                $("#date_template_double").attr("hidden",true);
                $("#time_template").attr("hidden",false);
            }
        })

        $('select[name=id_company]').on('change',function(){
            let val = $('select[name=id_company]').find(':selected').text();
            $('input[name=name_company]').val(val);
        })

        $('select[name=id_site]').on('change',function(){
            {
                $.ajax({
                    url:"{{route('getLocationSelect2')}}",
                    type: 'get',
                    dataType: "json",
                    data:{
                        id:this.value
                    },
                    success: function(datas) {
                        var data = datas
                        $('select[name=id_location]').empty();
                        $('select[name=id_area]').empty();
                        $('select[name=id_location]').select2({data: data}).trigger('change')
                    }
                });
            }
        });
        $('select[name=id_location]').on('change',function(){
            {
                $.ajax({
                    url:"{{route('getAreaSelect2')}}",
                    type: 'get',
                    dataType: "json",
                    data:{
                        id:this.value
                    },
                    success: function(datas) {
                        var data = datas
                        $('select[name=id_area]').empty();
                        $('select[name=id_area]').select2({data: data}).trigger('change')
                    },
                });
            }
        });


        $('.clockpicker').clockpicker()
            .find('input').change(function(){
            // TODO: time changed
        });

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).on('keydown.autocomplete', '#companyName', function() {
            var parent  = $(this).closest('.form-group')
            // console.log(parent)
            $( this ).autocomplete({
                source: function( request, response ) {
                    console.log(request.term)
                    $.ajax({
                        url:"{{route('postCompanyName')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            cari: request.term
                        },
                        success: function( data ) {
                            console.log(data)
                            response( data );
                        }
                    });
                },
                select: (event, ui) => {
                    parent.find('#companyName').val(ui.item.name);
                    parent.find('#companyId').val(ui.item.id);
                    return false;
                }
            });
        });

    </script>
@endsection
