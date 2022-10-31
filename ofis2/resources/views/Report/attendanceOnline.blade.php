@extends('master')

@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.1/css/dataTables.dateTime.min.css">
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
                    <h4 class="box-title">Attendance Online Report</h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <div class="row">
                            <div class="col-sm-2 col-6">
                                <div class="form-group mb-0">
                                    <label for="">From</label>
                                    <input type="text" class="form-control" id="min" name="min" value="" placeholder="Start Date">
                                </div>
                            </div>
                            <div class="col-sm-2 col-6">
                                <div class="form-group mb-0">
                                    <label for="">To</label>
                                    <input type="text" class="form-control" id="max" name="max" value="" placeholder="End Date">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table" id="dataTable">
                                <thead>
                                    <tr class="">
                                        {{-- <th class="text-nowrap">#</th> --}}
                                        <th class="text-nowrap">Date</th>
                                        <th class="text-nowrap">Employee ID</th>
                                        <th class="text-nowrap">Employee Name</th>
                                        <th class="text-nowrap">Check In</th>
                                        <th class="text-nowrap">Check Out</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @php
                                        $no = 1;
                                    @endphp --}}
                                    @foreach ($datas as $data)
                                        <tr class="">
                                            {{-- <td class="text-nowrap">{{ $no++ }}</td> --}}
                                            <td class="text-nowrap">{{ $data->date }}</td>
                                            <td class="text-nowrap">{{ $data->employee_id }}</td>
                                            <td class="text-nowrap">{{ $data->name }}</td>
                                            <td class="text-nowrap">{{ $data->checkin }}</td>
                                            <td class="text-nowrap">
                                                @if ($data->checkout != $data->checkin)
                                                    {{ $data->checkout }}
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
    <script>
        var minDate, maxDate;
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var min = minDate.val();
                var max = maxDate.val();
                var date = new Date( data[0] );

                if (
                    ( min === null && max === null ) ||
                    ( min === null && date <= max ) ||
                    ( min <= date   && max === null ) ||
                    ( min <= date   && date <= max )
                ) {
                    return true;
                }
                return false;
            }
        );

        // Create date inputs
        minDate = new DateTime($('#min'), {
            format: 'MMM D YYYY'
        });
        maxDate = new DateTime($('#max'), {
            format: 'MMM D YYYY'
        });

        // DataTables initialisation
        var table = $('#dataTable').DataTable({
            dom: 'Bfrtip',
            bSort: false,
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Download Report',
                    title: 'Attendance Online Report'
                },
            ],
            // order: [[ 0, "desc" ]]
        });

        // Refilter the table
        $('#min, #max').on('change', function () {
            table.draw();
        });
    </script>
@endsection
