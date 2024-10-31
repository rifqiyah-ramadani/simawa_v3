@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
    <!-- Bootstrap Toggle CSS -->
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

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
                    <h3 class="mb-0">Konfigurasi - Akses Role</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Konfigurasi
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Akses Role
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
                <h5 class="modal-title" id="exampleModalLabel">Akses Role: <span id="role-name"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th>Create</th>
                            <th>Read</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="permissions-container">
                        <!-- Konten permissions akan diisi di sini -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary tombol-simpan">Save changes</button>
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
    <!-- Bootstrap Toggle JS -->
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{!! route('akses_role.index') !!}",
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

        $('body').on('click', '.tombol-edit', function (e) {
            e.preventDefault();
            var id = $(this).data('id');

            // Panggil data permission melalui AJAX
            $.ajax({
                url: 'akses_role/' + id + '/edit',
                type: 'GET',
                success: function (response) {
                    $('#exampleModal').modal('show');
                    $('#role-name').text(response.role.name); // Tampilkan nama role di modal

                    // Bersihkan container permissions sebelum mengisinya kembali
                    $('#permissions-container').empty();

                    // Loop melalui permissions dan buat toggle switches
                    $.each(response.permissionsGroupedByMenu, function(menu, actions) {
                        var rowHtml = '<tr>';
                        rowHtml += '<td>' + menu + '</td>'; // Nama menu

                        // Untuk setiap aksi (create, read, update, delete, approve)
                        var actionsList = ['create', 'read', 'update', 'delete'];
                        $.each(actionsList, function(index, action) {
                            var checked = actions.includes(action) ? 'checked' : '';
                            rowHtml += '<td>' +
                                '<input class="form-check-input toggle-switch" ' + checked + ' type="checkbox" id="' + menu + '-' + action + '" value="' + action + '" data-menu="' + menu + '" />' +
                            '</td>';
                        });

                        rowHtml += '</tr>';

                        // Tambahkan row ke table
                        $('#permissions-container').append(rowHtml);
                    });

                    // Simpan data ketika tombol-simpan di-klik
                    $('.tombol-simpan').off('click').on('click', function () {
                        simpan(id);
                    });
                }
            });
        });

        function simpan(id) {
            var permissionUpdates = {};

            // Loop melalui setiap baris tabel dan ambil permissions yang diaktifkan
            $('#permissions-container tr').each(function() {
                var menu = $(this).find('td:first').text(); // Nama menu
                
                // Ambil setiap aksi yang aktif (create, read, update, delete, approve)
                var actions = [];
                $(this).find('input[type="checkbox"]:checked').each(function() {
                    actions.push($(this).val());
                });

                // Simpan permission ke objek permissionUpdates
                permissionUpdates[menu] = actions;
            });

            // Kirim data ke server
            $.ajax({
                url: 'akses_role/' + id,
                type: 'PUT', // Atau POST jika create baru
                data: {
                    permissions: permissionUpdates,
                    _token: $('meta[name="csrf-token"]').attr('content') // Pastikan CSRF token disertakan
                },
                success: function (response) {
                    iziToast.success({
                        title: 'Success',
                        message: response.message,
                        position: 'topRight'
                    });
                    $('#exampleModal').modal('hide');
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    </script>
    {{-- script datatables --}}    
@endpush
