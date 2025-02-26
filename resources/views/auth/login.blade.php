<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>SIMAWA UNJA</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE v4 | Dashboard">
    <meta name="author" content="ColorlibHQ">
    <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard">
    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous">
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous">
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous">
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{asset('AdminLTE4/dist/pages/../../dist/css/adminlte.css')}}">
    <!--end::Required Plugin(AdminLTE)-->
    <!-- apexcharts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous">
    <!-- jsvectormap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css" integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
</head> <!--end::Head-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container py-1 h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
              <div class="card rounded-3 text-black">
                <div class="row g-0">
                  <div class="col-lg-6">
                    <div class="card-body p-md-5 mx-md-4">
                      <div class="text-center">
                        <img src="{{ asset('images/logo.png') }}" alt="SIMAWA Logo" style="width: 100px;" />
                        <h4 class="mt-3 mb-3 pb-1">SISTEM INFORMASI KEMAHASISWAAN UNIVERSITAS JAMBI</h4>
                      </div>
                    
                      <!-- Form Login -->
                      <form action="{{ route('login') }}" method="POST">
                        @csrf
                    
                        <!-- Username Field -->
                        <div class="mb-3">
                          <label for="username" class="form-label">Username:</label>
                          <input type="text" 
                                 class="form-control @error('username') is-invalid @enderror" 
                                 id="username" 
                                 name="username" 
                                 value="{{ old('username') }}" 
                                 placeholder="Enter username" 
                                 required>
                          @error('username')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                    
                        <!-- Password Field -->
                        <div class="mb-3">
                          <label for="password" class="form-label">Password:</label>
                          <input type="password" 
                                 class="form-control @error('password') is-invalid @enderror" 
                                 id="password" 
                                 name="password" 
                                 placeholder="Enter password" 
                                 required>
                          @error('password')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                    
                        <!-- Remember Me -->
                        <div class="form-check mb-3">
                          <input class="form-check-input" type="checkbox" name="remember" id="remember">
                          <label class="form-check-label" for="remember">Remember Me</label>
                        </div>
                    
                        <!-- Submit Button -->
                        <div class="d-grid">
                          <button type="submit" class="btn btn-block text-white" style="background-color: #ff9800;">Masuk</button>
                        </div>
                      </form>
                    </div>
                    
                  </div>
                  <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                    <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                      <h4 class="mb-4">Selamat Datang di SIMAWA UNJA</h4>
                      <p class="small mb-0">
                        SIMAWA UNJA merupakan sistem informasi mahasiswa UNJA yang terkoordinir di bawah lembaga 
                        pengembangan kemahasiswaan dan alumni Universitas Jambi yang berfungsi untuk 
                        pengelolaan seluruh kegiatan kemahasiswaan Universitas Jambi.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section> <!--begin::Script--> <!--begin::Third Party Plugin(OverlayScrollbars)-->
   
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script>
    <!-- Required Plugins -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script>
    <script src="{{asset('AdminLTE4/dist/pages/../../dist/js/adminlte.js')}}"></script>
</body><!--end::Body-->
</html>
