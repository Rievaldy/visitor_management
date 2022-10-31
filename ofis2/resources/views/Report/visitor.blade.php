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
                    <h4 class="box-title">Visitor Report</h4>
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
                        <table class="table" id="dataTable">
                            <thead>
                                <tr class="">
                                    {{-- <th class="">#</th> --}}
                                    <th class="text-nowrap">Date</th>
                                    <th class="text-nowrap">User ID</th>
                                    <th class="text-nowrap">Name</th>
                                    <th class="text-nowrap">Phone Number</th>
                                    <th class="text-nowrap">Company</th>
                                    <th class="text-nowrap">Necessity</th>
                                    <th class="text-nowrap">Visit Time</th>
                                    <th class="text-nowrap">PIC</th>
                                    <th class="text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @php
                                    $no = 1;
                                @endphp --}}
                                @foreach ($datas as $data)
                                    <tr class="">
                                        {{-- <td class="">{{ $no++ }}</td> --}}
                                        <td class="text-nowrap">{{ date('M d, Y', strtotime($data->created_at))}}</td>
                                        <td class="text-nowrap">{{ $data->unix_id }}</td>
                                        <td class="text-nowrap">{{ $data->name }}</td>
                                        <td class="text-nowrap">{{ $data->phone }}</td>
                                        <td class="text-nowrap">{{ $data->company }}</td>
                                        <td class="text-nowrap">{{ $data->necessity }}</td>
                                        <td class="text-nowrap">{{ date('H:i:s', strtotime($data->created_at))}}</td>
                                        <td class="text-nowrap">{{ $data->name_pic }}</td>
                                        <td class="text-nowrap text-center">
                                            <a href="{{ url('report/visitor/view/'.$data->id) }}" class="btn-action" data-toggle="tooltip" data-placement="bottom" title="View">
                                                <i class="ti-eye"></i>
                                            </a>
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

    {{-- modal here --}}
    <div class="modal modal-fill fade" data-backdrop="false" id="modal-detail" tabindex="-1" style="z-index: 9999">
        <div class="modal-dialog modal-lg"">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" style="padding-right: 28px" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box">
                                <div class="box-header">
                                    <h4 class="box-title">View Visitor</h4>
                                </div>
                                <form action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                    <div class="box-body">
                                        <div class="form-group">
                                            <img src="" alt="" id="imgVisitor" class="shadow" style="width: 200px">
                                        </div>
                                        <div class="form-group">
                                            <label>Visitor Name</label>
                                            <input name="name" type="text" class="form-control" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Company</label>
                                            <input name="company" type="text" class="form-control" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Necessity</label>
                                            <input name="necessity" type="text" class="form-control" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>PIC</label>
                                            <input name="name_pic" type="text" class="form-control" value="" placeholder="" readonly>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <div class="row">
                                            <div class="col-3">
                                                <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $('.btn-view').on('click',function(){
        var item = $(this).data('visitor')
        $('#modal-detail').find('#imgVisitor').attr('src',item.img)
        $('#modal-detail').find('input[name=name]').val(item.name)
        $('#modal-detail').find('input[name=necessity]').val(item.necessity)
        $('#modal-detail').find('input[name=phone]').val(item.phone)
        $('#modal-detail').find('input[name=company]').val(item.company)
        $('#modal-detail').find('input[name=name_pic]').val(item.name_pic)
    })

    $(".alert").fadeTo(4000, 500).slideUp(500, function(){
        $(".alert").slideUp(500);
    });
</script>
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
                        title: 'Visitor Report'
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
