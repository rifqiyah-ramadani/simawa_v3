@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
                    <h3 class="mb-0">Kelola Beasiswa - Data Penerima</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Kelola Beasiswa
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Data Penerima
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
                        <div class="card-header justify-content-between">
                            <button class="btn btn-outline-primary tombol-export"><i class="fa fa-file-export me-2"></i> Export Data</button>
                            {{-- <button class="btn btn-outline-success tombol-import"><i class="fa fa-file-import me-2"></i> Import Data</button> --}}
                        </div>
                        <div class="card-body"> 
                            <table class="table table-bordered mb-3" id="myTable">
                                <thead>
                                    <tr>
                                        <th style="width: 20px">No</th>
                                        <th>Beasiswa</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>NIM</th>
                                        <th>Fakultas</th>
                                        <th>Prodi</th>
                                        <th>Semester Terima</th>
                                        <th>No. Handphone</th>
                                        <th>Mulai Berlaku Beasiswa</th>
                                        <th>Akhir Berlaku Beasiswa</th>
                                        <th>Status Penerima</th>
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

    <!-- Modal Form -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="editForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Data Penerima</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="dataId" name="id">
                        <!-- Field dari Pendaftaran Beasiswa (Disabled) -->
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nama_mahasiswa" class="form-label fw-bold">Nama Mahasiswa</label>
                                <input type="text" id="nama_mahasiswa" class="form-control" disabled>
                            </div>
                            <div class="col mb-3">
                                <label for="nim" class="form-label fw-bold">NIM</label>
                                <input type="text" id="nim" class="form-control" disabled>
                            </div> 
                        </div>

                        <div class="col mb-3">
                            <label for="fakultas" class="form-label fw-bold">Fakultas</label>
                            <input type="text" id="fakultas" class="form-control" disabled>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="jurusan" class="form-label fw-bold">Prodi</label>
                                <input type="text" id="jurusan" class="form-control" disabled>
                            </div>
                            <div class="col mb-3">
                                <label for="nama_beasiswa" class="form-label fw-bold">Beasiswa</label>
                                <input type="text" id="nama_beasiswa" class="form-control" disabled>
                            </div> 
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="semester" class="form-label fw-bold">Semester Terima</label>
                                <input type="text" id="semester" class="form-control" disabled>
                            </div>
                            <div class="col mb-3">
                                <label for="telepon" class="form-label fw-bold">No. Handphone</label>
                                <input type="text" id="telepon" class="form-control" disabled>
                            </div> 
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="mulai_berlaku" class="form-label fw-bold">Mulai Berlaku Beasiswa</label>
                                <input type="text" id="mulai_berlaku" class="form-control" disabled>
                            </div>
                            <div class="col mb-3">
                                <label for="akhir_berlaku" class="form-label fw-bold">Akhir Berlaku Beasiswa</label>
                                <input type="text" id="akhir_berlaku" class="form-control" disabled>
                            </div> 
                        </div>

                        <div class="form-group mb-3">
                            <label for="file_uploads" class="form-label fw-bold">File Bukti</label>
                            <div class="list-group" id="file_uploads">
                                <!-- Data file akan diisi dengan JavaScript -->
                            </div>
                        </div>
                        
                        <!-- Field Editable -->
                        <div class="row">
                            <div class="col mb-3">
                                <label for="biaya_hidup" class="form-label fw-bold">Biaya Hidup</label>
                                <input type="number" step="0.01" name="biaya_hidup" id="biaya_hidup" class="form-control">
                            </div>
                            <div class="col mb-3">
                                <label for="biaya_ukt" class="form-label fw-bold">Biaya UKT</label>
                                <input type="number" step="0.01" name="biaya_ukt" id="biaya_ukt" class="form-control">
                            </div> 
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="start_semester" class="form-label fw-bold">Start Semester</label>
                                <input type="text" name="start_semester" id="start_semester" class="form-control">
                            </div>
                            <div class="col mb-3">
                                <label for="end_semester" class="form-label fw-bold">End Semester</label>
                                <input type="text" name="end_semester" id="end_semester" class="form-control">
                            </div> 
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary tombol-close" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary tombol-simpan">
                            <i class="bi bi-save me-1"></i>Simpan Data</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main> 

