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
		<!-- Header Area -->
		<header class="header" >
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
		
		<!-- Breadcrumbs -->
		<div class="breadcrumbs overlay">
			<div class="container">
				<div class="bread-inner">
					<div class="row">
						<div class="col-12">
							<h2>Detail Berita</h2>
							<ul class="bread-list">
								<li><a href="index.html">Home</a></li>
								<li><i class="icofont-simple-right"></i></li>
								<li class="active">Detail Berita</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Breadcrumbs -->
		
		<!-- Single News -->
		<section class="news-single section">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 col-12">
						<div class="row">
							<div class="col-12">
								<div class="single-main">
									<!-- News Head -->
									<div class="news-head mb-4">
										<img src="{{ asset('storage/' . $berita->image) }}" alt="{{ $berita->judul }}" class="img-fluid rounded">
									</div>

									<!-- News Title -->
									<h1 class="news-title"><a href="#">{{ $berita->judul }}</a></h1>
									
									<!-- Category -->
									<div class="news-category mb-3">
										<span class="badge bg-warning text-white">Berita Kampus</span>
									</div>

									<!-- Meta -->
									<div class="meta d-flex align-items-center justify-content-between mb-4">
										<span class="date"><i class="fa fa-clock-o"></i> Dipublikasikan {{ \Carbon\Carbon::parse($berita->publish_date)->format('d M, Y') }}</span>
										<span class="author d-flex align-items-center"><i class="fa fa-user"></i> Oleh Admin</span>
									</div>

									<!-- News Text -->
									<div class="news-text">
										{!! $berita->content !!}
									</div>
									
									<div class="blog-bottom mt-3">
										<!-- Social Share -->
										<ul class="social-share">
											<li class="facebook">
												<a href="#">
													<i class="fa fa-facebook"></i>
													<span>Facebook</span>
												</a>
											</li>
											<li class="twitter">
												<a href="#">
													<i class="fa fa-twitter"></i>
													<span>Twitter</span>
												</a>
											</li>
											<li class="instagram">
												<a href="#">
													<i class="fa fa-instagram"></i>
													<span>Instagram</span>
												</a>
											</li>
											<li class="linkedin">
												<a href="#">
													<i class="fa fa-linkedin"></i>
													<span>LinkedIn</span>
												</a>
											</li>
										</ul>
									</div>									
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-12">
						<div class="main-sidebar">
							<!-- Single Widget -->
							<div class="single-widget search">
								<form id="search-form">
									<div class="form">
										<input type="text" id="search-query" name="query" placeholder="Search Here..." required>
										<button class="button" type="submit">
											<i class="fa fa-search"></i>
										</button>
									</div>
								</form>
							</div>
							
							<!-- Single Widget -->
							<div class="single-widget recent-post">
								<h3 class="title">Recent Post</h3>
								@foreach ($recentPosts as $post)
									<!-- Single Post -->
									<div class="single-post">
										<div class="image">
											<img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->judul }}" class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;">
										</div>
										<div class="content">
											<h5>
												<a href="{{ route('berita.show', $post->id) }}">{{ $post->judul }}</a>
											</h5>
											<ul class="meta">
												<li><i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($post->publish_date)->format('M d, Y') }}</li>
											</ul>
										</div>
									</div>
									<!-- End Single Post -->
								@endforeach
							</div>
							<!--/ End Single Widget -->
						</div>
					</div>
					
				</div>
			</div>
		</section>
		<!--/ End Single News -->
		
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
			$(document).ready(function() {
			$('#search-form').on('submit', function(e) {
				e.preventDefault(); // Cegah reload halaman

				let query = $('#search-query').val(); // Ambil input pencarian

				if (query.length >= 3) { // Validasi minimal 3 karakter
					$.ajax({
						url: '/search', // Endpoint untuk search
						method: 'GET',
						data: { query: query },
						success: function(response) {
							// Perbarui Recent Post dengan hasil pencarian
							$('.recent-post').html(response.html);
						},
						error: function() {
							$('.recent-post').html('<p>An error occurred. Please try again.</p>');
						}
					});
				} else {
					$('.recent-post').html('<p>Please type at least 3 characters to search.</p>');
				}
			});
		});
		</script>
    </body>
</html>

