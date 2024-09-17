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
                    <div class="card-body"> 
                        @foreach($persyaratan as $syarat)
                            <div class="alert {{ $syarat['status'] ? 'alert-success' : 'alert-danger' }}">
                                <i class="{{ $syarat['status'] ? 'bi bi-check-circle-fill' : 'fa fa-times-circle' }}" 
                                style="font-size: 1.5rem; color: {{ $syarat['status'] ? '#28a745' : '#dc3545' }}; margin-right: 10px;"></i>
    
                                <span style="font-size: 1.2rem;">{{ $syarat['nama'] }}</span>
                            </div>
                        @endforeach
                    </div> 
                    <!--end::Card Body-->
                </div>
                <!--end::Card Persyaratan-->
    
                <!--begin::Tabs-->
                <ul class="nav nav-tabs" id="beasiswaTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="form-tab" data-bs-toggle="tab" href="#form-pendaftaran" role="tab" aria-controls="form-pendaftaran" aria-selected="true">Form Pendaftaran</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="riwayat-tab" data-bs-toggle="tab" href="#riwayat-pendaftaran" role="tab" aria-controls="riwayat-pendaftaran" aria-selected="false">Riwayat Usulan Beasiswa</a>
                    </li>
                </ul>
                <!--end::Tabs-->
    
                <!--begin::Tab Content-->
                <div class="tab-content" id="beasiswaTabsContent">
                    <!--begin::Tab Pane for Form Pendaftaran-->
                    <div class="tab-pane fade show active" id="form-pendaftaran" role="tabpanel" aria-labelledby="form-tab">
                        <!--begin::Card Form Pendaftaran-->
                        <div class="card mb-4">
                            <!--begin::Card Header-->
                            <div class="card-header">
                                <h3 class="text-center">Form Pendaftaran Beasiswa</h3>
                            </div> 
                            <!--end::Card Header-->
            
                            <!--begin::Card Body-->
                            <div class="card-body">
                                @if($semuaTerpenuhi)
                                    <form action="{{ route('pendaftaran_beasiswa.store', $buatPendaftaran->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        {{-- Field Nama dan NIM --}}
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nama_lengkap" class="form-label fw-bold">Nama Lengkap
                                                    <span style="color: red;">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="nama_lengkap" placeholder="Enter Nama Lengkap" name="nama_lengkap" required>
                                            </div>
                                            <div class="col mb-3">
                                                <label for="nim" class="form-label fw-bold">NIM
                                                    <span style="color: red;">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="nim" placeholder="Enter NIM" name="nim" required>
                                            </div>
                                        </div>
    
                                        {{-- Field Fakultas dan Jurusan --}}
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="fakultas" class="form-label fw-bold">Fakultas:
                                                    <span style="color: red;">*</span>
                                                </label>
                                                <select class="form-control" id="fakultas" name="fakultas" required>
                                                    <option value="" disabled selected>--Pilih Fakultas--</option>
                                                    <option value="Fakultas Keguruan dan Ilmu Pendidikan">Fakultas Keguruan dan Ilmu Pendidikan</option>
                                                    <option value="Fakultas Hukum">Fakultas Hukum</option>
                                                    <option value="Fakultas Ekonomi dan Bisnis">Fakultas Ekonomi dan Bisnis</option>
                                                    <option value="Fakultas Pertanian">Fakultas Pertanian</option>
                                                    <option value="Fakultas Peternakan">Fakultas Peternakan</option>
                                                    <option value="Fakultas Sains dan Teknologi">Fakultas Sains dan Teknologi</option>
                                                    <option value="Fakultas Kedokteran dan Ilmu Kesehatan">Fakultas Kedokteran dan Ilmu Kesehatan</option>
                                                    <option value="Fakultas Ilmu Sosial dan Politik">Fakultas Ilmu Sosial dan Politik</option>
                                                    <option value="Fakultas Ilmu Budaya">Fakultas Ilmu Budaya</option>
                                                    <option value="Fakultas Teknologi Pertanian">Fakultas Teknologi Pertanian</option>
                                                    <option value="Fakultas Ilmu Keolahragaan">Fakultas Ilmu Keolahragaan</option>
                                                    <option value="Fakultas Kehuatanan">Fakultas Kehuatanan</option>
                                                    <option value="Fakultas Kesehatan Masyarakat">Fakultas Kesehatan Masyarakat</option>
                                                </select>
                                            </div>
                                            <div class="col mb-3">
                                                <label for="jurusan" class="form-label fw-bold">Jurusan:
                                                    <span style="color: red;">*</span>
                                                </label>
                                                <select class="form-control" id="jurusan" name="jurusan" required>
                                                    <option value="" disabled selected>--Pilih Jurusan--</option>
                                                    <option value="Administrasi Pendidikan">Administrasi Pendidikan</option>
                                                    <option value="Pendidikan Pancasila dan Kewarganegaraan">Pendidikan Pancasila dan Kewarganegaraan</option>
                                                    <option value="Pendidikan Matematika">Pendidikan Matematika</option>
                                                    <option value="Pendidikan Guru Sekolah Dasar">Pendidikan Guru Sekolah Dasar</option>
                                                    <option value="Pendidikan Sejarah">Pendidikan Sejarah</option>
                                                    <option value="Pendidikan Bahasa Inggris">Pendidikan Bahasa Inggris</option>
                                                    <option value="Pendidikan Kimia">Pendidikan Kimia</option>
                                                    <option value="Pendidikan Fisika">Pendidikan Fisika</option>
                                                    <option value="Pendidikan Guru PAUD">Pendidikan Guru PAUD</option>
                                                    <option value="Sistem Informasi">Sistem Informasi</option>
                                                    <option value="Teknik Sipil">Teknik Sipil</option>
                                                    <option value="Teknik Kimia">Teknik Kimia</option>
                                                    <option value="Kehutanan">Kehutanan</option>
                                                    <option value="Peternakan">Peternakan</option>
                                                    <option value="Perikanan">Perikanan</option>
                                                    <option value="Pendidikan Olahraga">Pendidikan Olahraga</option>
                                                    <option value="Sejarah">Sejarah</option>
                                                    <option value="Ilmu Ekonomi">Ilmu Ekonomi</option>
                                                    <option value="Akuntansi">Akuntansi</option>
                                                </select>
                                            </div>
                                        </div>
    
                                        {{-- Field Alamat dan Telepon --}}
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="alamat_lengkap" class="form-label fw-bold">Alamat Lengkap (Sesuai KTP)
                                                    <span style="color: red;">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="alamat_lengkap" placeholder="Enter Alamat Lengkap" name="alamat_lengkap" required>
                                            </div>
                                            <div class="col mb-3">
                                                <label for="telepon" class="form-label fw-bold">No. Telepon
                                                    <span style="color: red;">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="telepon" placeholder="Enter Telepon" name="telepon" required>
                                            </div>
                                        </div>
    
                                        {{-- Field Berkas Pendaftaran --}}
                                        <div class="row">
                                            @foreach($berkas as $fileBerkas)
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
                                @else
                                    <div class="alert text-center" style="background-color: #ff4d4d; color: white;">
                                        Mohon maaf! Anda belum memenuhi semua persyaratan untuk mendaftar beasiswa ini.
                                    </div>
                                @endif
                            </div> 
                            <!--end::Card Body-->
                        </div>
                        <!--end::Card Form Pendaftaran-->
                    </div>
                    <!--end::Tab Pane for Form Pendaftaran-->
    
                    <!--begin::Tab Pane for Riwayat Usulan-->
                    <div class="tab-pane fade" id="riwayat-pendaftaran" role="tabpanel" aria-labelledby="riwayat-tab">
                        <!--begin::Card Riwayat-->
                        <div class="card mb-4">
                            <!--begin::Card Header-->
                            <div class="card-header">
                                <h3 class="text-center">Riwayat Usulan Beasiswa</h3>
                            </div> 
                            <!--end::Card Header-->
            
                            <!--begin::Card Body-->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Beasiswa</th>
                                            <th>Status</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach($riwayatUsulan as $riwayat) --}}
                                            <tr>
                                                <td>1</td>
                                                <td>2</td>
                                                <td>3</td>
                                                <td>4</td>
                                                <td>
                                                    <a href="#" class="btn btn-info btn-sm">Lihat Detail</a>
                                                </td>
                                            </tr>
                                        {{-- @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                            <!--end::Card Body-->
                        </div>
                        <!--end::Card Riwayat-->
                    </div>
                    <!--end::Tab Pane for Riwayat Usulan-->
                </div>
                <!--end::Tab Content-->
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
    
@endpush
