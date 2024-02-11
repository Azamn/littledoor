<!doctype html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ URL::asset('Main/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('Main/css/slick.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('Main/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('Main/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('Main/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('Main/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('Main/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('Main/css/colors/solid/color.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('Main/css/style.css') }}">
    <title>LittleDoor - Healing starts here</title>
</head>

<body  class="no-scroll-y">
     <!-- ==================================================
							Preloader
    ================================================== -->

		<section>
			<div id="preloader">
				<div id="ctn-preloader" class="ctn-preloader">
					<div class="animation-preloader">
						<div class="spinner"></div>
						<div class="txt-loading">
							<span data-text-preloader="L" class="letters-loading">
								L
							</span>
							<span data-text-preloader="i" class="letters-loading">
								i
							</span>
							<span data-text-preloader="t" class="letters-loading">
								t
							</span>
							<span data-text-preloader="t" class="letters-loading">
								t
							</span>
							<span data-text-preloader="l" class="letters-loading">
								l
							</span>
							<span data-text-preloader="e" class="letters-loading">
								e
							</span>
							<span data-text-preloader="D" class="letters-loading">
								D
							</span>
							<span data-text-preloader="O" class="letters-loading">
								O
							</span>
							<span data-text-preloader="O" class="letters-loading">
								O
							</span>
							<span data-text-preloader="R" class="letters-loading">
								R
							</span>
						</div>
					</div>
					<div class="loader-section section-left"></div>
					<div class="loader-section section-right"></div>
				</div>
			</div>
		</section>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('Main/images/logo.png') }}" alt="logo"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonial-bg">Testimonial</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <section id="banner" class="banner-2">
        <div class="container">
            <div class="row">
                <div class="col-md-6 wow fadeInLeft" data-wow-duration="2.5s">
                    <div class="bnr-social">
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="#"><i class="fa fa-fw fa-facebook"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-fw fa-twitter"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-fw fa-dribbble"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-fw fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                    <h1>Let us guide you towards a happier, healthier life.</h1>
                    <p>For life  <span>#TheraphyMatter</span></p>
                    <div class="bnr-btn">
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="#">Download App</a></li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="bnr-shape-img-3 wow fadeInDown" data-wow-duration="2.5s">
            <img class="img-fluid" src="{{ asset('Main/images/bnr-shape-3.png')}}" alt="img">
        </div>
    </section>
    <section class="counter-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="counter-item wow fadeInUp" data-wow-duration="0.5s">
                        <span class="counter">40</span>
                        <p>Theraphists</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="counter-item wow fadeInUp" data-wow-duration="1s">
                        <span class="counter">150</span>
                        <p>Sessions</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="counter-item wow fadeInUp" data-wow-duration="1.5s">
                        <span class="counter">100</span>
                        <p>Happy Patients</p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <div class="container service-bg">
        <div class="row">
            <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-duration="1s">
                <div class="service-item-2">
                    <img src="{{ asset('Main/images/icon-1.png')}}" alt="obj">
                    <h5>Accessible </h5>
                    <p>Accessible therapy anytime, anywhere with affordable pricing to fit your budget. </p>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-duration="1.5s">
                <div class="service-item-2">
                   <img src="{{ asset('Main/images/icon-3.png')}}" alt="obj">
                    <h5>Trusted</h5>
                    <p>Experienced licensed therapists to support you and provide continuous support.</p>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-duration="2.5s">
                <div class="service-item-2">
                   <img src="{{ asset('Main/images/icon-2.png')}}" alt="obj">
                    <h5>User-friendly</h5>
                    <p>User-friendly interface for easy navigation with safe and confidential online secruity.</p>
                </div>
            </div>

        </div>
    </div>
    <div class="space" style="height: 100px" id="about"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-sm-12 wow fadeInLeft" data-wow-duration="2.5s">
                <div class="space" style="height: 60px"></div>
                <div class="section-title">
                    <span>about us</span>
                    <h1>Let's work together <span> to improve</span> your mental health.</h1>
                </div>
                <p>We believe that everyone deserves access to quality mental health care. We understand that life can be challenging, and that it's not always easy to find the support you need to overcome those challenges. That's why we've created an online therapy platform that's accessible, affordable, and effective.</p>

                <p>Our team of licensed therapists are passionate about helping people live happier, healthier lives. We offer a range of evidence-based therapies, including cognitive-behavioral therapy, psychodynamic therapy, and mindfulness-based therapy, to help you address a variety of mental health concerns.</p>
                <ul>
                    <li>Accessible therapy anytime, anywhere.</li>
                    <li>Experienced licensed therapists to support you.</li>
                    <li>User-friendly interface for easy navigation.</li>
                </ul>
                <div class="space" style="height: 30px"></div>
                <div class="thegncy-btn">
                    <a href="#">Download Now</a>
                </div>
            </div>
            <div class="col-xl-5 col-lg-6 offset-xl-1 col-sm-12 text-center photo-anim wow fadeInRight" data-wow-duration="2.5s">
                <img class="circle-img-animate" src="{{ asset('Main/images/circle-1.png')}}" alt="img">
                <ul class="animate-obj">
                    <li><img src="{{ asset('Main/images/obj-squire-2.png')}}" alt="obj"></li>
                    <li><img src="{{ asset('Main/images/obj-star.png')}}" alt="obj"></li>
                    <li><img src="{{ asset('Main/images/obj-triangle.png')}}" alt="obj"></li>
                    <li><img src="{{ asset('Main/images/obj-squire-shadow.png')}}" alt="obj"></li>
                    <li><img src="{{ asset('Main/images/obj-triangle.png')}}" alt="obj"></li>
                    <li><img src="{{ asset('Main/images/obj-squire.png')}}" alt="obj"></li>
                    <li><img src="{{ asset('Main/images/obj-star.png')}}" alt="obj"></li>
                    <li><img src="{{ asset('Main/images/obj-tringle-shadow.png')}}" alt="obj"></li>
                    <li><img src="{{ asset('Main/images/obj-squire-2.png')}}" alt="obj"></li>
                    <li><img src="{{ asset('Main/images/obj-squire-shadow-2.png')}}" alt="obj"></li>
                    <li><img src="{{ asset('Main/images/obj-tringle-shadow.png')}}" alt="obj"></li>
                    <li><img src="{{ asset('Main/images/obj-triangle.png')}}" alt="obj"></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="space" style="height: 100px"></div>
    <section class="call-to-action-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 text-center offset-lg-3 col-sm-12">
                    <div class="call-to-action">
                        <span>Let’s Connect</span>
                        <h1>Why to choose us?</h1>
                        <p>We believe that therapy should be accessible to everyone, which is why we've made our platform easy to use and affordable. Our online therapy sessions can be accessed from anywhere, at any time, and we offer flexible scheduling options to accommodate your busy life.</p>
                        <a href="#contact">Send Queries</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="space" style="height: 100px"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-12 text-center wow fadeInLeft" data-wow-duration="2.5s">
                <img class="circle-img-animate img-fluid" src="{{ URL::asset('Main/images/circle-2.png')}}" alt="img">
                <ul class="animate-obj">
                    <li><img src="{{ asset('Main/images/obj-squire-2.png')}}" alt="obj"></li>
                    <li><img src="{{ asset('Main/images/obj-star.png')}}" alt="obj"></li>
                    <li><img src="{{ asset('Main/images/obj-triangle.png')}}" alt="obj"></li>
                    <li><img src="{{ asset('Main/images/obj-squire-shadow.png')}}" alt="obj"></li>
                    <li><img src="{{ asset('Main/images/obj-triangle.png')}}" alt="obj"></li>
                    <li><img src="{{ asset('Main/images/obj-squire.png')}}" alt="obj"></li>
                    <li><img src="{{ asset('Main/images/obj-star.png')}}" alt="obj"></li>
                    <li><img src="{{ asset('Main/images/obj-tringle-shadow.png')}}" alt="obj"></li>
                    <li><img src="{{ asset('Main/images/obj-squire-2.png')}}" alt="obj"></li>
                    <li><img src="{{ asset('Main/images/obj-squire-shadow-2.png')}}" alt="obj"></li>
                    <li><img src="{{ asset('Main/images/obj-tringle-shadow.png')}}" alt="obj"></li>
                    <li><img src="{{ asset('Main/images/obj-triangle.png')}}" alt="obj"></li>
                </ul>
            </div>
            <div class="col-xl-5 col-lg-6 offset-xl-1 wow fadeInRight" data-wow-duration="2.5s">
                <div class="space" style="height: 60px"></div>
                <div class="section-title">
                    <span>about the founder</span>
                    <h1>Meet the   <span>visionary</span> behind LittleDoor</h1>
                    <img src="{{ asset('Main/images/dot-bluecolor.png')}}" alt="img">
                </div>
                <p>Meet Muzammil, the founder of Little Door, a mental health services start-up application that aims to provide a personalized experience to its clients. Muzammil is a completely blind entrepreneur who has completed his Masters in computer applications from the prestigious college VJTI in  Mumbai. He is also a certified ethical hacker and a stand-up comedian, with a passion for using technology to improve people's lives.
				<p>Muzammil's personal experience with anxiety and depression, coupled with the prevalence of misleading guidance and  lack of mental health awareness in the Indian society inspired him to create a unique start-up idea focused on mental health services. Little Door is the result of Muzammil's drive to offer a new, more personalized approach to mental health services, leveraging technology to make a positive impact on people's lives.
				</p>

                <div class="space" style="height: 30px"></div>

            </div>
        </div>
    </div>
    <div class="space" style="height: 100px" id="testimonial-bg"></div>
    <section class="testimonial-bg" >
        <div class="space" style="height: 60px"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="section-title text-center white">
                        <span>Feedback</span>
                        <h1>What Patients says</h1>
                        <img src="{{ asset('Main/images/dot-white.png')}}" alt="img">
                    </div>
                    <div class="space" style="height: 60px"></div>
                </div>
                <div class="col-lg-8 col-sm-12">
                    <div class="testimonials">
                        <div class="testimonial-item">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate</p>
                            <h4>John Doe</h4>
                            <span>Students</span>
                        </div>
                        <div class="testimonial-item">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate</p>
                            <h4>Nolan Vid</h4>
                            <span>Teacher</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="space" style="height: 60px"></div>
    </section>
    <div class="space" style="height: 100px" id="contact"></div>
    <div  class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-12 wow fadeInLeft" data-wow-duration="2.5s">
                <div class="section-title">
                    <span>Contact</span>
                    <h1>Don’t feel hesitate to <span>contact</span></h1>
                </div>
                <div class="space" style="height: 60px"></div>
                <div class="row contact-form">
                    <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Name">
                    </div>
                    <div class="col-md-6">
                        <input type="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Phone">
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Subject">
                    </div>
                    <div class="col-md-12">
                        <textarea class="form-control" rows="3"></textarea>
                        <div class="thegncy-btn">
                            <input class="contact-btn" type="submit" value="Send Now">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-sm-none d-lg-block d-xs-none wow fadeInRight" data-wow-duration="2.5s">
                <div class="space" style="height: 70px"></div>
                <img class="img-fluid" src="{{ asset('Main/images/contact-vector-2.png')}}" alt="Contact">
            </div>
        </div>
    </div>



    <footer class="site-footer">
        <div class="col-sm-12 text-center">
            <img src="{{ asset('Main/images/logo-alt.png')}}" alt="logo">
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Home</a></li>
                <li class="list-inline-item"><a href="#">About Us</a></li>
                <li class="list-inline-item"><a href="#">Testimonial</a></li>
                <li class="list-inline-item"><a href="#">Contact</a></li>
            </ul>
        </div>
        <div class="footer-copyright">
            <p>Copyrighs @ LittleDoor 2023</p>
        </div>
    </footer>

    <div id="backtotop"><i class="fa fa-2x fa-long-arrow-up"></i></div>


    <script src="{{ URL::asset('Main/js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('Main/js/jquery-migrate-3.0.0.min.js') }}"></script>
    <script src="{{ URL::asset('Main/js/circliful.min.js') }}"></script>
    <script src="{{ URL::asset('Main/js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('Main/js/isotope.js') }}"></script>
    <script src="{{ URL::asset('Main/js/slick.min.js') }}"></script>
    <script src="{{ URL::asset('Main/js/tilt.min.js') }}"></script>
    <script src="{{ URL::asset('Main/js/wow.min.js') }}"></script>
    <script src="{{ URL::asset('Main/js/waypoints.min.js') }}"></script>
    <script src="{{ URL::asset('Main/js/counterup.min.js') }}"></script>
    <script src="{{ URL::asset('Main/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ URL::asset('Main/js/main.js') }}"></script>


</body>

</html>
