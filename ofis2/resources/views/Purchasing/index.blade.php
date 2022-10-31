@extends('master')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">PIC Project/Purchasing</h3>
    </div>
@endsection


@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            {{-- <h4 class="box-title">Attendance ({{$monthName}}, {{$year}})</h4> --}}
                            <h4 class="box-title">List Visitor</h4>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    {{-- <div class="box-header"> --}}
                        <div class="row">
                            {{-- <div class="col-sm-12 text-left">
                                <h4 class="box-title mb-4">My Attendance</h4>
                            </div> --}}
                            <div class="col-sm-10 text-left">
                                <form action="" method="GET" class="form-inline">
                                    <div class="form-group">
                                        <input type="date" class="form-control form-control-sm" name="start_date" value="{{ date('Y-m-d');}}">
                                    </div>
                                    <div class="form-group">
                                        To
                                    </div>
                                    <div class="form-group">
                                        <input type="date" class="form-control form-control-sm" name="end_date" value="{{ date('Y-m-d');}}">
                                    </div>
                                    <button type="submit" class="btn btn-bold btn-pure btn-info">Filter</button>
                                </form>
                            </div>
                            <div class="col-sm-2 text-right">
                                <a href="{{ route('purchasingAdd') }}"  id="register" class="col-sm-12 btn btn-bold btn-pure btn-info">Register</a>
                            </div>
                        </div><br>
                    {{-- </div> --}}
                    <div class="flash-message"></div>
                    <div class="table-responsive-lg dataTables_scroll">
                        <table id="data-tables" class="table table-striped table-bordered " style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-wrap">Date From</th>
                                <th class="text-wrap">Time</th>
                                <th class="text-wrap">Visitor Type</th>
                                <th class="text-wrap">Visitor Coordinator</th>
                                <th class="text-wrap">Visitor Purpose</th>
                                <th class="text-wrap">Project Detail</th>
                                <th class="text-wrap">Progress</th>
                                <th class="text-wrap text-center">Reject Reason</th>
                                <th class="text-wrap text-center">Findings</th>
                                <th class="text-wrap">Status</th>
                                <th class="text-wrap text-center">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="confirm-delete" class="modal fade"  data-backdrop="false" tabindex="-1" style="z-index: 9999">
        <div class="modal-dialog modal-confirm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row col-12">
                        <div class="col-12">
                            <div class="icon-box">
                                <i class="material-icons center">&#xE5CD;</i>
                            </div>
                        </div>
                        <div class="col-12">
                            <h4 class="modal-title">Are you sure?</h4>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <p>Do you really want to approve these project?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger btn-delete">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src='https://cdn.jsdelivr.net/npm/moment@2.24.0/min/moment.min.js'></script>
    <script src="https://cdn.rawgit.com/ashl1/datatables-rowsgroup/fbd569b8768155c7a9a62568e66a64115887d7d0/dataTables.rowsGroup.js"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>
        function MergeGridCells(TableID,rCols) {
            var dimension_cells = new Array();
            var dimension_col = null;
            for(Col in rCols) {
                console.log(Col);
                dimension_col=rCols[Col];
                // first_instance holds the first instance of identical td
                var first_Hash="";
                var first_instance = null;
                var rowspan = 1;
                // iterate through rows
                $("#"+TableID+"> tbody > tr").children("td").attr('hidden', false);
                $("#"+TableID+"> tbody > tr").children("td").attr('rowspan', 1);
                $("#"+TableID).find('tr').each(function () {
                    // find the td of the correct column (determined by the dimension_col set above)
                    var dimension_td = $(this).find('td:nth-child(' + dimension_col + ')');
                    var dim_Hash="";
                    for(x=1;x<dimension_col;x++){
                        dim_Hash+=$(this).find('td:nth-child(' + x + ')').text();
                    }
                    if (first_instance === null) {
                        // must be the first row
                        first_instance = dimension_td;
                    } else if (dimension_td.text() === first_instance.text() && first_Hash === dim_Hash) {
                        // the current td is identical to the previous AND the Hashes are as well
                        // remove the current td
                        // dimension_td.remove();
                        dimension_td.attr('hidden', true);
                        ++rowspan;
                        // increment the rowspan attribute of the first instance
                        first_instance.attr('rowspan', rowspan);
                    } else {
                        // this cell is different from the last
                        first_instance = dimension_td;
                        first_Hash = dim_Hash;
                        rowspan = 1;
                    }
                });
            }
        }
        $(document).ready(function () {
            jQuery('.dataTable').wrap('<div class="dataTables_scroll" />');

            $('#data-tables').DataTable({

                processing: true,
                rowsGroup: [3],
                serverSide: true,
                "autoWidth": false,
                "responsive": true,
                "order": [[ 1, 'asc' ]],
                ajax: "{{route('getAllPurchasing')}}",
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var info = $(this).DataTable().page.info();
                    $("td:nth-child(1)", nRow).html(info.start + iDisplayIndex + 1);
                    return nRow;
                },
                columnDefs: [
                    {
                        targets: [8,9,11],
                        className : "text-center",
                    },
                    {   targets: 1,
                        render: function (data, type, row, meta) {
                            if(data.date_start == data.date_end){
                                return moment(data.date_start).format('MMM D, YYYY');
                            } else {
                                return moment(data.date_start).format('MMM D, YYYY') +" - " +moment(data.date_end).format('MMM D, YYYY');
                            }
                        },
                    },
                    {  targets: 2,
                        render: function (data, type, row, meta) {
                            return moment(data.time_start).format('HH:mm') +"-" +moment(data.time_end).format('HH:mm');
                        },
                    },
                    {  targets: 3,
                        render: function (data, type, row, meta) {
                            if (type === "display") {
                                return data.display;
                            } else {
                                return data.type;
                            }
                        }
                    },
                    {  targets: 7,
                        render: function (data, type, row, meta) {
                            let classColor = data.is_rejected === 0 ? 'btn-primary': 'btn-warning';
                            if(type === 'display'){
                                if(data.is_rejected){
                                    return data.display_rejected
                                }else{
                                    return data.display_not_rejected
                                }
                            }else{
                                return data.status;
                            }
                        },
                    },
                    {  targets: 11,
                        render: function (data, type, row, meta) {
                            if(data.status === 6 && data.is_finish === 0 ){
                                return '<button id=d-"' + data.id + '" class="ml-3 btn-action btn-view" data-toggle="tooltip" data-placement="bottom" title="View">'+
                                    '<i class="ti-eye"></i>'+
                                    '</button>'+
                                    '<button id=d-"' + data.id + '" class="ml-3 btn-action btn-check" data-toggle="tooltip" data-placement="bottom" title="Approve">'+
                                    '<i class="ti-check"></i>'+
                                    '</button>';
                            }else{
                                return '<button id=d-"' + data.id + '" class="ml-3 btn-action btn-view" data-toggle="tooltip" data-placement="bottom" title="View">'+
                                    '<i class="ti-eye"></i>'+
                                    '</button>';
                            }
                        }
                    }
                ],
                columns: [

                    { data: null,"sortable": false  },
                    { data: 'date',"sortable": false },
                    { data: 'time',"sortable": false },
                    { data: 'type',"sortable": false },
                    { data: 'visitor_coordinator',"sortable": false },
                    { data: 'purpose',"sortable": false },
                    { data: 'project_detail',"sortable": false },
                    { data: 'progress',"sortable": false},
                    { data: 'reason',"sortable": false },
                    { data: 'findings',"sortable": false },
                    { data: 'status',"sortable": false },
                    { data: 'action',"sortable": false  }
                ]
            });
            MergeGridCells('data-tables',1);
        });

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        function triggerSwal(id){
            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "Do you want to approve this project ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Approve!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "purchasing/finish/"+id,
                        type: 'post',
                        dataType: 'json',
                        success: function(data) {
                            if(data.result == true){
                                swalWithBootstrapButtons.fire(
                                    'Finish Project!',
                                    'Project has been finish.',
                                    'success'
                                )

                            }else{
                                swalWithBootstrapButtons.fire(
                                    'Finish Failed!',
                                    'Cancel finish project.',
                                    'error'
                                );
                            }
                            $('#data-tables').DataTable().ajax.reload();
                        }
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'You cancel this project finish ',
                        'error'
                    )
                }
            });
        }


        $('#data-tables').on('click', 'button.btn-check', function () {
            let id = $(this).attr("id").match(/\d+/)[0];
            //$('#data-tables').DataTable().column( 1 ).visible( 'false' );
            triggerSwal(id);
        });
        $('#data-tables').on('click', 'button.btn-view', function () {
            let id = $(this).attr("id").match(/\d+/)[0];
            window.location.href = "project-get/"+id;
        });


    </script>
@endsection

