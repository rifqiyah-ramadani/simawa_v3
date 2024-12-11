@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        
    </style>
@endpush

@section('content')
<main class="app-main"> 
    <div class="app-content-header"> 
        <div class="container-fluid"> 
            <div class="row"> 
                <div class="col-sm-6">
                    <h3 class="mb-0">Beasiswa - Pendaftaran Beasiswa</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Beasiswa
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Pendaftaran Beasiswa
                        </li>
                    </ol>
                </div>
            </div> 
        </div> 
    </div> 

    <div class="app-content"> 
        <div class="container-fluid"> 
            <div class="col-md-12">   
                <div class="card mb-4"> 
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Nama Beasiswa dan Tahun -->
                            <h3 class="fw-bold">Beasiswa {{ $buatPendaftaran->beasiswa->nama_beasiswa }} - {{ $buatPendaftaran->tahun }}</h3>
                            
                            <!-- Status -->
                            <span class="badge-status px-3 py-2" 
                            style="border-radius: 20px; 
                                color: white; 
                                text-transform: capitalize; 
                                background-color: {{ $buatPendaftaran->status === 'dibuka' ? '#28a745' : '#dc3545' }}">
                            {{ $buatPendaftaran->status }}
                            </span>
                        </div>
                    
                        <!-- Tanggal Pendaftaran -->
                        <span class="d-block">Tanggal Pendaftaran</span>
                        <span>
                            <i class="bi bi-calendar2-week"></i> 
                            {{ \Carbon\Carbon::parse($buatPendaftaran->tanggal_mulai)->format('d M Y') }} - 
                            {{ \Carbon\Carbon::parse($buatPendaftaran->tanggal_berakhir)->format('d M Y') }}
                        </span>
                    </div>                    
    
                    <div class="card-body">
                        <!-- Informasi Detail -->
                        <div class="row mt-4">
                            <!-- Bagian Kiri (Persyaratan dan Berkas) -->
                            <div class="col-md-6">
                                <!-- Tahapan -->
                                <h5 class="fw-bold">Timeline & Alur Seleksi Beasiswa:</h5>
                                <ul>
                                    @foreach($buatPendaftaran->tahapan as $tahap)
                                        <li>{{ $tahap->nama_tahapan }}: {{ \Carbon\Carbon::parse($tahap->pivot->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($tahap->pivot->tanggal_akhir)->format('d M Y') }}</li>
                                    @endforeach
                                </ul>
                                <!-- Persyaratan -->
                                <h5 class="fw-bold">Persyaratan Beasiswa:</h5>
                                <ul>
                                    @foreach($buatPendaftaran->persyaratan as $syarat)
                                        <li>{{ $syarat->nama_persyaratan }}</li>
                                    @endforeach
                                </ul>

                                <!-- Berkas yang Diperlukan -->
                                <h5 class="fw-bold">Berkas yang Perlu Dipersiapkan:</h5>
                                <ul>
                                    @foreach($buatPendaftaran->berkasPendaftarans as $berkas)
                                        <li>{{ $berkas->nama_file }}</li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Bagian Kanan (Flyer) -->
                            <div class="col-md-6 text-center">
                                <!-- Flyer (Jika Ada) -->
                                @if($buatPendaftaran->flyer)
                                    <img src="{{ asset('storage/' . $buatPendaftaran->flyer) }}" alt="Flyer Beasiswa" class="img-fluid" />
                                @endif
                            </div>
                        </div>

                        <!-- Link Pendaftaran (Jika Ada) -->
                        @if($buatPendaftaran->link_pendaftaran)
                            <div class="text-center mt-4">
                                <a href="{{ $buatPendaftaran->link_pendaftaran }}" target="_blank" class="btn btn-primary">Daftar Beasiswa</a>
                            </div>
                        @endif
                    </div> 
                </div>
            </div> 
        </div> 
    </div> 
</main> 
@endsection


