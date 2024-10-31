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

    <div class="container mt-5">
        <ul class="progressbar d-flex justify-content-between">
            @foreach ($tahapans as $index => $tahapan)
                <li 
                    class="progress-step {{ $index === 0 ? 'active' : '' }}" 
                    data-step="{{ $index + 1 }}">
                    <span class="step-number">{{ $index + 1 }}</span>
                    <span class="step-title">{{ $tahapan['nama_tahapan'] }}</span>
                </li>
            @endforeach
        </ul>
    
        <div class="tab-content mt-4">
            @foreach ($tahapans as $index => $tahapan)
                <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="tab{{ $index }}" role="tabpanel">
                    @if ($tahapan['nama_tahapan'] === 'Seleksi Administrasi')
                        <!-- Konten Seleksi Administrasi -->
                        <div class="card mb-4 shadow-sm rounded">
                            <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #f6783a;">
                                <h4 class="fw-bold mb-0">{{ $namaBeasiswa }}</h4>
                                <span class="badge-status">Status: {{ $pendaftaran->status }}</span>
                            </div>
    
                            {{-- Card body --}}
                            <div class="card-body">
                                <h5 class="mt-2 fw-bold"><i class="fa fa-user-circle"></i> Data Mahasiswa</h5>
                                <table class="table table-hover table-striped">
                                    <tr><th>Nama Lengkap</th><td>{{ $pendaftaran->pendaftaran->nama_lengkap }}</td></tr>
                                    <tr><th>NIM</th><td>{{ $pendaftaran->pendaftaran->nim }}</td></tr>
                                    <tr><th>Fakultas</th><td>{{ $pendaftaran->pendaftaran->fakultas }}</td></tr>
                                    <tr><th>Jurusan</th><td>{{ $pendaftaran->pendaftaran->jurusan }}</td></tr>
                                    <tr><th>IPK</th><td>{{ $pendaftaran->pendaftaran->IPK }}</td></tr>
                                    <tr><th>Semester</th><td>{{ $pendaftaran->pendaftaran->semester }}</td></tr>
                                    <tr><th>Alamat Lengkap</th><td>{{ $pendaftaran->pendaftaran->alamat_lengkap }}</td></tr>
                                    <tr><th>Telepon</th><td>{{ $pendaftaran->pendaftaran->telepon }}</td></tr>
                                </table>
    
                                <h5 class="mt-4 fw-bold"><i class="fa fa-folder-open"></i> Berkas Mahasiswa</h5>
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
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $berkas['nama_file'] }}</td>
                                                <td>{{ $berkas['file_path'] }}</td>
                                                <td>
                                                    <a href="{{ $berkas['lihat_path'] }}" target="_blank" class="btn btn-sm btn-success">
                                                        <i class="fa fa-eye"></i> Lihat
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada berkas upload mahasiswa.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{-- end card body --}}

                            {{-- card footer --}}
                            <div class="class card-footer">
                                <!-- Tombol Validasi -->
                                <div class="mt-2 mb-2 d-flex justify-content-center">
                                    <button class="btn btn-success me-2"
                                            onclick="validate('setuju', {{ $pendaftaran->pendaftaran->id }})"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Setujui Pendaftaran"
                                            @if(in_array($pendaftaran->status, ['disetujui', 'ditolak']) || !in_array($pendaftaran->status, ['menunggu', 'diproses']))
                                                disabled
                                            @endif>
                                        <i class="fa fa-check-circle"></i> Setujui Usulan
                                    </button>

                                    <button class="btn btn-danger"
                                            onclick="validate('tolak', {{ $pendaftaran->pendaftaran->id }})"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Tolak Pendaftaran"
                                            @if(in_array($pendaftaran->status, ['disetujui', 'ditolak']) || !in_array($pendaftaran->status, ['menunggu', 'diproses']))
                                                disabled
                                            @endif>
                                        <i class="fa fa-times-circle"></i> Tolak Usulan
                                    </button>
                                </div>
                            </div>
                            {{-- end card footer --}}
                        </div>
                    @else
                        <!-- Konten Tahapan Lain -->
                        <div class="alert alert-info text-center">
                            Konten untuk {{ $tahapan['nama_tahapan'] }} belum tersedia.
                        </div>
                    @endif
                </div>
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

    <script>
        $(document).ready(function() {
            $('#berkasTable').DataTable({
                "language": {
                    "emptyTable": "Tidak ada berkas yang tersedia"
                }
            });
        });

        // Untuk tombol validasi
        $(function () {
            $('[data-bs-toggle="tooltip"]').tooltip();
        });


        // Untuk tabs tahapan
        document.querySelectorAll('.progress-step').forEach((step, index) => {
            step.addEventListener('click', () => {
                // Hapus kelas aktif dari semua step
                document.querySelectorAll('.progress-step').forEach(s => s.classList.remove('active'));

                // Tambahkan kelas aktif ke step yang dipilih
                step.classList.add('active');

                // Tampilkan konten tab yang sesuai
                document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));
                document.getElementById(`tab${index}`).classList.add('show', 'active');
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Script untuk menangani validasi dengan konfirmasi SweetAlert
        function validate(action, pendaftaranId) {
            // Tampilkan SweetAlert konfirmasi
            Swal.fire({
                title: action === 'setuju' ? 'Setujui Usulan?' : 'Tolak Usulan?',
                text: "Apakah Anda yakin ingin melanjutkan?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745', // Warna hijau untuk Setujui
                cancelButtonColor: '#dc3545', // Warna merah untuk Tolak
                confirmButtonText: action === 'setuju' ? 'Ya, Setujui' : 'Ya, Tolak',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna mengonfirmasi, lakukan proses validasi
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
                            setTimeout(() => location.reload(), 1000);  // Refresh halaman setelah validasi
                        },
                        error: function(error) {
                            iziToast.error({ title: 'Error', message: error.responseJSON.message });
                            console.log("Error Details:", error.responseJSON); // Untuk debug
                        }
                    });
                }
            });
        }

    </script>
