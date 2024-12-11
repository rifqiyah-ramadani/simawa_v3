@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />

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
    <div class="app-content-header"> 
        <div class="container-fluid"> 
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Master Informasi - Pengumuman</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Master Informasi
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Pengumuman
                        </li>
                    </ol>
                </div>
            </div> 
        </div> 
    </div> 

    <div class="app-content"> 
        <div class="container-fluid"> 
            <div class="col-md-12"> 
                <form> 
                    <div class="card mb-4"> 
                        <div class="card-header">
                            <a href="#" class="btn text-dark tombol-tambah" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="bi bi-plus"></i> Tambah Data
                            </a>
                        </div> 
                        <div class="card-body"> 
                            <table class="table table-bordered mb-3" id="myTable">
                                <thead>
                                    <tr>
                                        <th style="width: 20px">No</th>
                                        <th style="width: 100px">Kategori Informasi</th>
                                        <th>Judul</th>
                                        <th>File</th>
                                        <th style="width: 100px">Tanggal Publikasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead> 
                            </table>
                        </div> 
                    </div>
                </form> 
            </div> 
        </div> 
    </div> 
</main> 

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Form Informasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="col mb-3">
                <input type="hidden" name="kategori_informasi" value="pengumuman">
            </div>
            <div class="row">
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul
                        <span style="color: red;">*</span>
                    </label>
                    <input type="text" id="judul" name="judul" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">File 
                        <span style="color: gray; font-size: 12px;">Format: pdf, doc, docx.</span>
                    </label>
                    <input type="file" class="form-control" id="file" name="file" required>

                    <!-- Menambahkan elemen untuk menampilkan file yang sudah diupload -->
                    <div id="current-file-container" style="display: none;">
                        <p>File sebelumnya: <span id="current-file"></span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary tombol-simpan">
            <i class="bi bi-save me-1"></i>Simpan Data</button>
        </div>
      </div>
    </div>
