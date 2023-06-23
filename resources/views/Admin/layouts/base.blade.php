<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Little Door"
        content="Little Door">
    <meta name="keywords"
        content="Little Door, scordprotection,Little Door, Security, security, Navi mumbai security, panvel security, office-security, government security">
    <meta name="author" content="pixelstrap">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('Admin/images/littledoor/littleDoorLogo.png') }}" type="image/x-icon">
    <title>Little Door</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('Admin/css/fontawesome.css')}}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{asset('Admin/css/vendors/icofont.css')}}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('Admin/css/vendors/themify.css')}}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('Admin/css/vendors/flag-icon.css')}}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('Admin/css/vendors/feather-icon.css')}}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{asset('Admin/css/vendors/prism.css')}}">
    <!-- Plugins css Ends-->
    <link rel="stylesheet" type="text/css" href="{{asset('Admin/css/vendors/todo.css')}}">
    <!-- Bootstrap css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.css"/>
    <link rel="stylesheet" type="text/css" href="{{asset('Admin/css/vendors/select2.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('Admin/css/vendors/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Admin/css/vendors/owlcarousel.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Admin/css/vendors/rating.css')}}">


    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{asset('Admin/css/vendors/chartist.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Admin/css/vendors/prism.css')}}">
     <link rel="stylesheet" type="text/css"  href="{{asset('Admin/css/vendors/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Admin/css/vendors/bootstrap.css')}}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{asset('Admin/css/style.css')}}">
    <link id="color" rel="stylesheet" href="{{asset('Admin/css/color-1.css')}}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{asset('Admin/css/responsive.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.css" integrity="sha512-9tISBnhZjiw7MV4a1gbemtB9tmPcoJ7ahj8QWIc0daBCdvlKjEA48oLlo6zALYm3037tPYYulT0YQyJIJJoyMQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>



<body >
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">

    <div class="page-body-wrapper horizontal-menu">
    @include('Admin.layouts.sidebar')
    @include('Admin.layouts.navbar')
    @yield('content')
    @include('Admin.layouts.footer')
    <script src="{{asset('Admin/js/jquery-3.5.1.min.js')}}"></script>
    <!-- Bootstrap js-->
    <script src="{{asset('Admin/js/bootstrap/popper.min.js')}}"></script>
    <script src="{{asset('Admin/js/bootstrap/bootstrap.js')}}"></script>
    <!-- feather icon js-->
    <script src="{{asset('Admin/js/icons/feather-icon/feather.min.js')}}"></script>
    <script src="{{asset('Admin/js/icons/feather-icon/feather-icon.js')}}"></script>
    <!-- Sidebar jquery-->
    <script src="{{asset('Admin/js/sidebar-menu.js')}}"></script>
    <script src="{{asset('Admin/js/config.js')}}"></script>
    <!-- Plugins JS start-->
    <script src="{{asset('Admin/js/prism/prism.min.js')}}"></script>
    <script src="{{asset('Admin/js/custom-card/custom-card.js')}}"></script>
    <script src="{{asset('Admin/js/modal-animated.js')}}"></script>
    
    <script src="{{asset('Admin/js/tooltip-init.js')}}"></script>
    <script src="{{asset('Admin/js/todo/todo.js')}}"></script>

    <!-- Plugins JS Ends-->

    <script src="{{asset('Admin/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('Admin/js/rating/jquery.barrating.js')}}"></script>
    <script src="{{asset('Admin/js/owlcarousel/owl.carousel.js')}}"></script>
    <script src="{{asset('Admin/js/ecommerce.js')}}"></script>
    <script src="{{asset('Admin/js/product-list-custom.js')}}"></script>

    <script src="{{asset('Admin/js/datatable/datatables/datatable.custom.js')}}"></script>
    <script src="{{asset('Admin/js/notify/bootstrap-notify.min.js')}}"></script>

    <script src="{{asset('Admin/js/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('Admin/js/select2/select2-custom.js')}}"></script>
    <script src="{{asset('Admin/js/prism/prism.min.js')}}"></script>
    <script src="{{asset('Admin/js/counter/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('Admin/js/counter/jquery.counterup.min.js')}}"></script>
    <script src="{{asset('Admin/js/counter/counter-custom.js')}}"></script>
    <script src="{{asset('Admin/js/custom-card/custom-card.js')}}"></script>
    <script src="{{asset('Admin/js/owlcarousel/owl.carousel.js')}}"></script>
    <script src="{{asset('Admin/js/dashboard/dashboard_2.js')}}"></script>


    <!-- Theme js-->
    <script src="{{asset('Admin/js/script.js')}}"></script>
    <!-- login js-->
    <!-- Plugin used-->
{{--        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.minjs')}}"></script>--}}

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js" integrity="sha512-F636MAkMAhtTplahL9F6KmTfxTmYcAcjcCkyu0f0voT3N/6vzAuJ4Num55a0gEJ+hRLHhdz3vDvZpf6kqgEa5w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
       

    {{-- <script>
    WOW.init();
    </script> --}}
     @yield('js')

</body>

</html>
