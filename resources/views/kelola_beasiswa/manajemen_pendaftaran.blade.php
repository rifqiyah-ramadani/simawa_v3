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
        #myTable td {
            padding: 5px;
            border: 1px solid #f2f2f2;
        }

        .select2-container {
            z-index: 2051 !important; /* Ensure it's above the modal's z-index */
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
                            <a href="#" class="btn btn-primary text-light tombol-tambah"><i class="bi bi-plus"></i> Tambah Data</a>
                        </div> 
                        <!--end::card header-->

                        <!--begin::card body-->
                        <div class="card-body"> 
                            <table class="table table-bordered mb-3" id="myTable">
                                <thead>
                                    <tr>
                                        <th style="width: 20px">No</th>
                                        <th>Jenis Beasiswa</th>
                                        <th>Nama Beasiswa</th>
                                        <th>Tahun</th>
                                        <th>Tanggal Mulai Pendaftaran</th>
                                        <th>Tanggal Akhir Pendaftaran</th>
                                        <th>Status</th>
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
                    <div class="mb-3">
                        <label for="status" class="form-label fw-bold">Status:
                            <span style="color: red;">*</span>
                        </label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="" disabled selected>Pilih Status</option>
                            <option value="dibuka">Dibuka</option>
                            <option value="ditutup">Ditutup</option>
                        </select>
                    </div>
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
                        <label for="flyer" class="form-label fw-bold">Gambar Flyer:
                            <span style="color: red;">*</span>
                        </label>
                        <input type="file" class="form-control" id="flyer" name="flyer">
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

    {{-- script datatables --}}
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
                $('#status').val('');
                $('#persyaratan').val([]).trigger('change');
                $('#berkas').val([]).trigger('change');
                $('#role-validasi-container').empty(); // Pastikan tidak ada role yang tersisa dari proses sebelumnya
                addDefaultRoleRow(); // Tambahkan satu baris default untuk role dan urutan
                $('#flyer').val(''); // Kosongkan field flyer
                $('#link_pendaftaran').val(''); // Kosongkan field link pendaftaran
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
                        $('#roles').prop('required', false); // Hilangkan sifat required dari roles
                        $('input[name="urutan[]"]').prop('required', false); // Hilangkan sifat required dari urutan
                    } else {
                        $('#form-eksternal').hide(); // Sembunyikan jika beasiswa internal
                        $('#role-validasi-container').show(); // Tampilkan container role validasi untuk internal
                        $('#roles').prop('required', true); // Tambahkan required untuk roles
                        $('input[name="urutan[]"]').prop('required', true); // Tambahkan required untuk urutan
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
                $('#daftar_beasiswas_id').attr('disabled', false);
                $('#tahun').attr('disabled', false);
                $('#tanggal_mulai').attr('disabled', false);
                $('#tanggal_berakhir').attr('disabled', false);
                $('#status').attr('disabled', false);
                $('#persyaratan').attr('disabled', false).trigger('change');
                $('#berkas').attr('disabled', false).trigger('change');
                $('#role-validasi-container select').attr('disabled', false);
                $('#role-validasi-container input').attr('disabled', false);
                $('#flyer').attr('disabled', false); // Aktifkan field flyer
                $('#link_pendaftaran').attr('disabled', false); // Aktifkan field link pendaftaran
                $('.add-role').show(); // Tampilkan tombol tambah role
            }

            // Fungsi untuk simpan dan update data
            function simpan(id = '', closeModal = true) {
                var var_url = id ? 'manajemen_pendaftaran/' + id : 'manajemen_pendaftaran';
                var var_type = id ? 'PUT' : 'POST';

                // Reset pesan kesalahan sebelumnya
                $('.text-danger').remove();
                $('.is-invalid').removeClass('is-invalid');

                // Persiapkan form data untuk mengirim file jika ada flyer (eksternal)
                var formData = new FormData();
                formData.append('daftar_beasiswas_id', $('#daftar_beasiswas_id').val());
                formData.append('tahun', $('#tahun').val());
                formData.append('tanggal_mulai', $('#tanggal_mulai').val());
                formData.append('tanggal_berakhir', $('#tanggal_berakhir').val());
                formData.append('status', $('#status').val());
                formData.append('jenis_beasiswa', $('input[name="jenis_beasiswa"]:checked').val()); // Jenis beasiswa (internal/eksternal)

                // Tambahkan flyer jika jenis beasiswa eksternal dan ada file
                if ($('input[name="jenis_beasiswa"]:checked').val() === 'eksternal') {
                    if ($('#flyer')[0].files.length > 0) {
                        formData.append('flyer', $('#flyer')[0].files[0]); // Menambahkan file flyer ke FormData
                    }
                    formData.append('link_pendaftaran', $('#link_pendaftaran').val()); // Menambahkan link pendaftaran
                }

                // Menambahkan array persyaratan
                $.each($('#persyaratan').val(), function (i, persyaratan_id) {
                    formData.append('persyaratan[]', persyaratan_id); // Tambahkan persyaratan ke FormData
                });

                // Menambahkan array berkas
                $.each($('#berkas').val(), function (i, berkas_id) {
                    formData.append('berkas[]', berkas_id); // Tambahkan berkas ke FormData
                });

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
                                $('#status').val('').removeClass('is-invalid');
                                $('#persyaratan').val([]).trigger('change').removeClass('is-invalid'); // Reset persyaratan
                                $('#berkas').val([]).trigger('change').removeClass('is-invalid'); // Reset berkas
                                $('#roles').val([]).trigger('change').removeClass('is-invalid'); // Reset roles
                                $('input[name="urutan[]"]').val('').removeClass('is-invalid'); // Reset urutan
                                $('.text-danger').remove(); // Bersihkan pesan kesalahan sebelumnya
                                $('#flyer').val(''); // Reset flyer
                                $('#link_pendaftaran').val(''); // Reset link pendaftaran
                                $('select[name="tahapans[]"]').val(null).trigger('change');
                                $('input[name="tahapan_tanggal_mulai[]"]').val('');
                                $('input[name="tahapan_tanggal_akhir[]"]').val('');
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
