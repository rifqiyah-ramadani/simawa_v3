<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\DaftarBeasiswa;
use App\Models\TahapanBeasiswa;
use App\Models\BerkasPendaftaran;
use App\Models\PersyaratanBeasiswa;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use App\Models\BuatPendaftaranBeasiswa;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\ValidasiPendaftaranBeasiswa;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BuatPendaftaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read kelola_beasiswa/manajemen_pendaftaran')->only('index');
        $this->middleware('can:create kelola_beasiswa/manajemen_pendaftaran')->only(['create', 'store']);
        $this->middleware('can:update kelola_beasiswa/manajemen_pendaftaran')->only(['edit', 'update']);
        $this->middleware('can:delete kelola_beasiswa/manajemen_pendaftaran')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data dengan relasi beasiswa
            $buatPendaftaran = BuatPendaftaranBeasiswa::with('beasiswa')->get();
            
            // Looping untuk mengecek status pendaftaran beasiswa berdasarkan tanggal
            foreach ($buatPendaftaran as $pendaftaran) {
                $currentDate = now()->startOfDay();
                $tanggalMulai = \Carbon\Carbon::parse($pendaftaran->tanggal_mulai)->startOfDay();
                $tanggalBerakhir = \Carbon\Carbon::parse($pendaftaran->tanggal_berakhir)->endOfDay();

                // Jika tanggal saat ini berada di luar rentang pendaftaran
                if ($currentDate < $tanggalMulai || $currentDate > $tanggalBerakhir) {
                    // Perbarui status menjadi 'ditutup' jika belum ditutup
                    if ($pendaftaran->status !== 'ditutup') {
                        $pendaftaran->update(['status' => 'ditutup']);
                    }
                } else {
                    // Perbarui status menjadi 'dibuka' jika dalam rentang pendaftaran
                    if ($pendaftaran->status !== 'dibuka') {
                        $pendaftaran->update(['status' => 'dibuka']);
                    }
                }
            }            

            return DataTables::of($buatPendaftaran)
                ->addIndexColumn()
                ->addColumn('aksi', function($buatPendaftaran){
                    return view('kelola_beasiswa.tombol')->with('data', $buatPendaftaran);
                })
                ->make(true);
        }

        // Ambil data terkait untuk view
        $beasiswa = DaftarBeasiswa::all();
        $persyaratan = PersyaratanBeasiswa::all();
        $berkasPendaftarans = BerkasPendaftaran::all();
        $roles = Role::all();
        $tahapans = TahapanBeasiswa::all();

        return view('kelola_beasiswa.manajemen_pendaftaran', compact(
            'beasiswa', 'persyaratan', 'berkasPendaftarans', 'roles', 'tahapans'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data terkait untuk view
        $beasiswa = DaftarBeasiswa::all();
        $persyaratan = PersyaratanBeasiswa::all();
        $berkasPendaftarans = BerkasPendaftaran::all();
        $roles = Role::all();
        $tahapans = TahapanBeasiswa::all();

        // Kirim data ke view
        return view('kelola_beasiswa.manajemen_pendaftaran', compact('beasiswa', 'persyaratan', 'berkasPendaftarans', 'roles', 'tahapans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input untuk pendaftaran beasiswa
        $validate = Validator::make($request->all(), [
            'daftar_beasiswas_id' => 'required|exists:daftar_beasiswas,id',
            'tahun' => 'required|integer',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_mulai',
            'status' => 'nullable|in:dibuka,ditutup',
            'persyaratan.*' => 'required|exists:persyaratan_beasiswas,id',
            'berkas.*' => 'required|exists:berkas_pendaftarans,id',
            'mulai_berlaku' => 'required|date',
            'akhir_berlaku' => 'required|date|after:mulai_berlaku',
            'roles.*' => $request->jenis_beasiswa === 'internal' ? 'required|exists:roles,id' : '', // Validasi roles dan urutan hanya untuk beasiswa internal
            'urutan.*' => $request->jenis_beasiswa === 'internal' ? 'required|integer|min:1' : '',
            'jenis_beasiswa' => 'required|in:internal,eksternal',
            'flyer' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi flyer untuk eksternal
            'link_pendaftaran' => 'nullable|url', // Validasi link pendaftaran eksternal
            'tahapans.*' => 'required|exists:tahapan_beasiswas,id', // Validasi tahapan
            'tahapan_tanggal_mulai.*' => 'required|date',
            'tahapan_tanggal_akhir.*' => 'required|date|after:tahapan_tanggal_mulai.*',
        ], [
            'daftar_beasiswas_id.required' => '*Beasiswa wajib dipilih',
            'tahun.required' => '*Tahun wajib diisi',
            'tanggal_mulai.required' => '*Tanggal mulai wajib diisi',
            'tanggal_berakhir.required' => '*Tanggal akhir wajib diisi',
            'tanggal_berakhir.after' => '*Tanggal akhir harus setelah tanggal mulai',
            'persyaratan.*.required' => '*Persyaratan wajib dipilih',
            'persyaratan.*.exists' => '*Persyaratan yang dipilih tidak valid',
            'berkas.*.required' => '*Berkas wajib dipilih',
            'berkas.*.exists' => '*Berkas yang dipilih tidak valid',
            'mulai_berlaku.required' => '*Mulai berlaku wajib diisi',
            'akhir_berlaku.required' => '*Akhir berlaku wajib diisi',
            'akhir_berlaku.after' => '*Akhir berlaku harus setelah mulai berlaku',
            'roles.*.required' => '*Role wajib dipilih untuk beasiswa internal',
            'roles.*.exists' => '*Role yang dipilih tidak valid',
            'urutan.*.required' => '*Urutan validasi wajib diisi untuk beasiswa internal',
            'urutan.*.integer' => '*Urutan validasi harus berupa angka',
            'jenis_beasiswa.required' => '*Jenis Beasiswa wajib dipilih',
            'flyer.image' => '*File flyer harus berupa gambar',
            'link_pendaftaran.url' => '*Link pendaftaran harus berupa URL yang valid',
        ]);
    
        // Jika validasi gagal, kembalikan error
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        } 
        
        // Menentukan status pendaftaran secara otomatis berdasarkan tanggal
        $currentDate = now()->startOfDay();
        $tanggalMulai = \Carbon\Carbon::parse($request->tanggal_mulai)->startOfDay();
        $tanggalBerakhir = \Carbon\Carbon::parse($request->tanggal_berakhir)->endOfDay();
        
        $status = ($currentDate >= $tanggalMulai && $currentDate <= $tanggalBerakhir)
            ? 'dibuka'
            : 'ditutup';        

        // Buat pendaftaran beasiswa baru dan simpan ke database
        $buatPendaftaran = BuatPendaftaranBeasiswa::create([
            'daftar_beasiswas_id' => $request->daftar_beasiswas_id,
            'tahun' => $request->tahun,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'status' => $status, // Status otomatis
            'mulai_berlaku' => $request->mulai_berlaku,
            'akhir_berlaku' => $request->akhir_berlaku,
            'jenis_beasiswa' => $request->jenis_beasiswa,
            'link_pendaftaran' => $request->link_pendaftaran,
        ]);

        // Jika ada flyer untuk beasiswa eksternal, upload file
        if ($request->hasFile('flyer')) {
            $flyerPath = $request->file('flyer')->store('flyers', 'public');
            $buatPendaftaran->flyer = $flyerPath;
            $buatPendaftaran->save();
        }
        
        // Menyimpan persyaratan yang dipilih
        if ($request->has('persyaratan')) {
            $buatPendaftaran->persyaratan()->attach($request->persyaratan);
        }
    
        // Simpan berkas pendaftaran yang dipilih
        if ($request->has('berkas')) {
            $buatPendaftaran->berkasPendaftarans()->attach($request->berkas);
        }

            // Simpan role validasi jika internal
            if ($request->jenis_beasiswa === 'internal' && $request->has('roles')) {
            foreach ($request->roles as $index => $role_id) {
                ValidasiPendaftaranBeasiswa::create([
                    'buat_pendaftaran_id' => $buatPendaftaran->id,
                    'role_id' => $role_id,
                    'urutan' => $request->urutan[$index],
                ]);
            }
        }

        // Menyimpan tahapan dan tanggal mulai/akhir ke pivot table
        if ($request->has('tahapans')) {
            foreach ($request->tahapans as $tahapan_id) {
                $buatPendaftaran->tahapan()->attach($tahapan_id, [
                    'tanggal_mulai' => $request->tahapan_tanggal_mulai[$tahapan_id],
                    'tanggal_akhir' => $request->tahapan_tanggal_akhir[$tahapan_id],
                ]);
            }
        }
    
        // Jika berhasil menyimpan data
        return response()->json(['success' => "Berhasil menyimpan data"]);
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
         // Temukan data berdasarkan ID
         $buatPendaftaran = BuatPendaftaranBeasiswa::with(['beasiswa', 'persyaratan', 'berkasPendaftarans', 'roles', 'tahapan'])->findOrFail($id);
 
         return response()->json(['result' => $buatPendaftaran]);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validate = Validator::make($request->all(), [
            'daftar_beasiswas_id' => 'required|exists:daftar_beasiswas,id',
            'tahun' => 'required|integer',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_mulai',
            'status' => 'nullable|in:dibuka,ditutup',
            'persyaratan.*' => 'required|exists:persyaratan_beasiswas,id',
            'berkas.*' => 'required|exists:berkas_pendaftarans,id',
            'mulai_berlaku' => 'required|date',
            'akhir_berlaku' => 'required|date|after:mulai_berlaku',
            'roles.*' => $request->jenis_beasiswa === 'internal' ? 'required|exists:roles,id' : '',
            'urutan.*' => $request->jenis_beasiswa === 'internal' ? 'required|integer|min:1' : '',
            'jenis_beasiswa' => 'required|in:internal,eksternal',
            'flyer' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link_pendaftaran' => 'nullable|url',
            'tahapans.*' => 'required|exists:tahapan_beasiswas,id',
            'tahapan_tanggal_mulai.*' => 'required|date',
            'tahapan_tanggal_akhir.*' => 'required|date|after:tahapan_tanggal_mulai.*',
        ]);
    
        // Jika validasi gagal
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        }
    
        // Tentukan status berdasarkan tanggal
        $currentDate = now();
        $status = ($currentDate >= $request->tanggal_mulai && $currentDate <= $request->tanggal_berakhir)
            ? 'dibuka'
            : 'ditutup';
    
        // Temukan data yang akan diperbarui
        $buatPendaftaran = BuatPendaftaranBeasiswa::findOrFail($id);
        $buatPendaftaran->update([
            'daftar_beasiswas_id' => $request->daftar_beasiswas_id,
            'tahun' => $request->tahun,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'status' => $status,
            'mulai_berlaku' => $request->mulai_berlaku,
            'akhir_berlaku' => $request->akhir_berlaku,
            'jenis_beasiswa' => $request->jenis_beasiswa,
            'link_pendaftaran' => $request->link_pendaftaran,
        ]);
    
        // Update flyer jika ada
        if ($request->hasFile('flyer')) {
            $flyerPath = $request->file('flyer')->store('flyers', 'public');
            $buatPendaftaran->flyer = $flyerPath;
            $buatPendaftaran->save();
        }
    
        // Update persyaratan
        $buatPendaftaran->persyaratan()->sync($request->persyaratan);
    
        // Update berkas pendaftaran
        $buatPendaftaran->berkasPendaftarans()->sync($request->berkas);
    
        // Update roles untuk internal
        if ($request->jenis_beasiswa === 'internal' && $request->has('roles')) {
            $buatPendaftaran->validasi()->delete();
            foreach ($request->roles as $index => $role_id) {
                ValidasiPendaftaranBeasiswa::create([
                    'buat_pendaftaran_id' => $buatPendaftaran->id,
                    'role_id' => $role_id,
                    'urutan' => $request->urutan[$index],
                ]);
            }
        }
    
        // Update tahapan
        if ($request->has('tahapans')) {
            $tahapanData = [];
            foreach ($request->tahapans as $tahapan_id) {
                $tahapanData[$tahapan_id] = [
                    'tanggal_mulai' => $request->tahapan_tanggal_mulai[$tahapan_id] ?? null,
                    'tanggal_akhir' => $request->tahapan_tanggal_akhir[$tahapan_id] ?? null,
                ];
            }
            $buatPendaftaran->tahapan()->sync($tahapanData);
        }
    
        return response()->json(['success' => "Data berhasil diperbarui"]);
    }

    public function show($id)
    {
        $buatPendaftaran = BuatPendaftaranBeasiswa::with(['beasiswa', 'persyaratan', 'berkasPendaftarans', 'roles', 'tahapan'])
                        ->findOrFail($id);

        // Konversi path flyer menjadi URL penuh jika flyer tersedia
        if ($buatPendaftaran->flyer) {
            $buatPendaftaran->flyer = asset('storage/' . $buatPendaftaran->flyer); 
        }

        return response()->json(['result' => $buatPendaftaran]);
    }

    public function destroy($id)
    {
        // Cari data BuatPendaftaranBeasiswa berdasarkan ID
        $buatPendaftaran = BuatPendaftaranBeasiswa::findOrFail($id);

        // Hapus relasi berkas_pendaftarans di tabel pivot
        $buatPendaftaran->berkasPendaftarans()->detach();

        // Hapus relasi persyaratan di tabel pivot
        $buatPendaftaran->persyaratan()->detach();

        // Hapus relasi roles (role validasi) di tabel pivot
        $buatPendaftaran->roles()->detach();

        // Hapus relasi tahapan di tabel pivot
        $buatPendaftaran->tahapan()->detach();
 
        // Hapus file flyer dari storage jika ada
        if ($buatPendaftaran->flyer) {
            Storage::delete($buatPendaftaran->flyer);
        }

        // Hapus data pendaftaran dari database
        $buatPendaftaran->delete();

        // Berikan respons sukses
        return response()->json(['message' => 'Data pendaftaran dan semua relasi berhasil dihapus.'], 200);
    }
}
