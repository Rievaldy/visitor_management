<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="col-md-4 offset-md-4 mt-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Form Register</h3>
                </div>
                <form action="{{ route('register') }}" method="POST">
                @csrf
                    <div class="card-body">
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
                        <div class="form-group">
                            <label for=""><strong>Full Name</strong></label>
                            <input type="text" name="name" class="form-control" placeholder="Nama Lengkap">
                        </div>
                        <div class="form-group">
                            <label for=""><strong>Email Address</strong></label>
                            <input type="text" name="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for=""><strong>Company</strong></label>
                            <input type="text" name="company" class="form-control" placeholder="Nama Lengkap">
                        </div>
                        <div class="form-group">
                            <label for=""><strong>Phone Number</strong></label>
                            <input type="number" name="phone" class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                            <select name="user_type" class="form-control select2" id="" data-tags="true" required>
                                <option value="99">Administrator</option>
                                <option value="4">Manager</option>
                                <option value="3" selected >Employee</option>
                                <option value="2">Food & Beverage</option>
                                <option value="1">Frontdesk</option>
                                <option value="40">Visitor Management System</option>
                                {{-- <option value="5">Secretary</option> --}}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for=""><strong>Password</strong></label>
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for=""><strong>Konfirmasi Password</strong></label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Password">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                        <p class="text-center">Sudah punya akun? <a href="{{ route('login') }}">Login</a> sekarang!</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
