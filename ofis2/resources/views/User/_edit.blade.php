@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Edit User</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title">User Info</h4>
                </div>
                <form method="POST" action="{{ url('userUpdate/' . $user->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        @if (session('errors'))
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
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        @if (Session::has('error'))
                            <div class="alert alert-danger">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                        <div class="form-group">
                            <label>Employee ID <span class="text-danger">*</span></label>
                            <input type="text" name="employee_id" class="form-control" value="{{ $user->employee_id }}">
                        </div>
                        <div class="form-group">
                            <label>Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>
                        <div class="form-group">
                            <label>Email Address <span class="text-danger">*</span></label>
                            <input type="mail" name="email" class="form-control" id="email" value="{{ $user->email }}" required>
                        </div>
                        <div class="form-group">
                            <label>Company <span class="text-danger">*</span></label>
                            <input type="text" name="company" class="form-control" value="{{ $user->company }}" required>
                        </div>
                        <div class="form-group">
                            <label>Phone Number <span class="text-danger">*</span></label>
                            <input type="number" name="phone" class="form-control" value="{{ $user->phone }}" required>
                        </div>
                        <div class="form-group">
                            <label>User type <span class="text-danger">*</span></label>
                            <select name="user_type" class="form-control select2" id="" style="width: 100%" data-tags="true" required>
                                <option value="99" {{ $user->user_type == 99 ? 'selected' : '' }}>Administrator</option>
                                <option value="1" {{ $user->user_type == 1 ? 'selected' : '' }}>GA/Security</option>
                                <option value="2" {{ $user->user_type == 2 ? 'selected' : '' }}>PIC Project/Purchasing/YKK Employee</option>
                                <option value="3" {{ $user->user_type == 3 ? 'selected' : '' }}>HSE Management</option>
                                <option value="4" {{ $user->user_type == 4 ? 'selected' : '' }}>Confidential Management</option>
                                <option value="5" {{ $user->user_type == 5 ? 'selected' : '' }}>Factory Director</option>

                            </select>
                        </div>
                        <div class="form-group d-none" id="userGrade">
                            <label>User Grade <span class="text-danger">*</span></label>
                            <select name="user_grade" class="form-control select2" data-tags="true">
                                <option value="0" {{ $user->user_grade == null ? 'selected' : '' }} disabled>Select User Grade</option>
                                <option value="1" {{ $user->user_grade == 1 ? 'selected' : '' }}>Director</option>
                                <option value="2" {{ $user->user_grade == 2 ? 'selected' : '' }}>Sub Directorate</option>
                            </select>
                        </div>
                        <div class="form-group d-none" id="userDepartment">
                            <label>User Department</label>
                            @if ($user->id_dep == null)
                                <select name="id_dep" class="form-control select2" data-tags="true">
                                    <option value="none" selected disabled>Select Department</option>
                                </select>
                            @else
                                <select name="id_dep" class="form-control select2" data-tags="true">
                                    @foreach ($userDep as $dep)
                                        <option value="{{ $dep->id }}" {{ $dep->id == $user->id_dep ? 'selected' : '' }}>{{ $dep->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" id="uname" value="{{ $user->email }}" placeholder="" readonly>
                            <span class="form-text text-muted font-size-12">The username follow the registered email address.</span>
                        </div>
                        <div class="form-group">
                            <label>User Status</label>
                            <div class="c-inputs-stacked">
                                <input name="status" type="radio" id="status_active" value="1" {{ $user->status == 1 ? 'checked' : '' }}>
                                <label for="status_active" class="mr-30">Active</label>
                                <input name="status" type="radio" id="status_inactive" value="0" {{ $user->status == 0 ? 'checked' : '' }}>
                                <label for="status_inactive" class="mr-30">Inactive</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Employee Photo<span class="text-danger">*</span></label>
                            <input type="file" name="img" class="form-control" value="">
                        </div>

                        @if ($user->user_type == 99 )
                            <div class="form-group pt-5">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" value="....." disabled><br>

                                <span data-toggle="modal" class="btn-view text-right" id="{{ $user->id }}" data-users="{{ json_encode($user) }}" data-target="#modal-detail">
                                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="View">
                                        Change Password
                                    </a>
                                </span>
                            </div>
                        @else
                            <div class="form-group pt-5">
                                <label>Change Password</label>
                                <input type="password" name="password" value="" class="form-control" placeholder="New Password"><br>
                            </div>
                        @endif

                        {{-- @if ($user->user_type == 2 || $user->user_type == 1 || $user->user_type == 20 || $user->user_type == 30 || $user->user_type == 40)
                            <div class="form-group pt-5">
                                <label>Change Password</label>
                                <input type="password" name="password" value="" class="form-control" placeholder="New Password"><br>
                            </div>
                        @endif --}}

                        <td class="text-center">
                        </td>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-3">
                                <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" onclick="location.href='{{ route('user') }}'">Cancel</button>
                            </div>
                            <div class="col-3">
                                <button type="submit" class="btn btn-bold btn-pure btn-info float-right btn-block">Save</button>
                            </div>
                        </div>
                    </div>
                </form>

                {{-- <form action="{{ url('user-change/'.$user->id) }}" method="POST" class="d-inline">
                    @csrf
                <button class="ml-3 btn-action" data-toggle="tooltip" data-placement="bottom" title="View">
                    Change Password
                </button>
                </form> --}}


                {{-- Modal is change password here --}}
                <div class="modal modal-fill fade" data-backdrop="false" id="modal-detail" tabindex="-1" style="z-index: 9999">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" style="padding-right: 28px" data-dismiss="modal">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="box">
                                            <div class="box-header">
                                                <h4 class="box-title">Change Password</h4>
                                            </div>
                                            <form method="POST" action="" enctype="multipart/form-data" id="frmChangePassword">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <label>Old Password</label>
                                                        <input type="hidden" class="form-control" name="_token" id="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" class="form-control" name="user_id" id="user_id" value="{{ $user->id }}">
                                                        <input type="text" class="form-control" name="current_password" value="" placeholder="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>New Password</label>
                                                        <input type="text" class="form-control" name="new_password" value="" placeholder="">
                                                    </div>
                                                    {{-- <div class="form-group">
                                                        <label>Retype New Password</label>
                                                        <input type="text" class="form-control" name="new_confirm_password" value="" placeholder="">
                                                    </div> --}}
                                                </div>
                                                <div class="box-footer">
                                                    <div class="row">
                                                        <div class="col-3">
                                                            <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" data-dismiss="modal">Close</button>
                                                        </div>
                                                        <div class="col-3">
                                                            <button type="button" onclick="resetPassword()" class="btn btn-bold btn-pure btn-info float-right btn-block">Edit</button>
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
                {{-- End Modal --}}



            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>
        $('select[name=user_type]').on('change', function() {
            if (this.value > 2 && this.value < 6) {
                $('#userGrade').removeClass('d-none');
                $('#userDepartment').addClass('d-none');
            } else if(this.value == 2){
                $('#userGrade').addClass('d-none');
                $('#userDepartment').removeClass('d-none');
                $.ajax({
                    url: "{{ route('userGetDepartment') }}",
                    type: 'get',
                    dataType: "json",
                    success: function(datas) {
                        $('select[name=id_dep]').empty();
                        var data = datas
                        console.log(data);
                        $('select[name=id_dep]').select2({
                            data: data
                        })
                    }
                });
            }else{
                $('#userDepartment').addClass('d-none');
                $('#userDepartment').addClass('d-none');
            }
        });

        $(function() {
            var $email = $('#email'),
                $uname = $('#uname');
            $email.on('input', function() {
                $uname.val($email.val());
            });
        });

        function resetPassword() {
            $.ajax({
                type: "POST",
                url: "{{ url('user/change-password/') }}" + '/' + $('#user_id').val(),
                data: $('#frmChangePassword').serialize(),
                success: function(response) {
                    if(response.status == true){
                        Swal.fire('Success',response.data,'success');
                        $('#modal-detail').modal('hide');
                    }else{
                        Swal.fire('Error',response.data,'error');
                    }
                }
            });
        }
    </script>
@endsection
