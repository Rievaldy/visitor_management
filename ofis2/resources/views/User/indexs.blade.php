@extends('master')

@section('head')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}">
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
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            {{ Session::get('error') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped dataTables">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-left">Name</th>
                                    <th class="text-left text-nowrap">Email Address</th>
                                    <th class="text-left">Company</th>
                                    <th class="text-left text-nowrap">Phone Number</th>
                                    <th class="text-left text-nowrap">User Type</th>
                                    <th class="text-center">Status</th>
                                    {{-- <th class="text-center">Last Update</th> --}}
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach($users as $user)
                                    {{-- <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td class="text-left text-nowrap">{{ $user->name }}</td>
                                        <td class="text-left">{{ $user->email}}</td>
                                        <td class="text-left">{{ $user->company}}</td>
                                        <td class="text-left">{{ $user->phone}}</td>
                                        <td class="text-left">
                                            <?php
                                                if ($user->user_type == 99) {
                                                    echo "Administrator";
                                                } else if ($user->user_type == 6) {
                                                    echo "Human Resources";
                                                } else if ($user->user_type == 5) {
                                                    echo "Secretary";
                                                } else if ($user->user_type == 3) {
                                                    echo "Employee";
                                                } else if ($user->user_type == 2) {
                                                    echo "Food & Baverage";
                                                } else if ($user->user_type == 1) {
                                                    echo "Frontdesk";
                                                } else if ($user->user_type == 20) {
                                                    echo "Automation Control";
                                                } else if ($user->user_type == 30) {
                                                    echo "Digital Signage";
                                                } else if ($user->user_type == 40) {
                                                    echo "Visitor Management System";
                                                }
                                            ?>
                                        </td>
                                        <td class="text-center text-success">
                                            <span class="btn btn-block btn-rounded {{$user->status == 1 ? 'btn-success' : 'btn-danger' }}">
                                                {{$user->status == 1 ? 'Active' : 'Inctive' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span data-toggle="modal" class="btn-view" id="{{ $user -> id}}" data-users="{{ json_encode($user) }}" data-target="#modal-detail">
                                                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="View">
                                                    <i class="ti-eye"></i>
                                                </a>
                                            </span>
                                            <form action="{{ url('user/'.$user->id) }}" method="POST" onsubmit="return confirm('Are you sure? This record and its details will be permanantly deleted!')" class="d-inline">
                                                @method('DELETE')
                                                @csrf
                                                <button class="ml-3 btn-action" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                                    <i class="ti-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr> --}}
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
                                <form method="POST" action="" enctype="multipart/form-data">
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
                                            <label>Directorate</label>
                                            <input type="text" class="form-control" name="dir_name" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Division</label>
                                            <input type="text" class="form-control" name="div_name" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Department</label>
                                            <input type="text" class="form-control" name="dep_name" value="" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>user Status</label>
                                            <input type="text" class="form-control" name="empolyee_status" value="" placeholder="" readonly>
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
        $('.btn-view').on('click',function(){
            var item = $(this).data('users')
            $('#modal-detail').find('#imgUser').attr('src',item.img)
            $('#modal-detail').find('input[name=employee_id]').val(item.employee_id)
            $('#modal-detail').find('input[name=name]').val(item.name)
            $('#modal-detail').find('input[name=email]').val(item.email)
            $('#modal-detail').find('input[name=company]').val(item.company)
            $('#modal-detail').find('input[name=phone]').val(item.phone)
            $('#modal-detail').find('input[name=user_type]').val(item.user_type)
            $('#modal-detail').find('input[name=dir_name]').val(item.dir_name)
            $('#modal-detail').find('input[name=div_name]').val(item.div_name)
            $('#modal-detail').find('input[name=dep_name]').val(item.dep_name)
            if (item.user_grade == 1) {
                $('#modal-detail').find('input[name=user_grade]').val('Director');
            }else if (item.user_grade == 2) {
                $('#modal-detail').find('input[name=user_grade]').val('Directorate Head');
            }else if (item.user_grade == 3) {
                $('#modal-detail').find('input[name=user_grade]').val('Division Head');
            }else if (item.user_grade == 4) {
                $('#modal-detail').find('input[name=user_grade]').val('Advisor/Principal/Dept. Head');
            }else if (item.user_grade == 5) {
                $('#modal-detail').find('input[name=user_grade]').val('Section Head/Specialist');
            }else if (item.user_grade == 6) {
                $('#modal-detail').find('input[name=user_grade]').val('Staff');
            }

            if(item.user_type == 99){
                $('#modal-detail').find('input[name=user_type]').val('Administrator');
            } else if (item.user_type == 3) {
                $('#modal-detail').find('input[name=user_type]').val('Employee');
            }else if (item.user_type == 6) {
                $('#modal-detail').find('input[name=user_type]').val('Human Resources');
            }else if (item.user_type == 5) {
                $('#modal-detail').find('input[name=user_type]').val('Secretary');
            }else if (item.user_type == 2) {
                $('#modal-detail').find('input[name=user_type]').val('Food & Baverage');
            } else if (item.user_type == 1) {
                $('#modal-detail').find('input[name=user_type]').val('Frontdesk');
            } else if (item.user_type == 20) {
                $('#modal-detail').find('input[name=user_type]').val('Automation Control');
            } else if (item.user_type == 30) {
                $('#modal-detail').find('input[name=user_type]').val('Digital Signage');
            } else if (item.user_type == 40) {
                $('#modal-detail').find('input[name=user_type]').val('Visitor Management System');
            }
            $('#modal-detail').find('input[name=empolyee_status]').val(item.empolyee_status)
            if(item.empolyee_status == 1){
                $('#modal-detail').find('input[name=empolyee_status]').val('Employee');
            } else if (item.empolyee_status == 2) {
                $('#modal-detail').find('input[name=empolyee_status]').val('Outsource');
            } else if (item.empolyee_status == 3) {
                $('#modal-detail').find('input[name=empolyee_status]').val('Consultant');
            } else if (item.empolyee_status == 4) {
                $('#modal-detail').find('input[name=empolyee_status]').val('Auditor');
            } else if (item.empolyee_status == 5) {
                $('#modal-detail').find('input[name=empolyee_status]').val('Subsidiary');
            } else if (item.empolyee_status == 6) {
                $('#modal-detail').find('input[name=empolyee_status]').val('Partnership');
            } else if (item.empolyee_status == 7) {
                $('#modal-detail').find('input[name=empolyee_status]').val('Other');
            }


            $('#modal-detail').find('input[name=username]').val(item.email)
            $('#modal-detail').find('input[name=status]').val(item.status)
            if(item.status == 1){
                $('#modal-detail').find('input[name=status]').val('Active');
            } else {
                $('#modal-detail').find('input[name=status]').val('Inactive');
            }
            // console.log(item.id)
            $('#modal-detail').find('form').attr('action','/userEdit/'+item.id)
        })

        $(".alert").fadeTo(4000, 500).slideUp(500, function(){
            $(".alert").slideUp(500);
        });

        $('.dataTables').DataTable({
            "pageLength": 50
        });
    </script>
@endsection



