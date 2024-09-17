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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Form Buat Pendaftaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                {{-- start form --}}
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
                            @foreach($berkas as $item)
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
                </div> {{-- end form --}}   
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary tombol-simpan">Simpan Data</button>
          {{-- <button type="button" class="btn btn-warning tombol-simpan-lainnya">Simpan & Tambah Lainnya</button> --}}
        </div>
      </div>
    </div>
</div>
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
                    url: "{!! route('buat_pendaftaran_beasiswa.index') !!}",
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
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

                // Tampilkan modal
                $('#exampleModal').modal('show');

                // Tampilkan tombol simpan
                $('.tombol-simpan').show();

                // Proses simpan data baru
                $('.tombol-simpan').off('click').on('click', function () {
                    simpan(); // Fungsi simpan untuk create
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
                $('.add-role').show(); // Tampilkan tombol tambah role
            }

            // Saat tombol detail diklik
            $('body').on('click', '.tombol-detail', function (e) {
                e.preventDefault();
                var id = $(this).data('id');

                // Lakukan AJAX request untuk mendapatkan detail data
                $.ajax({
                    url: 'buat_pendaftaran_beasiswa/' + id,
                    type: 'GET',
                    success: function (response) {
                        $('#exampleModal').modal('show'); // Tampilkan modal yang sama
                        $('#exampleModalLabel').text('Detail Pendaftaran Beasiswa'); // Ubah judul modal
                        disableForm(); // Nonaktifkan form
                        
                        // Isi form dengan data dari response
                        $('#daftar_beasiswas_id').val(response.result.daftar_beasiswas_id);
                        $('#tahun').val(response.result.tahun);
                        $('#tanggal_mulai').val(response.result.tanggal_mulai);
                        $('#tanggal_berakhir').val(response.result.tanggal_berakhir);
                        $('#status').val(response.result.status);
                        $('#persyaratan').val(response.persyaratan).trigger('change');
                        $('#berkas').val(response.berkas).trigger('change');
                        
                        // Kosongkan role-validasi-container dan isi ulang
                        $('#role-validasi-container').empty();
                        $.each(response.roles, function (index, role) {
                            $('#role-validasi-container').append(`
                                <div class="row mb-2">
                                    <div class="col">
                                        <select class="form-control" name="roles[]" disabled>
                                            <option value="">Pilih Role</option>
                                            @foreach($roles as $roleOption)
                                                <option value="{{ $roleOption->id }}" ${role.role_id == {{ $roleOption->id }} ? 'selected' : ''}>{{ $roleOption->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control" name="urutan[]" value="${role.urutan}" placeholder="Urutan Validasi" disabled>
                                    </div>
                                </div>
                            `);
                        });

                        // Sembunyikan tombol simpan
                        $('.tombol-simpan').hide();
                    }
                });
            });

            // Proses edit data pendaftaran beasiswa
            $('body').on('click', '.tombol-edit', function (e) {
                e.preventDefault();
                enableForm(); // Aktifkan kembali form
                var id = $(this).data('id');
                $.ajax({
                    url: 'buat_pendaftaran_beasiswa/' + id + '/edit',
                    type: 'GET',
                    success: function (response) {
                        $('#exampleModal').modal('show');
                        $('#exampleModalLabel').text('Edit Pendaftaran Beasiswa');
                        $('#daftar_beasiswas_id').val(response.result.daftar_beasiswas_id);
                        $('#tahun').val(response.result.tahun);
                        $('#tanggal_mulai').val(response.result.tanggal_mulai);
                        $('#tanggal_berakhir').val(response.result.tanggal_berakhir);
                        $('#status').val(response.result.status);

                        // Isi ulang persyaratan
                        $('#persyaratan').val(response.persyaratan).trigger('change');

                        // Isi ulang berkas
                        $('#berkas').val(response.berkas).trigger('change');

                        // Kosongkan role-validasi-container dan isi ulang dengan role & urutan
                        $('#role-validasi-container').empty();
                        $.each(response.roles, function (index, role) {
                            $('#role-validasi-container').append(`
                                <div class="row mb-2">
                                    <div class="col">
                                        <select class="form-control" name="roles[]">
                                            <option value="">Pilih Role</option>
                                            @foreach($roles as $roleOption)
                                                <option value="{{ $roleOption->id }}" ${role.role_id == {{ $roleOption->id }} ? 'selected' : ''}>{{ $roleOption->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control" name="urutan[]" value="${role.urutan}" placeholder="Urutan Validasi">
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-danger remove-role">-</button>
                                    </div>
                                </div>
                            `);
                        });

                        // Tampilkan tombol simpan
                        $('.tombol-simpan').show();

                        $('.tombol-simpan').off('click').on('click', function () {
                            simpan(id);
                        });
                    }
                });
            });

            // Proses delete data
            $('body').on('click', '.tombol-delete', function (e) {
                e.preventDefault();
                var id = $(this).data('id');

                // Tampilkan SweetAlert2 untuk konfirmasi
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
                            url: 'buat_pendaftaran_beasiswa/' + id,
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

            // Fungsi untuk simpan dan update data
            function simpan(id = '', closeModal = true) {
                var var_url = id ? 'buat_pendaftaran_beasiswa/' + id : 'buat_pendaftaran_beasiswa';
                var var_type = id ? 'PUT' : 'POST';

                // Reset pesan kesalahan sebelumnya
                $('.text-danger').remove();
                $('.is-invalid').removeClass('is-invalid');

                // Debugging untuk melihat nilai roles yang diambil dari form
                var selectedRoles = $('#roles').val();
                console.log("Selected Roles:", selectedRoles);

                $.ajax({
                    url: var_url,
                    type: var_type,
                    data: {
                        daftar_beasiswas_id: $('#daftar_beasiswas_id').val(),
                        tahun: $('#tahun').val(),
                        tanggal_mulai: $('#tanggal_mulai').val(),
                        tanggal_berakhir: $('#tanggal_berakhir').val(),
                        status: $('#status').val(),
                        persyaratan: $('#persyaratan').val() || [], // Array of selected persyaratan
                        berkas: $('#berkas').val() || [], // Array of selected berkas
                        roles: $('select[name="roles[]"]').map(function() { return $(this).val(); }).get(), // Array of selected roles
                        urutan: $('input[name="urutan[]"]').map(function() { return $(this).val(); }).get(), // Array of urutan for roles
                    },
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
                            }
                        }
                    },
                });
            }
        });
    </script>
    
    
    
    
@endpush
