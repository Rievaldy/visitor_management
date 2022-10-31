@extends('master')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
@endsection

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Report</h3>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title">Attendance Report</h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <div class="row">
                            <div class="col-sm-2 col-6">
                                <div class="form-group mb-0">
                                    <label for="">From</label>
                                    <input type="text" class="form-control form-control-sm date-range-filter" placeholder="Date Start" data-date-format="mm-dd-yyyy" id="min" />
                                </div>
                            </div>
                            <div class="col-sm-2 col-6">
                                <div class="form-group mb-0">
                                    <label for="">To</label>
                                    <input type="text" class="form-control form-control-sm date-range-filter" placeholder="Date End" data-date-format="mm-dd-yyyy" id="max"/>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table" id="dataTable">
                                <thead>
                                    <tr class="">
                                        {{-- <th class="">#</th> --}}
                                        <th class="text-nowrap">Date</th>
                                        <th class="text-nowrap">Employee ID</th>
                                        <th class="text-nowrap">Employee Name</th>
                                        <th class="text-nowrap">Check In</th>
                                        <th class="text-nowrap">Attendance</th>
                                        <th class="text-nowrap">Reasons</th>
                                        <th class="text-nowrap">Description</th>
                                        <th class="text-nowrap">Check Out</th>
                                        <th class="text-nowrap">Attendance</th>
                                        <th class="text-nowrap">Reasons</th>
                                        <th class="text-nowrap">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @php
                                        $no = 1;
                                    @endphp --}}
                                    @foreach ($datas as $data)
                                        <tr class="">
                                            {{-- <td class="">{{ $no++ }}</td> --}}
                                            <td class="text-nowrap">{{ $data->date }}</td>
                                            <td class="text-nowrap">{{ $data->employee_id }}</td>
                                            <td class="text-nowrap">{{ $data->name }}</td>
                                            <td class="text-nowrap">
                                                {{ date('H:i:s', strtotime($data->masuk_time)) }}
                                            </td>
                                            <td class="">
                                                @if ($data->masuk_status == 1)
                                                    Online
                                                @elseif ($data->keluar_status == 9)
                                                    Offline
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($data->reasonsin != null)
                                                    @if ($data->reasonsin == 1)
                                                        WFH
                                                    @elseif ($data->reasonsin == 2)
                                                        Meeting
                                                    @elseif ($data->reasonsin == 3)
                                                        Training
                                                    @elseif ($data->reasonsin == 4)
                                                        Journey
                                                    @elseif ($data->reasonsin == 5)
                                                        Depo
                                                    @elseif ($data->reasonsin == 6)
                                                        Station
                                                    @elseif ($data->reasonsin == 7)
                                                        Others
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($data->descriptionin != null)
                                                    {{ $data->descriptionin }}
                                                @else  
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-nowrap">
                                                {{-- @if ($data->keluar_time!=null)
                                                    {{ date('H:i:s', strtotime($data->keluar_time)) }}
                                                @else
                                                    -
                                                @endif --}}
                                                @if ($data->keluar_time != $data->masuk_time)
                                                    @if ($data->keluar_time != null)
                                                        {{ date('H:i:s', strtotime($data->keluar_time)) }}
                                                    @else
                                                        -
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="">
                                                @if ($data->keluar_time != $data->masuk_time)
                                                    @if ($data->keluar_time != null)
                                                        @if ($data->keluar_status == 2)
                                                            Online
                                                        @elseif ($data->keluar_status == 9)
                                                            Offline
                                                        @else
                                                            -
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($data->reasonsout != null)
                                                    @if ($data->reasonsout == 1)
                                                        WFH
                                                    @elseif ($data->reasonsout == 2)
                                                        Meeting
                                                    @elseif ($data->reasonsout == 3)
                                                        Training
                                                    @elseif ($data->reasonsout == 4)
                                                        Journey
                                                    @elseif ($data->reasonsout == 5)
                                                        Depo
                                                    @elseif ($data->reasonsout == 6)
                                                        Station
                                                    @elseif ($data->reasonsout == 7)
                                                        Others
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($data->descriptionout != null)
                                                    {{ $data->descriptionout }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                dom: 'Bfrtip',
                bSort: false,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Download Report',
                        title: 'Attendance Report'
                    },
                ],
            });
            $('.input-daterange input').each(function() {
            $(this).datepicker('clearDates');
            });

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var min = $('#min').val();
                    var max = $('#max').val();
                    var createdAt = data[0];

                    if (
                    (min == "" || max == "") ||
                    (moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max))
                    ) {
                    return true;
                    }
                    return false;
                }
            );

            $('.date-range-filter').change(function() {
                table.draw();
            });


            $('.date-range-filter').datepicker({
                // format: 'dd/mm/yyyy',
                format: 'M d yyyy',
                todayHighlight:'TRUE',
                autoclose: true,
            });
        });
    </script>
@endsection