@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{!! route('penerima_beasiswa.index') !!}",
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'nama_beasiswa', name: 'nama_beasiswa' },
                    { data: 'nama_lengkap', name: 'nama_lengkap' },
                    { data: 'nim', name: 'nim' },
                    { data: 'fakultas', name: 'fakultas' },
                    { data: 'jurusan', name: 'jurusan' },
                    { data: 'semester', name: 'semester' },
                    { data: 'telepon', name: 'telepon' },
                    { data: 'mulai_berlaku', name: 'mulai_berlaku' },
                    { data: 'akhir_berlaku', name: 'akhir_berlaku' },
                    { data: 'status_penerima', name: 'status_penerima' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
                ]
            });

            // GLOBAL SETUP
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            // Tombol Export
            $('.tombol-export').on('click', function(e) {
                e.preventDefault();
                window.location.href = "{{ route('data_penerima.export') }}";
            });

            // Tombol Edit
            $('#myTable').on('click', '.tombol-edit', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                $.get("{{ url('kelola_beasiswa/penerima_beasiswa') }}/" + id + "/edit", function(data) {
                    // Isi form dengan data yang diambil
                    $('#dataId').val(data.id);
                    $('#nama_mahasiswa').val(data.pendaftaran_beasiswa.nama_lengkap).attr('disabled', true);
                    $('#nim').val(data.pendaftaran_beasiswa.nim).attr('disabled', true);
                    $('#fakultas').val(data.pendaftaran_beasiswa.fakultas).attr('disabled', true);
                    $('#jurusan').val(data.pendaftaran_beasiswa.jurusan).attr('disabled', true);
                    $('#semester').val(data.pendaftaran_beasiswa.semester).attr('disabled', true);
                    $('#telepon').val(data.pendaftaran_beasiswa.telepon).attr('disabled', true);
                    $('#nama_beasiswa').val(data.pendaftaran_beasiswa.buat_pendaftaran_beasiswa.beasiswa.nama_beasiswa).attr('disabled', true);
                    $('#mulai_berlaku').val(data.pendaftaran_beasiswa.buat_pendaftaran_beasiswa.mulai_berlaku).attr('disabled', true);
                    $('#akhir_berlaku').val(data.pendaftaran_beasiswa.buat_pendaftaran_beasiswa.akhir_berlaku).attr('disabled', true);
                    $('#biaya_hidup').val(data.pendaftaran_beasiswa.biaya_hidup).attr('disabled', true);
                    $('#biaya_ukt').val(data.pendaftaran_beasiswa.biaya_ukt).attr('disabled', true);

                    // Isi daftar file uploads
                    const fileUploads = data.pendaftaran_beasiswa.file_uploads || [];
                    const fileList = fileUploads.map(file => {
                        const fileName = file.berkas_pendaftaran?.nama_file || 'Tidak diketahui';
                        const filePath = file.file_path ? "{{ asset('storage') }}/" + file.file_path : '#';

                        // Template untuk setiap file
                        return `
                            <a href="${filePath}" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fa fa-file me-2 text-primary"></i> ${fileName}
                                </div>
                                <span class="badge bg-secondary">
                                    <i class="fa fa-download"></i> Download
                                </span>
                            </a>
                        `;
                    }).join('');

                    // Isi div file uploads
                    $('#file_uploads').html(fileList || `
                        <div class="list-group-item text-center text-muted">
                            Tidak ada file yang diunggah
                        </div>
                    `);

                    // Isi data edit
                    $('#start_semester').val(data.start_semester);
                    $('#end_semester').val(data.end_semester);
                    $('#status_penerima').val(data.status_penerima);

                    // Tampilkan modal
                    $('#editModal').modal('show');
                });
            });

            // Submit Form Edit
            $('#editForm').on('submit', function(e) {
                e.preventDefault();
                const id = $('#dataId').val();
                const formData = $(this).serialize();

                $.ajax({
                    url: "{{ url('kelola_beasiswa/penerima_beasiswa') }}/" + id, // Tambahkan prefix kelola_beasiswa
                    method: "PUT",
                    data: formData,
                    success: function(response) {
                        $('#editModal').modal('hide');
                        $('#myTable').DataTable().ajax.reload();
                        iziToast.success({
                            title: 'Sukses!',
                            message: response.message,
                            position: 'topRight'
                        });
                    },
                    error: function(xhr) {
                        iziToast.error({
                            title: 'Error!',
                            message: xhr.responseJSON.message,
                            position: 'topRight'
                        });
                    }
                });
            });

            $('#editModal').on('hidden.bs.modal', function() {
                // Kembalikan semua field ke kondisi editable
                $('#editForm input, #editForm select').attr('disabled', false);
                $('.tombol-simpan').show(); // Tampilkan tombol submit kembali
            });

            // Tombol Detail
            $('#myTable').on('click', '.tombol-detail', function(e) {
                e.preventDefault();
                const id = $(this).data('id');

                // AJAX Request untuk mendapatkan data detail
                $.get("{{ url('kelola_beasiswa/penerima_beasiswa') }}/" + id, function(data) {
                    // Isi form dengan data yang diambil
                    $('#dataId').val(data.id);
                    $('#nama_mahasiswa').val(data.pendaftaran_beasiswa.nama_lengkap).attr('disabled', true);
                    $('#nim').val(data.pendaftaran_beasiswa.nim).attr('disabled', true);
                    $('#fakultas').val(data.pendaftaran_beasiswa.fakultas).attr('disabled', true);
                    $('#jurusan').val(data.pendaftaran_beasiswa.jurusan).attr('disabled', true);
                    $('#semester').val(data.pendaftaran_beasiswa.semester).attr('disabled', true);
                    $('#telepon').val(data.pendaftaran_beasiswa.telepon).attr('disabled', true);
                    $('#nama_beasiswa').val(data.pendaftaran_beasiswa.buat_pendaftaran_beasiswa.beasiswa.nama_beasiswa).attr('disabled', true);
                    $('#mulai_berlaku').val(data.pendaftaran_beasiswa.buat_pendaftaran_beasiswa.mulai_berlaku).attr('disabled', true);
                    $('#akhir_berlaku').val(data.pendaftaran_beasiswa.buat_pendaftaran_beasiswa.akhir_berlaku).attr('disabled', true);
                    $('#biaya_hidup').val(data.pendaftaran_beasiswa.biaya_hidup).attr('disabled', true);
                    $('#biaya_ukt').val(data.pendaftaran_beasiswa.biaya_ukt).attr('disabled', true);

                    // Isi daftar file uploads
                    const fileUploads = data.pendaftaran_beasiswa.file_uploads || [];
                    const fileList = fileUploads.map(file => {
                        const fileName = file.berkas_pendaftaran?.nama_file || 'Tidak diketahui';
                        const filePath = file.file_path ? "{{ asset('storage') }}/" + file.file_path : '#';

                        // Template untuk setiap file
                        return `
                            <a href="${filePath}" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fa fa-file me-2 text-primary"></i> ${fileName}
                                </div>
                                <span class="badge bg-secondary">
                                    <i class="fa fa-download"></i> Download
                                </span>
                            </a>
                        `;
                    }).join('');

                    // Isi div file uploads
                    $('#file_uploads').html(fileList || `
                        <div class="list-group-item text-center text-muted">
                            Tidak ada file yang diunggah
                        </div>
                    `);

                    // Nonaktifkan field editable
                    $('#start_semester').val(data.start_semester).attr('disabled', true);
                    $('#end_semester').val(data.end_semester).attr('disabled', true);

                    // Sembunyikan tombol submit di footer
                    $('.tombol-simpan').hide();

                    // Tampilkan modal
                    $('#editModal').modal('show');
                });
            });
        });
    </script>
@endpush