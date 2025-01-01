@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        .badge-status {
            background-color: #ffffff; /* Warna badge */
            color: black;
            font-size: 16px; /* Font lebih besar */
            font-weight: 500; /* Lebih tebal */
            padding: 5px 15px;
            border-radius: 15px; /* Biar bulat di ujung */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Sedikit shadow */
            text-transform: capitalize;
        }

        .card-header {
            position: relative;
        }

        .badge-status {
            position: absolute;
            right: 15px; /* Letakkan di ujung kanan */
            top: 50%; /* Vertikal tengah */
            transform: translateY(-50%); /* Agar tepat di tengah */
        }

        .progressbar {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            position: relative;
            counter-reset: step;
        }

        .progress-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            position: relative;
            width: 20%; /* Set sesuai jumlah tahapan (otomatis proporsional) */
            font-weight: bold;
            color: #6c757d;
            transition: color 0.3s ease-in-out;
        }

        .step-number {
            width: 30px;
            height: 30px;
            line-height: 30px;
            border-radius: 50%;
            background-color: #dcdcdc;
            margin-bottom: 5px;
            font-weight: bold;
        }

        /* Nonaktifkan pointer pada progress bar */
        .progress-step {
            pointer-events: none;
        }

        .progress-step.active .step-number {
            background-color: #f6783a;
            color: white;
        }

        .progress-step .step-title {
            font-size: 14px;
            margin-top: 5px;
        }

        /* Garis penghubung antar langkah */
        .progressbar::before {
            content: "";
            position: absolute;
            top: 15px;
            left: 10%;
            width: 80%; /* Menyambungkan antar step */
            height: 4px;
            background-color: #dcdcdc;
            z-index: -1;
        }

        .progress-step.active ~ .progress-step::before {
            background-color: #f6783a;
        }

        .single-tab-container {
            display: flex;
            justify-content: center;
            padding: 1rem;
            border: 1px solid #dcdcdc;
            border-radius: 8px;
            margin-top: 1rem;
            background-color: #f9f9f9;
        }

        .single-tab-container h5 {
            font-size: 18px;
            color: #333;
        }

        .select2-container--bootstrap-5 .select2-selection--multiple {
            position: relative;
            padding-right: 30px; /* Beri ruang untuk ikon */
        }

        .select2-container--bootstrap-5 .select2-selection--multiple::after {
            content: "\f0d7"; /* Unicode untuk ikon panah bawah Font Awesome */
            font-family: "FontAwesome";
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            font-size: 14px;
            color: #6c757d; /* Warna ikon */
            pointer-events: none; /* Agar ikon tidak mengganggu klik */
        }
        
    </style>
@endpush

