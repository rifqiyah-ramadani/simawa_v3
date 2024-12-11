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
            /* text-align: center; */
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
                        <div class="card-header justify-content-between">
                            <button class="btn btn-outline-primary tombol-tambah"><i class="bi bi-plus"></i> Tambah Persyaratan</button>
                            <button class="btn btn-outline-success tombol-tambah-kriteria"><i class="bi bi-plus"></i> Tambah Kriteria</button>
                        </div> 
                        <!--end::card header-->

                        <!--begin::card body-->
                        <div class="card-body"> 
                            <table class="table table-bordered mb-3" id="myTable">
                                <thead>
                                    <tr>
                                        <th style="width: 20px">No</th>
                                        <th style="width: 150px">Nama Persyaratan</th>
                                        <th style="width: 100px">Keterangan</th>
                                        <th>Type</th>
                                        <th>Kriteria</th>
                                        <th>Operator</th>
                                        <th style="width: 100px">Value</th>
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

<!-- Modal persyaratan -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Persyaratan Beasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Start form --}}
                <form id="formPersyaratan">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nama_persyaratan" class="form-label fw-bold">Nama Persyaratan
                                <span style="color: red;">*</span>
                            </label>
                            <input type="text" class="form-control" id="nama_persyaratan" name="nama_persyaratan" placeholder="Masukkan nama persyaratan">
                        </div>
                        <div class="col mb-3">
                            <label for="keterangan" class="form-label fw-bold">Keterangan (Opsional)</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan keterangan tambahan">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="type" class="form-label fw-bold">Type
                                <span style="color: red;">*</span>
                            </label>
                            <select class="form-select" id="type" name="type">
                                <option value="tanpa_kriteria">Tanpa Kriteria</option>
                                <option value="dengan_kriteria">Dengan Kriteria</option>
                            </select>
                            <span class="form-text text-muted" style="font-style: italic;">Pilih apakah kriteria diperlukan atau tidak.</span>
                        </div>
                        <div class="col mb-3">
                            <label for="kriteria" class="form-label fw-bold">Kriteria</label>
                            <select class="form-select" id="kriteria" name="kriteria">
                                <option value="">Pilih Kriteria</option>
                                @foreach ($kriteria as $item)
                                    <option 
                                        value="{{ $item->id }}" 
                                        data-tipe_input="{{ $item->tipe_input }}" 
                                        data-opsi_dropdown='{{ $item->opsi_dropdown }}'>
                                        {{ $item->nama_kriteria }}
                                        {{-- data-opsi_dropdown="{{ $item->opsi_dropdown ?? '' }}">
                                        {{ $item->nama_kriteria }} --}}
                                    </option>
                                @endforeach
                            </select>
                            <span class="form-text text-muted" style="font-style: italic;">Pilih kriteria yang sesuai jika diperlukan.
                                <br>Jika pilihan kriteria tidak ada, tambahkan kriteria terlebih dahulu.
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="operator" class="form-label fw-bold">Operator</label>
                            <select class="form-select" id="operator" name="operator">
                                <option value="0">--Pilih Operator--</option>
                                <option value=">=">>= (Lebih dari atau sama dengan)</option>
                                <option value="<="><= (Kurang dari atau sama dengan)</option>
                                <option value="=">= (Sama dengan)</option>
                                <option value="<">< (Kurang dari)</option>
                                <option value=">">> (Lebih dari)</option>
                                <option value="!=">!= (Tidak sama dengan)</option>
                            </select>
                            <span class="form-text text-muted" style="font-style: italic;">Pilih operator yang sesuai</span>
                        </div>
                        <div class="col mb-3">
                            <label for="value" id="value-label" class="form-label d-none fw-bold">Value</label>
                            <div id="value-container" class="d-none">
                                <select id="value" name="value[]" class="form-select" multiple>
                                    <!-- Options akan diisi dinamis -->
                                </select>
                            </div>
                            <span id="value-help-text" class="form-text text-muted d-none" style="font-style: italic;">
                                Pilih satu atau beberapa nilai dari kriteria yang tersedia.
                            </span>
                        </div>
                    </div>
                </form>
                {{-- End form --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary tombol-simpan">
                    <i class="bi bi-save me-1"></i>Simpan Data</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Kriteria -->
<div class="modal fade" id="modalKriteria" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kriteria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formKriteria">
                    <div class="mb-3">
                        <label for="nama_kriteria" class="form-label">Nama Kriteria</label>
                        <input type="text" class="form-control" id="nama_kriteria" name="nama_kriteria">
                    </div>
                    <div class="mb-3">
                        <label for="tipe_input" class="form-label">Tipe Input</label>
                        <select class="form-select" id="tipe_input" name="tipe_input">
                            <option value="text">Text</option>
                            <option value="number">Number</option>
                            <option value="dropdown">Dropdown</option>
                        </select>
                    </div>
                    <div class="mb-3" id="dropdown-options" style="display: none;">
                        <label for="opsi_dropdown" class="form-label">Opsi Dropdown</label>
                        <textarea id="opsi_dropdown" class="form-control" name="opsi_dropdown"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="key_detail_user" class="form-label">Field Detail User</label>
                        <select class="form-select" id="key_detail_user" name="key_detail_user">
                            <!-- Dropdown ini akan diisi secara dinamis dari server -->
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary tombol-simpan-kriteria">Simpan</button>
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
     
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeField = document.getElementById('type');
            const kriteriaDropdown = document.getElementById('kriteria');
            const valueContainer = document.getElementById('value-container');
            const valueHelpText = document.getElementById('value-help-text');

            function toggleFields() {
                const kriteriaField = kriteriaDropdown?.parentElement;
                const operatorField = document.getElementById('operator')?.parentElement;

                if (typeField.value === 'tanpa_kriteria') {
                    kriteriaField?.classList.add('d-none');
                    operatorField?.classList.add('d-none');
                    valueContainer.classList.add('d-none');
                    valueHelpText.classList.add('d-none');
                } else {
                    kriteriaField?.classList.remove('d-none');
                    operatorField?.classList.remove('d-none');
                    valueContainer.classList.remove('d-none');
                    valueHelpText.classList.remove('d-none');
                }
            }

            toggleFields();

            typeField.addEventListener('change', toggleFields);

            kriteriaDropdown.addEventListener('change', function () {
                const selectedOption = kriteriaDropdown.options[kriteriaDropdown.selectedIndex];
                const tipeInput = selectedOption.getAttribute('data-tipe_input');
                const opsiDropdown = selectedOption.getAttribute('data-opsi_dropdown');

                valueContainer.innerHTML = '';
                document.getElementById('value-label').classList.remove('d-none');

                let options = [];
                if (opsiDropdown) {
                    try {
                        options = JSON.parse(opsiDropdown);
                        if (!Array.isArray(options)) {
                            options = [];
                        }
                    } catch (error) {
                        console.error("Parsing JSON gagal:", error);
                        options = [];
                    }
                }

                if (tipeInput === 'number') {
                    valueContainer.innerHTML = '<input id="value" name="value" type="number" class="form-control" />';
                } else if (tipeInput === 'text') {
                    valueContainer.innerHTML = '<input id="value" name="value" type="text" class="form-control" />';
                } else if (tipeInput === 'dropdown' && Array.isArray(options)) {
                    let dropdownHtml = `<select id="value" name="value[]" class="form-select" multiple>`;
                    options.forEach(option => {
                        dropdownHtml += `<option value="${option.trim()}">${option.trim()}</option>`;
                    });
                    dropdownHtml += '</select>';

                    valueContainer.innerHTML = dropdownHtml;

                    $('#value').select2({
                        theme: 'bootstrap-5',
                        placeholder: "Pilih nilai...",
                        allowClear: true,
                    });
                } else {
                    // Jika tipe input tidak valid, sembunyikan label dan container
                    document.getElementById('value-label').classList.add('d-none');
                    valueContainer.classList.add('d-none');
                }
            });
        });
    </script>
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
                    { data: 'type', name: 'type' },
                    { data: 'kriteria', name: 'kriteria', defaultContent: '-' },
                    { data: 'operator', name: 'operator', defaultContent: '-' },
                    { 
                        data: 'value', 
                        name: 'value', 
                        defaultContent: '-', 
                        render: function (data) {
                            if (Array.isArray(data)) {
                                return data.join(', '); // Gabungkan elemen array dengan koma
                            }
                            return data || '-'; // Tampilkan data langsung jika bukan array
                        }
                    },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
                ]
            });

            // GLOBAL SETUP
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            // SCRIPT UNTUK TAMBAH DAN SIMPAN DATA PERSYARATAN 
            $('body').on('click', '.tombol-tambah', function (e) {
                e.preventDefault();
                $('#exampleModal').modal('show');
                $('#exampleModalLabel').text('Tambah Persyaratan Beasiswa');

                // Reset form field
                $('#formPersyaratan')[0].reset();
                $('.is-invalid').removeClass('is-invalid'); // Clear validation errors
                $('.text-danger').remove();

                // Event listener untuk tombol Simpan
                $('.tombol-simpan').off('click').on('click', function () {
                    simpanPersyaratan(); // Simpan data
                });
            });

            // SCRIPT UNTUK EDIT
            $('body').on('click', '.tombol-edit', function (e) {
                e.preventDefault();
                const id = $(this).data('id'); // Ambil ID data

                // Request data untuk edit
                $.ajax({
                    url: 'persyaratan_beasiswa/' + id + '/edit',
                    type: 'GET',
                    success: function (response) {
                        const persyaratan = response.persyaratan;

                        // Isi data form
                        $('#nama_persyaratan').val(persyaratan.nama_persyaratan);
                        $('#keterangan').val(persyaratan.keterangan);
                        $('#type').val(persyaratan.type).trigger('change');

                        if (persyaratan.type === 'dengan_kriteria') {
                            $('#kriteria').parent().removeClass('d-none');
                            $('#operator').parent().removeClass('d-none');
                            $('#value-container').removeClass('d-none');
                            $('#value-help-text').removeClass('d-none');

                            $('#kriteria').val(persyaratan.kriteria_id).trigger('change');

                            setTimeout(() => {
                                $('#operator').val(persyaratan.operator).trigger('change');

                                const tipeInput = $('#kriteria option:selected').data('tipe_input');
                                const opsiDropdown = $('#kriteria option:selected').data('opsi_dropdown');

                                // Tangani opsiDropdown sebagai array atau string
                                let options = [];
                                if (Array.isArray(opsiDropdown)) {
                                    options = opsiDropdown;
                                } else if (typeof opsiDropdown === 'string' && opsiDropdown.startsWith('[') && opsiDropdown.endsWith(']')) {
                                    try {
                                        options = JSON.parse(opsiDropdown);
                                    } catch (error) {
                                        console.error("Parsing JSON gagal:", error);
                                        options = [];
                                    }
                                } else if (typeof opsiDropdown === 'string' && opsiDropdown.length > 0) {
                                    options = opsiDropdown.split(',').map(option => option.trim());
                                } 

                                if (tipeInput === 'dropdown') {
                                    // Jika tipe input adalah dropdown
                                    let dropdownHtml = `<select id="value" name="value[]" class="form-select" multiple>`;
                                    options.forEach(option => {
                                        const selected = Array.isArray(persyaratan.value) && persyaratan.value.includes(option) ? 'selected' : '';
                                        dropdownHtml += `<option value="${option}" ${selected}>${option}</option>`;
                                    });
                                    dropdownHtml += '</select>';
                                    $('#value-container').html(dropdownHtml);

                                    // Inisialisasi Select2
                                    $('#value').select2({
                                        theme: 'bootstrap-5',
                                        placeholder: "Pilih nilai...",
                                        allowClear: true,
                                    });
                                } else {
                                    const valueData = Array.isArray(persyaratan.value) ? persyaratan.value.join(', ') : persyaratan.value || '';
                                    $('#value-container').html(
                                        `<input id="value" name="value" type="${tipeInput}" class="form-control" value="${valueData}" />`
                                    );
                                }
                            }, 100);
                        }

                        $('#exampleModal').modal('show');

                        $('.tombol-simpan').off('click').on('click', function () {
                            simpanPersyaratan(id);
                        });
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                    },
                });
            });

            // SCRIPT UNTUK HAPUS DATA PERSYARATAN
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

            // Bersihkan formulir persyaratan ketika modal ditutup
            $('#exampleModal').on('hidden.bs.modal', function () {
                $('#formPersyaratan')[0].reset(); // Reset isi form
                $('.is-invalid').removeClass('is-invalid'); // Hapus error class
                $('.text-danger').remove(); // Hapus pesan error
                $('#value-container').empty(); // Kosongkan elemen value-container
                $('#value-label').addClass('d-none'); // Sembunyikan label value jika ada 

                // Sembunyikan elemen kriteria, operator, dan value
                $('#kriteria').parent().addClass('d-none');
                $('#operator').parent().addClass('d-none');
                $('#value-container').addClass('d-none');
                $('#value-help-text').addClass('d-none');

                // Reset dropdowns ke default
                $('#type').val('').trigger('change');
                $('#kriteria').val('').trigger('change');
                $('#operator').val('').trigger('change');
            });

            // FUNGSI SIMPAN DAN UPDATE PERSYARATAN
            function simpanPersyaratan(id = '') {
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
                        type: $('#type').val(),
                        kriteria: $('#type').val() === 'dengan_kriteria' ? $('#kriteria').val() : null,
                        operator: $('#type').val() === 'dengan_kriteria' ? $('#operator').val() : null,
                        value: $('#type').val() === 'dengan_kriteria' ? $('#value').val() : null,
                    },
                    success: function(response) {
                        if (response.errors) {
                            // Tampilkan pesan kesalahan di bawah input yang sesuai
                            $.each(response.errors, function(key, value) {
                                const inputElement = $(`#${key}`);
                                inputElement.addClass('is-invalid'); // Tambahkan kelas is-invalid ke input bermasalah
                                inputElement.after(`<span class="text-danger" style="font-style: italic; font-size: 12px;">${value[0]}</span>`); // Tampilkan pesan error
                            });
                        } else {
                            iziToast.success({
                                title: 'Success',
                                message: response.success,
                                position: 'topRight'
                            });

                            $('#myTable').DataTable().ajax.reload();
                            $('#exampleModal').modal('hide');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText); // Masih log error untuk debugging
                    },
                });
            }

            // SCRIPT TAMBAH DAN SIMPAN KRITERIA
            $('body').on('click', '.tombol-tambah-kriteria', function (e) {
                e.preventDefault();
                $('#modalKriteria').modal('show');

                // Reset form field
                $('#formKriteria')[0].reset();
                $('.is-invalid').removeClass('is-invalid'); // Clear validation errors
                $('.text-danger').remove();

                // Muat field detail user untuk dropdown
                $.ajax({
                    url: '/kriteria/create', // Endpoint untuk mendapatkan kolom detail_user
                    type: 'GET',
                    success: function (response) {
                        const fieldDropdown = $('#key_detail_user');
                        fieldDropdown.empty(); // Kosongkan dropdown terlebih dahulu
                        response.fields.forEach(field => {
                            fieldDropdown.append(`<option value="${field}">${field}</option>`);
                        });
                    },
                    error: function () {
                        iziToast.error({
                            title: 'Error',
                            message: 'Gagal memuat field detail_user.'
                        });
                    }
                });

                // Event listener untuk tombol Simpan
                $('.tombol-simpan-kriteria').off('click').on('click', function () {
                    simpanKriteria(); // Simpan data
                });
            });

            // FUNGSI SIMPAN DAN UPDATE KRITERIA
            function simpanKriteria(id = '') {
                var var_url = id ? '/kriteria/' + id : '/kriteria';
                var var_type = id ? 'PUT' : 'POST';

                // Reset pesan kesalahan sebelumnya
                $('.text-danger').remove();
                $('.is-invalid').removeClass('is-invalid');

                $.ajax({
                    url: var_url,
                    type: var_type,
                    data: {
                        nama_kriteria: $('#nama_kriteria').val(),
                        tipe_input: $('#tipe_input').val(),
                        opsi_dropdown: $('#tipe_input').val() === 'dropdown' ? $('#opsi_dropdown').val() : null,
                        key_detail_user: $('#key_detail_user').val(),
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

                            $('#modalKriteria').modal('hide');
                            // Reload dropdown kriteria di modal persyaratan
                            reloadKriteriaDropdown();
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                    },
                });
            }

            // BERSIHKAN MODAL KRITERIA SAAT FORM DITUTUP
            $('#modalKriteria').on('hidden.bs.modal', function () {
                $('#formKriteria')[0].reset(); // Reset isi form
                $('.is-invalid').removeClass('is-invalid'); // Hapus error class
                $('.text-danger').remove(); // Hapus pesan error
                $('#dropdown-options').hide(); // Sembunyikan opsi dropdown jika perlu
            });

            // FUNGSI RELOAD DROPDOWN KRITERIA DI JAVASCRIPT 
            function reloadKriteriaDropdown() {
                $.ajax({
                    url: '/kriteria', 
                    type: 'GET',
                    success: function (response) {
                        const kriteriaDropdown = $('#kriteria');
                        kriteriaDropdown.empty(); // Kosongkan dropdown
                        kriteriaDropdown.append('<option value="">Pilih Kriteria</option>');

                        response.kriteria.forEach(function (item) {
                            const opsiDropdown = item.opsi_dropdown ? item.opsi_dropdown : "[]"; // OPSI DROPDOWN HARUS ADA
                            kriteriaDropdown.append(`
                                <option value="${item.id}" 
                                        data-tipe_input="${item.tipe_input}" 
                                        data-opsi_dropdown='${opsiDropdown}'>
                                    ${item.nama_kriteria}
                                </option>
                            `);
                        });
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                    },
                });
            }
        });

        $('#tipe_input').on('change', function () {
            if ($(this).val() === 'dropdown') {
                $('#dropdown-options').show();
            } else {
                $('#dropdown-options').hide();
            }
        });
    </script>  

@endpush
