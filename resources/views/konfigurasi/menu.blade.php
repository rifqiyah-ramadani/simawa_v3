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
    <!--begin::App Content Header-->
    <div class="app-content-header"> 
        <!--begin::Container-->
        <div class="container-fluid"> 
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Konfigurasi - Menu</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Konfigurasi
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Menu
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
                            <a href="#" class="btn text-dark tombol-tambah"><i class="bi bi-plus"></i> Tambah Data</a>
                        </div> 
                        <!--end::card header-->

                        <!--begin::card body-->
                        <div class="card-body"> 
                            <table class="table table-bordered mb-3" id="myTable">
                                <thead>
                                    <tr>
                                        <th style="width: 20px">No</th>
                                        <th>Nama Menu</th>
                                        <th>URL</th>
                                        <th>Icon</th>
                                        <th>Main Menu</th>
                                        <th>Sort</th>
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
          <h5 class="modal-title" id="exampleModalLabel">Form Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                {{-- start form --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="url" class="form-label">URL</label>
                        <input type="text" class="form-control" id="url" name="url" required>
                    </div>
                    <div class="col mb-3">
                        <label for="icon" class="form-label">Icon</label>
                        <input type="text" class="form-control" id="icon" name="icon">
                    </div>
                </div> 
                <div class="row">
                    <div class="mb-3">
                        <label for="main_menu" class="form-label">Main Menu</label>
                        <select class="form-control" id="main_menu" name="main_menu">
                            <option value="">Select Main Menu</option>
                            @foreach($mainMenus as $menu)
                                <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col mb-3">
                        <label for="sort" class="form-label">Sort Order</label>
                        <input type="number" class="form-control" id="sort" name="sort">
                    </div>
                </div> 
                {{-- end form --}}   
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary tombol-simpan"><i class="bi bi-save me-1"></i>Simpan Data</button>
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
                    url: "{{ route('menu.index') }}",
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'url', name: 'url' },
                    { data: 'icon', name: 'icon' },
                    { data: 'main_menu', name: 'main_menu' },
                    { data: 'sort', name: 'sort' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false}
                ]
            });

            // GLOBAL SETUP
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            // Add Navigation
            // Proses tambah dan simpan data
            $('body').on('click', '.tombol-tambah', function (e) {
                e.preventDefault();
                $('#exampleModal').modal('show');
                $('.tombol-simpan').off('click').on('click', function () {
                    simpan();
                });
            });

            // Proses edit data
            $('body').on('click', '.tombol-edit', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    url: 'menu/' + id + '/edit',
                    type: 'GET',
                    success: function (response) {
                        $('#exampleModal').modal('show');
                        $('#name').val(response.result.name);
                        $('#url').val(response.result.url);
                        $('#icon').val(response.result.icon);
                        // Kosongkan dropdown Main Menu, lalu isi ulang dengan data yang ada
                        $('#main_menu').empty().append('<option value="">Select Main Menu</option>');
                        $.each(response.mainMenus, function (index, menu) {
                            $('#main_menu').append('<option value="' + menu.id + '">' + menu.name + '</option>');
                        });
                        $('#main_menu').val(response.result.main_menu);
                        $('#sort').val(response.result.sort);
                        $('.tombol-simpan').off('click').on('click', function () {
                            simpan(id);
                        });
                    }
                });
            });

            // Delete Button
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
                            url: 'menu/' + id,
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
            function simpan(id = '') {
                var var_url = id ? 'menu/' + id : 'menu';
                var var_type = id ? 'PUT' : 'POST';

                // Reset pesan kesalahan sebelumnya
                $('.text-danger').remove();
                $('.is-invalid').removeClass('is-invalid');

                $.ajax({
                        url: var_url,
                        type: var_type,
                        data: {
                            name: $('#name').val(),
                            url: $('#url').val(),
                            icon: $('#icon').val(),
                            main_menu: $('#main_menu').val(),
                            sort: $('#sort').val()
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

                                $('#exampleModal').modal('hide');
                                $('#myTable').DataTable().ajax.reload();
                            }
                        },
                });
            }

            $('#exampleModal').on('hidden.bs.modal', function () {
                    $('#name').val('').removeClass('is-invalid');
                    $('#url').val('').removeClass('is-invalid');
                    $('#icon').val('').removeClass('is-invalid');
                    $('#main_menu').val('').removeClass('is-invalid');
                    $('#sort').val('').removeClass('is-invalid');
                    $('.text-danger').remove(); // Bersihkan pesan kesalahan saat modal ditutup
            });
        });
    </script>
    
    
@endpush