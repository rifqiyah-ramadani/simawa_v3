<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\BerkasPendaftaran;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BerkasPendaftaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read master_beasiswa/berkas_pendaftaran')->only('index');
        $this->middleware('can:create master_beasiswa/berkas_pendaftaran')->only(['create', 'store']);
        $this->middleware('can:update master_beasiswa/berkas_pendaftaran')->only(['edit', 'update']);
        $this->middleware('can:delete master_beasiswa/berkas_pendaftaran')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Menggunakan paginate atau query yang lebih efisien daripada all()
            $berkasPendaftaran = BerkasPendaftaran::get();
    
            return DataTables::of($berkasPendaftaran)
                ->addIndexColumn()
                ->addColumn('template_path_url', function($row){
                    // Hanya bangun URL jika template_path ada
                    return $row->template_path ? asset('storage/' . $row->template_path) : null;
                })
                ->addColumn('aksi', function($berkasPendaftaran){
                    return view('konfigurasi.tombol', ['data' => $berkasPendaftaran])->render();
                })
                ->rawColumns(['aksi', 'template_path_url']) // agar kolom HTML tidak di-escape
                ->make(true);
        }
        return view('kelola_beasiswa.berkas_pendaftaran');
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
        // Validasi termasuk validasi file
        $validate = Validator::make($request->all(), [
            'nama_file' => 'required|unique:berkas_pendaftarans,nama_file',
            'keterangan' => 'nullable',
            'template_path' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Validasi untuk file
        ], [
            'nama_file.required' => '*Nama file wajib diisi',
            'nama_file.unique' => '*Nama file sudah ada, silakan masukkan yang lain',
            'template_path.file' => '*Template harus berupa file',
            'template_path.mimes' => '*Format file harus pdf, doc, atau docx',
            'template_path.max' => '*Ukuran file maksimal 2MB',
        ]);
    
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        }
    
        // Proses penyimpanan file
        $filePath = null;
        if ($request->hasFile('template_path')) {
            // Simpan file ke storage dan ambil path-nya
            $filePath = $request->file('template_path')->store('berkas_pendaftaran', 'public');
        }
    
        // Simpan data ke database
        $berkasPendaftaran = [
            'nama_file' => $request->nama_file,
            'keterangan' => $request->keterangan,
            'template_path' => $filePath, // Simpan path file jika ada
        ];
    
        BerkasPendaftaran::create($berkasPendaftaran);
    
        return response()->json(['success' => "Berhasil menyimpan data"]);
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
        $berkasPendaftaran = BerkasPendaftaran::findOrFail($id);

        // Buat URL lengkap untuk file yang di-upload sebelumnya
        $templatePathUrl = $berkasPendaftaran->template_path ? asset('storage/' . $berkasPendaftaran->template_path) : null;

        return response()->json([
            'result' => $berkasPendaftaran,
            'template_path_url' => $templatePathUrl,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Dapatkan data BerkasPendaftaran sebelum validasi
        $berkasPendaftaran = BerkasPendaftaran::findOrFail($id);

        // Validasi input
        $validate = Validator::make($request->all(), [
            'nama_file' => 'required|unique:berkas_pendaftarans,nama_file,' . $id,
            'keterangan' => 'nullable',
            'template_path' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ], [
            'nama_file.required' => '*Nama file wajib diisi',
            'nama_file.unique' => '*Nama file sudah ada, silakan masukkan yang lain',
            'template_path.file' => '*Template harus berupa file',
            'template_path.mimes' => '*Format file harus pdf, doc, atau docx',
            'template_path.max' => '*Ukuran file maksimal 2MB',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        }

        // Proses penyimpanan file jika ada file baru
        if ($request->hasFile('template_path')) {
            $filePath = $request->file('template_path')->store('berkas_pendaftaran', 'public');
            $berkasPendaftaran->template_path = $filePath;
        }

        // Update data BerkasPendaftaran
        $berkasPendaftaran->update([
            'nama_file' => $request->nama_file,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json(['success' => "Berhasil memperbarui data"]);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        BerkasPendaftaran::where('id', $id)->delete();
    }
}
