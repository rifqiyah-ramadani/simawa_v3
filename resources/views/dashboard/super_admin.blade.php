@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
@endpush

@section('content')
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header py-3 bg-light border-bottom">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h3 class="mb-0">
                        Dashboard Super Admin
                    </h3>
                </div>
                <div class="col-md-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb float-md-end mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!--end::App Content Header-->

    <!--begin::App Content-->
    <div class="app-content py-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Card Selamat Datang -->
                    <div class="card shadow-lg border-0 p-4" style="border-radius: 15px; background-color: #ffffff;">
                        <div class="card-body">
                            <!-- Header -->
                            <div class="d-flex flex-column align-items-center">
                                <!-- Ikon di Bagian Atas -->
                                <div class="icon-circle mb-4" 
                                     style="
                                         width: 100px; 
                                         height: 100px; 
                                         background-color: #ffe082; 
                                         border-radius: 50%; 
                                         display: flex; 
                                         align-items: center; 
                                         justify-content: center; 
                                         box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);">
                                    <i class="fas fa-user-shield fa-3x" style="color: #f57c00;"></i>
                                </div>
                                <!-- Teks Utama -->
                                <h3 class="fw-bold text-dark mb-1">
                                    Selamat Datang, <span style="color: #f57c00;">{{ $user->name }}</span>!
                                </h3>
                                <p class="text-muted mb-2" style="font-size: 1.1rem;">
                                    {{ $user->username }}
                                </p>
                                <hr class="my-2" style="border: 0; border-top: 2px solid #f57c00; width: 60%; margin: 0 auto;">
                                <!-- Role -->
                                <div class="d-flex justify-content-center flex-wrap gap-2 mt-3">
                                    @foreach($roles as $role)
                                        <span class="badge rounded-pill bg-primary text-white px-3 py-2" style="font-size: 0.9rem;">
                                            <i class="
                                                @switch($role)
                                                    @case('Super Admin') fas fa-user-shield @break
                                                    @case('Mahasiswa') fas fa-user-graduate @break
                                                    @case('Operator Kemahasiswaan') fas fa-chalkboard-teacher @break
                                                    @case('Operator Fakultas') fas fa-briefcase @break
                                                    @default fas fa-user-circle
                                                @endswitch
                                            me-2"></i>{{ ucfirst($role) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
    <!--end::App Content-->
</main>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
