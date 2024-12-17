<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Interview;
use Illuminate\Support\Str;
use App\Models\DataPenerima;
use App\Models\BuatPendaftaranBeasiswa;
use App\Models\DaftarBeasiswa;
use Illuminate\Http\Request;
use App\Models\PendaftaranBeasiswa;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataPenerimaExport;

class DataPenerimaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data dari tabel pendaftaran_beasiswas dengan status "diterima"
            $pendaftaranBeasiswas = PendaftaranBeasiswa::with([
                'buatPendaftaranBeasiswa.beasiswa' // Relasi hingga nama beasiswa
            ])->where('status', 'diterima')->get();
    
            // Simpan data ke tabel data_penerimas jika belum ada
            foreach ($pendaftaranBeasiswas as $pendaftaran) {
                // Periksa apakah data sudah ada di tabel data_penerimas
                $existingData = DataPenerima::where('pendaftaran_beasiswa_id', $pendaftaran->id)->first();
    
                if (!$existingData) {
                    $mulaiBerlaku = $pendaftaran->buatPendaftaranBeasiswa->mulai_berlaku;
                    $akhirBerlaku = $pendaftaran->buatPendaftaranBeasiswa->akhir_berlaku;
                    $now = Carbon::now();
                    $statusPenerima = '-';
    
                    if ($mulaiBerlaku && $akhirBerlaku) {
                        if ($now->lt(Carbon::parse($mulaiBerlaku))) {
                            $statusPenerima = 'Sedang Menerima';
                        } elseif ($now->between(Carbon::parse($mulaiBerlaku), Carbon::parse($akhirBerlaku))) {
                            $statusPenerima = 'Sedang Menerima';
                        } else {
                            $statusPenerima = 'Masa Selesai';
                        }
                    }
    
                    DataPenerima::create([
                        'pendaftaran_beasiswa_id' => $pendaftaran->id,
                        'status_penerima' => $statusPenerima, // Simpan status yang dihitung
                        'start_semester' => null,
                        'end_semester' => null,
                    ]);
                }
            }
    
            // Ambil data dari tabel data_penerimas untuk ditampilkan di DataTables
            $dataPenerimas = DataPenerima::with('pendaftaranBeasiswa.buatPendaftaranBeasiswa')->get();
    
            // Perbarui status_penerima untuk data yang sudah ada
            foreach ($dataPenerimas as $dataPenerima) {
                $mulaiBerlaku = $dataPenerima->pendaftaranBeasiswa->buatPendaftaranBeasiswa->mulai_berlaku ?? null;
                $akhirBerlaku = $dataPenerima->pendaftaranBeasiswa->buatPendaftaranBeasiswa->akhir_berlaku ?? null;
                $now = Carbon::now();
    
                $statusPenerima = $dataPenerima->status_penerima; // Ambil status saat ini dari database
    
                if ($mulaiBerlaku && $akhirBerlaku) {
                    if ($now->lt(Carbon::parse($mulaiBerlaku))) {
                        $statusPenerima = 'Sedang Menerima';
                    } elseif ($now->between(Carbon::parse($mulaiBerlaku), Carbon::parse($akhirBerlaku))) {
                        $statusPenerima = 'Sedang Menerima';
                    } else {
                        $statusPenerima = 'Masa Selesai';
                    }
    
                    // Perbarui status_penerima di database
                    $dataPenerima->update(['status_penerima' => $statusPenerima]);
                }
            }
    
            // Return data untuk DataTables
            return DataTables::of($dataPenerimas)
                ->addIndexColumn()
                ->addColumn('aksi', function ($dataPenerima) {
                    // Render tombol aksi (Edit/Hapus) menggunakan view
                    return view('kelola_beasiswa.tombol_data_penerima')->with('data', $dataPenerima);
                })
                ->addColumn('nama_beasiswa', function ($dataPenerima) {
                    // Ambil nama beasiswa melalui relasi pendaftaranBeasiswa -> buatPendaftaranBeasiswa -> beasiswa
                    return $dataPenerima->pendaftaranBeasiswa->buatPendaftaranBeasiswa->beasiswa->nama_beasiswa ?? '-';
                })
                ->addColumn('nama_lengkap', function ($dataPenerima) {
                    // Ambil nama mahasiswa dari relasi pendaftaran_beasiswa
                    return $dataPenerima->pendaftaranBeasiswa->nama_lengkap ?? '-';
                })
                ->addColumn('nim', function ($dataPenerima) {
                    // Ambil NIM mahasiswa
                    return $dataPenerima->pendaftaranBeasiswa->nim ?? '-';
                })
                ->addColumn('fakultas', function ($dataPenerima) {
                    // Ambil jurusan mahasiswa
                    return $dataPenerima->pendaftaranBeasiswa->fakultas ?? '-';
                })
                ->addColumn('jurusan', function ($dataPenerima) {
                    // Ambil jurusan mahasiswa
                    return $dataPenerima->pendaftaranBeasiswa->jurusan ?? '-';
                })
                ->addColumn('semester', function ($dataPenerima) {
                    // Ambil semester mahasiswa
                    return $dataPenerima->pendaftaranBeasiswa->semester ?? '-';
                })
                ->addColumn('telepon', function ($dataPenerima) {
                    // Ambil semester mahasiswa
                    return $dataPenerima->pendaftaranBeasiswa->telepon ?? '-';
                })
                ->addColumn('mulai_berlaku', function ($dataPenerima) {
                    // Ambil tanggal mulai_berlaku dari relasi
                    return $dataPenerima->pendaftaranBeasiswa->buatPendaftaranBeasiswa->mulai_berlaku ?? '-';
                })
                ->addColumn('akhir_berlaku', function ($dataPenerima) {
                    // Ambil tanggal akhir_berlaku dari relasi
                    return $dataPenerima->pendaftaranBeasiswa->buatPendaftaranBeasiswa->akhir_berlaku ?? '-';
                })
                ->addColumn('status_penerima', function ($dataPenerima) {
                    // Tampilkan nilai status_penerima dari database
                    return $dataPenerima->status_penerima ?? '-';
                })
                ->make(true);
        }
    
        // Jika request bukan AJAX, render view
        return view('kelola_beasiswa.penerima_beasiswa');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil data penerima dengan relasi pendaftaran_beasiswa dan buat_pendaftaran_beasiswa
       $dataPenerima = DataPenerima::with([
            'pendaftaranBeasiswa.buatPendaftaranBeasiswa.beasiswa',
            'pendaftaranBeasiswa.fileUploads.berkasPendaftaran'
        ])->findOrFail($id);
    
        // Kembalikan data dalam bentuk JSON untuk diisi ke dalam form modal
        return response()->json($dataPenerima);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'start_semester' => 'nullable|string|max:255',
            'end_semester' => 'nullable|string|max:255',
            'status_penerima' => 'nullable|in:sedang menerima,masa selesai',
        ]);
    
        // Ambil data penerima berdasarkan ID
        $dataPenerima = DataPenerima::findOrFail($id);
    
        // Perbarui data berdasarkan input
        $dataPenerima->update([
            'start_semester' => $request->start_semester,
            'end_semester' => $request->end_semester, 
            'status_penerima' => $request->status_penerima,
        ]);
    
        // Berikan respon sukses
        return response()->json(['message' => 'Data penerima berhasil diperbarui!']);
    }

    public function show($id)
    {
        // Ambil data penerima dengan relasi terkait
        $dataPenerima = DataPenerima::with([
            'pendaftaranBeasiswa.buatPendaftaranBeasiswa.beasiswa', // Relasi ke beasiswa
            'pendaftaranBeasiswa.fileUploads.berkasPendaftaran' // Relasi ke file uploads
        ])->findOrFail($id);

        // Kembalikan data dalam bentuk JSON
        return response()->json($dataPenerima);
    }

    /**
     * Fungsi export data
     */
    public function export(Request $request)
    {
        $fakultas = $request->input('fakultas'); // Ambil parameter fakultas dari request
        return Excel::download(new DataPenerimaExport($fakultas), 'penerima_beasiswa.xlsx');
        // return Excel::download(new DataPenerimaExport, 'penerima_beasiswa.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
