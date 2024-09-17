@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
         .card-scholarship {
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Shadow untuk card */
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            border: 1px solid #e9ecef;
            background-color: #ffffff; 
        }

        .card-scholarship img {
            max-width: 80px; /* Ukuran logo */
            border-radius: 10px;
        }

        .card-body {
            flex-grow: 1;
            padding-left: 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-start; /* Pastikan elemen anak berada di kiri dan tidak meluas */
        }

        .badge-status {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.875rem;
            margin-bottom: 10px;
            display: inline-block;
            width: auto; /* Pastikan width mengikuti teks */
            flex-shrink: 0; /* Cegah badge meluas dalam konteks flexbox */
            text-transform: capitalize;
        }

        .tombol-daftar {
            background-color: #007bff;
            color: white;
            border-radius: 25px;
            padding: 8px 15px;
            font-size: 0.875rem;
        }

        .info-icons {
            font-size: 0.875rem;
            color: #6c757d;
            display: flex;
            align-items: center;
        }

        .info-icons span {
            margin-right: 10px;
            display: flex;
            align-items: center;
        }

        .info-icons i {
            margin-right: 5px;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card-subtitle {
            font-size: 0.875rem;
            margin-bottom: 10px;
            color: #6c757d;
        }
    </style>
@endpush

@section('content')
<main class="app-main"> 
    <div class="app-content-header"> 
        <div class="container-fluid"> 
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Kelola Beasiswa - Buat Pendaftaran</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Kelola Beasiswa</li>
                        <li class="breadcrumb-item active">Buat Pendaftaran</li>
                    </ol>
                </div>
            </div> 
        </div> 
    </div> 

    <div class="app-content"> 
        <div class="container-fluid"> 
            <div class="row">
                @foreach($buatPendaftaran as $item)
                <div class="col-md-12">
                    <div class="card-scholarship">
                        <!-- Bagian Kiri: Gambar Logo -->
                        <img src="{{asset('images/logo.png')}}" alt="Logo Beasiswa">
    
                        <!-- Bagian Tengah: Detail Beasiswa -->
                        <div class="card-body">
                            <!-- Status di atas judul -->
                            <span class="badge-status">{{ $item->status }}</span>
                            <h5 class="card-title">Beasiswa {{ $item->beasiswa->nama_beasiswa }}</h5>
                            <p class="card-subtitle">{{ $item->tahun }}</p>
    
                            <div class="info-icons">
                                <span><i class="bi bi-calendar2-week"></i> {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($item->tanggal_berakhir)->format('d M Y') }}</span>
                            </div>
                        </div>
    
                        <!-- Bagian Kanan: Tombol -->
                        <div class="card-footer">
                            <button class="btn btn-primary tombol-daftar" data-id="{{ $item->id }}">Lihat Detail</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div> 
        </div> 
    </div> 
</main> 
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $(document).on('click', '.tombol-daftar', function () {
                var pendaftaranId = $(this).data('id');

                $.ajax({
                    url: '/pendaftaran-beasiswa/persyaratan/' + pendaftaranId,
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            window.location.href = '/pendaftaran-beasiswa/daftar/' + pendaftaranId;
                        } else {
                            iziToast.error({ title: 'Error', message: response.message });
                        }
                    },
                    error: function(xhr) {
                        iziToast.error({ title: 'Error', message: 'Terjadi kesalahan, coba lagi.' });
                    }
                });
            });
        });
    </script>
@endpush
