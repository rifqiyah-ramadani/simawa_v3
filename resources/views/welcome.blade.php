<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <!-- Meta Tags -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="keywords" content="Site keywords here">
		<meta name="description" content="">
		<meta name='copyright' content=''>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<!-- Title -->
        <title>SIMAWA UNJA</title>
		
		<!-- Favicon -->
        <link rel="icon" href="img/favicon.png">
		
		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{asset('mediplus-lite/css/bootstrap.min.css')}}">
		<!-- Nice Select CSS -->
		<link rel="stylesheet" href="{{asset('mediplus-lite/css/nice-select.css')}}">
		<!-- Font Awesome CSS -->
        <link rel="stylesheet" href="{{asset('mediplus-lite/css/font-awesome.min.css')}}">
		<!-- icofont CSS -->
        <link rel="stylesheet" href="{{asset('mediplus-lite/css/icofont.css')}}">
		<!-- Slicknav -->
		<link rel="stylesheet" href="{{asset('mediplus-lite/css/slicknav.min.css')}}">
		<!-- Owl Carousel CSS -->
        <link rel="stylesheet" href="{{asset('mediplus-lite/css/owl-carousel.css')}}">
		<!-- Datepicker CSS -->
		<link rel="stylesheet" href="{{asset('mediplus-lite/css/datepicker.css')}}">
		<!-- Animate CSS -->
        <link rel="stylesheet" href="{{asset('mediplus-lite/css/animate.min.css')}}">
		<!-- Magnific Popup CSS -->
        <link rel="stylesheet" href="{{asset('mediplus-lite/css/magnific-popup.css')}}">
		
		<!-- Medipro CSS -->
        <link rel="stylesheet" href="{{asset('mediplus-lite/css/normalize.css')}}">
        <link rel="stylesheet" href="{{asset('mediplus-lite/style.css')}}">
        <link rel="stylesheet" href="{{asset('mediplus-lite/css/responsive.css')}}">
		<!-- Bootstrap CSS -->
		{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
		<!-- Bootstrap Bundle with Popper (JavaScript) -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> --}}

		
        <style>
            .nav.menu > li > a {
                display: flex;
                align-items: center;
            }
        </style>
    </head>
    <body>
	
		<!-- Preloader -->
        {{-- <div class="preloader">
            <div class="loader">
                <div class="loader-outter"></div>
                <div class="loader-inner"></div>

                <div class="indicator"> 
                    <svg width="16px" height="12px">
                        <polyline id="back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                        <polyline id="front" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                    </svg>
                </div>
            </div>
        </div> --}}
        <!-- End Preloader -->
	
		<!-- Header Area -->
		<header class="header" >
			<!-- Topbar -->
			{{-- <div class="topbar">
				<div class="container">
					<div class="row">
						<div class="col-lg-6 col-md-5 col-12">
							<!-- Contact -->
							<ul class="top-link">
								<li><a href="#">About</a></li>
								<li><a href="#">Doctors</a></li>
								<li><a href="#">Contact</a></li>
								<li><a href="#">FAQ</a></li>
							</ul>
							<!-- End Contact -->
						</div>
						<div class="col-lg-6 col-md-7 col-12">
							<!-- Top Contact -->
							<ul class="top-contact">
								<li><i class="fa fa-phone"></i>+880 1234 56789</li>
								<li><i class="fa fa-envelope"></i><a href="mailto:support@yourmail.com">support@yourmail.com</a></li>
							</ul>
							<!-- End Top Contact -->
						</div>
					</div>
				</div>
			</div> --}}
			<!-- End Topbar -->
			<!-- Header Inner -->
			<div class="header-inner">
				<div class="container">
					<div class="inner">
						<div class="row justify-content-center">
							<div class="col-lg-3 col-md-3 col-12">
								<!-- Start Logo -->
								<div class="logo d-flex align-items-center">
									<img src="{{asset('images/logo.png')}}" alt="SIMAWA Logo" style="width: 40px; margin-right: 10px;">
									<h3>SIMAWA UNJA</h3>
								</div>
								<!-- End Logo -->
							</div>
							<div class="col-lg-7 col-md-9 col-12">
								<!-- Main Menu -->
								<div class="main-menu text-center">
									<nav class="navigation">
										<ul class="nav menu">
                                            <li class="active"><a href="#">Home </a></li>
                                            <li><a href="#">About </a></li>
											<li><a href="#">Informasi </a></li>
											<li><a href="#">Statistik <i class="icofont-rounded-down"></i></a>
												<ul class="dropdown">
													<li><a href="blog-single.html">Statistik Prestasi</a></li>
                                                    <li><a href="blog-single.html">Statistik Beasiswa</a></li>
												</ul>
											</li>
											<li><a href="#">Galeri </a></li>
										</ul>
									</nav>
								</div>
								<!--/ End Main Menu -->
							</div>
							<div class="col-lg-2 col-12">
                                <div class="get-quote text-end">
                                    @if (Route::has('login'))
                                        @auth
                                            <a href="{{ url('/dashboard') }}" class="btn">
                                                Dashboard
                                            </a>
                                        @else
                                            <a href="{{ route('login') }}" class="btn">
                                                Log in
                                            </a>
                                        @endauth
                                    @endif
                                </div>
                            </div>
                            
						</div>
					</div>
				</div>
			</div>
			<!--/ End Header Inner -->
		</header>
		<!-- End Header Area -->
		
		<!-- Slider Area -->
		<section class="slider">
			<div class="hero-slider">
				<!-- Start Single Slider -->
				<div class="single-slider" style="background-image: url('{{ asset('mediplus-lite/img/about2.jpeg') }}');">
					<div class="container">
						<div class="row">
							<div class="col-lg-12">
								<div class="text">
									<h1>SISTEM INFORMASI KEMAHASISWAAN</h1>
									<h1 class="mt-3"><span>UNIVERSITAS JAMBI</span></h1>
									<div class="button d-flex justify-content-center"> 
										<a href="#" class="btn">Contact Us</a>
										<a href="#" class="btn primary">Learn More</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- End Single Slider -->
			</div>
		</section>
		<!--/ End Slider Area -->
		
		<!-- Start Schedule Area -->
		{{-- <section class="schedule">
			<div class="container">
				<div class="schedule-inner">
					<div class="row">
						<div class="col-lg-4 col-md-6 col-12 ">
							<!-- single-schedule -->
							<div class="single-schedule first">
								<div class="inner">
									<div class="icon">
										<i class="fa fa-ambulance"></i>
									</div>
									<div class="single-content">
										<span>Lorem Amet</span>
										<h4>Emergency Cases</h4>
										<p>Lorem ipsum sit amet consectetur adipiscing elit. Vivamus et erat in lacus convallis sodales.</p>
										<a href="#">LEARN MORE<i class="fa fa-long-arrow-right"></i></a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-6 col-12">
							<!-- single-schedule -->
							<div class="single-schedule middle">
								<div class="inner">
									<div class="icon">
										<i class="icofont-prescription"></i>
									</div>
									<div class="single-content">
										<span>Fusce Porttitor</span>
										<h4>Doctors Timetable</h4>
										<p>Lorem ipsum sit amet consectetur adipiscing elit. Vivamus et erat in lacus convallis sodales.</p>
										<a href="#">LEARN MORE<i class="fa fa-long-arrow-right"></i></a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-12 col-12">
							<!-- single-schedule -->
							<div class="single-schedule last">
								<div class="inner">
									<div class="icon">
										<i class="icofont-ui-clock"></i>
									</div>
									<div class="single-content">
										<span>Donec luctus</span>
										<h4>Opening Hours</h4>
										<ul class="time-sidual">
											<li class="day">Monday - Fridayp <span>8.00-20.00</span></li>
											<li class="day">Saturday <span>9.00-18.30</span></li>
											<li class="day">Monday - Thusday <span>9.00-15.00</span></li>
										</ul>
										<a href="#">LEARN MORE<i class="fa fa-long-arrow-right"></i></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section> --}}
		<!--/End Start schedule Area -->

		<!-- Start Why choose -->
		<section class="why-choose section" >
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-12">
						<!-- Start Choose Left -->
						<div class="choose-left">
							<h2>ABOUT SIMAWA</h2>
							<p>Sistem Informasi Kemahasiswaan (SIMAWA) UNJA merupakan sistem informasi mahasiswa UNJA yang terkoordinir di bawah lembaga 
										pengembangan kemahasiswaan dan alumni Universitas Jambi yang berfungsi untuk 
										pengelolaan seluruh kegiatan kemahasiswaan Universitas Jambi.</p>
									
							<div class="row">
								<div class="col-lg-6">
									<ul class="list">
										<li><i class="fa fa-circle"></i>Kompetisi </li>
										<li><i class="fa fa-circle"></i>Pendanaan</li>
										<li><i class="fa fa-circle"></i>Prestasi Mahasiswa</li>
									</ul>
								</div>
								<div class="col-lg-6">
									<ul class="list">
										<li><i class="fa fa-circle"></i>Beasiswa </li>
										<li><i class="fa fa-circle"></i>Unit Kegiatan Mahasiswa</li>
										<li><i class="fa fa-circle"></i>Organisasi Kemahasiswaan</li>
									</ul>
								</div>
							</div>
						</div>
								<!-- End Choose Left -->
					</div>
					<div class="col-lg-6 col-12">
						<!-- Start Choose Right -->
						<div class="choose-right">
							<div class="image">
								<img src="{{ asset('mediplus-lite/img/about7.jpeg') }}" alt="Deskripsi Gambar" style="width: 100%; border-radius: 8px;">
							</div>
						</div>
						<!-- End Choose Right -->
					</div>
				</div>
			</div>
		</section>

				<!-- Start Blog Area -->
		<section class="blog section" id="blog">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="section-title">
							<h2>INFORMASI</h2>
							<!-- Nav Tabs -->
							<ul class="nav nav-tabs" id="myTab" role="tablist">
								<li class="nav-item" role="presentation">
									<button class="nav-link active" id="berita-tab" data-toggle="tab" data-target="#berita" type="button" role="tab" aria-controls="berita" aria-selected="true">Berita</button>
								</li>
								<li class="nav-item" role="presentation">
									<button class="nav-link" id="pengumuman-tab" data-toggle="tab" data-target="#pengumuman" type="button" role="tab" aria-controls="pengumuman" aria-selected="false">Pengumuman</button>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- Tab Content -->
				<div class="tab-content" id="myTabContent">
					<!-- Berita Tab -->
					<div class="tab-pane fade show active" id="berita" role="tabpanel" aria-labelledby="berita-tab">
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<!-- Single Blog -->
								<div class="single-news">
									<div class="news-head">
										<img src="mediplus-lite/img/about7.jpeg" alt="#">
									</div>
									<div class="news-body">
										<div class="news-content">
											<div class="date">22 Aug, 2020</div>
											<h2><a href="blog-single.html">We have announced our new product.</a></h2>
											<p class="text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
										</div>
									</div>
								</div>
							</div>
							<!-- Tambahkan konten berita lainnya jika diperlukan -->
						</div>
					</div>
		
					<!-- Pengumuman Tab -->
					<div class="tab-pane fade" id="pengumuman" role="tabpanel" aria-labelledby="pengumuman-tab">
						<div class="row">
							<div class="col-lg-4 col-md-6 col-12">
								<!-- Single Pengumuman -->
								<div class="single-news">
									<div class="news-head">
										<img src="mediplus-lite/img/about7.jpeg" alt="#">
									</div>
									<div class="news-body">
										<div class="news-content">
											<div class="date">01 Sep, 2020</div>
											<h2><a href="announcement-single.html">Important announcement for all users.</a></h2>
											<p class="text">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
										</div>
									</div>
								</div>
							</div>
							<!-- Tambahkan konten pengumuman lainnya jika diperlukan -->
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Blog Area -->

		<!-- Start portfolio -->
		<section class="portfolio section" >
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="section-title">
							<h2>GALERI KEGIATAN KEMAHASISWAAN UNIVERSITAS JAMBI</h2>
						</div>
					</div>
				</div>
			</div>
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12 col-12">
						<div class="owl-carousel portfolio-slider">
							<div class="single-pf">
								<img src={{ asset('mediplus-lite/img/about.jpeg') }} alt="#" >
								{{-- <a href="portfolio-details.html" class="btn">View Details</a> --}}
							</div>
							<div class="single-pf">
								<img src={{ asset('mediplus-lite/img/about3.jpg') }} alt="#" >
								{{-- <a href="portfolio-details.html" class="btn">View Details</a> --}}
							</div>
							<div class="single-pf">
								<img src={{ asset('mediplus-lite/img/about4.jpg') }} alt="#" >
							</div>
							<div class="single-pf">
								<img src={{ asset('mediplus-lite/img/about5.jpeg') }} alt="#" >
								{{-- <a href="portfolio-details.html" class="btn">View Details</a> --}}
							</div>
							<div class="single-pf">
								<img src={{ asset('mediplus-lite/img/about8.jpeg') }} alt="#">
								{{-- <a href="portfolio-details.html" class="btn">View Details</a> --}}
							</div>
							<div class="single-pf">
								<img src={{ asset('mediplus-lite/img/about9.jpeg') }} alt="#">
								{{-- <a href="portfolio-details.html" class="btn">View Details</a> --}}
							</div>
							<div class="single-pf">
								<img src={{ asset('mediplus-lite/img/about10.jpeg') }} alt="#">
								{{-- <a href="portfolio-details.html" class="btn">View Details</a> --}}
							</div>
							<div class="single-pf">
								<img src={{ asset('mediplus-lite/img/about11.jpeg') }} alt="#">
								{{-- <a href="portfolio-details.html" class="btn">View Details</a> --}}
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--/ End portfolio -->
		<!--/ End Why choose -->
		<!-- Start Feautes -->
		{{-- <section class="Feautes section">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="section-title">
							<h2>ABOUT</h2>
							
							<img src="img/section-img.png" alt="#">
							<p> SIMAWA UNJA merupakan sistem informasi mahasiswa UNJA yang terkoordinir di bawah lembaga 
								pengembangan kemahasiswaan dan alumni Universitas Jambi yang berfungsi untuk 
								pengelolaan seluruh kegiatan kemahasiswaan Universitas Jambi.</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4 col-12">
						<!-- Start Single features -->
						<div class="single-features">
							<div class="signle-icon">
								<i class="icofont icofont-ambulance-cross"></i>
							</div>
							<h3>Emergency Help</h3>
							<p>Lorem ipsum sit, consectetur adipiscing elit. Maecenas mi quam vulputate.</p>
						</div>
						<!-- End Single features -->
					</div>
					<div class="col-lg-4 col-12">
						<!-- Start Single features -->
						<div class="single-features">
							<div class="signle-icon">
								<i class="icofont icofont-medical-sign-alt"></i>
							</div>
							<h3>Enriched Pharmecy</h3>
							<p>Lorem ipsum sit, consectetur adipiscing elit. Maecenas mi quam vulputate.</p>
						</div>
						<!-- End Single features -->
					</div>
					<div class="col-lg-4 col-12">
						<!-- Start Single features -->
						<div class="single-features last">
							<div class="signle-icon">
								<i class="icofont icofont-stethoscope"></i>
							</div>
							<h3>Medical Treatment</h3>
							<p>Lorem ipsum sit, consectetur adipiscing elit. Maecenas mi quam vulputate.</p>
						</div>
						<!-- End Single features -->
					</div>
				</div>
			</div>
		</section> --}}
		<!--/ End Feautes -->
		
		<!-- Start Fun-facts -->
		{{-- <div id="fun-facts" class="fun-facts section overlay">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-md-6 col-12">
						<!-- Start Single Fun -->
						<div class="single-fun">
							<i class="icofont icofont-home"></i>
							<div class="content">
								<span class="counter">3468</span>
								<p>Hospital Rooms</p>
							</div>
						</div>
						<!-- End Single Fun -->
					</div>
					<div class="col-lg-3 col-md-6 col-12">
						<!-- Start Single Fun -->
						<div class="single-fun">
							<i class="icofont icofont-user-alt-3"></i>
							<div class="content">
								<span class="counter">557</span>
								<p>Specialist Doctors</p>
							</div>
						</div>
						<!-- End Single Fun -->
					</div>
					<div class="col-lg-3 col-md-6 col-12">
						<!-- Start Single Fun -->
						<div class="single-fun">
							<i class="icofont-simple-smile"></i>
							<div class="content">
								<span class="counter">4379</span>
								<p>Happy Patients</p>
							</div>
						</div>
						<!-- End Single Fun -->
					</div>
					<div class="col-lg-3 col-md-6 col-12">
						<!-- Start Single Fun -->
						<div class="single-fun">
							<i class="icofont icofont-table"></i>
							<div class="content">
								<span class="counter">32</span>
								<p>Years of Experience</p>
							</div>
						</div>
						<!-- End Single Fun -->
					</div>
				</div>
			</div>
		</div> --}}
		<!--/ End Fun-facts -->
				
		<!-- Start Call to action -->
		{{-- <section class="call-action overlay" data-stellar-background-ratio="0.5">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-12">
						<div class="content">
							<h2>Do you need Emergency Medical Care? Call @ 1234 56789</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque porttitor dictum turpis nec gravida.</p>
							<div class="button">
								<a href="#" class="btn">Contact Now</a>
								<a href="#" class="btn second">Learn More<i class="fa fa-long-arrow-right"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section> --}}
		<!--/ End Call to action -->

		<!-- Start service -->
		{{-- <section class="services section">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="section-title">
							<h2>We Offer Different Services To Improve Your Health</h2>
							<img src="img/section-img.png" alt="#">
							<p>Lorem ipsum dolor sit amet consectetur adipiscing elit praesent aliquet. pretiumts</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4 col-md-6 col-12">
						<!-- Start Single Service -->
						<div class="single-service">
							<i class="icofont icofont-prescription"></i>
							<h4><a href="service-details.html">General Treatment</a></h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec luctus dictum eros ut imperdiet. </p>	
						</div>
						<!-- End Single Service -->
					</div>
					<div class="col-lg-4 col-md-6 col-12">
						<!-- Start Single Service -->
						<div class="single-service">
							<i class="icofont icofont-tooth"></i>
							<h4><a href="service-details.html">Teeth Whitening</a></h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec luctus dictum eros ut imperdiet. </p>	
						</div>
						<!-- End Single Service -->
					</div>
					<div class="col-lg-4 col-md-6 col-12">
						<!-- Start Single Service -->
						<div class="single-service">
							<i class="icofont icofont-heart-alt"></i>
							<h4><a href="service-details.html">Heart Surgery</a></h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec luctus dictum eros ut imperdiet. </p>	
						</div>
						<!-- End Single Service -->
					</div>
					<div class="col-lg-4 col-md-6 col-12">
						<!-- Start Single Service -->
						<div class="single-service">
							<i class="icofont icofont-listening"></i>
							<h4><a href="service-details.html">Ear Treatment</a></h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec luctus dictum eros ut imperdiet. </p>	
						</div>
						<!-- End Single Service -->
					</div>
					<div class="col-lg-4 col-md-6 col-12">
						<!-- Start Single Service -->
						<div class="single-service">
							<i class="icofont icofont-eye-alt"></i>
							<h4><a href="service-details.html">Vision Problems</a></h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec luctus dictum eros ut imperdiet. </p>	
						</div>
						<!-- End Single Service -->
					</div>
					<div class="col-lg-4 col-md-6 col-12">
						<!-- Start Single Service -->
						<div class="single-service">
							<i class="icofont icofont-blood"></i>
							<h4><a href="service-details.html">Blood Transfusion</a></h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec luctus dictum eros ut imperdiet. </p>	
						</div>
						<!-- End Single Service -->
					</div>
				</div>
			</div>
		</section> --}}
		<!--/ End service -->
		
		<!-- Pricing Table -->
		{{-- <section class="pricing-table section">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="section-title">
							<h2>We Provide You The Best Treatment In Resonable Price</h2>
							<img src="img/section-img.png" alt="#">
							<p>Lorem ipsum dolor sit amet consectetur adipiscing elit praesent aliquet. pretiumts</p>
						</div>
					</div>
				</div>
				<div class="row">
					<!-- Single Table -->
					<div class="col-lg-4 col-md-12 col-12">
						<div class="single-table">
							<!-- Table Head -->
							<div class="table-head">
								<div class="icon">
									<i class="icofont icofont-ui-cut"></i>
								</div>
								<h4 class="title">Plastic Suggery</h4>
								<div class="price">
									<p class="amount">$199<span>/ Per Visit</span></p>
								</div>	
							</div>
							<!-- Table List -->
							<ul class="table-list">
								<li><i class="icofont icofont-ui-check"></i>Lorem ipsum dolor sit</li>
								<li><i class="icofont icofont-ui-check"></i>Cubitur sollicitudin fentum</li>
								<li class="cross"><i class="icofont icofont-ui-close"></i>Nullam interdum enim</li>
								<li class="cross"><i class="icofont icofont-ui-close"></i>Donec ultricies metus</li>
								<li class="cross"><i class="icofont icofont-ui-close"></i>Pellentesque eget nibh</li>
							</ul>
							<div class="table-bottom">
								<a class="btn" href="#">Book Now</a>
							</div>
							<!-- Table Bottom -->
						</div>
					</div>
					<!-- End Single Table-->
					<!-- Single Table -->
					<div class="col-lg-4 col-md-12 col-12">
						<div class="single-table">
							<!-- Table Head -->
							<div class="table-head">
								<div class="icon">
									<i class="icofont icofont-tooth"></i>
								</div>
								<h4 class="title">Teeth Whitening</h4>
								<div class="price">
									<p class="amount">$299<span>/ Per Visit</span></p>
								</div>	
							</div>
							<!-- Table List -->
							<ul class="table-list">
								<li><i class="icofont icofont-ui-check"></i>Lorem ipsum dolor sit</li>
								<li><i class="icofont icofont-ui-check"></i>Cubitur sollicitudin fentum</li>
								<li><i class="icofont icofont-ui-check"></i>Nullam interdum enim</li>
								<li class="cross"><i class="icofont icofont-ui-close"></i>Donec ultricies metus</li>
								<li class="cross"><i class="icofont icofont-ui-close"></i>Pellentesque eget nibh</li>
							</ul>
							<div class="table-bottom">
								<a class="btn" href="#">Book Now</a>
							</div>
							<!-- Table Bottom -->
						</div>
					</div>
					<!-- End Single Table-->
					<!-- Single Table -->
					<div class="col-lg-4 col-md-12 col-12">
						<div class="single-table">
							<!-- Table Head -->
							<div class="table-head">
								<div class="icon">
									<i class="icofont-heart-beat"></i>
								</div>
								<h4 class="title">Heart Suggery</h4>
								<div class="price">
									<p class="amount">$399<span>/ Per Visit</span></p>
								</div>	
							</div>
							<!-- Table List -->
							<ul class="table-list">
								<li><i class="icofont icofont-ui-check"></i>Lorem ipsum dolor sit</li>
								<li><i class="icofont icofont-ui-check"></i>Cubitur sollicitudin fentum</li>
								<li><i class="icofont icofont-ui-check"></i>Nullam interdum enim</li>
								<li><i class="icofont icofont-ui-check"></i>Donec ultricies metus</li>
								<li><i class="icofont icofont-ui-check"></i>Pellentesque eget nibh</li>
							</ul>
							<div class="table-bottom">
								<a class="btn" href="#">Book Now</a>
							</div>
							<!-- Table Bottom -->
						</div>
					</div>
					<!-- End Single Table-->
				</div>	
			</div>	
		</section>	 --}}
		<!--/ End Pricing Table -->
					
		<!-- Start clients -->
		{{-- <div class="clients overlay">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-12">
						<div class="owl-carousel clients-slider">
							<div class="single-clients">
								<img src="img/client1.png" alt="#">
							</div>
							<div class="single-clients">
								<img src="img/client2.png" alt="#">
							</div>
							<div class="single-clients">
								<img src="img/client3.png" alt="#">
							</div>
							<div class="single-clients">
								<img src="img/client4.png" alt="#">
							</div>
							<div class="single-clients">
								<img src="img/client5.png" alt="#">
							</div>
							<div class="single-clients">
								<img src="img/client1.png" alt="#">
							</div>
							<div class="single-clients">
								<img src="img/client2.png" alt="#">
							</div>
							<div class="single-clients">
								<img src="img/client3.png" alt="#">
							</div>
							<div class="single-clients">
								<img src="img/client4.png" alt="#">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> --}}
		<!--/Ens clients -->
		
		<!-- Start Appointment -->
		{{-- <section class="appointment">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="section-title">
							<h2>We Are Always Ready to Help You. Book An Appointment</h2>
							<img src="img/section-img.png" alt="#">
							<p>Lorem ipsum dolor sit amet consectetur adipiscing elit praesent aliquet. pretiumts</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-12 col-12">
						<form class="form" action="#">
							<div class="row">
								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<input name="name" type="text" placeholder="Name">
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<input name="email" type="email" placeholder="Email">
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<input name="phone" type="text" placeholder="Phone">
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<div class="nice-select form-control wide" tabindex="0"><span class="current">Department</span>
											<ul class="list">
												<li data-value="1" class="option selected ">Department</li>
												<li data-value="2" class="option">Cardiac Clinic</li>
												<li data-value="3" class="option">Neurology</li>
												<li data-value="4" class="option">Dentistry</li>
												<li data-value="5" class="option">Gastroenterology</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<div class="nice-select form-control wide" tabindex="0"><span class="current">Doctor</span>
											<ul class="list">
												<li data-value="1" class="option selected ">Doctor</li>
												<li data-value="2" class="option">Dr. Akther Hossain</li>
												<li data-value="3" class="option">Dr. Dery Alex</li>
												<li data-value="4" class="option">Dr. Jovis Karon</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<input type="text" placeholder="Date" id="datepicker">
									</div>
								</div>
								<div class="col-lg-12 col-md-12 col-12">
									<div class="form-group">
										<textarea name="message" placeholder="Write Your Message Here....."></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-5 col-md-4 col-12">
									<div class="form-group">
										<div class="button">
											<button type="submit" class="btn">Book An Appointment</button>
										</div>
									</div>
								</div>
								<div class="col-lg-7 col-md-8 col-12">
									<p>( We will be confirm by an Text Message )</p>
								</div>
							</div>
						</form>
					</div>
					<div class="col-lg-6 col-md-12 ">
						<div class="appointment-image">
							<img src="img/contact-img.png" alt="#">
						</div>
					</div>
				</div>
			</div>
		</section> --}}
		<!-- End Appointment -->
		
		<!-- Start Newsletter Area -->
		{{-- <section class="newsletter section">
			<div class="container">
				<div class="row ">
					<div class="col-lg-6  col-12">
						<!-- Start Newsletter Form -->
						<div class="subscribe-text ">
							<h6>Sign up for newsletter</h6>
							<p class="">Cu qui soleat partiendo urbanitas. Eum aperiri indoctum eu,<br> homero alterum.</p>
						</div>
						<!-- End Newsletter Form -->
					</div>
					<div class="col-lg-6  col-12">
						<!-- Start Newsletter Form -->
						<div class="subscribe-form ">
							<form action="mail/mail.php" method="get" target="_blank" class="newsletter-inner">
								<input name="EMAIL" placeholder="Your email address" class="common-input" onfocus="this.placeholder = ''"
									onblur="this.placeholder = 'Your email address'" required="" type="email">
								<button class="btn">Subscribe</button>
							</form>
						</div>
						<!-- End Newsletter Form -->
					</div>
				</div>
			</div>
		</section> --}}
		<!-- /End Newsletter Area -->
		
		<!-- Footer Area -->
		<footer id="footer" class="footer ">
			<!-- Footer Top -->
			<div class="footer-top">
				<div class="container">
					<div class="row">
						<div class="col-lg-6 col-md-6 col-12">
							<div class="single-footer">
								<h2>Tentang Kami</h2>
								<p>Sistem Informasi Kemahasiswaan (SIMAWA) UNJA merupakan sistem informasi mahasiswa UNJA yang terkoordinir di bawah lembaga 
									pengembangan kemahasiswaan dan alumni Universitas Jambi yang berfungsi untuk 
									pengelolaan seluruh kegiatan kemahasiswaan Universitas Jambi.</p>
								<!-- Social -->
								<ul class="social">
									<li><a href="#"><i class="icofont-facebook"></i></a></li>
									<li><a href="#"><i class="icofont-instagram"></i></a></li>
									<li><a href="#"><i class="icofont-youtube"></i></a></li>
									<li><a href="#"><i class="icofont-email"></i></a></li>
									{{-- <li><a href="#"><i class="icofont-pinterest"></i></a></li> --}}
								</ul>
								<!-- End Social -->
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-12">
							<div class="single-footer f-link">
								<h2>Link Utama</h2>
								<div class="row">
									<div class="col-lg-12 col-md-6 col-12">
										<ul>
											<li><a href="https://www.unja.ac.id/"><i class="fa fa-caret-right" aria-hidden="true"></i>WEB UNJA</a></li>
											<li><a href="https://gerbang.unja.ac.id/"><i class="fa fa-caret-right" aria-hidden="true"></i>PORTAL GERBANG UNJA</a></li>
											<li><a href="https://siakad.unja.ac.id/"><i class="fa fa-caret-right" aria-hidden="true"></i>SISTEM INFORMASI AKADEMIK</a></li>
											<li><a href="https://skpi.unja.ac.id/"><i class="fa fa-caret-right" aria-hidden="true"></i>SKPI</a></li>
											<li><a href="https://www.library.unja.ac.id/"><i class="fa fa-caret-right" aria-hidden="true"></i>PERPUSTAKAAN</a></li>	
											<li><a href="https://repository.unja.ac.id/"><i class="fa fa-caret-right" aria-hidden="true"></i>REPOSITORY</a></li>	
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-12">
							<div class="single-footer">
								<h2>Kontak Kami</h2>
								<p>Jl. Raya Jambi - Muara Bulian Km. 15, Mendalo Indah, Jambi Luar Kota, Jambi 36361</p>
								<ul class="time-sidual">
									<li class="day">Senin - Jum'at <span>07.00 - 17.00 WIB</span></li>
									{{-- <li class="day">Saturday <span>9.00-18.30</span></li>
									<li class="day">Monday - Thusday <span>9.00-15.00</span></li> --}}
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/ End Footer Top -->
			<!-- Copyright -->
			<div class="copyright">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-12">
							<div class="copyright-content">
								<p>© Copyright 2024  |  All Rights Reserved by UNIVERSITAS JAMBI </p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/ End Copyright -->
		</footer>
		<!--/ End Footer Area -->
		
		<!-- jquery Min JS -->
        <script src="{{ asset('mediplus-lite/js/jquery.min.js') }}"></script>
        <!-- jquery Migrate JS -->
        <script src="{{ asset('mediplus-lite/js/jquery-migrate-3.0.0.js') }}"></script>
        <!-- jquery Ui JS -->
        <script src="{{ asset('mediplus-lite/js/jquery-ui.min.js') }}"></script>
        <!-- Easing JS -->
        <script src="{{ asset('mediplus-lite/js/easing.js') }}"></script>
        <!-- Color JS -->
        <script src="{{ asset('mediplus-lite/js/colors.js') }}"></script>
        <!-- Popper JS -->
        <script src="{{ asset('mediplus-lite/js/popper.min.js') }}"></script>
        <!-- Bootstrap Datepicker JS -->
        <script src="{{ asset('mediplus-lite/js/bootstrap-datepicker.js') }}"></script>
        <!-- Jquery Nav JS -->
        <script src="{{ asset('mediplus-lite/js/jquery.nav.js') }}"></script>
        <!-- Slicknav JS -->
        <script src="{{ asset('mediplus-lite/js/slicknav.min.js') }}"></script>
        <!-- ScrollUp JS -->
        <script src="{{ asset('mediplus-lite/js/jquery.scrollUp.min.js') }}"></script>
        <!-- Niceselect JS -->
        <script src="{{ asset('mediplus-lite/js/niceselect.js') }}"></script>
        <!-- Tilt Jquery JS -->
        <script src="{{ asset('mediplus-lite/js/tilt.jquery.min.js') }}"></script>
        <!-- Owl Carousel JS -->
        <script src="{{ asset('mediplus-lite/js/owl-carousel.js') }}"></script>
        <!-- Counterup JS -->
        <script src="{{ asset('mediplus-lite/js/jquery.counterup.min.js') }}"></script>
        <!-- Steller JS -->
        <script src="{{ asset('mediplus-lite/js/steller.js') }}"></script>
        <!-- Wow JS -->
        <script src="{{ asset('mediplus-lite/js/wow.min.js') }}"></script>
        <!-- Magnific Popup JS -->
        <script src="{{ asset('mediplus-lite/js/jquery.magnific-popup.min.js') }}"></script>
        <!-- Counter Up CDN JS -->
        <script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
        <!-- Bootstrap JS -->
        <script src="{{ asset('mediplus-lite/js/bootstrap.min.js') }}"></script>
        <!-- Main JS -->
        <script src="{{ asset('mediplus-lite/js/main.js') }}"></script>
		<script>
			$('.hero-slider').owlCarousel({
				items: 1,
				loop: false,  // Nonaktifkan perulangan
				autoplay: false, // Nonaktifkan autoplay
				nav: false, // Nonaktifkan navigasi jika tidak dibutuhkan
			});
		</script>

    </body>
