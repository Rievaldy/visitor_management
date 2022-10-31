@extends('master')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .modal-content {
            height: auto;
            min-height: 100%;
            border-radius: 0;
        }
        .modal-confirm {
            color: #636363;
            width: 400px;
        }
        .modal-confirm .modal-content {
            padding: 20px;
            border-radius: 5px;
            border: none;
            text-align: center;
            font-size: 14px;
        }
        .modal-confirm .modal-header {
            border-bottom: none;
            position: relative;
        }
        .modal-confirm h4 {
            text-align: center;
            font-size: 26px;
            margin: 30px 0 -10px;
        }
        .modal-confirm .close {
            position: absolute;
            top: -5px;
            right: -2px;
        }
        .modal-confirm .modal-body {
            color: #999;
        }
        .modal-confirm .modal-footer {
            border: none;
            text-align: center;
            border-radius: 5px;
            font-size: 13px;
            padding: 10px 15px 25px;
        }
        .modal-confirm .modal-footer a {
            color: #999;
        }
        .modal-confirm .icon-box {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            border-radius: 50%;
            z-index: 9;
            text-align: center;
            border: 3px solid #f15e5e;
        }
        .modal-confirm .icon-box i {
            color: #f15e5e;
            font-size: 40px;
            display: inline-block;
            margin-bottom: 0;
            vertical-align: super;
        }
        .modal-confirm .btn {
            color: #fff;
            border-radius: 4px;
            background: #60c7c1;
            text-decoration: none;
            transition: all 0.4s;
            line-height: normal;
            min-width: 120px;
            border: none;
            min-height: 40px;
            border-radius: 3px;
            margin: 0 5px;
            outline: none !important;
        }
        .modal-confirm .btn-info {
            background: #c1c1c1;
        }
        .modal-confirm .btn-info:hover, .modal-confirm .btn-info:focus {
            background: #a8a8a8;
        }
        .modal-confirm .btn-danger {
            background: #f15e5e;
        }
        .modal-confirm .btn-danger:hover, .modal-confirm .btn-danger:focus {
            background: #ee3535;
        }
        .dataTables_scroll
        {
            overflow:auto;
        }
    </style>
