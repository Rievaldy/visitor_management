@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Edit Area</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title">Area Info</h4>
                </div>
                <form action="{{ url('areas/update/'.$area->id) }}" method="POST">
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
                            <label>Area Name</label>
                            <input type="text" name="name" class="form-control" value="{{$area->name}}" placeholder="">
                        </div>
                        <div class="form-group" id="siteName">
                            <label>Site Name</label>
                            <select name="id_site" class="form-control select2" data-tags="true">
                                @foreach ($sites as $site)
                                    <option value="{{ $site->id }}" {{ $site->id == $area->id_site ? 'selected' : '' }}>{{ $site->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="siteName">
                            <label>Location Name</label>
                            <select name="id_location" class="form-control select2" data-tags="true">
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}" {{ $location->id == $area->id_location ? 'selected' : '' }}>{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Confidential Category</label>
                            <div class="c-inputs-stacked">
                                <input name="cat_confidential" type="radio" id="non-restricted" value="1" {{$area->cat_confidential == 1 ? 'checked' : '' }} >
                                <label for="non-restricted" class="mr-30">Non-Restricted</label>
                                <input name="cat_confidential" type="radio" id="cat-strictly" value="2" {{$area->cat_confidential == 2 ? 'checked' : '' }}>
                                <label for="cat-strictly" class="mr-30">Strictly Area</label>
                                <input name="cat_confidential" type="radio" id="cat-restricted" value="3" {{$area->cat_confidential == 3 ? 'checked' : '' }}>
                                <label for="cat-restricted" class="mr-30">Restricted Area</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Risk Not Working</label>
                            <div class="c-inputs-stacked">
                                <input name="risk_not_work" type="radio" id="risk-not-work-low" value="1" {{$area->risk_not_work == 1 ? 'checked' : '' }} >
                                <label for="risk-not-work-low" class="mr-30">LOW</label>
                                <input name="risk_not_work" type="radio" id="risk-not-work-med" value="2" {{$area->risk_not_work == 2 ? 'checked' : '' }}>
                                <label for="risk-not-work-med" class="mr-30">MEDIUM</label>
                                <input name="risk_not_work" type="radio" id="risk-not-work-high" value="3" {{$area->risk_not_work == 3 ? 'checked' : '' }}>
                                <label for="risk-not-work-high" class="mr-30">HIGH</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Risk Working</label>
                            <div class="c-inputs-stacked">
                                <input name="risk_work" type="radio" id="risk-work-low" value="1" {{$area->risk_work == 1 ? 'checked' : '' }} >
                                <label for="risk-work-low" class="mr-30">LOW</label>
                                <input name="risk_work" type="radio" id="risk-work-med" value="2" {{$area->risk_work == 2 ? 'checked' : '' }}>
                                <label for="risk-work-med" class="mr-30">MEDIUM</label>
                                <input name="risk_work" type="radio" id="risk-work-high" value="3" {{$area->risk_work == 3 ? 'checked' : '' }} >
                                <label for="risk-work-high" class="mr-30">HIGH</label>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-3">
                                <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" onclick="window.location.href='{{route('locations')}}'">Cancel</button>
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
                    $('select[name=id_location]').select2({data: data}).trigger('change')
                }
            });
        }
    });
</script>
@endsection