@section('content')
<main class="app-main">
    <!-- Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0"><i class="fa fa-graduation-cap"></i> Detail Pendaftaran Beasiswa</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Usulan Beasiswa</li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Beasiswa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-2">
        <div class="d-flex justify-content-start mb-4">
            <!-- Membuat tombol "Kembali ke daftar usulan"-->
            <button class="btn btn-outline-primary" onclick="history.back()">
                <i class="fa fa-arrow-left"></i> Kembali ke daftar usulan
            </button>
        </div>

        <!-- Membuat progress bar untuk menampilkan tahapan -->
        <ul class="progressbar d-flex justify-content-between">
            @php $displayIndex = 1; @endphp <!-- Variabel indeks tampilan -->
            @foreach ($tahapans as $index => $tahapan)
                @if (strtolower($tahapan['nama_tahapan']) === 'pendaftaran beasiswa')
                    <!-- Lewati tahapan "Pendaftaran Beasiswa" -->
                    @continue
                @endif
    
                @if ($isRolePertama && $hasNextValidasi && strtolower($tahapan['nama_tahapan']) !== 'seleksi administrasi')
                    <!-- Jika role pertama dan memiliki validasi berikutnya, tampilkan hanya Seleksi Administrasi -->
                    @continue
                @endif

                <!-- Tampilkan langkah-langkah pada progress bar -->
                <li class="progress-step {{ $displayIndex === 1 ? 'active' : '' }}" data-step="{{ $displayIndex }}">
                    <span class="step-number">{{ $displayIndex }}</span>
                    <span class="step-title">{{ $tahapan['nama_tahapan'] }}</span>
                </li>
                @php $displayIndex++; @endphp <!-- Tambahkan indeks tampilan -->
            @endforeach
        </ul>
    
        <div class="tab-content mt-4">
            @php $displayIndex = 1; @endphp <!-- Reset indeks tampilan untuk konten tab -->
            @foreach ($tahapans as $index => $tahapan)
                @if (strtolower($tahapan['nama_tahapan']) !== 'pendaftaran beasiswa')
                    <!-- Tampilkan konten tab untuk setiap tahapan kecuali "Pendaftaran Beasiswa" -->
                    <div class="tab-pane fade {{ $displayIndex === 1 ? 'show active' : '' }}" id="tab{{ $displayIndex }}" role="tabpanel"
                        data-tanggal-mulai="{{ $tahapan['tanggal_mulai'] }}" 
                        data-tanggal-akhir="{{ $tahapan['tanggal_akhir'] }}">
                        <!-- Tampilkan konten Seleksi Administrasi -->
                        @if (strtolower($tahapan['nama_tahapan']) === 'seleksi administrasi')
                            <!-- Alert jika validasi sudah dilakukan -->
                            @if (in_array($pendaftaran->status, ['disetujui', 'ditolak']))
                                <div class="alert alert-info text-center mb-4">
                                    <strong>Validasi telah selesai dilakukan.</strong> <br>
                                    <strong>Status pendaftaran saat ini adalah</strong>
                                    <strong>{{ ucfirst($pendaftaran->status) }}</strong>
                                </div>
                            @endif
    
                            @php
                                // Tentukan tanggal sekarang dan rentang tanggal untuk Seleksi Administrasi
                                $tanggalSekarang = \Carbon\Carbon::now();
                                $tanggalMulaiSeleksi = \Carbon\Carbon::parse($tahapan['tanggal_mulai']);
                                $tanggalAkhirSeleksi = \Carbon\Carbon::parse($tahapan['tanggal_akhir'])->endOfDay();
                                
                                // Cek apakah seleksi administrasi masih aktif (dalam rentang tanggal mulai dan akhir)
                                $isSeleksiAdministrasiActive = $tanggalSekarang->between($tanggalMulaiSeleksi, $tanggalAkhirSeleksi);
                            @endphp
                        
                            <!-- Alert jika belum masuk tanggal seleksi -->
                            @if ($tanggalSekarang->lt($tanggalMulaiSeleksi))
                                <div class="alert alert-warning text-center mb-4">
                                    <strong>Validasi belum dapat dilakukan</strong> karena belum masuk ke dalam tahapan <strong>Seleksi Administrasi</strong>.
                                    Tahapan ini baru bisa dilakukan mulai tanggal 
                                    <strong>{{ $tanggalMulaiSeleksi->format('d M Y') }}</strong> 
                                    sampai 
                                    <strong>{{ $tanggalAkhirSeleksi->format('d M Y') }}</strong>.
                                </div>
                            @elseif ($tanggalSekarang->gt($tanggalAkhirSeleksi))
                                <!-- Alert jika tahapan sudah berakhir -->
                                <div class="alert alert-danger text-center mb-4">
                                    <strong>Validasi sudah tidak bisa dilakukan</strong> karena sudah lewat dari tahapan <strong>Seleksi Administrasi</strong>.
                                    Tahapan ini berlangsung dari tanggal 
                                    <strong>{{ $tanggalMulaiSeleksi->format('d M Y') }}</strong> 
                                    sampai 
                                    <strong>{{ $tanggalAkhirSeleksi->format('d M Y') }}</strong>.
                                </div>
                            @endif
                            
                            <!-- Konten Seleksi Administrasi -->
                            <div class="card mb-4 shadow-sm rounded">
                                <!-- Header card menampilkan nama beasiswa dan status -->
                                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #f6783a;">
                                    <h4 class="fw-bold mb-0">{{ $namaBeasiswa }}</h4>
                                    <span class="badge-status">Status: {{ $pendaftaran->status }}</span>
                                </div>
    
                                <!-- card body menampilkan data mahasiswa -->
                                <div class="card-body">
                                    <h5 class="mt-2 fw-bold"><i class="fa fa-user-circle"></i> Data Mahasiswa</h5>
                                    <!-- Tabel data mahasiswa -->
                                    <table class="table table-hover table-striped">
                                        <tr><th>Nama Lengkap</th><td>{{ $pendaftaran->pendaftaran->nama_lengkap }}</td></tr>
                                        <tr><th>NIM</th><td>{{ $pendaftaran->pendaftaran->nim }}</td></tr>
                                        <tr><th>Fakultas</th><td>{{ $namaFakultas }}</td></tr>
                                        <tr><th>Jurusan</th><td>{{ $pendaftaran->pendaftaran->jurusan }}</td></tr>
                                        <tr><th>Indeks Prestasi (IP)</th><td>{{ $pendaftaran->pendaftaran->IP }}</td></tr>
                                        <tr><th>Indeks Prestasi Kumulatif (IPK)</th><td>{{ $pendaftaran->pendaftaran->IPK }}</td></tr>
                                        <tr><th>Semester</th><td>{{ $pendaftaran->pendaftaran->semester }}</td></tr>
                                        <tr><th>Alamat Lengkap</th><td>{{ $pendaftaran->pendaftaran->alamat_lengkap }}</td></tr>
                                        <tr><th>Telepon</th><td>{{ $pendaftaran->pendaftaran->telepon }}</td></tr>
                                        <tr><th>Biaya Hidup</th><td>{{ $pendaftaran->pendaftaran->biaya_hidup }}</td></tr>
                                        <tr><th>Biaya UKT</th><td>{{ $pendaftaran->pendaftaran->biaya_ukt }}</td></tr>
                                    </table>
    
                                    <h5 class="mt-4 fw-bold"><i class="fa fa-folder-open"></i> Berkas Mahasiswa</h5>
                                    <!-- Tabel berkas mahasiswa -->
                                    <table class="table table-hover table-striped" id="berkasTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama File</th>
                                                <th>File Path</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($berkasUploadMahasiswa as $index => $berkas)
                                                <tr>
                                                    <!-- Tampilkan berkas upload mahasiswa -->
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $berkas['nama_file'] }}</td>
                                                    <td>{{ $berkas['file_path'] }}</td>
                                                    <td>
                                                        <!-- Tombol lihat berkas -->
                                                        <a href="{{ $berkas['lihat_path'] }}" target="_blank" class="btn btn-sm btn-success">
                                                            <i class="fa fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <!-- Jika tidak ada berkas -->
                                                <tr>
                                                    <td colspan="4" class="text-center">Tidak ada berkas upload mahasiswa.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                 <!-- end card body -->
    
                                <!-- card footer untuk tombol validasi -->
                                <div class="card-footer">
                                    <div class="mt-2 mb-2 d-flex justify-content-center">
                                        <!-- Tombol Setujui Pendaftaran -->
                                        <button class="btn btn-success me-2"
                                                onclick="validate('setuju', {{ $pendaftaran->pendaftaran->id }})"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                @if (!$isSeleksiAdministrasiActive || in_array($pendaftaran->status, ['disetujui', 'ditolak']))
                                                    disabled
                                                @endif>
                                            <i class="fa fa-check-circle"></i> Setujui Usulan
                                        </button>
    
                                        <!-- Tombol Tolak Pendaftaran -->
                                        <button class="btn btn-danger"
                                                onclick="validate('tolak', {{ $pendaftaran->pendaftaran->id }})"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                @if (!$isSeleksiAdministrasiActive || in_array($pendaftaran->status, ['disetujui', 'ditolak']))
                                                    disabled
                                                @endif>
                                            <i class="fa fa-times-circle"></i> Tolak Usulan
                                        </button>
                                    </div>
                                </div>
                                <!-- end card footer -->
                            </div>
                        @elseif (strtolower($tahapan['nama_tahapan']) === 'pengumuman seleksi administrasi')
                            <!-- Konten Pengumuman Seleksi Administrasi -->
                            <div class="card shadow-sm rounded mb-4">
                                <div class="card-header text-white" style="background-color: #4a90e2;">
                                    <h4 class="fw-bold mb-0"><i class="fa fa-info-circle"></i> Status Pengumuman Seleksi Administrasi</h4>
                                </div>
                        
                                <div class="card-body text-center p-4">
                                    <h3 class="mb-3">Status Usulan Anda</h3>
                                    <div class="p-3 mb-3 rounded" style="background-color: #f7f9fc;">
                                        @php
                                            $statusClass = match($statusUsulanAwal) {
                                                'lulus seleksi administrasi' => 'text-success',
                                                'diterima' => 'text-success',
                                                'diproses' => 'text-warning',
                                                'ditolak' => 'text-danger',
                                                default => 'text-secondary',
                                            };
                                            $statusIcon = match($statusUsulanAwal) {
                                                'lulus seleksi administrasi' => 'fa-check-circle',
                                                'diterima' => 'fa-check-circle',
                                                'diproses' => 'fa-hourglass-half',
                                                'ditolak' => 'fa-times-circle',
                                                default => 'fa-question-circle',
                                            };
                                        @endphp
                        
                                        <i class="fa {{ $statusIcon }} fa-3x {{ $statusClass }}"></i>
                                        <h4 class="mt-2 fw-bold {{ $statusClass }}">{{ ucfirst($statusUsulanAwal) }}</h4>
                                    </div>
                        
                                    @if($statusUsulanAwal === 'ditolak')
                                        <p class="mb-0">
                                            Status terbaru dari usulan mahasiswa ini adalah: <span class="fw-bold">{{ ucfirst($statusUsulanAwal) }}</span>.
                                            <br>
                                            Anda tidak perlu melanjutkan validasi ke tahapan berikutnya.
                                        </p>
                                    @endif
                                    @if($statusUsulanAwal === 'lulus seleksi administrasi')
                                        <p class="mb-0">
                                            Status terbaru dari usulan mahasiswa ini adalah: <span class="fw-bold">{{ ucfirst($statusUsulanAwal) }}</span>.
                                            <br>
                                            Silakan lanjutkan proses validasi agar mahasiswa bisa melanjutkan ke tahapan berikutnya.
                                        </p>
                                    @endif
                                    @if($statusUsulanAwal === 'diterima')
                                        <p class="mb-0">
                                            Status terbaru dari usulan mahasiswa ini adalah: <span class="fw-bold">{{ ucfirst($statusUsulanAwal) }}</span>.
                                            <br>
                                            Tidak perlu tindakan lebih lanjut yang perlu dilakukan.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @elseif (strtolower($tahapan['nama_tahapan']) === 'seleksi wawancara')
                            @php
                                // Tentukan tanggal sekarang dan rentang tanggal untuk Seleksi Wawancara
                                $tanggalSekarang = \Carbon\Carbon::now();
                                $tanggalMulaiWawancara = \Carbon\Carbon::parse($tahapan['tanggal_mulai']);
                                $tanggalAkhirWawancara = \Carbon\Carbon::parse($tahapan['tanggal_akhir'])->endOfDay();
                                $isSeleksiWawancaraActive = $tanggalSekarang->between($tanggalMulaiWawancara, $tanggalAkhirWawancara);
                            @endphp
                    
                            <!-- Alert jika validasi sudah dilakukan -->
                            @if (in_array($pendaftaran->status, ['lulus seleksi wawancara']))
                                <div class="alert alert-info text-center mb-4">
                                    <strong>Validasi telah selesai dilakukan.</strong> <br>
                                    <strong>Status pendaftaran saat ini adalah</strong>
                                    <strong>{{ ucfirst($pendaftaran->status) }}</strong>
                                </div>
                            @endif
                    
                            <!-- Alert jika belum masuk tanggal wawancara -->
                            @if ($tanggalSekarang->lt($tanggalMulaiWawancara))
                                <div class="alert alert-warning text-center mb-4">
                                    <strong>Validasi belum dapat dilakukan</strong> karena belum masuk ke dalam tahapan <strong>Seleksi Wawancara</strong>.
                                    Tahapan ini baru bisa dilakukan mulai tanggal 
                                    <strong>{{ $tanggalMulaiWawancara->format('d M Y') }}</strong> 
                                    sampai 
                                    <strong>{{ $tanggalAkhirWawancara->format('d M Y') }}</strong>.
                                </div>
                            @elseif ($tanggalSekarang->gt($tanggalAkhirWawancara))
                                <!-- Alert jika tahapan sudah berakhir -->
                                <div class="alert alert-danger text-center mb-4">
                                    <strong>Validasi sudah tidak bisa dilakukan</strong> karena sudah lewat dari tahapan <strong>Seleksi Wawancara</strong>.
                                    Tahapan ini berlangsung dari tanggal 
                                    <strong>{{ $tanggalMulaiWawancara->format('d M Y') }}</strong> 
                                    sampai 
                                    <strong>{{ $tanggalAkhirWawancara->format('d M Y') }}</strong>.
                                </div>
                            @endif
                                <div class="card shadow-sm rounded mb-4">
                                    <div class="card-body">
                                        @if($interview)
                                            <!-- Tampilkan informasi jadwal wawancara jika sudah disimpan -->
                                            <div class="alert alert-info mb-4">
                                                <strong>Info Jadwal:</strong> Mahasiswa telah diinformasikan jadwal wawancara berikut.
                                            </div>
                                            <p><strong>Tanggal Wawancara:</strong> {{ $interview->tanggal_mulai }} {{ $interview->tanggal_akhir ? 's/d ' . $interview->tanggal_akhir : '' }}</p>
                                            <p><strong>Jam Wawancara:</strong> {{ $interview->jam_wawancara }}</p>
                                            <p><strong>Lokasi:</strong> {{ $interview->lokasi }}</p>
                                            <p><strong>Nama Pewawancara:</strong> {{ implode(', ', $interview->pewawancara_names) }}</p>

                                            <!-- Tombol Validasi Seleksi Wawancara -->
                                            <div class="d-flex justify-content-center mt-4">
                                                <button class="btn btn-success me-2"
                                                        onclick="validate('setuju', {{ $pendaftaran->pendaftaran->id }})"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        @if (!$isSeleksiWawancaraActive || in_array($pendaftaran->status, [ 'ditolak']))
                                                            disabled
                                                        @endif>
                                                    <i class="fa fa-check-circle"></i> Setujui Usulan
                                                </button>

                                                <!-- Tombol Tolak Pendaftaran -->
                                                <button class="btn btn-danger"
                                                        onclick="validate('tolak', {{ $pendaftaran->pendaftaran->id }})"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        @if (!$isSeleksiWawancaraActive || in_array($pendaftaran->status, [ 'ditolak']))
                                                            disabled
                                                        @endif>
                                                    <i class="fa fa-times-circle"></i> Tolak Usulan
                                                </button>
                                            </div>
                                        @else
                                            <!-- Alert jika status pendaftaran adalah "ditolak" -->
                                            @if ($pendaftaran->status === 'ditolak')
                                                <div class="alert alert-danger text-center mb-4">
                                                    <strong>Validasi selanjutnya tidak dapat dilakukan</strong> karena mahasiswa sudah dinyatakan <strong>{{ ucfirst($pendaftaran->status) }}</strong>.
                                                </div>
                                            @else
                                                <!-- Tampilkan konten jika status bukan "ditolak" -->
                                                <div class="card shadow-sm rounded mb-4">
                                                    <div class="card-header text-white" style="background-color: #4a90e2;">
                                                        <h4 class="fw-bold mb-0"><i class="fa fa-calendar-check"></i> Jadwal Wawancara</h4>
                                                    </div>

                                                    <div class="card-body">
                                                        @if($interview)
                                                            <!-- Informasi jadwal wawancara jika sudah disimpan -->
                                                            <div class="alert alert-info mb-4">
                                                                <strong>Info Jadwal:</strong> Mahasiswa telah diinformasikan jadwal wawancara berikut.
                                                            </div>
                                                            <p><strong>Tanggal Wawancara:</strong> {{ $interview->tanggal_mulai }} {{ $interview->tanggal_akhir ? 's/d ' . $interview->tanggal_akhir : '' }}</p>
                                                            <p><strong>Jam Wawancara:</strong> {{ $interview->jam_wawancara }}</p>
                                                            <p><strong>Lokasi:</strong> {{ $interview->lokasi }}</p>
                                                            <p><strong>Nama Pewawancara:</strong> {{ implode(', ', $interview->pewawancara_names) }}</p>

                                                            <!-- Tombol Validasi Seleksi Wawancara -->
                                                            <div class="d-flex justify-content-center mt-4">
                                                                <button class="btn btn-success me-2"
                                                                        onclick="validate('setuju', {{ $pendaftaran->pendaftaran->id }})"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="top"
                                                                        @if (!$isSeleksiWawancaraActive || in_array($pendaftaran->status, [ 'ditolak']))
                                                                            disabled
                                                                        @endif>
                                                                    <i class="fa fa-check-circle"></i> Setujui Usulan
                                                                </button>
                    
                                                                <!-- Tombol Tolak Pendaftaran -->
                                                                <button class="btn btn-danger"
                                                                        onclick="validate('tolak', {{ $pendaftaran->pendaftaran->id }})"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="top"
                                                                        @if (!$isSeleksiWawancaraActive || in_array($pendaftaran->status, [ 'ditolak']))
                                                                            disabled
                                                                        @endif>
                                                                    <i class="fa fa-times-circle"></i> Tolak Usulan
                                                                </button>
                                                            </div>
                                                        @else
                                                            <!-- Form input jadwal wawancara jika belum diisi -->
                                                            <div class="alert alert-warning mb-4">
                                                                <strong>Penting:</strong> Anda perlu mengisi jadwal wawancara sebelum melakukan validasi.
                                                            </div>
                                                            <form action="{{ route('beasiswa.storeInterview', $pendaftaran->pendaftaran->id) }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="pendaftaran_id" value="{{ $pendaftaran->pendaftaran->id }}">
                                                                
                                                                <!-- Input Tanggal Mulai dan Akhir Wawancara -->
                                                                <div class="mb-3">
                                                                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai Wawancara</label>
                                                                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir Wawancara (opsional)</label>
                                                                    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir">
                                                                </div>

                                                                <!-- Input Jam Wawancara dan Lokasi -->
                                                                <div class="mb-3">
                                                                    <label for="jam_wawancara" class="form-label">Jam Wawancara</label>
                                                                    <input type="time" class="form-control" id="jam_wawancara" name="jam_wawancara" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="lokasi" class="form-label">Lokasi Wawancara</label>
                                                                    <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                                                                </div>

                                                                <!-- Pewawancara Selection -->
                                                                <div class="mb-3">
                                                                    <label for="pewawancara_ids" class="form-label">Nama Pewawancara</label>
                                                                    <select class="form-select" id="pewawancara_ids" name="pewawancara_ids[]" multiple required>
                                                                        <!-- Tambahkan option untuk Penyelenggara Beasiswa -->
                                                                        <option value="penyelenggara_beasiswa">Penyelenggara Beasiswa</option>

                                                                        @foreach ($users as $user)
                                                                            @if ($user->role != 'mahasiswa')
                                                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <button type="submit" class="btn btn-primary">Simpan Jadwal Wawancara</button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                            </div>
                        @elseif (strtolower($tahapan['nama_tahapan']) === 'pengumuman akhir' || strtolower($tahapan['nama_tahapan']) === 'pengumuman seleksi wawancara')
                            <!-- Konten Pengumuman Seleksi Administrasi -->
                            <div class="card shadow-sm rounded mb-4">
                                <div class="card-header text-white" style="background-color: #4a90e2;">
                                    <h4 class="fw-bold mb-0"><i class="fa fa-info-circle"></i> Status Pengumuman Seleksi Wawancara</h4>
                                </div>
                        
                                <div class="card-body text-center p-4">
                                    <h3 class="mb-3">Status Usulan Anda</h3>
                                    <div class="p-3 mb-3 rounded" style="background-color: #f7f9fc;">
                                        @php
                                            $statusClass = match($statusUsulanAwal) {
                                                'lulus seleksi wawancara' => 'text-success',
                                                'diterima' => 'text-success',
                                                'diproses' => 'text-warning',
                                                'ditolak' => 'text-danger',
                                                default => 'text-secondary',
                                            };
                                            $statusIcon = match($statusUsulanAwal) {
                                                'lulus seleksi wawancara' => 'fa-check-circle',
                                                'diterima' => 'fa-check-circle',
                                                'diproses' => 'fa-hourglass-half',
                                                'ditolak' => 'fa-times-circle',
                                                default => 'fa-question-circle',
                                            };
                                        @endphp
                        
                                        <i class="fa {{ $statusIcon }} fa-3x {{ $statusClass }}"></i>
                                        <h4 class="mt-2 fw-bold {{ $statusClass }}">{{ ucfirst($statusUsulanAwal) }}</h4>
                                    </div>
                        
                                    @if($statusUsulanAwal === 'ditolak')
                                        <p class="mb-0">
                                            Status terbaru dari usulan mahasiswa ini adalah: <span class="fw-bold">{{ ucfirst($statusUsulanAwal) }}</span>.
                                            <br>
                                            Anda tidak perlu melanjutkan validasi ke tahapan berikutnya.
                                        </p>
                                    @endif
                                    @if($statusUsulanAwal === 'lulus seleksi administrasi')
                                        <p class="mb-0">
                                            Status terbaru dari usulan mahasiswa ini adalah: <span class="fw-bold">{{ ucfirst($statusUsulanAwal) }}</span>.
                                            <br>
                                            Silakan lanjutkan proses validasi agar mahasiswa bisa melanjutkan ke tahapan berikutnya.
                                        </p>
                                    @endif
                                    @if($statusUsulanAwal === 'diterima')
                                        <p class="mb-0">
                                            Status terbaru dari usulan mahasiswa ini adalah: <span class="fw-bold">{{ ucfirst($statusUsulanAwal) }}</span>.
                                            <br>
                                            Tidak perlu tindakan lebih lanjut yang perlu dilakukan.
                                        </p>
                                    @endif
                                </div>
                        
                                <div class="card-footer text-center">
                                    <button class="btn btn-primary" onclick="goToPreviousTab()">Kembali ke Tab Sebelumnya</button>
                                </div>
                            </div>
                        @endif

                        <!-- Tombol Next & Previous -->
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary prev-tab" {{ $displayIndex === 1 ? 'disabled' : '' }}>
                                <i class="bi bi-arrow-left-circle-fill me-2"></i>Previous</button>
                            <button type="button" class="btn btn-outline-primary next-tab" data-index="{{ $displayIndex }}" {{ $displayIndex === count($tahapans) ? 'disabled' : '' }}>
                                <i class="bi bi-arrow-right-circle-fill"></i> Next</button>
                        </div>
                    </div>
                    @php $displayIndex++; @endphp <!-- Tambahkan indeks tampilan untuk konten tab -->
                @endif
            @endforeach
        </div>
    </div>
