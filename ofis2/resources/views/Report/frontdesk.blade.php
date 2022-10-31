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
                    <h4 class="box-title">Frontdesk Report</h4>
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
                                        <th class="text-nowrap">Request Date</th>
                                        <th class="text-nowrap">Request Time</th>
                                        <th class="text-nowrap">Room Name</th>
                                        <th class="text-nowrap">Meeting Start</th>
                                        <th class="text-nowrap">Meeting End</th>
                                        <th class="text-nowrap">Message</th>
                                        <th class="text-nowrap">Request Status</th>
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
                                            <td class="text-nowrap">{{ $data->time }}</td>
                                            <td class="text-nowrap">{{ $data->room }}</td>
                                            <td class="text-nowrap">{{ $data->start }}</td>
                                            <td class="text-nowrap">{{ $data->end }}</td>
                                            <td class="text-nowrap">{{ $data->end }}</td>
                                            <td class="text-nowrap">{{ $data->status }}</td>
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
                        title: 'Frontdesk Report'
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
