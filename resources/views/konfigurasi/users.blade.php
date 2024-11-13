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
                    <h3 class="mb-0">Konfigurasi - Users</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Konfigurasi
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Users
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
                                        <th>Username</th>
                                        <th>Nama User</th>
                                        <th>NIP</th>
                                        <th>UserType</th>
                                        <th>Role User</th>
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
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="userModalLabel">Form User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
               {{-- start form --}}
               {{-- field kolom username dan name --}}
                <div class="row">
                    <div class="col mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="username" placeholder="Enter Username" name="username" required>
                    </div>
                    <div class="col mb-3">
                        <label for="name" class="form-label">Nama User:</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter Nama" name="name" required>
                    </div> 
                </div>
                {{-- field kolom nip dan usertype --}}
                <div class="row">
                    <div class="col mb-3">
                        <label for="nip" class="form-label">NIP:</label>
                        <input type="text" class="form-control" id="nip" placeholder="Enter NIP" name="nip" required>
                    </div>
                    <div class="col mb-3">
                        <label for="usertype" class="form-label">UserType:</label>
                        <input type="text" class="form-control" id="usertype" placeholder="Enter UserType" name="usertype" required>
                    </div> 
                </div>

                {{-- field kolom password dan roles --}}
                <div class="row">
                    <div class="col mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password" required>
                    </div>
                    <div class="col mb-3">
                        <label for="roles" class="form-label">Roles:</label>
                        <select id="roles" name="roles[]" class="form-control" multiple="multiple" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div> 
                </div>
                {{-- end form --}}
        </div>

        {{-- modal footer --}}
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
   <!-- Select2 JS -->
   <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- script datatables --}}
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'username', name: 'username' },
                    { data: 'name', name: 'name' },
                    { data: 'nip', name: 'nip' },
                    { data: 'usertype', name: 'usertype' },
                    { data: 'roles', name: 'roles', orderable: false, searchable: false },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
                ]
            });
        });

        // GLOBAL SETUP
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $('#userModal').on('shown.bs.modal', function () {
            $('#roles').select2({
                placeholder: "Select roles",
                allowClear: true,
                width: '100%',
                theme: 'bootstrap-5'
            });
        });
        

        // Proses tambah dan simpan data
        $('body').on('click', '.tombol-tambah', function (e) {
            e.preventDefault();
            $('#userModal').modal('show');
            $('.tombol-simpan').off('click').on('click', function () {
                simpan();
            });
        });

        // Proses edit data
        $('body').on('click', '.tombol-edit', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url: 'users/' + id + '/edit',
                type: 'GET',
                success: function (response) {
                    $('#userModal').modal('show');
                    $('#username').val(response.user.username);
                    $('#name').val(response.user.name);
                    $('#nip').val(response.user.nip);
                    $('#usertype').val(response.user.usertype);
                    $('#roles').val(response.roles).trigger('change');
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
                        url: 'users/' + id,
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
                var var_url = id ? 'users/' + id : 'users';
                var var_type = id ? 'PUT' : 'POST';

                // Reset pesan kesalahan sebelumnya
                $('.text-danger').remove();
                $('.is-invalid').removeClass('is-invalid');

                $.ajax({
                    url: var_url,
                    type: var_type,
                    data: {
                        username: $('#username').val(),
                        name: $('#name').val(),
                        nip: $('#nip').val(),
                        usertype: $('#usertype').val(),
                        password: $('#password').val(),
                        roles: $('#roles').val(),
                    },
                    success: function(response) {
                        if (response.errors) {
                            $.each(response.errors, function(key, value) {
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

                            $('#userModal').modal('hide');
                            $('#myTable').DataTable().ajax.reload();
                        }
                    },
                });
            }

            $('#userModal').on('hidden.bs.modal', function () {
                $('#username').val('').removeClass('is-invalid');
                $('#name').val('').removeClass('is-invalid');
                $('#nip').val('').removeClass('is-invalid');
                $('#usertype').val('').removeClass('is-invalid');
                $('#password').val('').removeClass('is-invalid');
                $('#roles').val([]).trigger('change');
                $('.text-danger').remove();
            });

    </script>
    
    
@endpush
