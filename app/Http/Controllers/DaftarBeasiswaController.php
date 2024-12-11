<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\DaftarBeasiswa;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DaftarBeasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read master_beasiswa/daftar_beasiswa')->only('index');
        $this->middleware('can:create master_beasiswa/daftar_beasiswa')->only(['create', 'store']);
        $this->middleware('can:update master_beasiswa/daftar_beasiswa')->only(['edit', 'update']);
        $this->middleware('can:delete master_beasiswa/daftar_beasiswa')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // ambil semua data roles di database
            $daftarBeasiswa = DaftarBeasiswa::all();
            return DataTables::of($daftarBeasiswa) 
                ->addIndexColumn()
                ->addColumn('aksi', function($daftarBeasiswa){
                    return view('konfigurasi.tombol')->with('data',$daftarBeasiswa);
                })
                ->make(true);
        }
        return view('kelola_beasiswa.daftar_beasiswa'); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return 'create page';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi dengan cek unik
        $validate = Validator::make($request->all(), [
            'kode_beasiswa' => 'required|unique:daftar_beasiswas,kode_beasiswa',
            'nama_beasiswa' => 'required|unique:daftar_beasiswas,nama_beasiswa',
            'penyelenggara' => 'required|string',
        ], [
            'kode_beasiswa.required' => '*Kode wajib diisi',
            'kode_beasiswa.unique' => '*Kode sudah ada, silakan masukkan yang lain',
            'nama_beasiswa.required' => '*Nama beasiswa wajib diisi',
            'nama_beasiswa.unique' => '*Nama beasiswa sudah ada, silakan masukkan yang lain',
            'penyelenggara.required' => '*Penyelenggara beasiswa wajib diisi',
        ]);
    
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        } else {
            $daftarBeasiswa = [
                'kode_beasiswa' => $request->kode_beasiswa,
                'nama_beasiswa' => $request->nama_beasiswa,
                'penyelenggara' => $request->penyelenggara,
            ];
            DaftarBeasiswa::create($daftarBeasiswa);
            return response()->json(['success' => "Berhasil menyimpan data"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $daftarBeasiswa = DaftarBeasiswa::where('id', $id)->first();
        return response()->json(['result' => $daftarBeasiswa]);
    }
 
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi dengan cek unik
        $validate = Validator::make($request->all(), [
            'kode_beasiswa' => 'required:daftar_beasiswas,kode_beasiswa',
            'nama_beasiswa' => 'required:daftar_beasiswas,nama_beasiswa',
            'penyelenggara' => 'required|string',
        ], [
            'kode_beasiswa.required' => '*Kode wajib diisi',
            'kode_beasiswa.unique' => '*Kode sudah ada, silakan masukkan yang lain',
            'nama_beasiswa.required' => '*Nama beasiswa wajib diisi',
            'nama_beasiswa.unique' => '*Nama beasiswa sudah ada, silakan masukkan yang lain',
            'penyelenggara.required' => '*Penyelenggara beasiswa wajib diisi',
        ]);
    
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        } else {
            $daftarBeasiswa = DaftarBeasiswa::find($id);
            $daftarBeasiswa->update([
                'kode_beasiswa' => $request->kode_beasiswa,
                'nama_beasiswa' => $request->nama_beasiswa,
                'penyelenggara' => $request->penyelenggara,
            ]);
            return response()->json(['success' => "Berhasil memperbarui data"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DaftarBeasiswa::where('id', $id)->delete();
    }
}