@endsection

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">User</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="flexbox flex-justified text-center mb-30 bg-primary">
                <div class="no-shrink py-30">
                    <span class="ti-user font-size-50"></span>
                </div>
                <div class="py-30 bg-white text-dark">
                    <div class="font-size-30">
                        <?php
                        $count = DB::table('users')->count();
                        echo $count;
                        ?>
                    </div>
                    <span>Total User</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="flexbox flex-justified text-center mb-30 bg-danger">
                <div class="no-shrink py-30">
                    <span class="ti-link font-size-50"></span>
                </div>
                <div class="py-30 bg-white text-dark">
                    <div class="font-size-30">
                        <?php
                        $total = DB::table('users')->where('status', 1)->count();
                        echo $total.'/';
                        ?>
                        <span class="font-size-18">
                            <?php
                            $total = DB::table('users')->count();
                            echo $total;
                            ?>
                        </span>
                    </div>
                    <span>Active User</span>
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
                            <h4 class="box-title">User List</h4>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('userAdd') }}" class="btn btn-bold btn-pure btn-info">Add New User</a>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="flash-message"></div>
                    <div class="table-responsive-lg dataTables_scroll">
                        <table id="data-tables" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email Address</th>
                                <th>Company</th>
                                <th>Phone Number</th>
                                <th>User Type</th>
                                <th>Status</th>
                                <th>Last Update</th>
                                <th>Action</th>
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
    {{-- modal here --}}
    <div class="modal modal-fill fade" modal-backdrop="white" data-backdrop="false" id="modal-detail" tabindex="-1" style="z-index: 9999">
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
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header">
                                    <h4 class="box-title">View User</h4>
                                </div>
                                <form method="GET" action="" enctype="multipart/form-data">
                                    @csrf
                                    <div class="box-body">
                                        <div class="form-group">
                                            <img src="" alt="" id="imgUser" class="shadow" style="width: 200px">
                                        </div>
                                        <div class="form-group">
                                            <label>Employee ID</label>
                                            <input type="text" class="form-control" name="employee_id" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Full Name</label>
                                            <input type="text" class="form-control" name="name" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Email Address</label>
                                            <input type="text" class="form-control" name="email" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Company</label>
                                            <input type="text" class="form-control" name="company" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input type="number" class="form-control" name="phone" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>User Type</label>
                                            <input type="text" class="form-control" name="user_type" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>User Grade</label>
                                            <input type="text" class="form-control" name="user_grade" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Department</label>
                                            <input type="text" class="form-control" name="dep_name" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" class="form-control" name="username" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <input type="text" class="form-control" name="status" value="" placeholder="" readonly>
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
                        url: "/user/"+id,
                        type: 'delete',
                        dataType: 'json',
                        success: function(data) {
                            if(data.result == true){
                                swalWithBootstrapButtons.fire(
                                    'Deleted!',
                                    'User has been deleted.',
                                    'success'
                                )
                            }else{
                                swalWithBootstrapButtons.fire(
                                    'Delete Failed!',
                                    'Failed to delete user.',
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
                        'Your User data is safe ',
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
                ajax: "{{route('getAllUsers')}}",
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var info = $(this).DataTable().page.info();
                    $("td:nth-child(1)", nRow).html(info.start + iDisplayIndex + 1);
                    return nRow;
                },
                columnDefs: [
                    {  targets: 5,
                        render: function (data, type, row, meta) {
                            if(type === 'display'){
                                return data.display;
                            }else{
                                return data.user_type;
                            }
                        },
                    },
                    {  targets: 6,
                        render: function (data, type, row, meta) {
                            let classColor = data.status === 1 ? 'btn-success': 'btn-danger';
                            if(type === 'display'){
                                return '<span class="btn btn-block btn-rounded '+classColor+' ">'+
                                    data.display+
                                    '</span>';
                            }else{
                                return data.status;
                            }
                        },
                    },
                    {  targets: 8,
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
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'company' },
                    { data: 'phone' },
                    { data: 'user_type' },
                    { "data": 'status'},
                    { data: 'updated_at' },
                    { "data": null,"sortable": false  }
                ]

            });
        });

        $('#data-tables').on('click', 'button.btn-view', function () {
            let id = $(this).attr("id").match(/\d+/)[0];
            $.ajax({
                url: "/user-get/"+id,
                type: 'get',
                dataType: "json",
                success: function(item) {
                    console.log(item.img);
                    $('#modal-detail').find('#imgUser').attr('src',item.img);
                    $('#modal-detail').find('input[name=employee_id]').val(item.employee_id);
                    $('#modal-detail').find('input[name=name]').val(item.name);
                    $('#modal-detail').find('input[name=email]').val(item.email);
                    $('#modal-detail').find('input[name=company]').val(item.company);
                    $('#modal-detail').find('input[name=phone]').val(item.phone);
                    $('#modal-detail').find('input[name=user_type]').val(item.user_type);
                    $('#modal-detail').find('input[name=dep_name]').val(item.dep_name);
                    if (item.user_grade == 1) {
                        $('#modal-detail').find('input[name=user_grade]').val('Director');
                    }else if (item.user_grade == 2) {
                        $('#modal-detail').find('input[name=user_grade]').val('Sub Director');
                    }

                    if(item.user_type == 99){
                        $('#modal-detail').find('input[name=user_type]').val('Administrator');
                    } else if (item.user_type == 1) {
                        $('#modal-detail').find('input[name=user_type]').val('PIC Project/Purchasing/YKK Employee');
                    }else if (item.user_type == 2) {
                        $('#modal-detail').find('input[name=user_type]').val('GA/Security');
                    }else if (item.user_type == 3) {
                        $('#modal-detail').find('input[name=user_type]').val('HSE Management');
                    }else if (item.user_type == 4) {
                        $('#modal-detail').find('input[name=user_type]').val('Confidential Management');
                    }else if (item.user_type == 5) {
                        $('#modal-detail').find('input[name=user_type]').val('Factory Director');
                    }



                    $('#modal-detail').find('input[name=username]').val(item.email)
                    $('#modal-detail').find('input[name=status]').val(item.status)
                    if(item.status == 1){
                        $('#modal-detail').find('input[name=status]').val('Active');
                    } else {
                        $('#modal-detail').find('input[name=status]').val('Inactive');
                    }
                    // console.log(item.id)
                    $('#modal-detail').find('form').attr('action','/userEdit/'+id);
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
