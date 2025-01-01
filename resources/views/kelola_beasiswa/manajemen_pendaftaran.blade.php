@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Or for RTL support -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
    
    <style>
        .status-dibuka {
            background-color: #28a745; /* Warna hijau */
            color: white;
            padding: 3px;
            border-radius: 4px;
        }
        .status-ditutup {
            background-color: #dc3545; /* Warna merah */
            color: white;
            padding: 3px;
            border-radius: 4px;
        }
        /* Menambah padding dan border */
        #myTable { 
            font-size: 1rem;
            color: #333;
            margin-top: 100px;
        }

        .select2-container {
            z-index: 2051 !important; /* Ensure it's above the modal's z-index */
        }

        #myTable th {
            background-color: #FA812F;
            color: white;
            text-align: center;
        } 
        #myTable td {
            padding: 3px;
            text-align: center;
            border: 1px solid #f2f2f2;
        }

        /* Style untuk tombol */
        .tombol-tambah {
            background-color: #FEF3E2;
            border-color: #FA4032;
            color: #FA4032;
        }
        .tombol-tambah:hover {
            background-color: #FAD2B1; 
            border-color: #E53B1F;    
            color: #E53B1F;
        }
        .tombol-simpan {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        /* Styling modal */
        .modal-header {
            background-color: #FA812F;
            color: white;
        }
        .modal-body label {
            color: #495057;
        }
        /* Card Header Background */
        .card-header {
            background-color: white; 
            padding: 1rem;
        }
    </style>
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
                    <h3 class="mb-0">Kelola Beasiswa - Buat Pendaftaran</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Kelola Beasiswa
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Buat Pendaftaran
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
                <!--begin::form-->
                <form> 
                    <!--begin::card-->
                    <div class="card mb-4"> 
                        <!--begin::card header-->
                        <div class="card-header">
                            @role('Operator Kemahasiswaan')
                                <a href="#" class="btn text-dark tombol-tambah"><i class="bi bi-plus"></i> Tambah Data</a>
                            @endrole
                        </div>
                        <!--end::card header-->

                        <!--begin::card body-->
                        <div class="card-body"> 
                            <table class="table table-bordered mb-3" id="myTable">
                                <thead>
                                    <tr>
                                        <th style="width: 20px">No</th>
                                        <th style="width: 30px">Jenis Beasiswa</th>
                                        <th style="width: 30px">Nama Beasiswa</th>
                                        <th>Tahun</th>
                                        <th style="width: 50px">Tanggal Mulai Pendaftaran</th>
                                        <th style="width: 50px">Tanggal Akhir Pendaftaran</th>
                                        <th>Status</th>
                                        <th style="width: 50px">Mulai Berlaku Beasiswa</th>
                                        <th style="width: 50px">Akhir Berlaku Beasiswa</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead> 
                            </table>
                        </div> <!--end::card body-->
                    </div>
                    <!--end::card-->
                </form> 
                <!--end::form-->
            </div> 
            <!-- /.col -->
        </div> 
        <!--end::Container-->
    </div> 
    <!--end::App Content-->  
</main> 

<!-- Modal Jenis Beasiswa -->
<div class="modal fade" id="jenisBeasiswaModal" tabindex="-1" aria-labelledby="jenisBeasiswaLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="jenisBeasiswaLabel">Pilih Jenis Beasiswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <!-- Pilihan Jenis Beasiswa -->
            <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_beasiswa" id="beasiswa_internal" value="internal" checked>
                <label class="form-check-label" for="beasiswa_internal">
                    Beasiswa Internal
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_beasiswa" id="beasiswa_eksternal" value="eksternal">
                <label class="form-check-label" for="beasiswa_eksternal">
                    Beasiswa Eksternal
                </label>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary lanjutkan">Lanjutkan</button>
        </div>
      </div>
    </div>
</div>

<!-- Modal Tambah/Edit Pendaftaran -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Form Buat Pendaftaran Beasiswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div id="form-internal">
                {{-- Form untuk Beasiswa Internal --}}
                <div class="row">
                    <!-- Pilih Beasiswa -->
                    <div class="col mb-3">
                        <label for="daftar_beasiswas_id" class="form-label fw-bold">Pilih Beasiswa:
                            <span style="color: red;">*</span>
                        </label>
                        <select class="form-control" id="daftar_beasiswas_id" name="daftar_beasiswas_id" required>
                            <option value="" disabled selected>Pilih Beasiswa</option>
                            @foreach($beasiswa as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_beasiswa }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Tahun -->
                    <div class="col mb-3">
                      <label for="tahun" class="form-label fw-bold">Tahun:
                        <span style="color: red;">*</span>
                      </label>
                      <input type="number" class="form-control" id="tahun" name="tahun" required>
                    </div> 
                    <!-- Tanggal Mulai -->
                    <div class="mb-3">
                        <label for="tanggal_mulai" class="form-label fw-bold">Tanggal Mulai:
                            <span style="color: red;">*</span>
                        </label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                    </div>
                    <!-- Tanggal Berakhir -->
                    <div class="mb-3">
                        <label for="tanggal_berakhir" class="form-label fw-bold">Tanggal Berakhir:
                            <span style="color: red;">*</span>
                        </label>
                        <input type="date" class="form-control" id="tanggal_berakhir" name="tanggal_berakhir" required>
                    </div>
                    <!-- Status -->
                    {{-- <div class="mb-3">
                        <label for="status" class="form-label fw-bold">Status:
                            <span style="color: red;">*</span>
                        </label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="" disabled selected>Pilih Status</option>
                            <option value="dibuka">Dibuka</option>
                            <option value="ditutup">Ditutup</option>
                        </select>
                    </div> --}}
                    <!-- Pilih Tahapan -->
                    <div class="mb-3">
                        <label for="tahapan" class="form-label fw-bold">Pilih Tahapan:
                            <span style="color: red;">*</span>
                        </label>
                        <div id="tahapan-checkboxes">
                            @foreach($tahapans as $tahapan)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="tahapans[]" value="{{ $tahapan->id }}" id="tahapan_{{ $tahapan->id }}">
                                    <label class="form-check-label" for="tahapan_{{ $tahapan->id }}">
                                        {{ $tahapan->nama_tahapan }}
                                    </label>

                                    <!-- Input untuk tanggal mulai dan tanggal akhir -->
                                    <div class="row mt-2">
                                        <div class="col">
                                            <input type="date" class="form-control" name="tahapan_tanggal_mulai[{{ $tahapan->id }}]" id="tahapan_tanggal_mulai_{{ $tahapan->id }}" placeholder="Tanggal Mulai" disabled>
                                        </div>
                                        <div class="col">
                                            <input type="date" class="form-control" name="tahapan_tanggal_akhir[{{ $tahapan->id }}]" id="tahapan_tanggal_akhir_{{ $tahapan->id }}" placeholder="Tanggal Akhir" disabled>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div> 
                    </div>
                    <!-- Pilih Persyaratan -->
                    <div class="mb-3">
                        <label for="persyaratan" class="form-label fw-bold">Pilih Persyaratan:
                            <span style="color: red;">*</span>
                        </label>
                        <select class="form-control" id="persyaratan" name="persyaratan[]"  multiple="multiple" required>
                            @foreach($persyaratan as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_persyaratan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Pilih Berkas -->
                    <div class="mb-3">
                        <label for="berkas" class="form-label fw-bold">Pilih Berkas yang Dibutuhkan:
                            <span style="color: red;">*</span>
                        </label>
                        <select class="form-control" id="berkas" name="berkas[]"  multiple="multiple" required>
                            @foreach($berkasPendaftarans as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_file }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="mb-3">
                        <label for="mulai_berlaku" class="form-label fw-bold">Mulai Berlaku Beasiswa:
                            <span style="color: red;">*</span>
                        </label>
                        <input type="date" class="form-control" id="mulai_berlaku" name="mulai_berlaku" required>
                    </div>
                    <!-- Tanggal Berakhir -->
                    <div class="mb-3">
                        <label for="akhir_berlaku" class="form-label fw-bold">Akhir Berlaku Beasiswa:
                            <span style="color: red;">*</span>
                        </label>
                        <input type="date" class="form-control" id="akhir_berlaku" name="akhir_berlaku" required>
                    </div>

                    <!-- Pilih Role Validasi -->
                    <div class="mb-3">
                        <label for="roles" class="form-label fw-bold">Pilih Role Validator dan Urutan Validasi:
                            <span style="color: red;">*</span>
                        </label>
                        <div id="role-validasi-container">
                            <div class="row mb-2">
                                <div class="col">
                                    <select class="form-control" name="roles[]" id="roles" required>
                                        <option value="" disabled selected>Pilih Role</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" name="urutan[]" placeholder="Urutan Validasi" required>
                                </div>
                                <div class="col-auto">
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-success add-role">+</button> <!-- Tombol add-role -->
                                        <button type="button" class="btn btn-danger remove-role">-</button> <!-- Tombol remove-role -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="form-eksternal" style="display: none;">
                {{-- Form untuk Beasiswa Eksternal --}}
                <div class="row">
                    <!-- Field Internal yang sudah ada -->
                    <!-- Tambahan Field Eksternal: Gambar Flyer, Link Pendaftaran -->
                    <div class="col mb-3">
                        {{-- <img id="flyer-preview" src="" alt="Preview Flyer" style="max-width: 100%; display: none;"> --}}
                        <label for="flyer" class="form-label fw-bold">Gambar Flyer:
                            <span style="color: red;">*</span>
                        </label>
                        <input type="file" class="form-control" id="flyer" name="flyer">
                        <a id="flyer-link" href="" target="_blank" style="display: none;">Lihat Flyer yang Diupload</a>
                    </div>
                    <div class="col mb-3">
                        <label for="link_pendaftaran" class="form-label fw-bold">Link Pendaftaran:
                            <span style="color: red;">*</span>
                        </label>
                        <input type="url" class="form-control" id="link_pendaftaran" name="link_pendaftaran">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary tombol-simpan">Simpan Data</button>
        </div>
      </div>
    </div>
</div>
<!-- Modal -->

<!--end::App Main-->
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{!! route('manajemen_pendaftaran.index') !!}",
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'jenis_beasiswa', name: 'jenis_beasiswa' },
                    { data: 'beasiswa.nama_beasiswa', name: 'beasiswa.nama_beasiswa' },
                    { data: 'tahun', name: 'tahun' },
                    { data: 'tanggal_mulai', name: 'tanggal_mulai' },
                    { data: 'tanggal_berakhir', name: 'tanggal_berakhir' },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            if (data === 'dibuka') {
                                return '<span class="status-dibuka">Dibuka</span>';
                            } else if (data === 'ditutup') {
                                return '<span class="status-ditutup">Ditutup</span>';
                            } else {
                                return data;
                            }
                        }
                    },
                    { data: 'mulai_berlaku', name: 'mulai_berlaku' },
                    { data: 'akhir_berlaku', name: 'akhir_berlaku' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
                ]
            });
    
            // GLOBAL SETUP
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // select 2 persyaratan
            $('#exampleModal').on('shown.bs.modal', function () {
                $('#persyaratan').select2({
                    placeholder: "Select persyaratan",
                    allowClear: true,
                    width: '100%',
                    theme: 'bootstrap-5'
                });
            });

            // select 2 berkas
            $('#exampleModal').on('shown.bs.modal', function () {
                $('#berkas').select2({
                    placeholder: "Select berkas",
                    allowClear: true,
                    width: '100%',
                    theme: 'bootstrap-5'
                });
            });

            $('#exampleModal').on('hidden.bs.modal', function () {
                // Reset semua input di dalam modal
                $(this).find('form')[0].reset();

                // Kosongkan input tanggal mulai dan akhir tahapan
                $('input[name="tahapan_tanggal_mulai[]"]').val('').prop('disabled', false);
                $('input[name="tahapan_tanggal_akhir[]"]').val('').prop('disabled', false);

                // Uncheck semua checkbox tahapan
                $('input[name="tahapans[]"]').prop('checked', false);

                // Kosongkan container role validasi
                $('#role-validasi-container').empty();

                // Sembunyikan elemen tertentu
                $('#form-eksternal').hide();
                $('#flyer-link').hide();
            });

            // Proses tambah dan simpan data
            $('body').on('click', '.tombol-tambah', function (e) {
                e.preventDefault();
                enableForm(); // Aktifkan kembali form
                $('#exampleModalLabel').text('Buat Pendaftaran Beasiswa');

                // Kosongkan form saat menambah data baru
                $('#daftar_beasiswas_id').val('');
                $('#tahun').val('');
                $('#tanggal_mulai').val('');
                $('#tanggal_berakhir').val('');
                $('#persyaratan').val([]).trigger('change');
                $('#berkas').val([]).trigger('change');
                $('#mulai_berlaku').val('');
                $('#akhir_berlaku').val('');
                $('#role-validasi-container').empty(); // Pastikan tidak ada role yang tersisa dari proses sebelumnya
                addDefaultRoleRow(); // Tambahkan satu baris default untuk role dan urutan
                $('#flyer').val(null); // Kosongkan field flyer
                $('#flyer-link').hide(); // Sembunyikan link flyer
                $('#link_pendaftaran').val(''); // Kosongkan field link pendaftaran

                // Reset checkbox tahapan dan input tanggal
                // $('input[name="tahapans[]"]').prop('checked', false); // Uncheck semua tahapan
                // $('input[name="tahapan_tanggal_mulai[]"]').prop('disabled', false).val(''); // Disable dan kosongkan tanggal mulai
                // $('input[name="tahapan_tanggal_akhir[]"]').prop('disabled', false).val(''); // Disable dan kosongkan tanggal akhir
                
                $('#form-eksternal').hide(); // Sembunyikan form eksternal secara default

                // Tampilkan modal pemilihan jenis beasiswa (internal/eksternal)
                $('#jenisBeasiswaModal').modal('show');

                // Ketika user klik tombol lanjutkan setelah memilih jenis beasiswa
                $('.lanjutkan').off('click').on('click', function () {
                    const jenisBeasiswa = $('input[name="jenis_beasiswa"]:checked').val();

                    // Sembunyikan modal pemilihan jenis beasiswa
                    $('#jenisBeasiswaModal').modal('hide');

                    // Tampilkan atau sembunyikan form eksternal berdasarkan jenis beasiswa
                    if (jenisBeasiswa === 'eksternal') {
                        $('#form-eksternal').show(); // Tampilkan field flyer dan link pendaftaran jika eksternal
                        $('#role-validasi-container').hide(); // Sembunyikan container role validasi
                        $('#role-validasi-container').find('select, input').prop('disabled', true); // Nonaktifkan input role
                        $('label[for="roles"]').hide(); // Sembunyikan label role validasi
                    } else {
                        $('#form-eksternal').hide(); // Sembunyikan jika beasiswa internal
                        $('#role-validasi-container').show(); // Tampilkan container role validasi untuk internal
                        $('#role-validasi-container').find('select, input').prop('disabled', false); // Aktifkan kembali input role
                        $('label[for="roles"]').show(); // Tampilkan kembali label role validasi
                    }

                    // Tampilkan modal form utama
                    $('#exampleModal').modal('show');

                    // Tampilkan tombol simpan
                    $('.tombol-simpan').show();

                    // Proses simpan data baru
                    $('.tombol-simpan').off('click').on('click', function () {
                        simpan(); // Fungsi simpan untuk create
                    });
                });
            });

            // Aktifkan/Nonaktifkan tanggal mulai dan akhir berdasarkan checkbox tahapan
            $('input[name="tahapans[]"]').on('change', function () {
                var tahapanId = $(this).val();
                if ($(this).is(':checked')) {
                    // Jika checkbox dicentang, aktifkan field tanggal
                    $('#tahapan_tanggal_mulai_' + tahapanId).prop('disabled', false);
                    $('#tahapan_tanggal_akhir_' + tahapanId).prop('disabled', false);
                } else {
                    // Jika checkbox tidak dicentang, nonaktifkan dan kosongkan field tanggal
                    $('#tahapan_tanggal_mulai_' + tahapanId).prop('disabled', true).val('');
                    $('#tahapan_tanggal_akhir_' + tahapanId).prop('disabled', true).val('');
                }
            });

            // Fungsi untuk membuka modal edit dan mengisi data berdasarkan ID yang dipilih
            $('body').on('click', '.tombol-edit', function (e) {
                e.preventDefault();
                const id = $(this).data('id'); // Ambil ID dari tombol edit

                // Aktifkan kembali form dan tampilkan modal
                enableForm();
                $('#exampleModalLabel').text('Edit Pendaftaran Beasiswa');
                $('#exampleModal').modal('show');
                $('.tombol-simpan').show();

                // Kosongkan pesan error sebelumnya
                $('.text-danger').remove();
                $('.is-invalid').removeClass('is-invalid');

                // Ambil data dari server untuk mengisi form edit
                $.ajax({
                    url: 'manajemen_pendaftaran/' + id + '/edit',
                    type: 'GET',
                    success: function (response) {
                        console.log("Response dari Server:", response);

                        // Isi form dengan data yang diterima dari server
                        $('#daftar_beasiswas_id').val(response.result.daftar_beasiswas_id);
                        $('#tahun').val(response.result.tahun);
                        $('#tanggal_mulai').val(response.result.tanggal_mulai);
                        $('#tanggal_berakhir').val(response.result.tanggal_berakhir);

                        // Pilih persyaratan dan berkas yang sudah ada
                        $('#persyaratan').val(response.result.persyaratan.map(item => item.id)).trigger('change');
                        $('#berkas').val(response.result.berkas_pendaftarans.map(item => item.id)).trigger('change');
                        $('#mulai_berlaku').val(response.result.mulai_berlaku);
                        $('#akhir_berlaku').val(response.result.akhir_berlaku);

                        // Check jenis beasiswa
                        if (response.result.jenis_beasiswa === 'eksternal') {
                            $('input[name="jenis_beasiswa"][value="eksternal"]').prop('checked', true);
                            $('#form-eksternal').show();
                            $('#role-validasi-container').hide();
                            $('#role-validasi-container').find('select, input').prop('disabled', true); // Nonaktifkan input role
                            if (response.result.flyer) {
                                $('#flyer').val(null); // Kosongkan input file
                                $('#flyer-link')
                                    .attr('href', '/storage/' + response.result.flyer) // Path sesuai konfigurasi storage
                                    .text('Lihat Flyer')
                                    .show();
                            } else {
                                $('#flyer-link').hide(); // Sembunyikan jika tidak ada file
                            }
                            $('#link_pendaftaran').val(response.result.link_pendaftaran);
                        } else {
                            $('input[name="jenis_beasiswa"][value="internal"]').prop('checked', true);
                            $('#form-eksternal').hide();
                            $('#role-validasi-container').show();
                            $('#role-validasi-container').find('select, input').prop('disabled', false); // Aktifkan kembali input role
                        }


                        // Kosongkan role validasi dan tambahkan sesuai data yang ada
                        $('#role-validasi-container').empty();
                        if (response.result.roles) {
                            response.result.roles.forEach(role => {
                                const newRow = `
                                    <div class="row mb-2">
                                        <div class="col">
                                            <select class="form-control" name="roles[]" required>
                                                <option value="" disabled>Pilih Role</option>
                                                @foreach($roles as $roleOption)
                                                    <option value="{{ $roleOption->id }}" ${role.id == {{ $roleOption->id }} ? 'selected' : ''}>{{ $roleOption->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <input type="number" class="form-control" name="urutan[]" placeholder="Urutan Validasi" required value="${role.pivot.urutan}">
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-success add-role">+</button>
                                            <button type="button" class="btn btn-danger remove-role">-</button>
                                        </div>
                                    </div>`;
                                $('#role-validasi-container').append(newRow);
                            });
                        }

                        // Tambahkan data tahapan
                        $('input[name="tahapans[]"]').each(function () {
                            const tahapanId = $(this).val();
                            const tahapanData = response.result.tahapan.find(tahapan => tahapan.id == tahapanId);
                            if (tahapanData) {
                                $(this).prop('checked', true);
                                $('#tahapan_tanggal_mulai_' + tahapanId).val(tahapanData.pivot.tanggal_mulai).prop('disabled', false);
                                $('#tahapan_tanggal_akhir_' + tahapanId).val(tahapanData.pivot.tanggal_akhir).prop('disabled', false);
                            }
                        });
                    },
                    error: function (xhr) {
                        console.error("Error fetching data: ", xhr);
                    }
                });

                // Simpan perubahan data saat tombol simpan diklik
                $('.tombol-simpan').off('click').on('click', function () {
                    simpan(id); // Fungsi simpan untuk update (dengan ID)
                });
            });

            // Tombol untuk melihat detail
            $('body').on('click', '.tombol-detail', function(e) {
                e.preventDefault();

                const id = $(this).data('id'); // Ambil ID dari tombol detail

                // Nonaktifkan form untuk mode baca saja
                disableForm();

                // Ubah judul modal menjadi "Detail Pendaftaran Beasiswa"
                $('#exampleModalLabel').text('Detail Pendaftaran Beasiswa');
                
                // Kosongkan pesan error sebelumnya
                $('.text-danger').remove();
                $('.is-invalid').removeClass('is-invalid');

                // Ambil data dari server untuk mengisi form detail
                $.ajax({
                    url: `/kelola_beasiswa/manajemen_pendaftaran/${id}/`,// Endpoint detail sesuai dengan ID
                    type: 'GET',
                    success: function(response) {
                        const data = response.result;
                        
                        // Isi form dengan data yang diterima dari server
                        $('#daftar_beasiswas_id').val(data.daftar_beasiswas_id);
                        $('#tahun').val(data.tahun).prop('disabled', true);
                        $('#tanggal_mulai').val(data.tanggal_mulai).prop('disabled', true);
                        $('#tanggal_berakhir').val(data.tanggal_berakhir).prop('disabled', true);
                        $('#status').val(data.status).prop('disabled', true);
                        $('#persyaratan').val(data.persyaratan.map(item => item.id)).trigger('change').prop('disabled', true);
                        $('#berkas').val(data.berkas_pendaftarans.map(item => item.id)).trigger('change').prop('disabled', true);
                        $('#mulai_berlaku').val(data.mulai_berlaku).prop('disabled', true); 
                        $('#akhir_berlaku').val(data.akhir_berlaku).prop('disabled', true); 

                        if (data.jenis_beasiswa === 'eksternal') {
                            $('#form-eksternal').show();
                            $('#role-validasi-container').hide();

                            $('#link_pendaftaran').val(data.link_pendaftaran).prop('disabled', true); // Set disabled untuk link_pendaftaran

                            // Tampilkan link flyer jika data flyer tersedia
                            if (data.flyer) {
                                $('#flyer-link').attr('href', data.flyer).show();
                            } else {
                                $('#flyer-link').hide();
                            }
                        } else {
                            $('#form-eksternal').hide();
                            $('#role-validasi-container').show();
                            $('#flyer-link').hide();
                        }

                        // Kosongkan role validasi dan tambahkan sesuai data yang ada
                        $('#role-validasi-container').empty();
                        if (data.roles) {
                            data.roles.forEach((role) => {
                                const newRow = `
                                    <div class="row mb-2">
                                        <div class="col">
                                            <select class="form-control" name="roles[]" disabled>
                                                <option value="" disabled>Pilih Role</option>
                                                @foreach($roles as $roleOption)
                                                    <option value="{{ $roleOption->id }}" ${role.id == {{ $roleOption->id }} ? 'selected' : ''}>{{ $roleOption->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <input type="number" class="form-control" name="urutan[]" placeholder="Urutan Validasi" required value="${role.pivot.urutan}" disabled>
                                        </div>
                                    </div>`;
                                $('#role-validasi-container').append(newRow);
                            });
                        }

                        // Isi data tahapan dan tanggal mulai/akhir
                        $('input[name="tahapans[]"]').each(function () {
                            const tahapanId = $(this).val();
                            const tahapanData = data.tahapan.find(tahapan => tahapan.id == tahapanId);

                            if (tahapanData) {
                                $(this).prop('checked', true);
                                $('#tahapan_tanggal_mulai_' + tahapanId).val(tahapanData.pivot.tanggal_mulai).prop('disabled', true);
                                $('#tahapan_tanggal_akhir_' + tahapanId).val(tahapanData.pivot.tanggal_akhir).prop('disabled', true);
                            } else {
                                $(this).prop('checked', false);
                                $('#tahapan_tanggal_mulai_' + tahapanId).val('').prop('disabled', false);
                                $('#tahapan_tanggal_akhir_' + tahapanId).val('').prop('disabled', false); 
                            }
                        });

                        // Tampilkan modal
                        $('#exampleModal').modal('show');

                        // Sembunyikan tombol simpan di mode detail
                        $('.tombol-simpan').hide();
                    },
                    error: function(xhr) {
                        console.error("Gagal mengambil detail data: ", xhr);
                        iziToast.error({
                            title: 'Error',
                            message: 'Gagal memuat data detail. Silakan coba lagi.',
                            position: 'topRight'
                        });
                    }
                });
            });

            // Proses delete data
            $('body').on('click', '.tombol-delete', function (e) {
                e.preventDefault();
                var id = $(this).data('id');

                // Tampilkan SweetAlert2
                Swal.fire({
                    title: 'Yakin mau hapus data ini?',
                    text: "Data yang sudah dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Lakukan permintaan AJAX untuk menghapus data
                        $.ajax({
                            url: 'manajemen_pendaftaran/' + id,
                            type: 'DELETE',
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    'Data berhasil dihapus.',
                                    'success'
                                );
                                $('#myTable').DataTable().ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat menghapus data.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

            // Fungsi untuk menambahkan baris default untuk role validasi
            function addDefaultRoleRow() {
                const container = $('#role-validasi-container');
                const newRow = `
                    <div class="row mb-2">
                        <div class="col">
                            <select class="form-control" name="roles[]" required>
                                <option value="" disabled selected>Pilih Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" name="urutan[]" placeholder="Urutan Validasi" required>
                        </div>
                        <div class="col-auto">
                            <div class="col-auto">
                                <button type="button" class="btn btn-success add-role">+</button> <!-- Tombol add-role -->
                                <button type="button" class="btn btn-danger remove-role">-</button> <!-- Tombol remove-role -->
                            </div>
                        </div>
                    </div>
                `;
                container.append(newRow);
            }

            // Tambahkan role baru saat tombol add-role diklik
            $('body').on('click', '.add-role', function () {
                addDefaultRoleRow(); // Tambahkan baris baru dengan dropdown role dan urutan validasi
            });

            // Hapus role saat tombol remove-role diklik
            $('body').on('click', '.remove-role', function () {
                $(this).closest('.row').remove(); // Hapus baris role yang dipilih
            });

            // Fungsi untuk menonaktifkan semua field dalam form
            function disableForm() {
                $('#daftar_beasiswas_id').attr('disabled', true);
                $('#tahun').attr('disabled', true);
                $('#tanggal_mulai').attr('disabled', true);
                $('#tanggal_berakhir').attr('disabled', true);
                $('#status').attr('disabled', true);
                $('#persyaratan').attr('disabled', true).trigger('change');
                $('#berkas').attr('disabled', true).trigger('change');
                $('#role-validasi-container select').attr('disabled', true);
                $('#role-validasi-container input').attr('disabled', true);
                $('#flyer').attr('disabled', true); // Disable field flyer
                $('#link_pendaftaran').attr('disabled', true); // Disable field link pendaftaran
                $('.add-role').hide(); // Sembunyikan tombol tambah role
            }

            // Fungsi untuk mengaktifkan semua field dalam form
            function enableForm() {
                $('#daftar_beasiswas_id').prop('disabled', false).val('');
                $('#tahun').prop('disabled', false).val('');
                $('#tanggal_mulai').prop('disabled', false).val('');
                $('#tanggal_berakhir').prop('disabled', false).val('');
                $('#status').prop('disabled', false).val('');
                $('#persyaratan').prop('disabled', false).trigger('change');
                $('#berkas').prop('disabled', false).trigger('change');
                $('#role-validasi-container select').prop('disabled', false);
                $('#role-validasi-container input').prop('disabled', false);
                $('#flyer').prop('disabled', false).val(null);
                $('#link_pendaftaran').prop('disabled', false).val('');
                $('input[name="tahapans[]"]').prop('disabled', false).prop('checked', false);
                $('input[name="tahapan_tanggal_mulai[]"]').prop('disabled', false).val('');
                $('input[name="tahapan_tanggal_akhir[]"]').prop('disabled', false).val('');
                $('.add-role').show();
            }

            // Fungsi untuk simpan dan update data
            function simpan(id = '', closeModal = true) {
                var var_url = id ? 'manajemen_pendaftaran/' + id : 'manajemen_pendaftaran';
                var var_type = id ? 'POST' : 'POST'; 

                // Persiapkan form data untuk mengirim file jika ada flyer (eksternal)
                var formData = new FormData();
                formData.append('daftar_beasiswas_id', $('#daftar_beasiswas_id').val());
                formData.append('tahun', $('#tahun').val());
                formData.append('tanggal_mulai', $('#tanggal_mulai').val());
                formData.append('tanggal_berakhir', $('#tanggal_berakhir').val());

                // Validasi frontend: pastikan tanggal ada
                if (!$('#tanggal_mulai').val() || !$('#tanggal_berakhir').val()) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Tanggal Mulai dan Tanggal Berakhir wajib diisi!',
                        position: 'topRight'
                    });
                    return;
                }
                formData.append('jenis_beasiswa', $('input[name="jenis_beasiswa"]:checked').val()); // Jenis beasiswa (internal/eksternal)

                // Tambahkan flyer jika jenis beasiswa eksternal dan ada file
                if ($('input[name="jenis_beasiswa"]:checked').val() === 'eksternal' && $('#flyer')[0].files.length > 0) {
                    formData.append('flyer', $('#flyer')[0].files[0]); // Menambahkan file flyer ke FormData
                }
                formData.append('link_pendaftaran', $('#link_pendaftaran').val()); // Menambahkan link pendaftaran jika ada

                // Menambahkan array persyaratan
                $.each($('#persyaratan').val(), function (i, persyaratan_id) {
                    formData.append('persyaratan[]', persyaratan_id); // Tambahkan persyaratan ke FormData
                });

                // Menambahkan array berkas
                $.each($('#berkas').val(), function (i, berkas_id) {
                    formData.append('berkas[]', berkas_id); // Tambahkan berkas ke FormData
                });

                formData.append('mulai_berlaku', $('#mulai_berlaku').val());
                formData.append('akhir_berlaku', $('#akhir_berlaku').val());

                // Menambahkan roles dan urutan validasi
                $('select[name="roles[]"]').each(function (i, role) {
                    formData.append('roles[]', $(role).val());
                });
                $('input[name="urutan[]"]').each(function (i, urutan) {
                    formData.append('urutan[]', $(urutan).val());
                });

                // Tambahkan tahapan yang dipilih dan tanggalnya
                $('input[name="tahapans[]"]:checked').each(function () {
                    var tahapanId = $(this).val();
                    formData.append('tahapans[]', tahapanId);
                    formData.append('tahapan_tanggal_mulai[' + tahapanId + ']', $('#tahapan_tanggal_mulai_' + tahapanId).val());
                    formData.append('tahapan_tanggal_akhir[' + tahapanId + ']', $('#tahapan_tanggal_akhir_' + tahapanId).val());
                });
                // Jika ada id, tambahkan method untuk update PUT
                if (id) {
                    formData.append('_method', 'PUT'); // Override method PUT
                }

                // Tambahkan CSRF token
                formData.append('_token', $('meta[name="csrf-token"]').attr('content')); // Penting!

                // Debugging: Periksa apa yang ada di FormData
                for (var pair of formData.entries()) {
                    console.log(pair[0] + ', ' + pair[1]);
                }

                // Reset pesan kesalahan sebelumnya
                $('.text-danger').remove();
                $('.is-invalid').removeClass('is-invalid');

                $.ajax({
                    url: var_url,
                    type: var_type,
                    data: formData,
                    contentType: false, // Set ke false agar jQuery tidak memproses data
                    processData: false, // Set ke false agar jQuery tidak memproses form data
                    success: function(response) {
                        if (response.errors) {
                            // Tampilkan pesan kesalahan di bawah input yang sesuai
                            $.each(response.errors, function(key, value) {
                                $('#' + key)
                                    .addClass('is-invalid') // Tambahkan kelas is-invalid ke input yang bermasalah
                                    .after('<span class="text-danger" style="font-style: italic; font-size: 12px;">' + value[0] + '</span>');
                            });
                        } else {
                            iziToast.success({
                                title: 'Success',
                                message: response.success,
                                position: 'topRight'
                            });

                            // Reload DataTables untuk memperbarui data
                            $('#myTable').DataTable().ajax.reload();

                            if (closeModal) {
                                $('#exampleModal').modal('hide'); // Tutup modal jika closeModal true
                            } else {
                                // Bersihkan form untuk input baru
                                $('#daftar_beasiswas_id').val('').removeClass('is-invalid');
                                $('#tahun').val('').removeClass('is-invalid');
                                $('#tanggal_mulai').val('').removeClass('is-invalid');
                                $('#tanggal_berakhir').val('').removeClass('is-invalid');
                                $('#persyaratan').val([]).trigger('change').removeClass('is-invalid'); // Reset persyaratan
                                $('#berkas').val([]).trigger('change').removeClass('is-invalid'); // Reset berkas
                                $('#mulai_berlaku').val('').removeClass('is-invalid');
                                $('#akhir_berlaku').val('').removeClass('is-invalid');
                                $('#roles').val([]).trigger('change').removeClass('is-invalid'); // Reset roles
                                $('input[name="urutan[]"]').val('').removeClass('is-invalid'); // Reset urutan
                                $('.text-danger').remove(); // Bersihkan pesan kesalahan sebelumnya
                                $('#flyer').val(''); // Reset flyer
                                $('#link_pendaftaran').val(''); // Reset link pendaftaran
                                $('select[name="tahapans[]"]').val(null).trigger('change');
                                $('input[name="tahapan_tanggal_mulai[]"]').val('').removeClass('is-invalid');
                                $('input[name="tahapan_tanggal_akhir[]"]').val('').removeClass('is-invalid');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // Tangani error jika ada masalah pada server
                        console.log("Error: ", error);
                        iziToast.error({
                            title: 'Error',
                            message: 'Gagal menyimpan data. Silakan coba lagi.',
                            position: 'topRight'
                        });
                    }
                });
            }
        });
    </script>
@endpush