</html>
{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel SPA</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        /* Your existing Tailwind CSS styles or any other styles here */
        html, body {
            scroll-behavior: smooth;
        }
        .section {
            padding: 2rem 0;
            min-height: 100vh;
        }
    </style>
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <!-- Navigation with scroll links -->
                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <div class="flex lg:justify-center lg:col-start-2">
                        <a href="#home" class="px-3 py-2 text-black dark:text-white">Home</a>
                        <a href="#berita" class="px-3 py-2 text-black dark:text-white">Berita</a>
                        <a href="#pengumuman" class="px-3 py-2 text-black dark:text-white">Pengumuman</a>
                        <a href="#statistik" class="px-3 py-2 text-black dark:text-white">Statistik</a>
                    </div>

                    @if (Route::has('login'))
                        <nav class="-mx-3 flex flex-1 justify-end">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="rounded-md px-3 py-2 text-black dark:text-white">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-black dark:text-white">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="rounded-md px-3 py-2 text-black dark:text-white">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </header>

                <!-- Section: Home -->
                <section id="home" class="section">
                    <h2 class="text-2xl font-semibold text-center">Home</h2>
                    <p>Selamat datang di halaman Home.</p>
                </section>

                <!-- Section: Berita -->
                <section id="berita" class="section">
                    <h2 class="text-2xl font-semibold text-center">Berita</h2>
                    <p>Berita terkini akan ditampilkan di sini.</p>
                </section>

                <!-- Section: Pengumuman -->
                <section id="pengumuman" class="section">
                    <h2 class="text-2xl font-semibold text-center">Pengumuman</h2>
                    <p>Pengumuman terbaru akan ditampilkan di sini.</p>
                </section>

                <!-- Section: Statistik -->
                <section id="statistik" class="section">
                    <h2 class="text-2xl font-semibold text-center">Statistik</h2>
                    <p>Statistik terkait akan ditampilkan di sini.</p>
                </section>

                <!-- Footer -->
                <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </footer>
            </div>
        </div>
    </div>
</body>
</html> --}}