</main>
@endsection 

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        function validate(action, pendaftaranId) {
            Swal.fire({
                title: action === 'setuju' ? 'Setujui Usulan?' : 'Tolak Usulan?',
                text: "Apakah Anda yakin ingin melanjutkan?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#dc3545',
                confirmButtonText: action === 'setuju' ? 'Ya, Setujui' : 'Ya, Tolak',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('beasiswa.lanjutkanValidasi') }}",
                        method: "POST",
                        data: {
                            action: action,
                            pendaftaranId: pendaftaranId,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            iziToast.success({ title: 'Sukses', message: response.message });
                            setTimeout(() => location.reload(), 1000);
                        },
                        error: function(error) {
                            iziToast.error({ title: 'Error', message: error.responseJSON.message });
                            console.log("Error Details:", error.responseJSON);
                        }
                    });
                }
            });
        }

        $(document).ready(function() {
            $('#berkasTable').DataTable({
                "language": {
                    "emptyTable": "Tidak ada berkas yang tersedia"
                }
            });
    
            $('#pewawancara_ids').select2({
                placeholder: "Pilih Nama Pewawancara",
                allowClear: true,
                width: '100%',
                theme: 'bootstrap-5'
            });

            // Fungsi untuk menemukan tab aktif berdasarkan rentang tanggal saat ini
            function findActiveTabIndex() {
                const tabs = $('.tab-pane');
                const today = new Date();
                let activeTabIndex = 0; // Default ke tab pertama jika tidak ada yang cocok
    
                tabs.each(function(index) {
                    const startDate = new Date($(this).data('tanggal-mulai'));
                    const endDate = new Date($(this).data('tanggal-akhir'));
    
                    // Cek apakah tanggal saat ini berada dalam rentang tanggal
                    if (today >= startDate && today <= endDate) {
                        activeTabIndex = index;
                        return false; // Hentikan loop jika menemukan tab aktif
                    }
                });
    
                return activeTabIndex;
            }
    
            // Hapus posisi tab aktif yang disimpan di localStorage agar selalu cek tab aktif dari rentang tanggal
            const activeTabKey = 'activeTabIndex';
            localStorage.removeItem(activeTabKey); // Tambahkan ini untuk menghapus posisi tab terakhir dari localStorage
    
            // Inisialisasi indeks tab saat ini berdasarkan rentang tanggal atau simpanan localStorage
            let currentIndex = findActiveTabIndex();
            showTab(currentIndex); // Tampilkan tab aktif yang sesuai
    
            // Fungsi untuk menampilkan tab berdasarkan indeks
            function showTab(index) {
                const tabs = $('.tab-pane');
                tabs.removeClass('show active');
                $(tabs[index]).addClass('show active');
    
                currentIndex = index; // Perbarui indeks tab saat ini
                updateButtons(); // Perbarui tombol next dan prev
                updateProgress(); // Perbarui status progress bar
            }
    
            // Fungsi untuk memperbarui status tombol next dan prev
            function updateButtons() {
                const tabs = $('.tab-pane');
                const today = new Date();
    
                // Mengambil data tanggal dari tab berikutnya, jika ada
                if (currentIndex < tabs.length - 1) {
                    const nextTab = $(tabs[currentIndex + 1]);
                    const startDate = new Date(nextTab.data('tanggal-mulai'));
    
                    // Tombol Next hanya aktif jika sudah melewati tanggal mulai dari tab berikutnya
                    const isStartReached = today >= startDate;
                    $('.next-tab').prop('disabled', !isStartReached);
                } else {
                    $('.next-tab').prop('disabled', true);
                }
    
                // Tombol Prev dinonaktifkan jika di tab pertama
                $('.prev-tab').prop('disabled', currentIndex === 0);
            }
    
            function updateProgress() {
                const steps = $('.progress-step');
                steps.removeClass('active');
                $(steps[currentIndex]).addClass('active');
            }
    
            // Event untuk tombol next
            $('.next-tab').on('click', function() {
                if (currentIndex < $('.tab-pane').length - 1) {
                    currentIndex += 1;
                    localStorage.setItem(activeTabKey, currentIndex); // Simpan tab aktif ke localStorage
                    showTab(currentIndex);
                }
            });
    
            // Event untuk tombol prev
            $('.prev-tab').on('click', function() {
                if (currentIndex > 0) {
                    currentIndex -= 1;
                    localStorage.setItem(activeTabKey, currentIndex); // Simpan tab aktif ke localStorage
                    showTab(currentIndex);
                }
            });
    
            // Untuk tooltip
            $('[data-bs-toggle="tooltip"]').tooltip();
    
            // Ajax setup untuk konfirmasi validasi
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
    
    
        
@endpush