<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <!-- Page Title -->
    <title>Little Door</title>
    <!-- Google Fonts css-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700,800,900" rel="stylesheet">
    <!-- Bootstrap css -->

    <link href="{{ URL::asset('Main/css/bootstrap.min.css') }}" rel="stylesheet" media="screen">
    {{-- <link href="css/bootstrap.min.css" rel="stylesheet" media="screen"> --}}
    <!-- Font Awesome icon css-->
    <link href="{{ URL::asset('Main/css/font-awesome.min.css') }}" rel="stylesheet" media="screen">
    {{-- <link href="css/font-awesome.min.css" rel="stylesheet" media="screen"> --}}
    <!-- Main custom css -->
    <link href="{{ URL::asset('Main/css/custom.css') }}" rel="stylesheet">
    {{-- <link href="css/custom.css" rel="stylesheet" media="screen"> --}}
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

</head>

<body>

    <!-- Coming Soon Wrapper start -->
    <div class="comming-soon">
        <div class="comming-soon-info">
            <div class="comming-soon-inner">
                <!-- Countdown Start -->
                <div class="countdown-timer-wrapper">
                    <div class="timer" id="countdown"></div>
                </div>
                <!-- Countdown end -->

                <!-- Logo Start -->
                <div class="logo">
                    <img src="{{ asset('Main/images/logo.png') }}" alt="Logo" />
                </div>
                <!-- Logo end -->

                <div class="site-info">
                    <h2>We're launching our <span>New App</span></h2>
                    <p>Begin the journey towards a happier you.. We're <br /> working hard to give you the best
                        experience!</p>
                </div>
            </div>
        </div>

        <!-- Contact Form start -->
        <div class="contact-form">
            <div class="contact-box">
                <h2 class="title">Contact Us</h2>
                <p>Drop us an email and we will get back to you as soon as we can
                <p>

                <form id="contactUs" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <input type="text" id="name" name="name" class="form-control"
                                placeholder="Your Name" />
                            <span class="text error-text name_error"></span>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <input type="text" id="email" name="email" class="form-control"
                                placeholder="Your Email" />
                            <span class="text error-text email_error"></span>
                        </div>

                        <div class="col-md-12 col-sm-12">
                            <textarea id="message" name="message" class="form-control" rows="6" placeholder="Your Message"></textarea>
                        </div>

                        <div class="col-md-12 col-sm-12">
                            <input type="submit" class="btn-submit" />
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <!-- Contact Form end -->
    </div>
    <!-- Coming Soon Wrapper end -->

    <!-- Jquery Library File -->
    {{-- <script src="{{ URL::asset('Main/js/jquery-1.12.4.min.js') }}"></script> --}}
    <script src="{{ URL::asset('Main/js/jquery.js') }}"></script>
    {{-- <script src="js/jquery-1.12.4.min.js"></script> --}}
    <!-- Timer counter js file -->
    <script src="{{ URL::asset('Main/js/countdown-timer.js') }}"></script>
    {{-- <script src="js/countdown-timer.js"></script> --}}
    <!-- SmoothScroll -->
    <script src="{{ URL::asset('Main/js/SmoothScroll.js') }}"></script>
    {{-- <script src="js/SmoothScroll.js"></script> --}}
    <!-- Bootstrap js file -->
    <script src="{{ URL::asset('Main/js/bootstrap.min.js') }}"></script>
    {{-- <script src="js/bootstrap.min.js"></script> --}}
    <!-- Main Custom js file -->
    <script src="{{ URL::asset('Main/js/function.js') }}"></script>
    {{-- <script src="js/function.js"></script> --}}
    <!-- Countdown Script start -->
    <script src="{{ URL::asset('Main/js/form-validation-custom.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // $(document).ready(function() {
        //     //var myDate = new Date("08/04/2019");
        //     var myDate = new Date();
        //     myDate.setDate(myDate.getDate() + 90);
        //     $("#countdown").countdown(myDate, function(event) {
        //         $(this).html(
        //             event.strftime(
        //                 '<div class="timer-wrapper"><div class="time">%D</div><span class="text">Days</span></div><div class="timer-wrapper"><div class="time">%H</div><span class="text">Hours</span></div><div class="timer-wrapper"><div class="time">%M</div><span class="text">Minutes</span></div><div class="timer-wrapper"><div class="time">%S</div><span class="text">Seconds</span></div>'
        //             )
        //         );
        //     });

        // });

        $('#contactUs').on('submit', function(e) {
            e.preventDefault();

            let name = $('#name').val();
            let email = $('#email').val();
            let message = $('#message').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route("store.contact-us") }}',
                method: 'POST',
                data: {
                    name: name,
                    email: email,
                    message: message,
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    if (data.status == true) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 5000
                        });
                        location.reload(true);
                    } else {
                        $.each(data.errors, function(prefix, val) {
                            $('#contactUs').find('span.' + prefix + '_error').text(val[0]);
                        });
                    }

                },
                error: function(data) {},
            });
        });
    </script>

</body>

</html>
