<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\BuatPendaftaranBeasiswa;
use App\Models\DaftarBeasiswa;
use App\Models\ValidasiPendaftaranBeasiswa;
use App\Models\BerkasPendaftaran;
use App\Models\PersyaratanBeasiswa;
use App\Models\TahapanBeasiswa;
use App\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
            
            // Pengecekan status pendaftaran
            foreach ($buatPendaftaran as $pendaftaran) {
                $currentDate = now();
                if ($currentDate->lt($pendaftaran->tanggal_mulai) || $currentDate->gt($pendaftaran->tanggal_berakhir)) {
                    $pendaftaran->update(['status' => 'ditutup']);
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
            'status' => 'required|in:dibuka,ditutup',
            'persyaratan.*' => 'required|exists:persyaratan_beasiswas,id',
            'berkas.*' => 'required|exists:berkas_pendaftarans,id',
            // Validasi roles dan urutan hanya untuk beasiswa internal
            'roles.*' => $request->jenis_beasiswa === 'internal' ? 'required|exists:roles,id' : '',
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
            'status.required' => '*Status wajib dipilih',
            'persyaratan.*.required' => '*Persyaratan wajib dipilih',
            'persyaratan.*.exists' => '*Persyaratan yang dipilih tidak valid',
            'berkas.*.required' => '*Berkas wajib dipilih',
            'berkas.*.exists' => '*Berkas yang dipilih tidak valid',
            'roles.*.required' => '*Role wajib dipilih untuk beasiswa internal',
            'roles.*.exists' => '*Role yang dipilih tidak valid',
            'urutan.*.required' => '*Urutan validasi wajib diisi untuk beasiswa internal',
            'urutan.*.integer' => '*Urutan validasi harus berupa angka',
            'jenis_beasiswa.required' => '*Jenis Beasiswa wajib dipilih',
            'flyer.image' => '*File flyer harus berupa gambar',
            'link_pendaftaran.url' => '*Link pendaftaran harus berupa URL yang valid',
        ]);
    
        // Jika validasi gagal
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        } else {
            // Buat pendaftaran beasiswa baru
            $buatPendaftaran = BuatPendaftaranBeasiswa::create([
                'daftar_beasiswas_id' => $request->daftar_beasiswas_id,
                'tahun' => $request->tahun,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_berakhir' => $request->tanggal_berakhir,
                'status' => $request->status,
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
    }
    

    
    /**
     * Display the specified resource.
     */
    // public function show($id)
    // {
    //     // Ambil data pendaftaran beasiswa berdasarkan ID
    //     $buatPendaftaran = BuatPendaftaranBeasiswa::with('persyaratan', 'berkas', 'roles')
    //                         ->findOrFail($id);

    //     // Mengambil detail validasi dari role
    //     $roles = ValidasiPendaftaranBeasiswa::where('pendaftaran_id', $id)
    //                 ->with('role')  // relasi 'role' di model ValidasiPendaftaranBeasiswa
    //                 ->get();

    //     // Kembalikan data ke AJAX sebagai response
    //     return response()->json([
    //         'result' => $buatPendaftaran,
    //         'roles' => $roles,
    //         'persyaratan' => $buatPendaftaran->persyaratan->pluck('id')->toArray(),
    //         'berkas' => $buatPendaftaran->berkas->pluck('id')->toArray(),
    //     ]);
    // }


    /**
     * Show the form for editing the specified resource.
     */
    // public function edit($id)
    // {
    //     // Muat pendaftaran beasiswa bersama dengan persyaratan, berkas, dan validasi
    //     $buatPendaftaran = BuatPendaftaranBeasiswa::with(['persyaratan', 'berkas', 'validasi'])->findOrFail($id);

    //     // Ambil ID persyaratan dan berkas untuk memudahkan pengisian di form edit
    //     return response()->json([
    //         'result' => $buatPendaftaran,
    //         'persyaratan' => $buatPendaftaran->persyaratan->pluck('id')->toArray(),  // Ambil ID persyaratan
    //         'berkas' => $buatPendaftaran->berkas->pluck('id')->toArray(),  // Ambil ID berkas
    //         'roles' => $buatPendaftaran->validasi->map(function ($validasi) {
    //             return [
    //                 'role_id' => $validasi->role_id,
    //                 'urutan' => $validasi->urutan
    //             ];
    //         })
    //     ]);
    // }


    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, $id)
    // {
    //     // Validasi input
    //     $validate = Validator::make($request->all(), [
    //         'daftar_beasiswas_id' => 'required|exists:daftar_beasiswas,id',
    //         'tahun' => 'required|integer',
    //         'tanggal_mulai' => 'required|date',
    //         'tanggal_berakhir' => 'required|date|after:tanggal_mulai',
    //         'status' => 'required|in:dibuka,ditutup',
    //         'persyaratan.*' => 'required|exists:persyaratan_beasiswas,id',
    //         'berkas.*' => 'required|exists:berkas_pendaftarans,id',
    //         'roles.*' => 'required|exists:roles,id',
    //         'urutan.*' => 'required|integer|min:1',
    //     ]);

    //     if ($validate->fails()) {
    //         return response()->json(['errors' => $validate->errors()]);
    //     }

    //     // Perbarui data pendaftaran beasiswa
    //     $buatPendaftaran = BuatPendaftaranBeasiswa::find($id);
    //     $buatPendaftaran->update([
    //         'daftar_beasiswas_id' => $request->daftar_beasiswas_id,
    //         'tahun' => $request->tahun,
    //         'tanggal_mulai' => $request->tanggal_mulai,
    //         'tanggal_berakhir' => $request->tanggal_berakhir,
    //         'status' => $request->status,
    //     ]);

    //     // Sinkronisasi persyaratan yang dipilih
    //     if ($request->has('persyaratan')) {
    //         $buatPendaftaran->persyaratan()->sync($request->persyaratan);
    //     }

    //     // Sinkronisasi berkas yang dipilih
    //     if ($request->has('berkas')) {
    //         $buatPendaftaran->berkas()->sync($request->berkas);
    //     }

    //     // Update atau tambah role validasi
    //     foreach ($request->roles as $index => $role_id) {
    //         $urutan = $request->urutan[$index];
            
    //         // Cari apakah validasi untuk role ini sudah ada
    //         $validasi = ValidasiPendaftaranBeasiswa::where('pendaftaran_id', $buatPendaftaran->id)
    //             ->where('role_id', $role_id)
    //             ->first();

    //         if ($validasi) {
    //             // Jika sudah ada, perbarui urutannya
    //             $validasi->update(['urutan' => $urutan]);
    //         } else {
    //             // Jika belum ada, tambahkan validasi baru
    //             ValidasiPendaftaranBeasiswa::create([
    //                 'pendaftaran_id' => $buatPendaftaran->id,
    //                 'role_id' => $role_id,
    //                 'urutan' => $urutan,
    //             ]);
    //         }
    //     }

    //     // Hapus validasi yang sudah tidak ada di form
    //     ValidasiPendaftaranBeasiswa::where('pendaftaran_id', $buatPendaftaran->id)
    //         ->whereNotIn('role_id', $request->roles)
    //         ->delete();

    //     return response()->json(['success' => "Berhasil memperbarui data"]);
    // }


    /**
     * Remove the specified resource from storage.
     */
    // public function destroy($id)
    // {
    //     // Temukan data BuatPendaftaranBeasiswa berdasarkan ID
    //     $buatPendaftaran = BuatPendaftaranBeasiswa::findOrFail($id);
        
    //     // Jika ada relasi yang ingin dihapus juga (seperti validasi, persyaratan, berkas), gunakan detach atau delete.
    //     // Misalnya, jika BuatPendaftaranBeasiswa memiliki relasi dengan persyaratan dan berkas:
    //     $buatPendaftaran->persyaratan()->detach(); // Hapus relasi persyaratan
    //     $buatPendaftaran->berkas()->detach(); // Hapus relasi berkas

    //     // Hapus validasi yang berhubungan dengan pendaftaran ini
    //     ValidasiPendaftaranBeasiswa::where('pendaftaran_id', $id)->delete();

    //     // Hapus data pendaftaran beasiswa
    //     $buatPendaftaran->delete();

    //     // Berikan response sukses
    //     return response()->json(['success' => 'Pendaftaran beasiswa berhasil dihapus']);
    // }
}
