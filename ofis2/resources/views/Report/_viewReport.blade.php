@extends('master')

@section('head')
    <link href='{{ asset('vendor/fullcalendar-3.10.2/fullcalendar.min.css') }}' rel='stylesheet' />
    <link href='{{ asset('vendor/bootstrap-datepicker/css/scheduler.min.css') }}' rel='stylesheet' />
    <link href='{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}' rel='stylesheet' />


@endsection

@section('content')
    <div class="modal" data-backdrop="false" tabindex="-1" id="exampleModal" style="z-index: 9999; background: #fff;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="box-shadow: none">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box">
                                <div class="box-header">
                                    <h4 class="box-title">View Visitor</h4><br>
                                </div>
                                <form action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                    @foreach ($datas as $data)
                                    <div class="box-body">
                                        <div class="form-group">
                                            {{-- <img src="{{ $room_image[0]->img }}" alt=""> --}}
                                            <img src="{{ $data->img }}" alt="" class="shadow" style="width: 200px">
                                        </div>
                                        <div class="form-group">
                                            <label>Visitor Name</label>
                                            <input name="name" type="text" class="form-control" value="{{ $data->name }}" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Company</label>
                                            <input name="company" type="text" class="form-control" value="{{ $data->company }}" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Necessity</label>
                                            <input name="necessity" type="text" class="form-control" value="{{ $data->necessity }}" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>PIC</label>
                                            <input name="pic_name" type="text" class="form-control" value="{{ $data->name_pic }}" placeholder="" readonly>
                                        </div>
                                    </div>
                                    @endforeach
                                </form>
                                <div class="box-footer">
                                    <div class="row">
                                        <div class="col-3">
                                            <a href="{{ url('report/visitor') }}" type="button" class="btn btn-bold btn-pure btn-secondary btn-block">Close</a>
                                            {{-- <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" data-dismiss="modal">Close</button> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src='https://cdn.jsdelivr.net/npm/moment@2.24.0/min/moment.min.js'></script>
    <script src='{{ asset('vendor/fullcalendar-3.10.2/fullcalendar.min.js') }}'></script>
    {{-- <script src='{{ asset('vendor/fullcalendar-3.10.2/scheduler.min.js') }}'></script> --}}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@1.10.1/dist/scheduler.min.js'></script>
    <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#exampleModal').show();
        });
        function closeModal(){
            $('#exampleModal').hide();
        }
    </script>
@endsection
