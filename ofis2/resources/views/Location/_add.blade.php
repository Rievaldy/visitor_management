@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Add New Location</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title">Location Info</h4>
                </div>
                <form action="{{ route('locationStore') }}" method="POST">
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
                            <label>Location Name</label>
                            <input type="text" name="name" class="form-control" value="" placeholder="">
                        </div>
                        <div class="form-group" id="userDirectorate">
                            <label>Site Name</label>
                            <select name="id_site" class="form-control select2"  data-tags="true">
                                <option value="none" selected disabled>Select Site</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Location Category</label>
                            <div class="c-inputs-stacked">
                                <input name="is_production_area" type="radio" id="category_non_production" value="0" checked >
                                <label for="category_non_production" class="mr-30">Non-Production</label>
                                <input name="is_production_area" type="radio" id="status_inactive" value="1">
                                <label for="status_inactive" class="mr-30">Production</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>NDA Requirement</label>
                            <div class="c-inputs-stacked">
                                <input name="is_need_nda" type="radio" id="category_non_nda" value="0" checked >
                                <label for="category_non_nda" class="mr-30">No Need NDA</label>
                                <input name="is_need_nda" type="radio" id="category_need_nda" value="1">
                                <label for="category_need_nda" class="mr-30">Need NDA</label>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-3">
                                <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" onclick="window.location.href='{{route('locations')}}'">Cancel</button>
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
    <script>
        $.ajax({
            url:"{{route('getsitesSelect2')}}",
            type: 'get',
            dataType: "json",
            success: function(datas) {
                var data = datas
                console.log(data);
                $('select[name=id_site]').select2({data: data}).trigger('change')
            }
        });
    </script>
@endsection
