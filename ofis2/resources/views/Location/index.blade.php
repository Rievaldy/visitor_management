@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Location</h3>
    </div>
@endsection

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="flexbox flex-justified text-center mb-30 bg-primary">
                <div class="no-shrink py-30">
                    <span class="ti-location-pin font-size-50"></span>
                </div>
                <div class="py-30 bg-white text-dark">
                    <div class="font-size-30">
                        <?php
                            $count = DB::table('locations')->count();
                            echo $count;
                        ?>
                    </div>
                    <span>Total Location</span>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">Location List</h4>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('locationAdd') }}" class="btn btn-bold btn-pure btn-info">Add New Location</a>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="flash-message"></div>
                    <div class="table-responsive-lg dataTables_scroll">
                        <table id="data-tables" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-left">Site Name</th>
                                    <th class="text-left">Location Name</th>
                                    <th class="text-center">Production Category</th>
                                    <th class="text-center">NDA Requirement</th>
                                    <th class="text-center">Last Update</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--        modal delete confirmation--}}
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
                    <p>Do you really want to delete these records? This process cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger btn-delete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL HERE --}}
    <div class="modal modal-fill fade" data-backdrop="false" id="modal-detail" tabindex="-1" style="z-index: 9999">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h5 class="modal-title">Large Meeting Room	</h5> --}}
                    <button type="button" class="close" style="padding-right: 28px" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box">
                                <div class="box-header">
                                    <h4 class="box-title">View Location</h4>
                                </div>
                                <form action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>Site Name</label>
                                            <input type="text" name="site_name" class="form-control" value="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Location Name</label>
                                            <input type="text" name="location_name" class="form-control" value="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Location Category</label>
                                            <input name="is_production_area" type="text" class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>NDA Requirement</label>
                                            <input name="is_need_nda" type="text" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <div class="row">
                                            <div class="col-3">
                                                <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" data-dismiss="modal">Close</button>
                                            </div>
                                            <div class="col-3">
                                                <button type="submit" class="btn btn-bold btn-pure btn-info float-right btn-block">Edit</button>
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
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        function triggerSwal(id){
            console.log()
            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "location/"+id,
                        type: 'delete',
                        dataType: 'json',
                        success: function(data) {
                            if(data.result == true){
                                swalWithBootstrapButtons.fire(
                                    'Deleted!',
                                    'Locations has been deleted.',
                                    'success'
                                )
                            }else{
                                swalWithBootstrapButtons.fire(
                                    'Delete Failed!',
                                    'Failed to delete locations.',
                                    'error'
                                );
                            }
                            $('#data-tables').DataTable().ajax.reload(null, false);
                        }
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your locations data is safe ',
                        'error'
                    )
                }
            });
        }


        $(".alert").fadeTo(4000, 500).slideUp(500, function(){
            $(".alert").slideUp(500);
        });

        $(document).ready(function () {
            jQuery('.dataTable').wrap('<div class="dataTables_scroll" />');
            $('#data-tables').DataTable({
                processing: true,
                serverSide: true,
                "autoWidth": false,
                "responsive": true,
                "order": [[ 1, 'asc' ]],
                ajax: "{{route('getAllLocations')}}",
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var info = $(this).DataTable().page.info();
                    $("td:nth-child(1)", nRow).html(info.start + iDisplayIndex + 1);
                    return nRow;
                },
                columnDefs: [
                    {  targets: 3,
                        render: function (data, type, row, meta) {
                            let classColor = data.is_production_area === 0 ? 'btn-success': 'btn-danger';
                            if(type === 'display'){
                                return '<span class="btn btn-block btn-rounded '+classColor+' ">'+
                                    data.display+
                                    '</span>';
                            }else{
                                return data.is_production_area;
                            }
                        },
                    },
                    {  targets: 4,
                        render: function (data, type, row, meta) {
                            let classColor = data.is_need_nda === 0 ? 'btn-success': 'btn-danger';
                            if(type === 'display'){
                                return '<span class="btn btn-block btn-rounded '+classColor+' ">'+
                                    data.display+
                                    '</span>';
                            }else{
                                return data.is_need_nda;
                            }
                        },
                    },
                    {  targets: 6,
                        render: function (data, type, row, meta) {
                            return '<button id=d-"' + data.id + '" class="ml-3 btn-action btn-view" data-toggle="tooltip" data-placement="bottom" title="View">'+
                                '<i class="ti-eye"></i>'+
                                '</button>'+
                                '<button id=d-"' + data.id + '" class="ml-3 btn-action btn-delete" data-toggle="tooltip" data-placement="bottom" title="Delete">'+
                                '<i class="ti-trash"></i>'+
                                '</button>';
                        }
                    }
                ],
                columns: [
                    { "data": null,"sortable": false  },
                    { data: 'site_name' },
                    { data: 'location_name' },
                    { data: 'is_production_area' },
                    { data: 'is_need_nda' },
                    { data: 'updated_at' },
                    { "data": null,"sortable": false  }
                ]

            });
        });

        $('#data-tables').on('click', 'button.btn-view', function () {
            let id = $(this).attr("id").match(/\d+/)[0];
            $.ajax({
                url: "/locations-get/"+id,
                type: 'get',
                dataType: "json",
                success: function(item) {
                    console.log(item);
                    $('#modal-detail').find('input[name=site_name]').val(item.site_name)
                    $('#modal-detail').find('input[name=location_name]').val(item.location_name)
                    $('#modal-detail').find('input[name=is_production_area]').val(item.is_production_area.display)
                    $('#modal-detail').find('input[name=is_need_nda]').val(item.is_need_nda.display)
                    // console.log(item.id)
                    $('#modal-detail').find('form').attr('action','/locations/edit/'+item.id)
                    $('#modal-detail').modal('show');
                }
            });
        });

        $('#data-tables').on('click', 'button.btn-delete', function () {
            let id = $(this).attr("id").match(/\d+/)[0];
            triggerSwal(id);
        });
    </script>
@endsection
