@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    
    <style>
        /* Menambah padding dan border */
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
       /* Gaya untuk Badge */
        .badge {
            display: inline-block;
            padding: 0.25em 0.5em;
            font-size: 0.9rem;
            font-weight: 600;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
            color: white; /* Warna teks */
        }

        /* Warna spesifik untuk setiap status */
        .badge-menunggu {
            background-color: #007bff; /* Biru */
        }

        .badge-diproses {
            background-color: #17a2b8; /* Cyan */
        }

        .badge-lulus {
            background-color: #28a745; /* Hijau */
        }

        .badge-diterima {
            background-color: #28a745; /* Hijau */
        }

        .badge-ditolak {
            background-color: #dc3545; /* Merah */
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
                    <h3 class="mb-0">Beasiswa - Usulan Beasiswa</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Beasiswa
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Usulan Beasiswa
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
                        <!--begin::card body-->
                        <div class="card-body"> 
                            <table class="table table-bordered mb-3" id="myTable">
                                <thead>
                                    <tr>
                                        <th style="width: 20px">No</th>
                                        <th>Nama Beasiswa</th>
                                        <th>Nama Lengkap</th>
                                        <th>NIM</th>
                                        <th style="width: 150px">Fakultas</th>
                                        <th>Jurusan</th>
                                        <th>Status Usulan</th>
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

<!--end::App Main-->
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    {{-- script datatables --}}
    <script>
       $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('riwayat_usulan.index') }}",
                    type: 'GET' 
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'nama_beasiswa', name: 'nama_beasiswa' },
                    { data: 'nama_lengkap', name: 'nama_lengkap' },
                    { data: 'nim', name: 'nim' },
                    { data: 'fakultas', name: 'fakultas' },
                    { data: 'jurusan', name: 'jurusan' },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            // Capitalize the first letter of the status
                            let capitalizedStatus = data.charAt(0).toUpperCase() + data.slice(1);

                            // Assign CSS class and badge content based on status
                            let badgeClass = '';
                            let icon = '';
                            if (['menunggu', 'diproses'].includes(data.toLowerCase())) {
                                badgeClass = 'badge-menunggu';
                                icon = '<i class="fas fa-hourglass-half"></i>'; // Ikon menunggu/diproses
                            } else if (data.toLowerCase().startsWith('lulus')) {
                                badgeClass = 'badge-lulus';
                                icon = '<i class="fas fa-check-circle"></i>'; // Ikon lulus
                            } else if (data.toLowerCase() === 'ditolak') {
                                badgeClass = 'badge-ditolak';
                                icon = '<i class="fas fa-times-circle"></i>'; // Ikon ditolak
                            } else if (data.toLowerCase() === 'diterima') {
                                badgeClass = 'badge-diterima';
                                icon = '<i class="fas fa-handshake"></i>'; // Ikon diterima
                            }

                            return `<span class="badge ${badgeClass}">${icon} ${capitalizedStatus}</span>`;
                    }

                    },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
                ]

            });
        });
    </script> 
@endpush
