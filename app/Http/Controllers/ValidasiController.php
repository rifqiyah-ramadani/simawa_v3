<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PendaftaranBeasiswa;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use App\Models\BuatPendaftaranBeasiswa;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\ValidasiPendaftaranBeasiswa;
use App\Models\ValidasiPendaftaranMahasiswa;
use App\Models\Interview;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ValidasiController extends Controller
{
    public function __construct() 
    {
        $this->middleware('can:read kelola_beasiswa/usulan_beasiswa')->only('index');
        $this->middleware('can:create kelola_beasiswa/usulan_beasiswa')->only(['create', 'store']);
        $this->middleware('can:update kelola_beasiswa/usulan_beasiswa')->only(['edit', 'update']);
        $this->middleware('can:delete kelola_beasiswa/usulan_beasiswa')->only('destroy');
    }

    // public function index(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $user = auth()->user();
    //         $role = $user->roles->first();
    
    //         // Ambil data validasi yang sesuai dengan role user dan status yang relevan
    //         $validasiQuery = ValidasiPendaftaranMahasiswa::with(['pendaftaran.buatPendaftaranBeasiswa.beasiswa'])
    //             ->where('role_id', $role->id)
    //             ->whereIn('status', ['menunggu', 'diproses', 'disetujui', 'ditolak', 'lulus seleksi wawancara'])  // Filter status 'menunggu' dan 'diproses' untuk semua role
    //             ->orderBy('urutan');  // Urutkan sesuai urutan untuk memastikan tampilan yang terstruktur
    
    //         // Jalankan query untuk mendapatkan data validasi
    //         $validasi = $validasiQuery->get();
    
    //         // Mapping data untuk menambahkan nama beasiswa dan informasi lainnya
    //         $data = $validasi->map(function ($item) {
    //             $pendaftaran = $item->pendaftaran;
    //             $buatPendaftaran = $pendaftaran->buatPendaftaranBeasiswa;
    //             $namaBeasiswa = $buatPendaftaran->beasiswa->nama_beasiswa ?? '-';
    
    //             return [
    //                 'id' => $item->id,
    //                 'nama_beasiswa' => $namaBeasiswa,
    //                 'nama_lengkap' => $pendaftaran->nama_lengkap ?? '-',
    //                 'nim' => $pendaftaran->nim ?? '-',
    //                 'fakultas' => $pendaftaran->fakultas ?? '-',
    //                 'jurusan' => $pendaftaran->jurusan ?? '-',
    //                 'status' => $item->status,
    //             ];
    //         });
    
    //         return DataTables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('aksi', function ($data) {
    //                 return view('beasiswa.tombol_validasi', compact('data'));
    //             })
    //             ->make(true);
    //     }
    
    //     return view('kelola_beasiswa.usulan_beasiswa');
    // }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = auth()->user();
            $role = $user->roles->first();

            // Query untuk role user saat ini, hanya menampilkan data sesuai urutan dan status validasi
            $validasiQuery = ValidasiPendaftaranMahasiswa::with(['pendaftaran.buatPendaftaranBeasiswa.beasiswa'])
                ->where('role_id', $role->id)
                ->whereIn('status', ['menunggu', 'diproses', 'disetujui', 'ditolak', 'lulus seleksi wawancara'])  
                ->where(function ($query) use ($role) {
                    $query->where('urutan', 1) // Menampilkan semua role urutan pertama
                        ->orWhereHas('pendaftaran.validasi', function ($subQuery) {
                            // Memastikan data muncul di role berikutnya hanya jika role sebelumnya sudah disetujui
                            $subQuery->where('status', 'disetujui');
                        });
                })
                ->orderBy('urutan'); // Urutkan berdasarkan urutan untuk struktur tampilan yang benar

            $validasi = $validasiQuery->get();

            // Mapping data untuk menampilkan nama beasiswa dan informasi lainnya
            $data = $validasi->map(function ($item) {
                $pendaftaran = $item->pendaftaran;
                $buatPendaftaran = $pendaftaran->buatPendaftaranBeasiswa;
                $namaBeasiswa = $buatPendaftaran->beasiswa->nama_beasiswa ?? '-';

                return [
                    'id' => $item->id,
                    'nama_beasiswa' => $namaBeasiswa,
                    'nama_lengkap' => $pendaftaran->nama_lengkap ?? '-',
                    'nim' => $pendaftaran->nim ?? '-',
                    'fakultas' => $pendaftaran->fakultas ?? '-',
                    'jurusan' => $pendaftaran->jurusan ?? '-',
                    'status' => $item->status,
                ];
            });

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($data) {
                    return view('beasiswa.tombol_validasi', compact('data'));
                })
                ->make(true);
        }

        return view('kelola_beasiswa.usulan_beasiswa');
    }

        
    /**
     * Fungsi untuk menampilkan detail 
     */
    public function show($id)
    {
        // Ambil data validasi dengan relasi pendaftaran dan file uploads terkait
        $pendaftaran = ValidasiPendaftaranMahasiswa::with([
            'pendaftaran.buatPendaftaranBeasiswa.tahapan', // Relasi tahapan
            'pendaftaran.buatPendaftaranBeasiswa.beasiswa', // Relasi buatPendaftaranBeasiswa
            'pendaftaran.fileUploads.berkasPendaftaran' // File uploads mahasiswa
        ])->findOrFail($id);
    
        // Ambil nama beasiswa dari relasi buatPendaftaranBeasiswa
        $namaBeasiswa = $pendaftaran->pendaftaran->buatPendaftaranBeasiswa->beasiswa->nama_beasiswa ?? 'Tidak diketahui';
    
        // Filter hanya berkas dengan upload mahasiswa
        $berkasUploadMahasiswa = $pendaftaran->pendaftaran->fileUploads->map(function ($fileUpload) {
            return [
                'nama_file' => $fileUpload->berkasPendaftaran->nama_file ?? 'Tidak diketahui',
                'file_path' => basename($fileUpload->file_path),
                'lihat_path' => asset('storage/' . $fileUpload->file_path), // Link file
            ];
        });
    
        // Ambil data tahapan beasiswa untuk ditampilkan dalam tabs
        $tahapans = $pendaftaran->pendaftaran->buatPendaftaranBeasiswa->tahapan->map(function ($tahapan) {
            return [
                'nama_tahapan' => $tahapan->nama_tahapan,
                'tanggal_mulai' => $tahapan->pivot->tanggal_mulai ? Carbon::parse($tahapan->pivot->tanggal_mulai)->format('Y-m-d') : null,
                'tanggal_akhir' => $tahapan->pivot->tanggal_akhir ? Carbon::parse($tahapan->pivot->tanggal_akhir)->format('Y-m-d') : null,
                // $tanggalAkhir = Carbon::parse($currentTahapan->pivot->tanggal_akhir)->endOfDay();
            ];
        });
    
        // Status awal adalah "lulus seleksi administrasi" jika sudah pernah lulus pada tahap itu
        $statusUsulanAwal = $pendaftaran->pendaftaran->status === 'lulus seleksi administrasi' || 
                            $pendaftaran->pendaftaran->status === 'lulus seleksi wawancara' ? 
                            'lulus seleksi administrasi' : $pendaftaran->pendaftaran->status;

        // Status akhir adalah "lulus seleksi wawancara" jika status sudah mencapai tahap ini
        $statusUsulanAkhir = $pendaftaran->pendaftaran->status === 'lulus seleksi wawancara' || 
                            $pendaftaran->pendaftaran->status === 'diterima' ? 
                            'lulus seleksi wawancara' : $pendaftaran->pendaftaran->status;

        // Ambil status terbaru dari PendaftaranBeasiswa
        $statusUsulan = $pendaftaran->pendaftaran->status;
        
        // Ambil tahapan Seleksi Administrasi
        $tahapanAdministrasi = $tahapans->firstWhere('nama_tahapan', 'Seleksi Administrasi');
        $tanggalMulaiSeleksi = $tahapanAdministrasi ? Carbon::parse($tahapanAdministrasi['tanggal_mulai']) : null;
        $tanggalAkhirSeleksi = $tahapanAdministrasi ? Carbon::parse($tahapanAdministrasi['tanggal_akhir']) : null;
    
        // Ambil data wawancara, jika ada
        $interview = Interview::where('pendaftaran_id', $pendaftaran->pendaftaran->id)->first();
    
        // Ambil user yang bukan role mahasiswa (gunakan relasi)
        $users = User::whereHas('roles', function($query) {
            $query->where('name', '!=', 'Mahasiswa');
        })->get();
    
        // Tentukan apakah role saat ini adalah yang pertama dalam urutan validasi dan jika ada validasi berikutnya
        $isRolePertama = $pendaftaran->urutan === 1;
        $hasNextValidasi = ValidasiPendaftaranMahasiswa::where('pendaftaran_id', $pendaftaran->pendaftaran_id)
            ->where('urutan', '>', $pendaftaran->urutan)
            ->exists();
    
        return view('beasiswa.detail', compact(
            'pendaftaran', 'berkasUploadMahasiswa', 'namaBeasiswa', 'tahapans', 
            'tanggalMulaiSeleksi', 'tanggalAkhirSeleksi', 'isRolePertama', 'hasNextValidasi', 'statusUsulan',
            'interview', 'users',  'statusUsulanAwal', 'statusUsulanAkhir'
        ));
    }

    /**
     * Fungsi untuk status validasi berjenjang
     */
    public function lanjutkanValidasi(Request $request)
    {
        $request->validate([
            'action' => 'required|in:setuju,tolak',
            'pendaftaranId' => 'required|exists:pendaftaran_beasiswas,id',
        ]);
    
        $action = $request->action;
        $pendaftaranId = $request->pendaftaranId;
    
        $user = auth()->user();
        $roleId = $user->roles->first()?->id;
    
        if (!$roleId) {
            return response()->json(['message' => 'Role user tidak ditemukan.'], 422);
        }
    
        // Cari validasi berdasarkan ID `pendaftaranId` dan `role_id` user saat ini
        $currentValidasi = ValidasiPendaftaranMahasiswa::where('pendaftaran_id', $pendaftaranId)
                            ->where('role_id', $roleId)
                            ->whereIn('status', ['diproses', 'menunggu', 'disetujui'])
                            ->first();
    
        if (!$currentValidasi) {
            return response()->json(['message' => 'Validasi tidak ditemukan.'], 404);
        }
    
        // Ambil status terkini PendaftaranBeasiswa
        $pendaftaran = PendaftaranBeasiswa::find($pendaftaranId);
    
        // Logika untuk Seleksi Administrasi
        if ($pendaftaran->status === 'diproses' || $pendaftaran->status === 'menunggu') {
            // Hanya untuk "Seleksi Administrasi"
            $currentTahapan = $currentValidasi->pendaftaran->buatPendaftaranBeasiswa->tahapan()
                            ->where('nama_tahapan', 'Seleksi Administrasi')
                            ->first();
    
            if ($currentTahapan) {
                $tanggalMulai = Carbon::parse($currentTahapan->pivot->tanggal_mulai);
                $tanggalAkhir = Carbon::parse($currentTahapan->pivot->tanggal_akhir)->endOfDay();
                $tanggalSekarang = Carbon::now();
    
                if (!$tanggalSekarang->between($tanggalMulai, $tanggalAkhir)) {
                    return response()->json(['message' => 'Validasi tidak dapat dilakukan di luar rentang tanggal seleksi administrasi.'], 403);
                }
    
                if ($action === 'setuju') {
                    // Update status untuk role saat ini
                    $currentValidasi->update(['status' => 'disetujui']);
    
                    // Periksa apakah ada validasi berikutnya
                    $nextValidasi = ValidasiPendaftaranMahasiswa::where('pendaftaran_id', $pendaftaranId)
                                            ->where('urutan', '>', $currentValidasi->urutan)
                                            ->orderBy('urutan')
                                            ->first();
    
                    if ($nextValidasi) {
                        // Jika ada validasi berikutnya, set statusnya menjadi 'diproses'
                        $nextValidasi->update(['status' => 'diproses']);
                        $pendaftaran->update(['status' => 'diproses']);
                        return response()->json(['message' => 'Validasi berhasil disetujui dan dilanjutkan ke role berikutnya.']);
                    } else {
                        // Jika tidak ada validasi berikutnya, set status akhir menjadi "lulus seleksi administrasi"
                        $pendaftaran->update(['status' => 'lulus seleksi administrasi']);
                        return response()->json(['message' => 'Validasi berhasil disetujui dan status diperbarui ke lulus seleksi administrasi.']);
                    }
                }
            }
        }
    
        // Logika untuk Seleksi Wawancara
        if ($pendaftaran->status === 'lulus seleksi administrasi') {
            $currentTahapan = $currentValidasi->pendaftaran->buatPendaftaranBeasiswa->tahapan()
                            ->where('nama_tahapan', 'Seleksi Wawancara')
                            ->first();
    
            if ($currentTahapan) {
                $interviewExists = Interview::where('pendaftaran_id', $pendaftaranId)->exists();
                if (!$interviewExists && $action === 'setuju') {
                    return response()->json(['message' => 'Data wawancara harus diisi sebelum melanjutkan validasi.'], 403);
                }
    
                if ($action === 'setuju') {
                    // Update status untuk role terakhir atau satu-satunya
                    $totalRoles = ValidasiPendaftaranMahasiswa::where('pendaftaran_id', $pendaftaranId)->distinct('role_id')->count('role_id');
                    $nextValidasi = ValidasiPendaftaranMahasiswa::where('pendaftaran_id', $pendaftaranId)
                                        ->where('urutan', '>', $currentValidasi->urutan)
                                        ->orderBy('urutan')
                                        ->first();
    
                    if ($totalRoles === 1 || !$nextValidasi) {
                        $currentValidasi->update(['status' => 'lulus seleksi wawancara']);
                        $pendaftaran->update(['status' => 'lulus seleksi wawancara']);
                        return response()->json(['message' => 'Validasi seleksi wawancara disetujui dan status diperbarui ke lulus seleksi wawancara.']);
                    }
    
                    // Jika ada role berikutnya
                    $currentValidasi->update(['status' => 'setuju tahapan berikutnya']);
                    $nextValidasi->update(['status' => 'diproses']);
                    $pendaftaran->update(['status' => 'diproses']);
                    return response()->json(['message' => 'Validasi seleksi wawancara disetujui dan dilanjutkan ke role berikutnya.']);
                }
            }
        }
    
        if ($action === 'tolak') {
            $currentValidasi->update(['status' => 'ditolak']);
            $pendaftaran->update(['status' => 'ditolak']);
            return response()->json(['message' => 'Validasi telah ditolak dan tidak dilanjutkan.']);
        }
    
        return response()->json(['message' => 'Tahapan seleksi yang dimaksud tidak ditemukan.'], 404);
    }
    
    // Fungsi untuk menyimpan data wawancara ke tabel interviews
    public function storeInterview(Request $request)
    {
        $validated = $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftaran_beasiswas,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            'jam_wawancara' => 'required|date_format:H:i',
            'lokasi' => 'nullable|string|max:255',
            'pewawancara_ids' => 'required|array',
            'pewawancara_ids.*' => 'exists:users,id',
        ]);

        // Debug hasil validasi
        try {
            Interview::create([
                'pendaftaran_id' => $request->pendaftaran_id,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_akhir' => $request->tanggal_akhir,
                'jam_wawancara' => $request->jam_wawancara,
                'lokasi' => $request->lokasi,
                'pewawancara_ids' => $request->pewawancara_ids,
            ]);
        
            return redirect()->back()->with('success', 'Data wawancara berhasil disimpan. Silakan lanjutkan validasi.');
        } catch (\Exception $e) {
            \Log::error('Error saving interview data: '.$e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data wawancara.');
        }
    
        // return redirect()->back()->with('success', 'Data wawancara berhasil disimpan. Silakan lanjutkan validasi.');
    }

    /**
     * Update status final berdasarkan tahapan terakhir jika semua validasi selesai.
     */
    // private function updateFinalPendaftaranStatus($pendaftaranId)
    // {
    //     // Mencari data pendaftaran berdasarkan ID yang diberikan atau gagal jika tidak ditemukan
    //     $pendaftaran = PendaftaranBeasiswa::findOrFail($pendaftaranId);
    
    //     // Memeriksa status pendaftaran saat ini dan memperbarui ke tahap berikutnya
    //     switch ($pendaftaran->status) {
    //         case 'diproses':
    //             // Jika status saat ini adalah 'diproses', ubah menjadi 'lulus seleksi administrasi'
    //             $pendaftaran->status = 'lulus seleksi administrasi';
    //             break;
    //         case 'lulus seleksi administrasi':
    //             // Jika status saat ini adalah 'lulus seleksi administrasi', ubah menjadi 'lulus seleksi wawancara'
    //             $pendaftaran->status = 'lulus seleksi wawancara';
    //             break;
    //         case 'lulus seleksi wawancara':
    //             // Jika status saat ini adalah 'lulus seleksi wawancara', ubah menjadi 'lulus seleksi tertulis'
    //             $pendaftaran->status = 'lulus seleksi tertulis';
    //             break;
    //         case 'lulus seleksi tertulis':
    //             // Jika status saat ini adalah 'lulus seleksi tertulis', ubah menjadi 'lulus semua tahapan' (status akhir)
    //             $pendaftaran->status = 'lulus semua tahapan';
    //             break;
    //     }
    
    //     // Menyimpan status pendaftaran yang telah diperbarui ke database
    //     $pendaftaran->save();
    // }
    
    // public function lanjutkanValidasi(Request $request)
    // {
    //     // Validasi input untuk memastikan bahwa action dan pendaftaranId benar
    //     $request->validate([
    //         'action' => 'required|in:setuju,tolak',
    //         'pendaftaranId' => 'required|exists:pendaftaran_beasiswas,id',
    //     ]);

    //     $action = $request->action;
    //     $pendaftaranId = $request->pendaftaranId;

    //     // Ambil user yang sedang login dan periksa role-nya
    //     $user = auth()->user();
    //     $roleId = $user->roles->first()?->id;

    //     if (!$roleId) {
    //         return response()->json(['message' => 'Role user tidak ditemukan.'], 422);
    //     }

    //     // Cari validasi berdasarkan ID `pendaftaranId` dan `role_id` user saat ini
    //     $currentValidasi = ValidasiPendaftaranMahasiswa::where('pendaftaran_id', $pendaftaranId)
    //         ->where('role_id', $roleId)
    //         ->whereIn('status', ['diproses', 'menunggu'])
    //         ->firstOrFail();

    //     // Ambil rentang tanggal tahapan seleksi administrasi
    //     $tahapanAdministrasi = $currentValidasi->pendaftaran->buatPendaftaranBeasiswa->tahapan()
    //         ->where('nama_tahapan', 'Seleksi Administrasi')
    //         ->first();

    //     if ($tahapanAdministrasi) {
    //         $tanggalMulai = Carbon::parse($tahapanAdministrasi->pivot->tanggal_mulai);
    //         $tanggalAkhir = Carbon::parse($tahapanAdministrasi->pivot->tanggal_akhir)->endOfDay();
    //         $tanggalSekarang = Carbon::now();

    //         // Periksa apakah tanggal saat ini berada dalam rentang seleksi administrasi
    //         if (!$tanggalSekarang->between($tanggalMulai, $tanggalAkhir)) {
    //             return response()->json(['message' => 'Validasi tidak dapat dilakukan di luar rentang tanggal seleksi administrasi.'], 403);
    //         }
    //     } else {
    //         return response()->json(['message' => 'Tahapan seleksi administrasi tidak ditemukan.'], 404);
    //     }

    //     // Periksa jika data wawancara sudah diisi sebelum lanjutkan validasi, hanya pada tahap wawancara
    //     $interviewExists = Interview::where('pendaftaran_id', $pendaftaranId)->exists();
    //     if (!$interviewExists && $action === 'setuju' && $currentValidasi->status === 'Seleksi Wawancara') {
    //         return response()->json(['message' => 'Data wawancara harus diisi sebelum melanjutkan validasi.'], 403);
    //     }

    //     // Jika memilih untuk menyetujui
    //     if ($action === 'setuju') {
    //         // Set status menjadi 'disetujui' untuk validasi saat ini
    //         $currentValidasi->update(['status' => 'disetujui']);

    //         // Hitung jumlah total role untuk menentukan apakah hanya satu role yang terlibat
    //         $totalRoles = ValidasiPendaftaranMahasiswa::where('pendaftaran_id', $pendaftaranId)->distinct('role_id')->count('role_id');

    //         if ($totalRoles === 1) {
    //             // Jika hanya satu role validasi, set status langsung ke 'lulus seleksi administrasi' dan hentikan di sini
    //             PendaftaranBeasiswa::where('id', $pendaftaranId)->update(['status' => 'lulus seleksi administrasi']);
    //             return response()->json(['message' => 'Validasi berhasil disetujui dan status diperbarui telah diperbarui.']);
    //         }

    //         // Jika ada lebih dari satu role, lanjutkan ke role berikutnya jika ada
    //         $nextValidasi = ValidasiPendaftaranMahasiswa::where('pendaftaran_id', $pendaftaranId)
    //             ->where('urutan', '>', $currentValidasi->urutan)
    //             ->orderBy('urutan')
    //             ->first();

    //         if ($nextValidasi) {
    //             // Jika ada validasi berikutnya, set statusnya menjadi 'diproses'
    //             $nextValidasi->update(['status' => 'diproses']);
    //             // Perbarui status di `PendaftaranBeasiswa` menjadi 'diproses'
    //             PendaftaranBeasiswa::where('id', $pendaftaranId)->update(['status' => 'diproses']);
    //             return response()->json(['message' => 'Validasi berhasil disetujui dan dilanjutkan ke role berikutnya.']);
    //         } else {
    //             // Jika tidak ada validasi berikutnya, set status final
    //             $this->updateFinalPendaftaranStatus($pendaftaranId);
    //             return response()->json(['message' => 'Validasi berhasil disetujui dan status diperbarui ke lulus seleksi adminitrasi.']);
    //         }
    //     }

    //     // Jika memilih untuk menolak
    //     if ($action === 'tolak') {
    //         // Set status menjadi 'ditolak' dan perbarui pendaftaran
    //         $currentValidasi->update(['status' => 'ditolak']);
    //         PendaftaranBeasiswa::where('id', $pendaftaranId)->update(['status' => 'ditolak']);

    //         // Jika ada validasi berikutnya, set statusnya menjadi 'ditolak'
    //         $nextValidasi = ValidasiPendaftaranMahasiswa::where('pendaftaran_id', $pendaftaranId)
    //             ->where('urutan', '>', $currentValidasi->urutan)
    //             ->orderBy('urutan')
    //             ->first();

    //         if ($nextValidasi) {
    //             $nextValidasi->update(['status' => 'ditolak']);
    //         }

    //         return response()->json(['message' => 'Validasi telah ditolak dan tidak dilanjutkan.']);
    //     }
    // }

    // public function lanjutkanValidasi(Request $request)
    // {
    //     // Validasi input untuk memastikan bahwa action dan pendaftaranId benar
    //     $request->validate([
    //         'action' => 'required|in:setuju,tolak',
    //         'pendaftaranId' => 'required|exists:pendaftaran_beasiswas,id',
    //     ]);
    
    //     $action = $request->action;
    //     $pendaftaranId = $request->pendaftaranId;
    
    //     // Ambil user yang sedang login dan periksa role-nya
    //     $user = auth()->user();
    //     $roleId = $user->roles()->first()?->id;
    
    //     if (!$roleId) {
    //         return response()->json(['message' => 'Role user tidak ditemukan.'], 422);
    //     }
    
    //     // Cari validasi berdasarkan ID `pendaftaranId` dan `role_id` user saat ini
    //     $currentValidasi = ValidasiPendaftaranMahasiswa::where('pendaftaran_id', $pendaftaranId)
    //         ->where('role_id', $roleId)
    //         ->whereIn('status', ['diproses', 'menunggu'])
    //         ->firstOrFail();
    
    //     // Ambil rentang tanggal tahapan seleksi administrasi
    //     $tahapanAdministrasi = $currentValidasi->pendaftaran->buatPendaftaranBeasiswa->tahapan()
    //         ->where('nama_tahapan', 'Seleksi Administrasi')
    //         ->first();
    
    //     if ($tahapanAdministrasi) {
    //         $tanggalMulai = Carbon::parse($tahapanAdministrasi->pivot->tanggal_mulai);
    //         $tanggalAkhir = Carbon::parse($tahapanAdministrasi->pivot->tanggal_akhir)->endOfDay();
    //         $tanggalSekarang = Carbon::now();
    
    //         // Periksa apakah tanggal saat ini berada dalam rentang seleksi administrasi
    //         if (!$tanggalSekarang->between($tanggalMulai, $tanggalAkhir)) {
    //             return response()->json(['message' => 'Validasi tidak dapat dilakukan di luar rentang tanggal seleksi administrasi.'], 403);
    //         }
    //     } else {
    //         return response()->json(['message' => 'Tahapan seleksi administrasi tidak ditemukan.'], 404);
    //     }
    
    //     // Periksa jika data wawancara sudah diisi sebelum lanjutkan validasi
    //     $interviewExists = Interview::where('pendaftaran_id', $pendaftaranId)->exists();
    //     if (!$interviewExists) {
    //         return response()->json(['message' => 'Data wawancara harus diisi sebelum melanjutkan validasi.'], 403);
    //     }

    //     // Jika memilih untuk menyetujui
    //     if ($action === 'setuju') {
    //         // Set status menjadi 'disetujui' untuk validasi saat ini
    //         $currentValidasi->update(['status' => 'disetujui']);
    
    //         // Hitung jumlah total role untuk menentukan apakah hanya satu role yang terlibat
    //         $totalRoles = ValidasiPendaftaranMahasiswa::where('pendaftaran_id', $pendaftaranId)->distinct('role_id')->count('role_id');
    
    //         if ($totalRoles === 1) {
    //             // Jika hanya satu role validasi, set status langsung ke 'lulus seleksi administrasi' dan hentikan di sini
    //             PendaftaranBeasiswa::where('id', $pendaftaranId)->update(['status' => 'lulus seleksi administrasi']);
    //             return response()->json(['message' => 'Validasi berhasil disetujui dan status diperbarui ke lulus seleksi administrasi.']);
    //         } 
    
    //         // Jika ada lebih dari satu role, lanjutkan ke role berikutnya jika ada
    //         $nextValidasi = ValidasiPendaftaranMahasiswa::where('pendaftaran_id', $pendaftaranId)
    //             ->where('urutan', '>', $currentValidasi->urutan)
    //             ->orderBy('urutan')
    //             ->first();
    
    //         if ($nextValidasi) {
    //             // Jika ada validasi berikutnya, set statusnya menjadi 'diproses'
    //             $nextValidasi->update(['status' => 'diproses']);
    //             // Perbarui status di `PendaftaranBeasiswa` menjadi 'diproses'
    //             PendaftaranBeasiswa::where('id', $pendaftaranId)->update(['status' => 'diproses']);

    //             // Berikan pesan bahwa validasi telah disetujui dan dilanjutkan ke role berikutnya
    //             return response()->json(['message' => 'Validasi berhasil disetujui dan dilanjutkan ke role berikutnya.']);
    //         } else {
    //             // Jika tidak ada validasi berikutnya, set status final
    //             $this->updateFinalPendaftaranStatus($pendaftaranId);
    //             return response()->json(['message' => 'Validasi berhasil disetujui dan status diperbarui ke lulus seleksi administrasi.']);
    //         }
    //     }
    
    //     // Jika memilih untuk menolak
    //     if ($action === 'tolak') {
    //         // Set status menjadi 'ditolak' dan perbarui pendaftaran
    //         $currentValidasi->update(['status' => 'ditolak']);
    //         PendaftaranBeasiswa::where('id', $pendaftaranId)->update(['status' => 'ditolak']);
    
    //         //  // Jika ada lebih dari satu role, lanjutkan ke role berikutnya jika ada
    //          $nextValidasi = ValidasiPendaftaranMahasiswa::where('pendaftaran_id', $pendaftaranId)
    //          ->where('urutan', '>', $currentValidasi->urutan)
    //          ->orderBy('urutan')
    //          ->first();
    
    //         if ($nextValidasi) {
    //         //     // Jika ada validasi berikutnya, set statusnya menjadi 'ditolak'
    //             $nextValidasi->update(['status' => 'ditolak']);
    //         //     // Perbarui status di `PendaftaranBeasiswa` menjadi 'ditolak'
    //         //     PendaftaranBeasiswa::where('id', $pendaftaranId)->update(['status' => 'ditolak']);
    //         }
        
    //         return response()->json(['message' => 'Validasi telah ditolak dan tidak dilanjutkan.']);
    //     }
    // }
}
