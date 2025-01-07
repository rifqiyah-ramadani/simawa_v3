<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\TahapanBeasiswa;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TahapanBeasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read master_beasiswa/tahapan_beasiswa')->only('index');
        $this->middleware('can:create master_beasiswa/tahapan_beasiswa')->only(['create', 'store']);
        $this->middleware('can:update master_beasiswa/tahapan_beasiswa')->only(['edit', 'update']);
        $this->middleware('can:delete master_beasiswa/tahapan_beasiswa')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // ambil semua data roles di database
            $tahapanBeasiswa = TahapanBeasiswa::all();
            return DataTables::of($tahapanBeasiswa)
                ->addIndexColumn()
                ->addColumn('aksi', function($tahapanBeasiswa){
                    return view('konfigurasi.tombol')->with('data',$tahapanBeasiswa);
                })
                ->make(true);
        }
    
        return view('kelola_beasiswa.tahapan_beasiswa');
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
            'nama_tahapan' => 'required|unique:tahapan_beasiswas,nama_tahapan',
        ], [
            'nama_tahapan.required' => '*Nama tahapan wajib diisi',
            'nama_tahapan.unique' => '*Nama tahapan sudah ada, silakan masukkan yang lain',
        ]);
    
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        } else {
            $tahapanBeasiswa = [
                'nama_tahapan' => $request->nama_tahapan,
            ];
            TahapanBeasiswa::create($tahapanBeasiswa);
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
        $tahapanBeasiswa = TahapanBeasiswa::where('id', $id)->first();
        return response()->json(['result' => $tahapanBeasiswa]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'nama_tahapan' => 'required|unique:tahapan_beasiswas,nama_tahapan,' . $id,
        ], [
            'nama_tahapan.required' => '*Nama tahapan wajib diisi',
            'nama_tahapan.unique' => '*Nama tahapan sudah ada, silakan masukkan yang lain',
        ]);
    
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        } else {
            $tahapanBeasiswa = TahapanBeasiswa::find($id);
            $tahapanBeasiswa->update([
                'nama_tahapan' => $request->nama_tahapan,
            ]);
            return response()->json(['success' => "Berhasil memperbarui data"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        TahapanBeasiswa::where('id', $id)->delete();
    }
}
