@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
    
    <style>
        /* Mengubah gaya baris tabel */


        /* Menambah padding dan border */
        #myTable td {
            padding: 5px;
            border: 1px solid #f2f2f2;
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
                    <h3 class="mb-0">Kelola Beasiswa - Daftar Beasiswa</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Kelola Beasiswa
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Daftar Beasiswa
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
                                        <th>Kode Beasiswa</th>
                                        <th>Nama Beasiswa</th>
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
          <h5 class="modal-title" id="exampleModalLabel">Form Daftar Beasiswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                {{-- start form --}}
                <div class="row">
                    <div class="col mb-3">
                        <label for="kode_beasiswa" class="form-label fw-bold">Kode Beasiswa:
                            <span style="color: red;">*</span>
                        </label>
                        <input type="kode_beasiswa" class="form-control" id="kode_beasiswa" placeholder="Enter Kode Beasiswa" name="kode_beasiswa" required>
                    </div>
                    <div class="col mb-3">
                        <label for="nama_beasiswa" class="form-label fw-bold">Nama Beasiswa:
                            <span style="color: red;">*</span>
                        </label>
                      <input type="nama_beasiswa" class="form-control" id="nama_beasiswa" placeholder="Enter Nama Beasiswa" name="nama_beasiswa" required>
                    </div> 
                </div> {{-- end form --}}   
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary tombol-simpan">Simpan Data</button>
          <button type="button" class="btn btn-warning tombol-simpan-lainnya">Simpan & Tambah Lainnya</button>
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
                    url: "{!! route('daftar_beasiswa.index') !!}",
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'kode_beasiswa', name: 'kode_beasiswa' },
                    { data: 'nama_beasiswa', name: 'nama_beasiswa' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false}
                ]
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
                $('#exampleModalLabel').text('Tambah Daftar Beasiswa');
                
                // Event listener untuk tombol Simpan
                $('.tombol-simpan').off('click').on('click', function () {
                    simpanDanTutup(); // Simpan data dan tutup modal
                });

                // Event listener untuk tombol Simpan & Tambah Lainnya
                $('.tombol-simpan-lainnya').off('click').on('click', function () {
                    simpanDanTambahLainnya(); // Simpan data dan tetap di modal
                });
            });


            // Proses edit data
            $('body').on('click', '.tombol-edit', function (e) {
                e.preventDefault();
                var id = $(this).data('id');

                // Sembunyikan tombol "Simpan & Tambah Lainnya"
                $('.tombol-simpan-lainnya').hide();

                $.ajax({
                    url: 'daftar_beasiswa/' + id + '/edit',
                    type: 'GET',
                    success: function (response) {
                        $('#exampleModal').modal('show');
                        $('#exampleModalLabel').text('Edit Daftar Beasiswa');
                        $('#kode_beasiswa').val(response.result.kode_beasiswa);
                        $('#nama_beasiswa').val(response.result.nama_beasiswa);
                        $('.tombol-simpan').off('click').on('click', function () {
                            simpanDanTutup(id); // Simpan data dan tutup modal
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
                            url: 'daftar_beasiswa/' + id,
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

            // Fungsi simpan dan update data
            function simpanDanTutup(id = '') {
                simpan(id, true); // Panggil simpan dengan closeModal = true
            }

            function simpanDanTambahLainnya(id = '') {
                simpan(id, false); // Panggil simpan dengan closeModal = false
            }

            function simpan(id = '', closeModal = true) {
                var var_url = id ? 'daftar_beasiswa/' + id : 'daftar_beasiswa';
                var var_type = id ? 'PUT' : 'POST';

                // Reset pesan kesalahan sebelumnya
                $('.text-danger').remove();
                $('.is-invalid').removeClass('is-invalid');

                $.ajax({
                    url: var_url,
                    type: var_type,
                    data: {
                        kode_beasiswa: $('#kode_beasiswa').val(),
                        nama_beasiswa: $('#nama_beasiswa').val()
                    },
                    success: function(response) {
                        if (response.errors) {
                            // Jika ada kesalahan, tampilkan pesan kesalahan di bawah input yang sesuai
                            $.each(response.errors, function(key, value) {
                                $('#' + key)
                                .addClass('is-invalid')  // Tambahkan kelas is-invalid ke input yang bermasalah
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
                                $('#kode_beasiswa').val('').removeClass('is-invalid');
                                $('#nama_beasiswa').val('').removeClass('is-invalid');
                                $('.text-danger').remove();
                            }
                        }
                    },
                });
            }
        });
    </script>  
    
@endpush
