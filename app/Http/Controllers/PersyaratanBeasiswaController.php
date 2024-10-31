<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersyaratanBeasiswa;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PersyaratanBeasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read master_beasiswa/persyaratan_beasiswa')->only('index');
        $this->middleware('can:create master_beasiswa/persyaratan_beasiswa')->only(['create', 'store']);
        $this->middleware('can:update master_beasiswa/persyaratan_beasiswa')->only(['edit', 'update']);
        $this->middleware('can:delete master_beasiswa/persyaratan_beasiswa')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // ambil semua data roles di database
            $persyaratanBeasiswa = PersyaratanBeasiswa::all();
            return DataTables::of($persyaratanBeasiswa)
                ->addIndexColumn()
                ->addColumn('aksi', function($persyaratanBeasiswa){
                    return view('konfigurasi.tombol')->with('data',$persyaratanBeasiswa);
                })
                ->make(true);
        }
    
        return view('kelola_beasiswa.persyaratan_beasiswa');
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
            'nama_persyaratan' => 'required|unique:persyaratan_beasiswas,nama_persyaratan',
            'keterangan' => 'nullable',
            'kriteria' => 'required',
            'operator' => 'required',
            'value' => 'required',
        ], [
            'nama_persyaratan.required' => '*Nama persyaratan wajib diisi',
            'nama_persyaratan.unique' => '*Nama persyaratan sudah ada, silakan masukkan yang lain',
            'keterangan.nullable' => '*Keterangan tidak wajib diisi',
            'kriteria.nullable' => '*Kriteria tidak wajib diisi',
            'operator.nullable' => '*Operator tidak wajib dipilih',
            'value.nullable' => '*Value tidak wajib diisi',
        ]);
    
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        } else {
            $persyaratanBeasiswa = [
                'nama_persyaratan' => $request->nama_persyaratan,
                'keterangan' => $request->keterangan,
                'kriteria' => $request->kriteria,
                'operator' => $request->operator,
                'value' => $request->value,
            ];
            PersyaratanBeasiswa::create($persyaratanBeasiswa);
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
        $persyaratanBeasiswa = PersyaratanBeasiswa::where('id', $id)->first();
        return response()->json(['result' => $persyaratanBeasiswa]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi dengan cek unik
        $validate = Validator::make($request->all(), [
            'nama_persyaratan' => 'required|unique:persyaratan_beasiswas,nama_persyaratan,' . $id,
            'keterangan' => 'nullable',
            'kriteria' => 'required',
            'operator' => 'required',
            'value' => 'required',
        ], [
            'nama_persyaratan.required' => '*Nama persyaratan wajib diisi',
            'nama_persyaratan.unique' => '*Nama persyaratan sudah ada, silakan masukkan yang lain',
            'keterangan.nullable' => '*Keterangan tidak wajib diisi',
            'kriteria.nullable' => '*Kriteria tidak wajib diisi',
            'operator.nullable' => '*Operator tidak wajib dipilih',
            'value.nullable' => '*Value tidak wajib diisi',
        ]);
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        } else {
            $persyaratanBeasiswa = PersyaratanBeasiswa::find($id);
            $persyaratanBeasiswa->update([
                'nama_persyaratan' => $request->nama_persyaratan,
                'keterangan' => $request->keterangan,
                'kriteria' => $request->kriteria,
                'operator' => $request->operator,
                'value' => $request->value,
            ]);
            return response()->json(['success' => "Berhasil memperbarui data"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        PersyaratanBeasiswa::where('id', $id)->delete();
    }
}
