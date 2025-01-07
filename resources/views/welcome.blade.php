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
											<li><a href="#home">Home</a></li>
											<li><a href="#about">About</a></li>
											<li><a href="#informasi">Informasi</a></li>
											{{-- <li><a href="#">Statistik <i class="icofont-rounded-down"></i></a>
												<ul class="dropdown">
													<li><a href="blog-single.html">Statistik Prestasi</a></li>
                                                    <li><a href="blog-single.html">Statistik Beasiswa</a></li>
												</ul>
											</li> --}}
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
										<li><i class="fa fa-circle"></i>Pendanaan</li>
										<li><i class="fa fa-circle"></i>Beasiswa </li>
									</ul>
								</div>
								{{-- <div class="col-lg-6">
									<ul class="list">
										<li><i class="fa fa-circle"></i>Unit Kegiatan Mahasiswa</li> 
										<li><i class="fa fa-circle"></i>Organisasi Kemahasiswaan</li>
									</ul>
								</div> --}}
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
