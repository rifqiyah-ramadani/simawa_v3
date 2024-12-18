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
                    <h3 class="mb-0">Master Informasi - Berita</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Master informasi
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Berita
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
                            <a href="#" class="btn btn-outline-primary tombol-tambah" data-bs-toggle="modal" data-bs-target="#exampleModal">
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
                                        <th>Konten</th>
                                        <th>Tanggal Publikasi</th>
                                        <th style="width: 100px">Gambar</th>
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
                <input type="hidden" name="kategori_informasi" value="berita">
            </div>
            <div class="row">
                <div class="mb-3">
                    <label for="judul" class="form-label fw-bold">Judul
                        <span style="color: red;">*</span>
                    </label>
                    <input type="text" class="form-control" id="judul" name="judul" placeholder="Enter Judul Berita" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label fw-bold">Konten
                        <span style="color: red;">*</span>
                    </label>
                    <textarea class="form-control" id="content" name="content" rows="4" placeholder="Enter Konten Berita" required></textarea>
                </div>
            </div>
            <div class="row">
                <div class="mb-3">
                    <label for="image" class="form-label fw-bold">Gambar
                    </label>
                    <input type="file" class="form-control" id="image" name="image">
                    <span style="color: gray; font-size: 14px;">Format gambar: jpeg, png, jpg, gif.</span>
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
                    url: "{!! route('berita.index') !!}",
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'kategori_informasi', name: 'kategori_informasi' },
                    { data: 'judul', name: 'judul' },
                    { 
                        data: 'content', 
                        name: 'content',
                        render: function(data, type, row) {
                            if (data.length > 50) {
                                return `<span title="${data}">${data.substr(0, 50)}...</span>`;
                            }
                            return data;
                        }
                    },
                    { data: 'publish_date', name: 'publish_date' },
                    {
                        data: 'image',
                        name: 'image',
                        render: function(data, type, row) {
                            if (data) {
                                // Menggunakan asset() dengan asumsi 'data' adalah path yang disimpan
                                let url = '{{ asset('storage') }}/' + data;
                                return `<img src="${url}" alt="Gambar" style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">`;
                            }
                            return '<span class="text-muted">Tidak ada gambar</span>';
                        }
                    },
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
            $('#content').val('');
            $('#image').val('');

            // Hapus elemen kecil untuk file sebelumnya jika ada
            $('#image').next('small').remove(); 
            
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
            $('#judul').val('');
            $('#content').val('');
            $('#image').val('');
            $('.is-invalid').removeClass('is-invalid'); // Bersihkan kelas validasi
            $('.text-danger').remove(); // Hapus pesan kesalahan sebelumnya

            // Ambil data berita berdasarkan ID
            $.ajax({
                url: '/master_informasi/berita/' + id + '/edit',
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    $('#exampleModal').modal('show');
                    $('#exampleModalLabel').text('Edit Berita');
                    
                    // Isi form dengan data yang diambil
                    $('#judul').val(response.informasi.judul);
                    $('#content').val(response.informasi.content);

                    // Tampilkan tautan gambar lama (jika ada)
                    $('#image').next('small').remove(); // Hapus informasi file lama sebelumnya
                    if (response.informasi.image) {
                        let url = '{{ asset('storage') }}/' + response.informasi.image;
                        $('#image').after(`
                            <small>
                                File sebelumnya: 
                                <a href="${url}" target="_blank" class="text-primary">
                                    ${response.informasi.image}
                                </a>
                            </small>
                        `);
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
                        url: '/master_informasi/berita/' + id, // Adjust this to include the "kategori" segment
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
            var var_url = id ? '/master_informasi/berita/' + id : '/master_informasi/berita/store';
            var var_type = id ? 'POST' : 'POST'; 

            var formData = new FormData();
            formData.append('judul', $('#judul').val());
            formData.append('content', $('#content').val());

            if ($('#image')[0].files[0]) {
                formData.append('image', $('#image')[0].files[0]);
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
                            $('#content').val('').removeClass('is-invalid');
                            $('#image').val('').removeClass('is-invalid');
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
        //     var var_url = id ? '/master_data/berita/' + id : '/master_data/berita/store';
        //     var var_type = id ? 'PUT' : 'POST';

        //     var formData = new FormData();
        //     formData.append('judul', $('#judul').val());
        //     formData.append('content', $('#content').val());
        //     if ($('#image')[0].files[0]) {
        //         formData.append('image', $('#image')[0].files[0]);
        //     }

        //     if (id) {
        //         formData.append('_method', 'PUT'); // Tambahkan ini untuk update
        //     }
        //     console.log('Form Data:', $('#judul').val(), $('#content').val(), $('#image')[0].files[0]);
        //     console.log('Selected File:', $('#image')[0].files[0]);

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
        //                     $('#content').val('').removeClass('is-invalid');
        //                     $('#image').val('').removeClass('is-invalid');
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
