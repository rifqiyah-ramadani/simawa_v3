<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\BuatPendaftaranBeasiswa;
use App\Models\DetailUser;
use App\Models\BerkasPendaftaran;
use App\Models\FileUpload;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PendaftaranBeasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil hanya beasiswa yang masih dibuka
        $currentDate = now();
        
        $buatPendaftaran = BuatPendaftaranBeasiswa::with('beasiswa')
            ->where('status', 'dibuka') // Filter pendaftaran dengan status "dibuka"
            ->where('tanggal_mulai', '<=', $currentDate)
            ->where('tanggal_berakhir', '>=', $currentDate)
            ->get();

        // Cek apakah ada permintaan ajax (untuk datatables)
        if ($request->ajax()) {
            return DataTables::of($buatPendaftaran)
                ->addIndexColumn()
                ->addColumn('aksi', function($buatPendaftaran){
                    return view('beasiswa.tombol')->with('data',$buatPendaftaran);
                })
                ->make(true);
        }

        // Mengembalikan ke view pendaftaran beasiswa untuk mahasiswa
        return view('beasiswa.pendaftaran_beasiswa', compact('buatPendaftaran'));
    }

    // Method untuk mendapatkan persyaratan beasiswa
    public function getPersyaratan($pendaftaranId)
    {
        // Ambil pendaftaran berdasarkan ID dengan relasi ke persyaratan
        $buatPendaftaran = BuatPendaftaranBeasiswa::with('persyaratan')->find($pendaftaranId);

        // Jika pendaftaran tidak ditemukan, kirim response error
        if (!$buatPendaftaran) {
            return response()->json(['success' => false, 'message' => 'Pendaftaran tidak ditemukan']);
        }

        // Ambil persyaratan dari pendaftaran yang ditemukan
        $persyaratan = $buatPendaftaran->persyaratan;

        // Kirim response sukses dengan data persyaratan
        return response()->json(['success' => true, 'persyaratan' => $persyaratan]);
    }

    // Method untuk menampilkan halaman daftar
    public function daftar($pendaftaranId)
    {
        // Ambil data user yang sedang login
        $user = auth()->user();
        
        // Ambil detail user dari tabel detail_user
        $detailUser = DetailUser::where('user_id', $user->id)->first();

        // Ambil persyaratan dan berkas yang terkait dengan pendaftaran
        $buatPendaftaran = BuatPendaftaranBeasiswa::with('persyaratan', 'beasiswa', 'berkas')->findOrFail($pendaftaranId);

        // Logika pengecekan persyaratan
        $persyaratan = [];
        foreach ($buatPendaftaran->persyaratan as $syarat) {
            if ($syarat->nama_persyaratan === 'Memiliki IPK minimal 3.00 (Skala 4)' && $detailUser->IPK < 3.00) {
                $persyaratan[] = [
                    'nama' => 'Anda tidak memenuhi persyaratan karena IPK Anda saat ini kurang dari 3.00',
                    'status' => false, // Tidak terpenuhi
                ];
            } else if ($syarat->nama_persyaratan === 'Mahasiswa aktif program S1' && $detailUser->program_reguler !== 'Program S1') {
                $persyaratan[] = [
                    'nama' => 'Anda tidak memenuhi syarat karena Anda bukan mahasiswa aktif program S1',
                    'status' => false, // Tidak terpenuhi
                ];
            } else if ($syarat->nama_persyaratan === 'Telah menyelasaikan minimal 40 SKS atau 3 semester' && $detailUser->semester < "Semester 3") {
                $persyaratan[] = [
                    'nama' => 'Saat ini Anda belum menyelesaikan minimal 40 SKS atau 3 semester',
                    'status' => false, // Tidak terpenuhi
                ];
            } else if ($syarat->nama_persyaratan === 'Maksimal umur 23 tahun' && $detailUser->Umur > 23) {
                $persyaratan[] = [
                    'nama' => 'Anda tidak memenuhi syarat karena usia Anda melebihi batas maksimal 23 tahun',
                    'status' => false, // Tidak terpenuhi
                ];
            } else if ($syarat->nama_persyaratan === 'Tidak sedang menerima beasiswa lain' && $detailUser->status_beasiswa === 'Sedang menerima beasiswa lain') {
                $persyaratan[] = [
                    'nama' => 'Anda tidak memenuhi syarat karena saat ini Anda sedang menerima beasiswa lain',
                    'status' => false, // Tidak terpenuhi
                ];    
            } else {
                $persyaratan[] = [
                    'nama' => $syarat->nama_persyaratan,
                    'status' => true, // Terpenuhi
                ];
            }
        }
    
        // Cek apakah semua persyaratan terpenuhi
        $semuaTerpenuhi = collect($persyaratan)->every(fn($p) => $p['status'] === true);
          // Ambil berkas yang terkait
        $berkas = $buatPendaftaran->berkas;
         // Tambahkan template_path dari pendaftaran (jika ada)
        $templatePath = $buatPendaftaran->template_path ? asset('storage/' . $buatPendaftaran->template_path) : null;

        // Kembalikan view dengan data pendaftaran, persyaratan, dan template_path
        return view('beasiswa.daftar', compact('buatPendaftaran', 'persyaratan', 'semuaTerpenuhi', 'berkas', 'templatePath'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($pendaftaranId)
    {
        // Ambil pendaftaran terkait
        $buatPendaftaran = BuatPendaftaranBeasiswa::findOrFail($pendaftaranId);

        // Tampilkan view dengan data pendaftaran
        return view('beasiswa.daftar', compact('buatPendaftaran'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $pendaftaranId)
    {
        // Validasi input pengguna
        $validate = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'nim' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',
            'telepon' => 'required|string|max:20',
            'berkas.*' => 'required|file|mimes:pdf,jpeg,png|max:2048', // Validasi berkas harus file dengan ekstensi tertentu
        ], [
            'nama_lengkap.required' => '*Nama lengkap wajib diisi',
            'nim.required' => '*NIM wajib diisi',
            'fakultas.required' => '*Fakultas wajib dipilih',
            'jurusan.required' => '*Jurusan wajib dipilih',
            'alamat_lengkap.required' => '*Alamat lengkap wajib diisi',
            'telepon.required' => '*Nomor telepon wajib diisi',
            'berkas.*.required' => 'Berkas wajib diunggah.',
            'berkas.*.mimes' => 'Berkas harus berupa file dengan format pdf, jpeg, atau png.',
            'berkas.*.max' => 'Ukuran berkas maksimal adalah 2MB.',
        ]);

        // Jika validasi gagal
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }

        // Ambil pendaftaran terkait
        $buatPendaftaran = BuatPendaftaranBeasiswa::with('berkas')->findOrFail($pendaftaranId);

        // Simpan data pendaftaran ke database (sesuaikan dengan struktur database Anda)
        $pendaftaran = $buatPendaftaran->pendaftaranBeasiswa()->create([
            'nama_lengkap' => $request->nama_lengkap,
            'nim' => $request->nim,
            'fakultas' => $request->fakultas,
            'jurusan' => $request->jurusan,
            'alamat_lengkap' => $request->alamat_lengkap,
            'telepon' => $request->telepon,
        ]);

        // Simpan berkas yang diunggah
        if ($request->hasFile('berkas')) {
            foreach ($request->file('berkas') as $file) {
                $path = $file->store('file_uploads', 'public');

                // Simpan path berkas ke tabel `file_uploads`
                FileUpload::create([
                    'pendaftaran_beasiswas_id' => $buatPendaftaran->id, // Menggunakan foreign key dari tabel pendaftaran beasiswa
                    'file_path' => $path,
                ]);
            }
        }

         // Jika berhasil menyimpan data
         return response()->json(['success' => "Berhasil menyimpan data"]);
    }

    // public function riwayat(Request $request)
    // {
    //     if ($request->ajax()) {
    //         // Ambil data pendaftaran yang sudah diusulkan oleh user
    //         $riwayatPendaftaran = auth()->user()->pendaftaranBeasiswa()->with('buatPendaftaranBeasiswa.beasiswa')->get();

    //         return DataTables::of($riwayatPendaftaran)
    //             ->addIndexColumn()
    //             ->addColumn('nama_beasiswa', function ($riwayat) {
    //                 return $riwayat->buatPendaftaranBeasiswa->beasiswa->nama_beasiswa;
    //             })
    //             ->addColumn('status', function ($riwayat) {
    //                 return $riwayat->status ?? 'Pending'; // Sesuaikan dengan field status pendaftaran
    //             })
    //             ->addColumn('tanggal_pengajuan', function ($riwayat) {
    //                 return $riwayat->created_at->format('d-m-Y');
    //             })
    //             ->addColumn('aksi', function ($riwayat) {
    //                 return '<a href="'.route('pendaftaran_beasiswa.show', $riwayat->id).'" class="btn btn-info btn-sm">Lihat Detail</a>';
    //             })
    //             ->rawColumns(['aksi'])
    //             ->make(true);
    //     }
    // }


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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
