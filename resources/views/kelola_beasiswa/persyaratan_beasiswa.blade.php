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
                    <h3 class="mb-0">Kelola Beasiswa - Persyaratan Beasiswa</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Kelola Beasiswa
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Persyaratan Beasiswa
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
                                        <th>Nama Persyaratan</th>
                                        <th style="width: 100px">Keterangan Tambahan</th>
                                        <th>Kritera</th>
                                        <th>Operator</th>
                                        <th>Value</th>
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
                <h5 class="modal-title" id="exampleModalLabel">Form Persyaratan Beasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Start form --}}
                <div class="row">
                    <div class="col mb-3">
                        <label for="nama_persyaratan" class="form-label fw-bold">Nama Persyaratan:
                            <span style="color: red;">*</span>
                        </label>
                        <input type="text" class="form-control" id="nama_persyaratan" placeholder="Enter Nama Persyaratan" name="nama_persyaratan" required>
                    </div>
                    <div class="col mb-3">
                        <label for="keterangan" class="form-label fw-bold">Keterangan Tambahan:</label>
                        <input type="text" class="form-control" id="keterangan" placeholder="Enter Keterangan Tambahan" name="keterangan">
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="kriteria" class="form-label fw-bold">Kriteria:</label>
                        <input type="text" class="form-control" id="kriteria" placeholder="Masukkan Kriteria (mis. program_reguler, IPK, Umur)" name="kriteria" required>
                    </div>
                    <div class="col mb-3">
                        <label for="operator" class="form-label fw-bold">Operator:</label>
                        <select class="form-select" id="operator" name="operator" required>
                            <option value="">Pilih Operator</option>
                            <option value=">=">>= (Lebih dari atau sama dengan)</option>
                            <option value=">">> (Lebih dari)</option>
                            <option value="<">< (Kurang dari)</option>
                            <option value="<="><= (Kurang dari atau sama dengan)</option>
                            <option value="=">= (Sama dengan)</option>
                            <option value="!=">!= (Tidak sama dengan)</option>
                        </select>
                    </div>
                </div>
                <div class="col mb-3">
                    <label for="value" class="form-label fw-bold">Value:</label>
                    <input type="text" class="form-control" id="value" placeholder="Masukkan Nilai (mis. '3.00', 'S1', '23')" name="value" required>
                </div>
                {{-- End form --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary tombol-simpan">Simpan Data</button>
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
                    url: "{!! route('persyaratan_beasiswa.index') !!}",
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'nama_persyaratan', name: 'nama_persyaratan' },
                    { data: 'keterangan', name: 'keterangan' },
                    { data: 'kriteria', name: 'kriteria' },
                    { data: 'operator', name: 'operator' },
                    { data: 'value', name: 'value' },
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
                $('#exampleModalLabel').text('Tambah Persyaratan Beasiswa');

                // Reset form field
                $('#nama_persyaratan').val('');
                $('#keterangan').val('');
                $('#kriteria').val('');
                $('#operator').val('');
                $('#value').val('');
                $('.is-invalid').removeClass('is-invalid'); // Clear validation errors
                $('.text-danger').remove();
                
                // Event listener untuk tombol Simpan
                $('.tombol-simpan').off('click').on('click', function () {
                    simpanDanTutup(); // Simpan data dan tutup modal
                });
            });

            // Proses edit data
            $('body').on('click', '.tombol-edit', function (e) {
                e.preventDefault();
                var id = $(this).data('id');

                // Reset form field
                $('#nama_persyaratan').val('');
                $('#keterangan').val('');
                $('#kriteria').val('');
                $('#operator').val('');
                $('#value').val('');
                $('.is-invalid').removeClass('is-invalid'); // Clear validation errors
                $('.text-danger').remove();

                $.ajax({
                    url: 'persyaratan_beasiswa/' + id + '/edit',
                    type: 'GET',
                    success: function (response) {
                        $('#exampleModal').modal('show');
                        $('#exampleModalLabel').text('Edit Persyaratan Beasiswa');
                        $('#nama_persyaratan').val(response.result.nama_persyaratan);
                        $('#keterangan').val(response.result.keterangan);
                        $('#kriteria').val(response.result.kriteria);
                        $('#operator').val(response.result.operator);
                        $('#value').val(response.result.value);
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
                            url: 'persyaratan_beasiswa/' + id,
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

            function simpan(id = '', closeModal = true) {
                var var_url = id ? 'persyaratan_beasiswa/' + id : 'persyaratan_beasiswa';
                var var_type = id ? 'PUT' : 'POST';

                // Reset pesan kesalahan sebelumnya
                $('.text-danger').remove();
                $('.is-invalid').removeClass('is-invalid');

                $.ajax({
                    url: var_url,
                    type: var_type,
                    data: {
                        nama_persyaratan: $('#nama_persyaratan').val(),
                        keterangan: $('#keterangan').val(),
                        kriteria: $('#kriteria').val(),
                        operator: $('#operator').val(),
                        value: $('#value').val()
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
                                $('#nama_persyaratan').val('').removeClass('is-invalid');
                                $('#keterangan').val('').removeClass('is-invalid');
                                $('#kriteria').val('').removeClass('is-invalid');
                                $('#operator').val('').removeClass('is-invalid');
                                $('#value').val('').removeClass('is-invalid');
                                $('.text-danger').remove();
                            }
                        }
                    },
                });
            }
        });
    </script>
    
    
@endpush