</div>
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
                    url: "{!! route('pengumuman.index') !!}",
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'kategori_informasi', name: 'kategori_informasi' },
                    { data: 'judul', name: 'judul' },
                    { 
                        data: 'file', 
                        name: 'file',
                        render: function(data, type, row) {
                            if (data) {
                                let url = '{{ asset('storage') }}/' + data; 
                                return `<a href="${url}" target="_blank" class="btn btn-link">Download File</a>`;
                            }
                            return '-'; // Jika file kosong
                        }
                    },
                    { data: 'publish_date', name: 'publish_date' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
                ]
            });
        });

        // GLOBAL SETUP
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        // Proses tambah dan simpan data
        $('body').on('click', '.tombol-tambah', function (e) {
            e.preventDefault();
            $('#exampleModal').modal('show');
            $('#exampleModalLabel').text('Tambah Data Berita');

            // Reset form field
            $('#judul').val('');
            $('#file').val('');
            // $('#publish_date').val('');
            $('.is-invalid').removeClass('is-invalid'); // Clear validation errors
            $('.text-danger').remove();
                    
            // Event listener untuk tombol Simpan
            $('.tombol-simpan').off('click').on('click', function () {
                simpanDanTutup(); // Simpan data dan tutup modal
            });
        });

        // Proses edit data berita
        $('body').on('click', '.tombol-edit', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            // Reset form dan pesan kesalahan sebelumnya
            $('.is-invalid').removeClass('is-invalid'); // Bersihkan kelas validasi
            $('.text-danger').remove(); // Hapus pesan kesalahan sebelumnya

            // Ambil data berita berdasarkan ID
            $.ajax({
                url: '/master_informasi/pengumuman/' + id + '/edit',
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    $('#exampleModal').modal('show');
                    $('#exampleModalLabel').text('Edit Berita');
                    
                    // Isi form dengan data yang diambil
                    $('#judul').val(response.informasi.judul);
                    // Tampilkan file yang sudah di-upload sebelumnya
                    if (response.informasi.file) {
                        $('#current-file-container').show();
                        $('#current-file').html('<a href="/storage/' + response.informasi.file + '" target="_blank">Lihat File</a>');
                    } else {
                        $('#current-file-container').hide();
                    }
                    
                    // Tambahkan event listener untuk tombol Simpan
                    $('.tombol-simpan').off('click').on('click', function() {
                        simpanDanTutup(id); // Simpan data dan tutup modal
                    });
                },
                error: function(xhr) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Terjadi kesalahan saat mengambil data',
                        position: 'topRight'
                    });
                    console.error(xhr.responseText);
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
                        url: '/master_informasi/pengumuman/' + id, // Adjust this to include the "kategori" segment
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
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

        // Fungsi simpan dan update data berita
        function simpanDanTutup(id = '') {
            simpan(id, true); // Panggil fungsi simpan dengan closeModal = true
        }

        function simpan(id = '', closeModal = true) {
            var var_url = id ? '/master_informasi/pengumuman/' + id : '/master_informasi/pengumuman/store';
            var var_type = id ? 'POST' : 'POST'; 

            var formData = new FormData();
            formData.append('judul', $('#judul').val());
            
            // File hanya ditambahkan jika ada file baru yang diunggah
            if ($('#file')[0].files.length > 0) {
                formData.append('file', $('#file')[0].files[0]);
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

            // Reset pesan kesalahan sebelumnya
            $('.text-danger').remove();
            $('.is-invalid').removeClass('is-invalid');

            $.ajax({
                url: var_url,
                type: var_type,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.errors) {
                        // Jika ada kesalahan, tampilkan pesan kesalahan di bawah input yang sesuai
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

                        $('#myTable').DataTable().ajax.reload();

                        if (closeModal) {
                            $('#exampleModal').modal('hide');
                        } else {
                            // Bersihkan form untuk input baru
                            $('#judul').val('').removeClass('is-invalid');
                            $('#file').val('').removeClass('is-invalid');
                            $('.text-danger').remove();
                        }
                    }
                },
                error: function(xhr) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Terjadi kesalahan saat menyimpan data',
                        position: 'topRight'
                    });
                    console.error(xhr.responseText);
                }
            });
        }

        // function simpan(id = '', closeModal = true) {
        //     var var_url = id ? '/master_data/pengumuman/' + id : '/master_data/pengumuman/store';
        //     var var_type = id ? 'PUT' : 'POST';

        //     var formData = new FormData();
        //     formData.append('judul', $('#judul').val());
        //     formData.append('content', $('#content').val());
        //     if ($('#file')[0].files.length > 0) {
        //         formData.append('file', $('#file')[0].files[0]);
        //     }

        //     if (id) {
        //         formData.append('_method', 'PUT'); // Tambahkan ini untuk update
        //     }

        //     // Reset pesan kesalahan sebelumnya
        //     $('.text-danger').remove();
        //     $('.is-invalid').removeClass('is-invalid');

        //     $.ajax({
        //         url: var_url,
        //         type: var_type,
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         headers: {
        //             'X-HTTP-Method-Override': var_type,
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         success: function(response) {
        //             if (response.errors) {
        //                 // Jika ada kesalahan, tampilkan pesan kesalahan di bawah input yang sesuai
        //                 $.each(response.errors, function(key, value) {
        //                     $('#' + key)
        //                         .addClass('is-invalid') // Tambahkan kelas is-invalid ke input yang bermasalah
        //                         .after('<span class="text-danger" style="font-style: italic; font-size: 12px;">' + value[0] + '</span>');
        //                 });
        //             } else {
        //                 iziToast.success({
        //                     title: 'Success',
        //                     message: response.success,
        //                     position: 'topRight'
        //                 });

        //                 $('#myTable').DataTable().ajax.reload();

        //                 if (closeModal) {
        //                     $('#exampleModal').modal('hide');
        //                 } else {
        //                     // Bersihkan form untuk input baru
        //                     $('#judul').val('').removeClass('is-invalid');
        //                     $('#file').val('').removeClass('is-invalid');
        //                     $('.text-danger').remove();
        //                 }
        //             }
        //         },
        //         error: function(xhr) {
        //             iziToast.error({
        //                 title: 'Error',
        //                 message: 'Terjadi kesalahan saat menyimpan data',
        //                 position: 'topRight'
        //             });
        //             console.error(xhr.responseText);
        //         }
        //     });
        // }
    </script>  
    
@endpush
