
@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Add New User</h3>
    </div>
@endsection

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title">User Info</h4>
                </div>
                <form action="{{ route('userAdd') }}" method="POST" enctype="multipart/form-data">
                    @csrf
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
                            <input type="text" name="employee_id" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label>Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label>Email Address <span class="text-danger">*</span></label>
                            <input type="mail" name="email" id="email" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label>Company <span class="text-danger">*</span></label>
                            <input type="text" name="company" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label>Phone Number <span class="text-danger">*</span></label>
                            <input type="number" name="phone" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label>User type <span class="text-danger">*</span></label>
                            <select name="user_type" class="form-control select2"  data-tags="true">
                                <option value="99" selected >Administrator</option>
                                <option value="1" >GA/Security</option>
                                <option value="2" >PIC Project/Purchasing/YKK Employee</option>
                                <option value="3" >HSE Management</option>
                                <option value="4" >Confidential Management</option>
                                <option value="5" >Factory Director</option>
                            </select>
                        </div>
                        <div class="form-group d-none" id="userGrade">
                            <label>User Grade <span class="text-danger">*</span></label>
                            <select name="user_grade" class="form-control select2"  data-tags="true">
                                <option value="0" disabled>Select User Grade</option>
                                <option value="1" >Director</option>
                                <option value="2" >Sub Directorate</option>
                            </select>
                        </div>
                        <div class="form-group d-none" id="userDepartment">
                            <label>Department</label>
                            <select name="id_dep" class="form-control select2"  data-tags="true">
                                <option value="none" selected disabled>Select Division First</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>User Photo<span class="text-danger">*</span></label>
                            <input type="file" name="img" class="form-control" value="" required>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="" id="uname" class="form-control" value="" placeholder="" readonly>
                            <span class="form-text text-muted font-size-12">The username follow the registered email address.</span>
                        </div>
                        {{-- <div class="form-group">
                            <label>Password</label>
                            <input type="text" name="password" class="form-control" value="Pwd@123" placeholder="" readonly>
                            <span class="form-text text-muted font-size-12">The password is generated automatically by the system and will be sent to the user's email.</span>
                            <span class="form-text text-muted font-size-12">This is the initial password, users can change it in <b>My Profile</b> menu when they log in.</span>
                        </div> --}}
                        <div class="form-group">
                            <label>Status</label>
                            <div class="c-inputs-stacked">
                                <input name="status" type="radio" id="status_active" value="1" checked>
                                <label for="status_active" class="mr-30">Active</label>
                                <input name="status" type="radio" id="status_inactive" value="0">
                                <label for="status_inactive" class="mr-30">Inactive</label>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-3">
                                <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" onclick="window.location.href='{{route('user')}}'">Back</button>
                            </div>
                            <div class="col-3">
                                <button type="submit" class="btn btn-bold btn-pure btn-info float-right btn-block">Create</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>

        $('select[name=user_type]').on('change', function() {
            if (this.value > 2 && this.value < 6) {
                $('#userGrade').removeClass('d-none');
                $('#userDepartment').addClass('d-none');
            } else if(this.value == 2){
                $('#userDepartment').addClass('d-none');
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

        $(function () {
            var $email = $('#email'),
                $uname = $('#uname');
            $email.on('input', function () {
                $uname.val($email.val());
            });
        });
    </script>
@endsection
