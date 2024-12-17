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
    <!--begin::App Content Header-->
    <div class="app-content-header"> 
        <!--begin::Container-->
        <div class="container-fluid"> 
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Konfigurasi - Role</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Konfigurasi
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Roles
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
                                        <th>Role User</th>
                                        <th>Guard Name</th>
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
          <h5 class="modal-title" id="exampleModalLabel">Form Role User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                {{-- start form --}}
                <div class="row">
                    <div class="col mb-3">
                        <label for="role" class="form-label fw-bold">Role User:
                            <span style="color: red;">*</span>
                        </label>
                        <input type="role" class="form-control" id="name" placeholder="Enter Role User" name="name" required>
                    </div>
                </div> {{-- end form --}}   
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary tombol-simpan"><i class="bi bi-save me-1"></i>Simpan Data</button>
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
                    url: "{!! route('role.index') !!}",
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'guard_name', name: 'guard_name' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false}
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
            $('.tombol-simpan').off('click').on('click', function () {
                simpan();
            });
        });

        // Proses edit data
        $('body').on('click', '.tombol-edit', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url: 'role/' + id + '/edit',
                type: 'GET',
                success: function (response) {
                    $('#exampleModal').modal('show');
                    $('#name').val(response.result.name);
                    // $('#guard_name').val(response.result.guard_name);
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
                        url: 'role/' + id,
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
            var var_url = id ? 'role/' + id : 'role';
            var var_type = id ? 'PUT' : 'POST';

            // Reset pesan kesalahan sebelumnya
            $('.text-danger').remove();
            $('.is-invalid').removeClass('is-invalid');

            $.ajax({
                url: var_url,
                type: var_type,
                data: {
                    name: $('#name').val(),
                    // guard_name: $('#guard_name').val()
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
            // $('#guard_name').val('').removeClass('is-invalid');
            $('.text-danger').remove(); // Bersihkan pesan kesalahan saat modal ditutup
        });

    </script>
    
    
@endpush