@endpush



{{-- Aksi Validasi
<form action="{{ route('pendaftaran.validasi', $pendaftaran->id) }}" method="POST" class="mt-3">
    @csrf
    <button type="submit" name="status" value="setuju" class="btn btn-success">
        Setuju
    </button>
    <button type="submit" name="status" value="tolak" class="btn btn-danger">
        Tolak
    </button>
</form> --}}

{{-- @extends('layouts.master')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Detail Pendaftaran Beasiswa</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('usulan_beasiswa.index') }}">Kelola Beasiswa</a></li>
                        <li class="breadcrumb-item active">Detail Pendaftaran</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Informasi Pendaftaran: {{ $buatPendaftaran->nama_beasiswa }}</h5>
                </div>
                <div class="card-body">
                    <!-- Tabs for Tahapan -->
                    <ul class="nav nav-tabs" id="tahapanTabs" role="tablist">
                        @foreach($buatPendaftaran->tahapan as $index => $tahapan)
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ $index === 0 ? 'active' : '' }}" 
                                   id="tab-{{ $tahapan->id }}" 
                                   data-bs-toggle="tab" 
                                   href="#tahapan-{{ $tahapan->id }}" 
                                   role="tab" 
                                   aria-controls="tahapan-{{ $tahapan->id }}" 
                                   aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                    {{ $tahapan->nama_tahapan }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="tahapanTabsContent">
                        @foreach($buatPendaftaran->tahapan as $index => $tahapan)
                            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" 
                                 id="tahapan-{{ $tahapan->id }}" 
                                 role="tabpanel" 
                                 aria-labelledby="tab-{{ $tahapan->id }}">
                                <h5 class="mt-3">{{ $tahapan->nama_tahapan }}</h5>
                                <p>Tanggal Mulai: {{ \Carbon\Carbon::parse($tahapan->pivot->tanggal_mulai)->format('d M Y') }}</p>
                                <p>Tanggal Akhir: {{ \Carbon\Carbon::parse($tahapan->pivot->tanggal_akhir)->format('d M Y') }}</p>
                                <!-- Tambahkan detail lain jika ada -->
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection --}}
