<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Wanc Studios">
    <link rel="icon" href="{{ asset('') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('') }}" type="image/x-icon">
    <title>Login</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('Admin//css/fontawesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('Admin//css/vendors/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('Admin//css/vendors/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('Admin//css/vendors/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('Admin//css/vendors/feather-icon.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('Admin//css/vendors/sweetalert2.css') }}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('Admin//css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('Admin//css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('Admin//css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('Admin//css/responsive.css') }}">
</head>

<body>
    <!-- login page start-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-0">
                <div class="login-card" style="background-image: url('{{ asset('Admin/images/login_bg.jpg') }}')">
                    <div>
                        <div class="login-main" style="">
                            <div>
                                <a class="logo text-center" href="index.html">
                                    <img class="img-fluid" src="{{ asset('Admin/images/littledoor/littleDoorLogo.png') }}"
                                        alt="" width="40%">
                                </a>
                            </div>
                            <form class="theme-form" method="POST" action="">
                                @csrf
                                {{-- <form class="theme-form" method="POST">
                    @csrf --}}
                                <h4>Reset Password</h4>
                                <p>Enter your email & password to login</p>
                                <div class="form-group">
                                    <label class="col-form-label">Email Address</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong></strong>
                                        </span>
                                    @enderror
                                    {{-- <input class="form-control email" type="email" placeholder="" required autofocus name="email"> --}}
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Current Password</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong></strong>
                                        </span>
                                    @enderror
                                    {{-- <input class="form-control pwd" type="password" placeholder="" required name="password"> --}}

                                </div> <div class="form-group">
                                    <label class="col-form-label">New Password</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong></strong>
                                        </span>
                                    @enderror
                                    {{-- <input class="form-control pwd" type="password" placeholder="" required name="password"> --}}

                                </div> 
                                <div class="form-group">
                                    <label class="col-form-label">Confirm New Password</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong></strong>
                                        </span>
                                    @enderror
                                    {{-- <input class="form-control pwd" type="password" placeholder="" required name="password"> --}}

                                </div>
                                <div class="mb-4">
                                    <button class="btn btn-primary btn-block" id="error" type="submit">Reset</button>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- latest jquery-->
        <script src="{{ asset('Admin//js/jquery-3.5.1.min.js') }}"></script>
        <!-- Bootstrap js-->
        <script src="{{ asset('Admin//js/bootstrap/popper.min.js') }}"></script>
        <script src="{{ asset('Admin//js/bootstrap/bootstrap.js') }}"></script>
        <!-- feather icon js-->
        <script src="{{ asset('Admin//js/icons/feather-icon/feather.min.js') }}"></script>
        <script src="{{ asset('Admin//js/icons/feather-icon/feather-icon.js') }}"></script>
        <!-- Sidebar jquery-->
        <script src="{{ asset('Admin//js/config.js') }}"></script>
        <!-- Plugins JS start-->
        <script src="{{ asset('Admin//js/sweet-alert/sweetalert.min.js') }}"></script>
        <!-- Plugins JS Ends-->
        <!-- Theme js-->
        <script src="{{ asset('Admin//js/script.js') }}"></script>
        <!-- login js-->
        <!-- Plugin used-->

    </div>
</body>

</html>
