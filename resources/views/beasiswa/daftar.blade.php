@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Or for RTL support -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
    
@endpush

@section('content')
<main class="app-main"> 
    <!--begin::App Content Header-->
    <div class="app-content-header"> 
        <!--begin::Container-->
        <div class="container-fluid"> 
            <!--begin::Row-->
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
            <!--end::Row-->
        </div> 
        <!--end::Container-->
    </div> 
    <!--end::App Content Header--> 
    
    <!--begin::App Content-->
    <div class="app-content"> 
        <!--begin::Container-->
        <div class="container-fluid"> 
            <!--begin::Row-->
            <div class="col-md-12">   
                <!--begin::Card Persyaratan-->
                <div class="card mb-4"> 
                    <!--begin::Card Header-->
                    <div class="card-header">
                        <h3>Persyaratan</h3>
                    </div> 
                    <!--end::Card Header-->
    
                    <!--begin::Card Body-->
                    @foreach($hasilValidasi as $syarat)
                        <div class="alert {{ $syarat['status'] ? 'alert-success' : 'alert-danger' }}">
                            <i class="{{ $syarat['status'] ? 'bi bi-check-circle-fill' : 'fa fa-times-circle' }}" 
                                style="font-size: 1.5rem; color: {{ $syarat['status'] ? '#28a745' : '#dc3545' }}; margin-right: 10px;">
                            </i>
                    
                            <span style="font-size: 1.2rem;">{{ $syarat['nama'] }}</span>
                            {{-- <p>{{ $syarat['message'] }}</p> --}}
                        </div>
                    @endforeach
                    <!--end::Card Body-->
                </div>
                <!--end::Card Persyaratan-->

                <!-- Sweet Alert jika form tidak muncul -->
                @if (!$showForm)
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Pendaftaran Tidak Dapat Dilanjutkan',
                                text: "{{ $alertMessage }}",
                                confirmButtonText: 'OK'
                            });
                        });
                    </script>
                @endif
    
                <!-- Form hanya akan muncul jika showForm bernilai true dan semua persyaratan terpenuhi -->
                @if($showForm && $semuaTerpenuhi)
                    <!--begin::Card Form Pendaftaran-->
                    <div class="card mb-4">
                        <!--begin::Card Header-->
                        <div class="card-header">
                            <h3 class="text-center">Form Pendaftaran Beasiswa</h3>
                        </div> 
                        <!--end::Card Header-->
        
                        <!--begin::Card Body-->
                        <div class="card-body">
                            <form id="form-beasiswa" action="{{ route('pendaftaran_beasiswa.store', $buatPendaftaran->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                {{-- Field Nama dan NIM --}}
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="nama_lengkap" class="form-label fw-bold">Nama Lengkap
                                            <span style="color: red;">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="nama_lengkap" placeholder="Masukkan Nama Lengkap" name="nama_lengkap" required>
                                    </div>
                                    <div class="col mb-3">
                                        <label for="nim" class="form-label fw-bold">NIM
                                            <span style="color: red;">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="nim" placeholder="Masukkan NIM" name="nim" required>
                                    </div>
                                </div>

                                {{-- Field Fakultas dan Jurusan --}}
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="fakultas_id" class="form-label fw-bold">Fakultas:
                                            <span style="color: red;">*</span>
                                        </label>
                                        <select name="fakultas_id" id="fakultas_id" class="form-control" required>
                                            <option value="" disabled selected>-- Pilih Fakultas --</option>
                                            @foreach ($fakultas as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_fakultas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col mb-3">
                                        <label for="jurusan" class="form-label fw-bold">Program Studi:
                                            <span style="color: red;">*</span>
                                        </label>
                                        <select class="form-control" id="jurusan" name="jurusan" required>
                                            <option value="" disabled selected>--Pilih Program Studi--</option>
                                            <option value="DIII akuntansi">DIII akuntansi</option>
                                            <option value="Ekonomi Islam">Ekonomi Islam</option>
                                            <option value="Ekonomi Pembangunan">Ekonomi Pembangunan</option>
                                            <option value="Keuangan Daerah">Keuangan Daerah</option>
                                            <option value="Manajemen">Manajemen</option>
                                            <option value="Manajemen Pemasaran">Manajemen Pemasaran</option>
                                            <option value="Perpajakan">Perpajakan</option>
                                            <option value="S1 Akuntansi">S1 Akuntansi</option>
                                            <option value="Ilmu Hukum">Ilmu Hukum</option>
                                            <option value="Arkeologi">Arkeologi</option>
                                            <option value="Bahasa Arab">Bahasa Arab</option>
                                            <option value="Ilmu Sejarah">Ilmu Sejarah</option>
                                            <option value="Seni Drama Tari dan Musik">Seni Drama Tari dan Musik</option>
                                            <option value="Ilmu Pemerintahan">Ilmu Pemerintahan</option>
                                            <option value="Ilmu Politik">Ilmu Politik</option>
                                            <option value="Manajemen Pemerintahan">Manajemen Pemerintahan</option>
                                            <option value="Farmasi">Farmasi</option>
                                            <option value="Ilmu Keperawatan">Ilmu Keperawatan</option>
                                            <option value="Ilmu Kesehatan Masyarakat">Ilmu Kesehatan Masyarakat</option>
                                            <option value="Kedokteran">Kedokteran</option>
                                            <option value="Psikologi">Psikologi</option>
                                            <option value="Administrasi Pendidikan">Administrasi Pendidikan</option>
                                            <option value="Bimbingan dan Konseling">Bimbingan dan Konseling</option>
                                            <option value="Kepelatihan Olahraga">Kepelatihan Olahraga</option>
                                            <option value="PG-PAUD">PG-PAUD</option>
                                            <option value="PGSD">PGSD</option>
                                            <option value="Pendidikan Bahasa Inggris">Pendidikan Bahasa Inggris</option>
                                            <option value="Pendidikan Bahasa dan Sastra Indo">Pendidikan Bahasa dan Sastra Indo</option>
                                            <option value="Pendidikan Biologi">Pendidikan Biologi</option>
                                            <option value="Pendidikan Ekonomi">Pendidikan Ekonomi</option>
                                            <option value="Pendidikan Fisika">Pendidikan Fisika</option>
                                            <option value="Pendidikan Kimia">Pendidikan Kimia</option>
                                            <option value="Pendidikan Matematika">Pendidikan Matematika</option>
                                            <option value="Pendidikan Olahraga dan Kesehatan">Pendidikan Olahraga dan Kesehatan</option>
                                            <option value="Pendidikan PPKN">Pendidikan PPKN</option>
                                            <option value="Pendidikan Sejarah">Pendidikan Sejarah</option>
                                            <option value="Sastra Indonesia">Sastra Indonesia</option>
                                            <option value="Kehutanan">Kehutanan</option>
                                            <option value="Agribisnis">Agribisnis</option>
                                            <option value="Agrobisnis">Agrobisnis</option>
                                            <option value="Agroekoteknologi">Agroekoteknologi</option>
                                            <option value="Sistem Informasi">Sistem Informasi</option>
                                            <option value="Kimia">Kimia</option>
                                            <option value="Farmasi">Farmasi</option>
                                            <option value="Matematika">Matematika</option>
                                            <option value="Biologi">Biologi</option>
                                            <option value="Fisika">Fisika</option>
                                            <option value="Matematika">Matematika</option>
                                            <option value="Kimia Industri">Kimia Industri</option>
                                            <option value="Teknik Sipil">Teknik Sipil</option>
                                            <option value="Teknik Kimia">Teknik Kimia</option>
                                            <option value="Teknik Geologi">Teknik Geologi</option>
                                            <option value="Teknik Pertambangan">Teknik Pertambangan</option>
                                            <option value="Teknik Geofisika">Teknik Geofisika</option>
                                            <option value="Teknik Lingkungan">Teknik Lingkungan</option>
                                            <option value="Teknik Elektro">Teknik Elektro</option>
                                            <option value="Peternakan">Peternakan</option>
                                            <option value="Perikanan">Perikanan</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Field IPK dan Semester --}}
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="semester" class="form-label fw-bold">Jurusan:
                                            <span style="color: red;">*</span>
                                        </label>
                                        <select class="form-control" id="semester" name="semester" required>
                                            <option value="" disabled selected>--Pilih Semester--</option>
                                            <option value="1">Semester 1</option>
                                            <option value="2">Semester 2</option>
                                            <option value="3">Semester 3</option>
                                            <option value="4">Semester 4</option>
                                            <option value="5">Semester 5</option>
                                            <option value="6">Semester 6</option>
                                            <option value="7">Semester 7</option>
                                            <option value="8">Semester 8</option>
                                            <option value="9">Semester 9</option>
                                        </select>
                                    </div>

                                    <div class="col mb-3">
                                        <label for="IP" class="form-label fw-bold">Indeks Prestasi (IP) saat ini
                                            <span style="color: red;">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="IP" placeholder="Masukkan IP Saat Ini" name="IP" required>
                                    </div>
                        
                                    <div class="col mb-3">
                                        <label for="IPK" class="form-label fw-bold">IPK Semester Terakhir
                                            <span style="color: red;">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="IPK" placeholder="Masukkan IPK Terakhir" name="IPK" required>
                                    </div>
                                </div>

                                {{-- Field Alamat dan Telepon --}}
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="alamat_lengkap" class="form-label fw-bold">Alamat Lengkap (Sesuai KTP)
                                            <span style="color: red;">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="alamat_lengkap" placeholder="Masukkan Alamat Lengkap" name="alamat_lengkap" required>
                                    </div>
                                    <div class="col mb-3">
                                        <label for="telepon" class="form-label fw-bold">No. Telepon
                                            <span style="color: red;">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="telepon" placeholder="Masukkan Telepon" name="telepon" required>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="biaya_hidup" class="form-label fw-bold">Biaya Hidup</label>
                                        <input type="number" step="0.01" name="biaya_hidup" id="biaya_hidup" class="form-control" placeholder="Contoh 1250000">
                                    </div>
                                    <div class="col mb-3">
                                        <label for="biaya_ukt" class="form-label fw-bold">Biaya UKT</label>
                                        <input type="number" step="0.01" name="biaya_ukt" id="biaya_ukt" class="form-control" placeholder="Contoh 1250000">
                                    </div> 
                                </div>

                                {{-- Field Berkas Pendaftaran --}}
                                <div class="row">
                                    @foreach($berkasPendaftaran as $fileBerkas)
                                        <div class="col-md-12 mb-3">
                                            <label for="berkas_{{ $fileBerkas->id }}" class="form-label fw-bold">{{ $fileBerkas->nama_file }}
                                                <span style="color: red;">*</span>
                                            </label>
                                            <input type="file" class="form-control" id="berkas_{{ $fileBerkas->id }}" name="berkas[{{ $fileBerkas->id }}]" required>

                                            {{-- Tampilkan link untuk mengunduh template jika ada --}}
                                            @if($fileBerkas->template_path)
                                                <div class="mt-2">
                                                    <a href="{{ asset('storage/' . $fileBerkas->template_path) }}" target="_blank" class="btn btn-info btn-sm">
                                                        Unduh Template {{ $fileBerkas->nama_file }}
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                <button type="submit" class="btn btn-primary">Daftar Beasiswa</button>
                            </form>
                        </div> 
                        <!--end::Card Body-->
                    </div>
                    <!--end::Card Form Pendaftaran-->
                    @elseif(!$semuaTerpenuhi)
                        <!-- Alert jika persyaratan tidak terpenuhi -->
                        <div class="alert text-center" style="background-color: #ff4d4d; color: white;">
                            Mohon maaf! Anda belum memenuhi semua persyaratan untuk mendaftar beasiswa ini.
                        </div>
                    @endif

                    <!-- Alert jika user sudah mengisi form atau tidak dalam tahapan administrasi -->
                    @if($alertMessage)
                        <div class="alert alert-warning text-center">
                            {{ $alertMessage }}
                        </div>
                    @endif
            </div> 
            <!--end::Row-->
        </div> 
        <!--end::Container-->
    </div>
    
    <!--end::App Content--> 
