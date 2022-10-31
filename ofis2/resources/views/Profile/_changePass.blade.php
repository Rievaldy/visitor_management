@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Change Password</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-12 text-left">
                            <h4 class="box-title">Password Info</h4>
                        </div>
                    </div>
                </div>
                <form action="{{ route('updatePassword') }}" method="POST">
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
                            <label>Old password</label>
                            <input type="password" name="current_password" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label>New password</label>
                            <input type="password" name="new_password" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label>Retype new password</label>
                            <input type="password" name="new_confirm_password" class="form-control" value="">
                        </div>
                    </div>
                    <div class="box-footer">
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

