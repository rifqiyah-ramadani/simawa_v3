@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        /* Style untuk tampilan tabel */
        #myTable {
            font-size: 1rem;
            color: #333;
            margin-top: 100px;
        }
        #myTable th {
            background-color: #FA812F;
            color: white;
            text-align: center;
        }
        #myTable td {
            padding: 3px;
            /* text-align: center; */
            border: 1px solid #f2f2f2;
        }

        /* Style untuk tombol */
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
                    <h3 class="mb-0">Kelola Beasiswa - Berkas Pendaftaran</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Kelola Beasiswa
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Berkas Pendaftaran
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
                            <a href="#" class="btn btn-outline-primary tombol-tambah"><i class="bi bi-plus"></i> Tambah Data</a>
                        </div> 
                        <!--end::card header-->

                        <!--begin::card body-->
                        <div class="card-body"> 
                            <table class="table table-bordered mb-3" id="myTable">
                                <thead>
                                    <tr>
                                        <th style="width: 20px">No</th>
                                        <th style="width: 300px">Nama Berkas</th>
                                        <th style="width: 300px">Keterangan Tambahan</th>
                                        <th style="width: 200px">Template Path</th>
                                        <th style="text-align: center">Aksi</th>
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
          <h5 class="modal-title" id="exampleModalLabel">Form Berkas Pendaftaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            {{-- Mulai form --}}
            <form id="formBerkas" enctype="multipart/form-data">
                 <div class="row">
                    <div class="col mb-3">
                        <label for="nama_file" class="form-label fw-bold">Nama Berkas:
                            <span style="color: red;">*</span>
                        </label>
                        <input type="text" class="form-control" id="nama_file"  placeholder="Enter Nama Berkas" name="nama_file" required>
                    </div>
                    <div class="col mb-3">
                        <label for="keterangan" class="form-label fw-bold">Keterangan Tambahan (Opsional):</label>
                        <input type="text" class="form-control" id="keterangan" placeholder="Enter Keterangan Tambahan" name="keterangan">
                    </div> 
                </div> 
                {{-- Input untuk template file --}}
                <div class="row">
                    <div class="col mb-3">
                        <label for="template_path" class="form-label fw-bold">Template File (Opsional):
                            <span style="color: gray; font-size: 12px;">Format: pdf, doc, dll.</span>
                        </label>
                        <input type="file" class="form-control" id="template_path" name="template_path" accept=".pdf,.doc,.docx">
                
                        <!-- Menambahkan elemen untuk menampilkan file yang sudah diupload -->
                        <div id="current-file-container" style="display: none;">
                            <p>File sebelumnya: <span id="current-file"></span></p>
                        </div>
                    </div>
                </div>
            </form>
            {{-- Selesai form --}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary tombol-simpan">
            <i class="bi bi-save me-1"></i>Simpan Data</button>
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
    
    {{-- script datatables --}}
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{!! route('berkas_pendaftaran.index') !!}",
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'nama_file', name: 'nama_file' },
                    { data: 'keterangan', name: 'keterangan' },
                    {
                        data: 'template_path_url',
                        name: 'template_path',
                        render: function(data, type, row) {
                            if (data) {
                                // Ikon berdasarkan ekstensi
                                let fileExtension = data.split('.').pop().toLowerCase();
                                let icon;

                                switch (fileExtension) {
                                    case 'jpg': case 'jpeg': case 'png': case 'gif':
                                        icon = '<i class="fas fa-file-image text-success" style="font-size: 50px;"></i>';
                                        break;
                                    case 'pdf':
                                        icon = '<i class="fas fa-file-pdf text-danger" style="font-size: 50px;"></i>';
                                        break;
                                    case 'doc': case 'docx':
                                        icon = '<i class="fas fa-file-word text-primary" style="font-size: 50px;"></i>';
                                        break;
                                    default:
                                        icon = '<i class="fas fa-file-alt text-secondary" style="font-size: 50px;"></i>';
                                }

                                // Tampilkan ikon dengan tautan
                                return `<a href="${data}" target="_blank" style="text-decoration: none; color: inherit;">${icon}</a>`;
                            }
                            return '<span class="text-muted">Tidak ada file</span>';
                        }
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `<div style="text-align: center; vertical-align: middle;">${data}</div>`;
                        }
                    }
                ]
                
            });

            // GLOBAL SETUP
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            // // Proses tambah dan simpan data
            $('body').on('click', '.tombol-tambah', function (e) {
                e.preventDefault();
                $('#exampleModal').modal('show');
                $('#exampleModalLabel').text('Tambah Berkas Pendaftaran');

                // Reset form ketika tombol Tambah Data diklik
                $('#nama_file').val('').removeClass('is-invalid');
                $('#keterangan').val('').removeClass('is-invalid');
                $('#template_path').val('').removeClass('is-invalid'); // Reset template_path
                $('.text-danger').remove(); // Bersihkan pesan kesalahan sebelumnya

                // Event listener untuk tombol Simpan
                $('.tombol-simpan').off('click').on('click', function () {
                    simpanDanTutup(); // Simpan data dan tutup modal
                });
            });

            // Proses edit data
            $('body').on('click', '.tombol-edit', function (e) {
                e.preventDefault();
                var id = $(this).data('id');

                $.ajax({
                    url: 'berkas_pendaftaran/' + id + '/edit',
                    type: 'GET',
                    success: function (response) {
                        console.log(response); // Cek respons dari server
                        $('#exampleModal').modal('show');
                        $('#exampleModalLabel').text('Edit Berkas Pendaftaran');

                        $('#nama_file').val(response.result.nama_file);
                        $('#keterangan').val(response.result.keterangan);

                        // Tampilkan file yang sudah di-upload sebelumnya
                        if (response.template_path_url) {
                            $('#current-file-container').show();
                            $('#current-file').html('<a href="' + response.template_path_url + '" target="_blank">' + response.result.template_path + '</a>');
                        } else {
                            $('#current-file-container').hide();
                        }

                        // Event listener untuk tombol Simpan
                        $('.tombol-simpan').off('click').on('click', function () {
                            simpanDanTutup(id); // Simpan data dan tutup modal
                        });
                    },
                    error: function (response) {
                        console.error(response);
                    }
                });
            });

            // // Proses delete data
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
                            url: 'berkas_pendaftaran/' + id,
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

            // // Reset form ketika modal ditutup
            $('#exampleModal').on('hidden.bs.modal', function () {
                $('#nama_file').val('').removeClass('is-invalid');
                $('#keterangan').val('').removeClass('is-invalid');
                $('#template_path').val('').removeClass('is-invalid');
                $('.text-danger').remove(); // Bersihkan pesan kesalahan sebelumnya
            });

            // Fungsi simpan dan update data
            function simpanDanTutup(id = '') {
                simpan(id, true); // Panggil simpan dengan closeModal = true
            }

            // Fungsi simpan dan update data
            function simpan(id = '', closeModal = true) {
                var var_url = id ? 'berkas_pendaftaran/' + id : 'berkas_pendaftaran';
                var var_type = id ? 'POST' : 'POST'; // POST digunakan dengan _method untuk PUT

                // Membuat FormData untuk file upload
                // menambahkan data ke dalam objek FormData
                // Form data digunakan untuk mengelola dan mengirim data dalam format multipart/form-data ke server, sering digunakan untuk upload file atau mengirim form melalui AJAX.
                var formData = new FormData();
                formData.append('nama_file', $('#nama_file').val());
                formData.append('keterangan', $('#keterangan').val());

                // Cek jika file diunggah, tambahkan ke formData
                if ($('#template_path')[0].files.length > 0) {
                    formData.append('template_path', $('#template_path')[0].files[0]);
                }

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

                
                $.ajax({
                    url: var_url,
                    type: var_type,
                    data: formData,
                    contentType: false, // Penting: jangan menetapkan tipe konten
                    processData: false, // Penting: jangan memproses data menjadi query string
                    success: function (response) {
                        if (response.errors) {
                            $.each(response.errors, function (key, value) {
                                $('#' + key)
                                    .addClass('is-invalid')
                                    .after('<span class="text-danger" style="font-style: italic; font-size: 12px;">' + value[0] + '</span>');
                            });
                        } else {
                            iziToast.success({
                                title: 'Success',
                                message: response.success,
                                position: 'topRight'
                            });

                            $('#myTable').DataTable().ajax.reload();
                            if (closeModal) {
                                $('#exampleModal').modal('hide');
                            }
                        }
                    },
                    error: function (response) {
                        console.error(response);
                    }
                });
            }

        });
    </script>
    
    
@endpush
