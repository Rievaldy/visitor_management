@extends('master')

@section('head')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-1.0.3/skins/all.css') }}">
@endsection

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">My Profile</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">Profile Info</h4>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('changePassword') }}" class="btn btn-bold btn-pure btn-info">Change Password</a>
                        </div>
                    </div>
                </div>
                <form action="{{ route('updateProfile') }}" method="POST">
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
                        <div class="form-group">
                            @if ( $users ->img != null)
                                <img src="{{ $users ->img }}" alt="" class="shadow" style="width: 200px; object-fit: cover">
                            @else
                                <img src="{{ asset('img/avatar/default-avatar.png') }}" class="" style="width: 200px; object-fit: cover" alt="User Image">
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Employee ID</label>
                            <input type="text" name="name" class="form-control" value="{{ $users ->employee_id}}" disabled required>
                        </div>
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $users ->name}}" disabled required>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="mail" name="email" id="email" class="form-control" value="{{ $users ->email}}" disabled required>
                        </div>
                        <div class="form-group">
                            <label>Company</label>
                            <input type="text" name="company" class="form-control" value="{{ $users ->company}}" disabled required>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="number" name="phone" class="form-control isInput" value="{{ $users ->phone}}" disabled required>
                        </div>
                        <div class="form-group">
                            <label>User Type</label>
                            <input type="text" name="user_type" class="form-control"
                            value="<?php
                                    if ($users->user_type == 99) {
                                        echo "Administrator";
                                    } else if ($users->user_type == 6) {
                                        echo "Human Resources";
                                    } else if ($users->user_type == 5) {
                                        echo "Secretary";
                                    } else if ($users->user_type == 4) {
                                        echo "Manager";
                                    } else if ($users->user_type == 3) {
                                        echo "Employee";
                                    } else if ($users->user_type == 2) {
                                        echo "Food & Baverage";
                                    } else {
                                        echo "Frontdesk";
                                    }
                                ?>"disabled required>
                        </div>
                        <div class="form-group">
                            <label>user Status</label>
                            <input type="text" name="empolyee_status" class="form-control"
                            value="<?php
                                    if ($users->empolyee_status == 1) {
                                        echo "Employee";
                                    } else if ($users->empolyee_status == 2) {
                                        echo "Outsource";
                                    } else if ($users->empolyee_status == 3) {
                                        echo "Internship";
                                    } else if ($users->empolyee_status == 4) {
                                        echo "Partnership";
                                    } else if ($users->empolyee_status == 5) {
                                        echo "VIP";
                                    } else {
                                        echo "Other";
                                    }
                                ?>"disabled required>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" id="uname" class="form-control" value="{{ $users ->email }}" placeholder="" readonly>
                            <span class="form-text text-muted font-size-12">The username follow the registered email address.</span>
                        </div>
                        {{-- <div class="form-group d-none" id="isChangePass">
                            <label>Change Password</label>
                            <input name="password" type="password" class="form-control" value="" placeholder="New Password">
                        </div> --}}
                        <div class="form-group ichack-input mb-0 pt-4">
                            <label>
                                <input type="checkbox" id="isEditCheckbox" class="square-green"><span class="ml-10 font-weight-400 text-initial font-size-1rem">Checklist for edit this data</span>
                            </label>
                        </div>
                    </div>
                    <div class="box-footer d-none" id="isEdit">
                        <div class="row">
                            <div class="col-3">
                                <button type="submit" class="btn btn-bold btn-pure btn-info float-right btn-block">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('vendor/icheck-1.0.3/icheck.min.js') }}"></script>
    <script>
        $('.ichack-input input[type="checkbox"].square-green').iCheck({
            checkboxClass: 'icheckbox_square-green',
        });

        $('#isEditCheckbox').on('ifChanged', function(event){
            //Check if checkbox is checked or not
            var checkboxChecked = $(this).is(':checked');

            if(checkboxChecked) {
                $('.isInput').prop('disabled', false)
                $('#isChangePass').removeClass('d-none')
                $('#isEdit').removeClass('d-none')
            }else{
                $('.isInput').prop('disabled', true)
                $('#isChangePass').addClass('d-none')
                $('#isEdit').addClass('d-none')
            }
        });

        $(function () {
            var $email = $('#email'),
                $uname = $('#uname');
            $email.on('input', function () {
                $uname.val($email.val());
            });
        });

        $(".alert").fadeTo(4000, 500).slideUp(500, function(){
            $(".alert").slideUp(500);
        });
    </script>
@endsection

