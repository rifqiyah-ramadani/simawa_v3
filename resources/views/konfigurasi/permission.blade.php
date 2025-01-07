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
                    <h3 class="mb-0">Konfigurasi - Permission</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Konfigurasi
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Permission
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
                                        <th>Permission Name</th>
                                        <th>Guard Name</th>
                                        <th>Navigation</th>
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
<div class="modal fade" id="permissionModal" tabindex="-1" aria-labelledby="permissionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="permissionModalLabel">Form Permission</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
               {{-- Start form --}}
                <div class="row">
                    <div class="col mb-3">
                        <label for="name" class="form-label">Permission Name:
                            <span style="color: red;">*</span>
                        </label>
                        <input type="text" class="form-control" id="name" placeholder="Enter Permission Name" name="name" required>
                    </div>
                    <div class="col mb-3">
                        <label for="guard_name" class="form-label">Guard Name:
                            <span style="color: red;">*</span>
                        </label>
                        <input type="text" class="form-control" id="guard_name" placeholder="Enter Guard Name" name="guard_name">
                    </div> 
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="navigation_id" class="form-label">Navigation:
                            <span style="color: red;">*</span>
                        </label>
                        <select id="navigation_id" name="navigation_id" class="form-control">
                            <option value="">-- Pilih Navigation --</option>
                            @foreach($navigations as $navigation)
                                <option value="{{ $navigation->id }}">{{ $navigation->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
               {{-- End form --}}
        </div>

        {{-- Modal footer --}}
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

    {{-- Script DataTables --}}
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('permission.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'guard_name', name: 'guard_name' },
                    { data: 'navigation_name', name: 'navigation_name' },
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
        
        // Proses tambah dan simpan data
        $('body').on('click', '.tombol-tambah', function (e) {
            e.preventDefault();
            $('#permissionModal').modal('show');
            $('.tombol-simpan').off('click').on('click', function () {
                simpan();
            });
        });

        // Proses edit data
        $('body').on('click', '.tombol-edit', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url: 'permission/' + id + '/edit',
                type: 'GET',
                success: function (response) {
                    $('#permissionModal').modal('show');
                    $('#name').val(response.permission.name);
                    $('#guard_name').val(response.permission.guard_name);
                    $('#navigation_id').val(response.permission.navigation_id);
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
                        url: 'permission/' + id,
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

        // Fungsi simpan data
        function simpan(id = '') {
            var var_url = id ? 'permission/' + id : 'permission';
            var var_type = id ? 'PUT' : 'POST';

            // Reset pesan kesalahan sebelumnya
            $('.text-danger').remove();
            $('.is-invalid').removeClass('is-invalid');

            $.ajax({
                url: var_url,
                type: var_type,
                data: {
                    name: $('#name').val(),
                    guard_name: $('#guard_name').val(),
                    navigation_id: $('#navigation_id').val(),
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

                        $('#permissionModal').modal('hide');
                        $('#myTable').DataTable().ajax.reload();
                    }
                },
            });
        }

        $('#permissionModal').on('hidden.bs.modal', function () {
            $('#name').val('').removeClass('is-invalid');
            $('#guard_name').val('').removeClass('is-invalid');
            $('#navigation_id').val('').trigger('change');
            $('.text-danger').remove();
        });
    </script>
@endpush
