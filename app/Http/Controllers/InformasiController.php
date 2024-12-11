<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Informasi;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class InformasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read master_informasi/berita')->only('index');
        $this->middleware('can:create master_informasi/berita')->only(['create', 'store']);
        $this->middleware('can:update master_informasi/berita')->only(['edit', 'update']);
        $this->middleware('can:delete master_informasi/berita')->only('destroy');

        $this->middleware('can:read master_informasi/pengumuman')->only('index');
        $this->middleware('can:create master_informasi/pengumuman')->only(['create', 'store']);
        $this->middleware('can:update master_informasi/pengumuman')->only(['edit', 'update']);
        $this->middleware('can:delete master_informasi/pengumuman')->only('destroy');
    }
    /**
     * index berita.
     */
    public function indexBerita(Request $request)
    {
        if ($request->ajax()) {
            // ambil data berita
            $berita = Informasi::where('kategori_informasi', 'berita')
                ->select(['id', 'kategori_informasi', 'judul', 'content', 'image', 'publish_date']);

            return DataTables::eloquent($berita)
                ->addIndexColumn()
                ->addColumn('aksi', function($berita){
                    return view('master_informasi.tombol')->with('data',$berita);
                })
                ->editColumn('kategori_informasi', function ($berita) {
                    return ucfirst($berita->kategori_informasi); // Capitalize: Berita, Pengumuman
                })
                ->make(true);
        }
        return view('master_informasi.berita'); 
    }

    /**
     * index perngumuman.
     */
    public function indexPengumuman(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data pengumuman saja
            $pengumuman = Informasi::where('kategori_informasi', 'pengumuman')
                ->select(['id', 'kategori_informasi', 'judul', 'file', 'publish_date']);
    
            return DataTables::eloquent($pengumuman)
                ->addIndexColumn()
                ->addColumn('aksi', function ($pengumuman) {
                    return view('master_informasi.tombol')->with('data', $pengumuman);
                })
                ->editColumn('kategori_informasi', function ($pengumuman) {
                    return ucfirst($pengumuman->kategori_informasi);
                })
                ->make(true);
        }
        return view('master_informasi.pengumuman');
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create($kategori)
    {
        // Validasi kategori
        if (!in_array($kategori, ['berita', 'pengumuman'])) {
            abort(404); // Jika kategori tidak valid, tampilkan error 404
        }
    
        // Tentukan nama Blade berdasarkan kategori
        $view = $kategori === 'berita' ? 'master_informasi.berita' : 'master_informasi.pengumuman';
    
        return view($view, compact('kategori'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $kategori)
    {
        // Validasi kategori
        if (!in_array($kategori, ['berita', 'pengumuman'])) {
            abort(404); // Jika kategori tidak valid, tampilkan error 404
        }
    
        // Validasi input berdasarkan kategori
        $rules = [
            'judul' => 'required|unique:informasis,judul',
        ];
    
        // Tambahkan validasi khusus untuk setiap kategori
        if ($kategori === 'berita') {
            $rules['content'] = 'required|string';
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        } elseif ($kategori === 'pengumuman') {
            $rules['file'] = 'nullable|mimes:pdf,doc,docx|max:5120';
        }
    
        $messages = [
            'judul.required' => '*Judul wajib diisi',
            'judul.unique' => '*Judul sudah ada, silakan masukkan judul lain',
            'publish_date.required' => '*Tanggal publikasi wajib diisi',
            'publish_date.date' => '*Tanggal publikasi tidak valid',
            'content.required' => '*Konten berita wajib diisi',
            'image.image' => '*File yang diunggah harus berupa gambar',
            'image.mimes' => '*Gambar harus berformat jpeg, png, jpg, atau gif',
            'image.max' => '*Ukuran gambar maksimal 2MB',
            'file.mimes' => '*File harus berupa PDF atau dokumen Word',
            'file.max' => '*Ukuran file maksimal 5MB',
        ];
    
        // Validasi input
        $validate = Validator::make($request->all(), $rules, $messages);
    
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        }
    
        // Persiapkan data untuk disimpan
        $informasi = [
            'kategori_informasi' => $kategori,
            'judul' => $request->judul,
            'publish_date' => now(),
        ];
    
        // Simpan data tambahan berdasarkan kategori
        if ($kategori === 'berita') {
            $informasi['content'] = $request->content;
    
            // Upload gambar jika ada
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('uploads/berita', 'public');
                $informasi['image'] = $path;
            }
        } elseif ($kategori === 'pengumuman') {
            // Upload file jika ada
            if ($request->hasFile('file')) {
                $path = $request->file('file')->store('uploads/pengumuman', 'public');
                $informasi['file'] = $path;
            }
        }
    
        // Simpan ke database
        Informasi::create($informasi);
    
        // Response sukses
        return response()->json(['success' => ucfirst($kategori) . ' berhasil disimpan']);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Tampilkan form edit untuk mengubah data.
     */
    public function edit($kategori, $id)
    {
        // Validasi kategori
        if (!in_array($kategori, ['berita', 'pengumuman'])) {
            abort(404); // Jika kategori tidak valid, tampilkan error 404
        }

        // Ambil data berdasarkan ID
        $informasi = Informasi::findOrFail($id);

        // Tentukan nama Blade berdasarkan kategori
        $view = $kategori === 'berita' ? 'master_informasi.berita' : 'master_informasi.pengumuman';

        return response()->json(['informasi' => $informasi]);
    }

    /**
     * Update data di database.
     */
    public function update(Request $request, $kategori, $id)
    {
        // Log::info('Request diterima:', ['data' => $request->all()]);
        // Log::info('Kategori Diterima:', ['kategori' => $kategori]);
    
        // Validasi kategori
        if (!in_array($kategori, ['berita', 'pengumuman'])) {
            return response()->json(['error' => 'Kategori tidak valid'], 404);
        }
    
        // Ambil data berdasarkan ID
        $informasi = Informasi::find($id);
        if (!$informasi) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
    
        // Validasi input
        $rules = [
            'judul' => 'required|unique:informasis,judul,' . $id,
        ];
    
        if ($kategori === 'berita') {
            $rules['content'] = 'required|string';
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        } elseif ($kategori === 'pengumuman') {
            $rules['file'] = 'nullable|mimes:pdf,doc,docx|max:5120';
        }
    
        $messages = [
            'judul.required' => '*Judul wajib diisi',
            'judul.unique' => '*Judul sudah ada, silakan masukkan judul lain',
            'content.required' => '*Konten berita wajib diisi',
            'image.image' => '*File yang diunggah harus berupa gambar',
            'image.mimes' => '*Gambar harus berformat jpeg, png, jpg, atau gif',
            'image.max' => '*Ukuran gambar maksimal 2MB',
            'file.mimes' => '*File harus berupa PDF atau dokumen Word',
            'file.max' => '*Ukuran file maksimal 5MB',
        ];
    
        Log::info('Request Validasi:', $request->all());
        $validate = Validator::make($request->all(), $rules, $messages);
        
        if ($validate->fails()) {
            Log::error('Validation Errors:', $validate->errors()->toArray());
            return response()->json(['errors' => $validate->errors()]);
        }
    
        // Update data
        $informasi->judul = $request->judul;
    
        if ($kategori === 'berita') {
            $informasi->content = $request->content;
    
            // Upload gambar baru jika ada
            if ($request->hasFile('image')) {
                // Hapus gambar lama
                if ($informasi->image && \Storage::disk('public')->exists($informasi->image)) {
                    \Storage::disk('public')->delete($informasi->image);
                }
                // Simpan gambar baru
                $path = $request->file('image')->store('uploads/berita', 'public');
                $informasi->image = $path;
            }
        } elseif ($kategori === 'pengumuman') {
            // Upload file baru jika ada
            if ($request->hasFile('file')) {
                // Hapus file lama
                if ($informasi->file && \Storage::disk('public')->exists($informasi->file)) {
                    \Storage::disk('public')->delete($informasi->file);
                }
                // Simpan file baru
                $path = $request->file('file')->store('uploads/pengumuman', 'public');
                $informasi->file = $path;
            } else {
                // Pertahankan file lama
                $informasi->file = $informasi->file;
            }
        }
    
        // Simpan perubahan ke database
        $informasi->save();
    
        Log::info('Data berhasil diperbarui:', ['data' => $informasi]);
    
        return response()->json(['success' => ucfirst($kategori) . ' berhasil diperbarui']);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kategori, $id)
    {
        // Validasi kategori
        if (!in_array($kategori, ['berita', 'pengumuman'])) {
            return response()->json(['error' => 'Kategori tidak valid'], 404);
        }
    
        // Temukan data berdasarkan ID
        $informasi = Informasi::find($id);
    
        if (!$informasi) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
    
        // Hapus file jika ada berdasarkan kategori
        if ($kategori === 'berita' && $informasi->image) {
            if (\Storage::disk('public')->exists($informasi->image)) {
                \Storage::disk('public')->delete($informasi->image);
            }
        } elseif ($kategori === 'pengumuman' && $informasi->file) {
            if (\Storage::disk('public')->exists($informasi->file)) {
                \Storage::disk('public')->delete($informasi->file);
            }
        }
    
        // Hapus data dari database
        $informasi->delete();
    
        return response()->json(['success' => 'Data berhasil dihapus']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit($kategori, $id)
    // {
    //     // \Log::info("Kategori yang diterima: " . $kategori);
    //     // \Log::info("ID yang diterima: " . $id);
    
    //     $informasi = Informasi::find($id);
    
    //     if (!$informasi) {
    //         \Log::warning("Data tidak ditemukan untuk ID: " . $id);
    //         return response()->json(['error' => 'Data tidak ditemukan'], 404);
    //     }
    
    //     return response()->json(['result' => $informasi]);
    // }
    
    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, $kategori, $id)
    // {
    //     // Temukan data berdasarkan ID
    //     $informasi = Informasi::find($id);
    
    //     if (!$informasi) {
    //         return response()->json(['error' => 'Data tidak ditemukan'], 404);
    //     }
    
    //     if (!in_array($kategori, ['berita', 'pengumuman'])) {
    //         abort(404);
    //     }
    
    //     $rules = [
    //         'judul' => 'required|unique:informasis,judul,' . $id . ',id',
    //     ];
    
    //     if ($kategori === 'berita') {
    //         $rules['content'] = 'required|string';
    //         $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
    //     } elseif ($kategori === 'pengumuman') {
    //         $rules['file'] = 'nullable|mimes:pdf,doc,docx|max:5120';
    //     }
    
    //     $messages = [
    //         'judul.required' => '*Judul wajib diisi',
    //         'judul.unique' => '*Judul sudah ada, silakan masukkan judul lain',
    //         'content.required' => '*Konten berita wajib diisi',
    //         'image.image' => '*File yang diunggah harus berupa gambar',
    //         'image.mimes' => '*Gambar harus berformat jpeg, png, jpg, atau gif',
    //         'image.max' => '*Ukuran gambar maksimal 2MB',
    //         'file.mimes' => '*File harus berupa PDF atau dokumen Word',
    //         'file.max' => '*Ukuran file maksimal 5MB',
    //     ];
        
    //     $validate = Validator::make($request->all(), $rules, $messages);
        
    
    //     \Log::info('Step 1: Validating data');
    //     if ($validate->fails()) {
    //         \Log::error('Validation Errors:', $validate->errors()->toArray());
    //         return response()->json(['errors' => $validate->errors()]);
    //     }
    //     \Log::info('Step 2: Validation passed');
    
    //     $informasi->judul = $request->judul;
    //     $informasi->publish_date = now();
    
    //     if ($kategori === 'berita') {
    //         $informasi->content = $request->content;
    
    //         if ($request->hasFile('image')) {
    //             if ($informasi->image) {
    //                 Storage::disk('public')->delete($informasi->image);
    //             }
    //             $path = $request->file('image')->store('uploads/berita', 'public');
    //             $informasi->image = $path;
    //         }
    //     } elseif ($kategori === 'pengumuman') {
    //         if ($request->hasFile('file')) {
    //             if ($informasi->file) {
    //                 Storage::disk('public')->delete($informasi->file);
    //             }
    //             $path = $request->file('file')->store('uploads/pengumuman', 'public');
    //             $informasi->file = $path;
    //         }
    //     }
    
    //     $informasi->save();
    
    //     return response()->json(['success' => ucfirst($kategori) . ' berhasil diperbarui']);
    // }
    

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     //
    // }
}
