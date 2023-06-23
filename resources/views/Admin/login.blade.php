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
                                    <img class="img-fluid" src="{{ asset('Admin/images/littledoor/logo.png') }}"
                                        alt="">
                                    <img class="img-fluid" src="{{ asset('Admin/images/littledoor/logotext.png') }}"
                                        alt="">
                                </a>
                            </div>
                            <form class="needs-validation" id="form1" action="{{ route('login') }}" method="POST"
                                enctype="multipart/form-data" novalidate="">
                                @csrf
                                <meta name="csrf-token" content="{{ csrf_token() }}">

                                <h4>Sign In</h4>
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
                                    <label class="col-form-label">Password</label>
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

                                <button class="btn btn-primary btn-block" id="error" type="submit">LOGIN</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <a id="scrollTop"><i class="icon-chevron-up"></i><i class="icon-chevron-up"></i></a> --}}
        <!--Plugins-->
        <script src="{{{asset('Main/js/jquery.js') }}}"></script>
        <script src="{{{asset('Main/js/plugins.js') }}}"></script>

        <script src="{{{asset('Main/js/functions.js') }}}"></script>

        <script src="{{ asset('Admin/js/form-validation-custom.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">

    </div>
</body>

<script>
    function errorMessage(data) {
        const status = data.status;

        if (status === false && "message" in data) {
            return data.message;
        } else if (status === false && "errors" in data) {
            const keys = Object.keys(data.errors);
            const error = keys && keys.length > 0 ? data.errors[keys[0]] : "";
            return error && error.length > 0 ? error[0] : "";
        }
    }

</script>
</html>
