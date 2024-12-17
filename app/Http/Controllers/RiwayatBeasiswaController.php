<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPenerima;
use App\Models\BuatPendaftaranBeasiswa;
use App\Models\DaftarBeasiswa;
use App\Models\PendaftaranBeasiswa;
use App\Models\FileUpload;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RiwayatBeasiswaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data riwayat beasiswa untuk mahasiswa yang sedang login
            $dataPenerimas = DataPenerima::with([
                'pendaftaranBeasiswa.buatPendaftaranBeasiswa.beasiswa',
                'pendaftaranBeasiswa.fileUploads.berkasPendaftaran'
            ])->whereHas('pendaftaranBeasiswa', function ($query) {
                $query->where('user_id', auth()->id())
                    ->where('status', 'diterima');
            })->get();
    
            // Format data untuk DataTables
            return DataTables::of($dataPenerimas)
                ->addIndexColumn()
                ->addColumn('aksi', function ($dataPenerima) {
                    return view('beasiswa.tombol_riwayat_beasiswa')->with('data', $dataPenerima);
                })
                ->make(true);
        }
    
        return view('beasiswa.riwayat_beasiswa');
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
}