</main> 
@endsection


<!-- Script untuk DataTables -->
@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> 
    <script>
        $(document).ready(function () {
            // Handling form submission with AJAX
            // Fungsi untuk melakukan submit form menggunakan AJAX
            $('#form-beasiswa').submit(function (event) {
                event.preventDefault(); // Mencegah submit form secara normal

                $.ajax({
                    url: $(this).attr('action'), // URL tujuan (controller) 
                    type: $(this).attr('method'), // Tipe request (POST)
                    data: new FormData(this), // Data form
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            iziToast.success({
                            title: 'Sukses',
                            message: response.success,
                            position: 'topRight',
                            timeout: 3000, // Durasi tampilan iziToast
                            onClosing: function () {
                                // Setelah iziToast selesai ditampilkan, ganti form dengan alert
                                $('#form-beasiswa').replaceWith(
                                    '<div class="alert alert-warning text-center">' +
                                        response.alertMessage +
                                    '</div>'
                                );
                            }
                        });
                        } else {
                            iziToast.error({
                                title: 'Error',
                                message: 'Terjadi kesalahan, coba lagi',
                                position: 'topRight'
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        iziToast.error({
                            title: 'Error',
                            message: 'Terjadi kesalahan saat menyimpan data',
                            position: 'topRight'
                        });
                    }
                });
            });
        });
    </script>
@endpush
