@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Set Meeting Reminder</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-sm-6">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-12 text-left">
                            <h4 class="box-title">Set Reminder Info</h4>
                        </div>
                        {{-- <div class="col-6 text-right">
                            <h4 class="box-title text-success">OPEN</h4>
                        </div> --}}
                    </div>
                </div>
                <form action="{{ url('set-reminder-parameter/update/'.$configs[0]->id) }}" method="POST" >
                @csrf
                    <div class="box-body">
                        @if(session('errors'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Something it's wrong:
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
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Reminder Minute</label>
                                    <input type="text" name="min" class="form-control" value="{{$configs[0]->min}}">
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="">You can set a reminder time to users in minutes via Auto Control if the meeting time will be end.</p>
                                <small class="form-text text-muted">Last update at {{ date('M d, Y h:i:s', strtotime($configs[0]->updated_at)) }}.</small>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-3">
                                <button type="submit" class="btn btn-bold btn-pure btn-info float-right btn-block">Update</button>
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
        $(".alert").fadeTo(4000, 500).slideUp(500, function(){
            $(".alert").slideUp(500);
        });
    </script>
@endsection
