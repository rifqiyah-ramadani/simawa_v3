@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        .card:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease-in-out;
        }

        .small-box-footer:hover {
            color: #ffd54f; /* Warna teks berubah saat dihover */
        }
    </style>
@endpush

@section('content')
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header py-3 bg-light border-bottom">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h3 class="mb-0">
                        Dashboard Operator Kemahasiswaan
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
    <div class="container-fluid py-4">
        <div class="row g-4 mb-4">
            <!-- Card Jumlah Usulan Beasiswa -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 p-3" 
                    style="
                        border-radius: 15px; 
                        background: linear-gradient(135deg, #e3f2fd, #bbdefb); 
                        transition: transform 0.3s, box-shadow 0.3s;">
                    <!-- Struktur Baris Ikon dan Konten -->
                    <div class="d-flex align-items-center mb-3">
                        <!-- Ikon di Kiri -->
                        <div class="icon-circle" 
                            style="
                                width: 50px; 
                                height: 50px; 
                                background: linear-gradient(135deg, #0288d1, #03a9f4); 
                                border-radius: 50%; 
                                display: flex; 
                                align-items: center; 
                                justify-content: center; 
                                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);">
                            <i class="fas fa-folder-open fa-lg text-white"></i>
                        </div>

                        <!-- Konten Teks -->
                        <div class="ms-3">
                            <h4 class="fw-bold mb-0" style="color: #333;">{{ $jumlahUsulan }}</h4>
                            <p class="text-secondary mb-0" style="font-size: 0.95rem;">Jumlah Usulan Beasiswa</p>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="text-center mt-3">
                        <a href="kelola_beasiswa/usulan_beasiswa" 
                        class="d-inline-block fw-bold text-decoration-none"
                        style="
                            display: inline-block;
                            color: #0288d1;
                            background: #ffffff; 
                            border: 1px solid #0288d1;
                            font-weight: 600;
                            border-radius: 20px;
                            padding: 8px 20px;
                            text-transform: uppercase;
                            font-size: 14px;
                            transition: all 0.3s ease;">
                            Lihat Detail <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Jumlah Beasiswa Tervalidasi -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 p-3" 
                    style="
                        border-radius: 15px; 
                        background: linear-gradient(135deg, #fbe9e7, #ffccbc); 
                        transition: transform 0.3s, box-shadow 0.3s;">
                    <!-- Struktur Baris Ikon dan Konten -->
                    <div class="d-flex align-items-center mb-3">
                        <!-- Ikon di Kiri -->
                        <div class="icon-circle" 
                            style="
                                width: 50px; 
                                height: 50px; 
                                background: linear-gradient(135deg, #e64a19, #ff5722); 
                                border-radius: 50%; 
                                display: flex; 
                                align-items: center; 
                                justify-content: center; 
                                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);">
                            <i class="fas fa-check-circle fa-lg text-white"></i>
                        </div>

                        <!-- Konten Teks -->
                        <div class="ms-3">
                            <h4 class="fw-bold mb-0" style="color: #333;">{{ $jumlahTervalidasi }}</h4>
                            <p class="text-secondary mb-0" style="font-size: 0.95rem;">Beasiswa Tervalidasi</p>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="text-center mt-3">
                        <a href="kelola_beasiswa/usulan_beasiswa" 
                        class="d-inline-block fw-bold text-decoration-none"
                        style="
                            display: inline-block;
                            color: #e64a19;
                            background: #ffffff; 
                            border: 1px solid #e64a19;
                            font-weight: 600;
                            border-radius: 20px;
                            padding: 8px 20px;
                            text-transform: uppercase;
                            font-size: 14px;
                            transition: all 0.3s ease;">
                            Lihat Detail <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Jumlah Penerima Beasiswa -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 p-3" 
                    style="
                        border-radius: 15px; 
                        background: linear-gradient(135deg, #e8f5e9, #c8e6c9); 
                        transition: transform 0.3s, box-shadow 0.3s;">
                    <!-- Struktur Baris Ikon dan Konten -->
                    <div class="d-flex align-items-center mb-3">
                        <!-- Ikon di Kiri -->
                        <div class="icon-circle" 
                            style="
                                width: 50px; 
                                height: 50px; 
                                background: linear-gradient(135deg, #388e3c, #4caf50); 
                                border-radius: 50%; 
                                display: flex; 
                                align-items: center; 
                                justify-content: center; 
                                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);">
                            <i class="fas fa-users fa-lg text-white"></i>
                        </div>

                        <!-- Konten Teks -->
                        <div class="ms-3">
                            <h4 class="fw-bold mb-0" style="color: #333;">{{ $jumlahPenerima }}</h4>
                            <p class="text-secondary mb-0" style="font-size: 0.95rem;">Penerima Beasiswa</p>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="text-center mt-3">
                        <a href="kelola_beasiswa/penerima_beasiswa" 
                        class="d-inline-block fw-bold text-decoration-none"
                        style="
                            display: inline-block;
                            color: #388e3c;
                            background: #ffffff; 
                            border: 1px solid #388e3c;
                            font-weight: 600;
                            border-radius: 20px;
                            padding: 8px 20px;
                            text-transform: uppercase;
                            font-size: 14px;
                            transition: all 0.3s ease;">
                            Lihat Detail <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
           
        <div class="row g-4">
            <!-- Card Selamat Datang -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 p-4" style="border-radius: 15px; background-color: #ffffff;">
                    <div class="card-body text-center">
                        <!-- Ikon -->
                        <div class="icon-circle mx-auto mb-3" 
                             style="
                                 width: 80px; 
                                 height: 80px; 
                                 background-color: #ffe082; 
                                 border-radius: 50%; 
                                 display: flex; 
                                 align-items: center; 
                                 justify-content: center; 
                                 box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);">
                            <i class="fas fa-user-graduate fa-2x" style="color: #f57c00;"></i>
                        </div>
                        <!-- Teks -->
                        <h4 class="fw-bold text-dark">
                            Selamat Datang, <span style="color: #f57c00;">{{ $user->name }}</span>!
                        </h4>
                        <p class="text-muted" style="font-size: 1rem;">{{ $user->username }}</p>
                        <hr class="my-3" style="border-top: 2px solid #f57c00; width: 60%; margin: 0 auto;">
                        <!-- Role -->
                        <div class="d-flex justify-content-center flex-wrap gap-2 mt-2">
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

             <!-- Grafik Aktivitas -->
                <div class="col-lg-6">
                    <div class="card card-shadow border-0">
                        <div class="card-header text-white" style="background: #f57c00">
                            <h5 class="mb-0">📈 Grafik Aktivitas</h5>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="activityChart"></canvas>
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
    <script>
        // Data untuk Grafik Jumlah Penerima Beasiswa Per Tahun
        const ctx = document.getElementById('activityChart').getContext('2d');
        const activityChart = new Chart(ctx, {
            type: 'bar', // Gunakan tipe chart bar
            data: {
                labels: {!! json_encode($chartLabels ?? []) !!}, // Tahun
                datasets: [{
                    label: 'Jumlah Penerima Beasiswa',
                    data: {!! json_encode($chartData ?? []) !!}, // Data jumlah per tahun
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Warna bar
                    borderColor: 'rgba(75, 192, 192, 1)', // Warna border bar
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.raw} Penerima`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Tahun',
                            font: { size: 14, weight: 'bold' }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Penerima',
                            font: { size: 14, weight: 'bold' }
                        }
                    }
                }
            }
        });
    </script>
@endpush

