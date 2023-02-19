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

    <link href="{{ URL::asset('Main/css/bootstrap.min.css') }}" rel="stylesheet"  media="screen">
	{{-- <link href="css/bootstrap.min.css" rel="stylesheet" media="screen"> --}}
	<!-- Font Awesome icon css-->
    <link href="{{ URL::asset('Main/css/font-awesome.min.css') }}" rel="stylesheet"  media="screen">
	{{-- <link href="css/font-awesome.min.css" rel="stylesheet" media="screen"> --}}
	<!-- Main custom css -->
    <link href="{{ URL::asset('Main/css/custom.css') }}" rel="stylesheet">
	{{-- <link href="css/custom.css" rel="stylesheet" media="screen"> --}}
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

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
					<p>Begin the journey towards a happier you.. We're <br /> working hard to give you the best experience!</p>
				</div>
			</div>
		</div>

		<!-- Contact Form start -->
		<div class="contact-form">
			<div class="contact-box">
				<h2 class="title">Contact Us</h2>
				<p>Drop us an email and we will get back to you as soon as we can<p>

				<form>
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<input type="text" class="form-control" placeholder="Your Name" />
						</div>

						<div class="col-md-6 col-sm-6">
							<input type="text" class="form-control" placeholder="Your Email" />
						</div>

						<div class="col-md-12 col-sm-12">
							<textarea class="form-control" rows="6" placeholder="Your Message"></textarea>
						</div>

						<div class="col-md-12 col-sm-12">
							<input type="submit" class="btn-submit" value="Send Message Now" />
						</div>
					</div>

				</form>
			</div>
		</div>
		<!-- Contact Form end -->
	</div>
	<!-- Coming Soon Wrapper end -->

    <!-- Jquery Library File -->
	<script src="js/jquery-1.12.4.min.js"></script>
	<!-- Timer counter js file -->
	<script src="js/countdown-timer.js"></script>
	<!-- SmoothScroll -->
	<script src="js/SmoothScroll.js"></script>
    <!-- Bootstrap js file -->
	<script src="js/bootstrap.min.js"></script>
    <!-- Main Custom js file -->
	<script src="js/function.js"></script>
	<!-- Countdown Script start -->
	<script>
        $(document).ready(function (){
			//var myDate = new Date("08/04/2019");
			var myDate = new Date();
			myDate.setDate(myDate.getDate() + 90);
            $("#countdown").countdown(myDate, function (event) {
                $(this).html(
                    event.strftime(
                        '<div class="timer-wrapper"><div class="time">%D</div><span class="text">Days</span></div><div class="timer-wrapper"><div class="time">%H</div><span class="text">Hours</span></div><div class="timer-wrapper"><div class="time">%M</div><span class="text">Minutes</span></div><div class="timer-wrapper"><div class="time">%S</div><span class="text">Seconds</span></div>'
                    )
                );
            });

        });
    </script>
	<!-- Countdown Script end -->
</body>
</html>
