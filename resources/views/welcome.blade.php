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

			.news-head img {
				width: 100%; /* Lebar gambar mengikuti lebar kolom */
				height: 200px; /* Atur tinggi gambar */
				object-fit: cover; /* Memastikan gambar terpotong rapi */
				border-radius: 8px; /* Opsional: berikan sudut melengkung */
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
											<li><a href="#home">Home</a></li>
											<li><a href="#about">About</a></li>
											<li><a href="#informasi">Informasi</a></li>
											<li><a href="#">Statistik <i class="icofont-rounded-down"></i></a>
												<ul class="dropdown">
													<li><a href="blog-single.html">Statistik Prestasi</a></li>
                                                    <li><a href="blog-single.html">Statistik Beasiswa</a></li>
												</ul>
											</li>
											<li><a href="#galeri">Galeri</a></li>
										</ul>
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
		<section class="slider" id="home">
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
		<section class="why-choose section" id="about">
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
		<section class="blog section" id="informasi">
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
						@include('partials.berita-partial', ['berita' => $berita])
					</div>
		
					<!-- Pengumuman Tab -->
					<div class="tab-pane fade" id="pengumuman" role="tabpanel" aria-labelledby="pengumuman-tab">
						<div class="row">
							<div class="col-lg-6 col-12">
								<!-- Informasi tentang pengumuman -->
								<div class="pengumuman-left">
									<div class="icon-wrap mb-3">
										<i class="fa fa-bullhorn"></i>
									</div>
									<h2 class="title">PENGUMUMAN</h2>
									<p>
										Temukan semua informasi terbaru mengenai kegiatan mahasiswa, jadwal penting, dan pengumuman lainnya di sini. Pastikan untuk selalu mengikuti kabar terkini!
									</p>
									<a href="#" class="btn-pengumuman mt-3">Lihat Semua</a>
									{{-- <a href="#" class="btn btn-outline-warning mt-3">Lihat Semua</a> --}}
								</div>
							</div>
							<div class="col-lg-6 col-12">
								<div class="pengumuman-list" id="pengumuman-list">
									<!-- Data pengumuman akan dimuat di sini -->
									@include('partials.pengumuman-partial', ['pengumuman' => $pengumuman])
								</div>
							</div>						
						</div>
					</div>
					
				</div>
			</div>
		</section>
		<!-- End Blog Area -->

		<!-- Start portfolio -->
		<section class="portfolio section" id="galeri">
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
									<li><a href="https://www.id-id.facebook.com/univ.jambi/"><i class="icofont-facebook"></i></a></li>
									<li><a href="https://www.instagram.com/univ.jambi/"><i class="icofont-instagram"></i></a></li>
									<li><a href="https://x.com/univ_jambi"><i class="icofont-twitter"></i></a></li>
									<li><a href="https://www.youtube.com/@unjasmarttv"><i class="icofont-youtube"></i></a></li>
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
									<li>Email <span>example@unja.ac.id</span></li>
									<li class="day">Senin - Jum'at <span>07.00 - 17.00 WIB</span></li>
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

		<script>
			document.addEventListener('DOMContentLoaded', function () {
			const sections = document.querySelectorAll('section');
			const navLinks = document.querySelectorAll('.nav li a');

			// Fungsi untuk menandai menu aktif
			const setActiveMenu = () => {
				let current = '';

				sections.forEach(section => {
					const sectionTop = section.offsetTop;
					const sectionHeight = section.offsetHeight;

					if (window.pageYOffset >= sectionTop - sectionHeight / 3) {
						current = section.getAttribute('id');
					}
				});

				navLinks.forEach(link => {
					link.parentElement.classList.remove('active');
					if (link.getAttribute('href') === `#${current}`) {
						link.parentElement.classList.add('active');

						// Tambahkan active pada parent dropdown
						const dropdown = link.closest('.dropdown');
						if (dropdown) {
							dropdown.classList.add('active');
						}
					}
				});
			};

			// Panggil fungsi saat scrolling
			window.addEventListener('scroll', setActiveMenu);
		});
		</script>

		<!-- Query untuk pagination berita -->
		<script>
			// Tangani klik pada pagination khusus berita
			$(document).on('click', '.pagination-berita a', function (e) {
				e.preventDefault(); // Hentikan perilaku default link

				let page = $(this).attr('href').split('page=')[1]; // Ambil nomor halaman
				fetchBerita(page);
			});

			function fetchBerita(page) {
				$.ajax({
					url: "/?type=berita&page=" + page, // Tambahkan parameter type
					type: "GET",
					beforeSend: function () {
						$('#berita').html('<div class="text-center">Memuat data berita...</div>'); // Placeholder loading
					},
					success: function (data) {
						$('#berita').html(data); // Perbarui konten berita
					},
					error: function () {
						alert('Gagal memuat data berita.');
					}
				});
			}
		</script>

		<script>
			$(document).on('click', '#prev-pengumuman, #next-pengumuman', function (e) {
				e.preventDefault();

				let url = $(this).data('url'); // URL dari tombol
				let type = 'pengumuman'; // Tetapkan jenis data

				$.ajax({
					url: url,
					type: 'GET',
					data: { type: type }, // Kirim parameter type
					beforeSend: function () {
						$('#pengumuman-list').html('<div class="text-center">Memuat...</div>'); // Placeholder loading
					},
					success: function (response) {
						$('#pengumuman-list').html(response); // Update bagian pengumuman-list
					},
					error: function () {
						alert('Gagal memuat data pengumuman.');
					}
				});
			});
		</script>
    </body>
</html>
