<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Interview;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PendaftaranBeasiswa;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use App\Models\BuatPendaftaranBeasiswa;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\ValidasiPendaftaranBeasiswa;
use App\Models\ValidasiPendaftaranMahasiswa;
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
                'nama_tahapan' => strtolower($tahapan->nama_tahapan),
                'tanggal_mulai' => $tahapan->pivot->tanggal_mulai ? Carbon::parse($tahapan->pivot->tanggal_mulai)->format('Y-m-d') : null,
                'tanggal_akhir' => $tahapan->pivot->tanggal_akhir ? Carbon::parse($tahapan->pivot->tanggal_akhir)->format('Y-m-d') : null,
                // $tanggalAkhir = Carbon::parse($currentTahapan->pivot->tanggal_akhir)->endOfDay();
            ];
        });
    
        if ($pendaftaran->pendaftaran->status === 'diterima') {
        $statusUsulanAwal = 'diterima';
        } elseif ($pendaftaran->pendaftaran->status === 'ditolak') {
            $statusUsulanAwal = 'ditolak';
        } elseif ($pendaftaran->pendaftaran->status === 'lulus seleksi administrasi' || $pendaftaran->pendaftaran->status === 'lulus seleksi wawancara') {
            $statusUsulanAwal = 'lulus seleksi administrasi';
        } else {
            $statusUsulanAwal = $pendaftaran->pendaftaran->status;
        }

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
            'interview', 'users',  'statusUsulanAwal'
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

        $currentValidasi = ValidasiPendaftaranMahasiswa::where('pendaftaran_id', $pendaftaranId)
            ->where('role_id', $roleId)
            ->whereIn('status', ['diproses', 'menunggu', 'disetujui'])
            ->first();

        if (!$currentValidasi) {
            return response()->json(['message' => 'Validasi tidak ditemukan.'], 404);
        }

        $pendaftaran = PendaftaranBeasiswa::find($pendaftaranId);
        // $tahapans = $pendaftaran->buatPendaftaranBeasiswa->tahapan()->orderBy('pivot_tanggal_mulai')->get();

        $tahapans = $pendaftaran->buatPendaftaranBeasiswa->tahapan()
        ->orderBy('pivot_tanggal_mulai')->get()
        ->filter(function ($tahapan) {
            return Str::startsWith(strtolower($tahapan->nama_tahapan), 'seleksi');
        });
        
        // Debugging: Log semua tahapan
        \Log::info('Tahapan yang relevan:', ['tahapans' => $tahapans->toArray()]);

        if ($tahapans->isEmpty()) {
            return response()->json(['message' => 'Tidak ada tahapan yang relevan ditemukan.'], 404);
        }

        $currentTahapan = $tahapans->first(function ($tahapan) {
            return Carbon::parse($tahapan->pivot->tanggal_mulai) <= now() &&
                   Carbon::parse($tahapan->pivot->tanggal_akhir)->endOfDay() >= now();
        });
        
        if (!$currentTahapan) {
            \Log::error('Tahapan saat ini tidak ditemukan.', [
                'validasi_tahapan_id' => $currentValidasi->tahapan_id,
                'tahapan_ids' => $tahapans->pluck('id')->toArray(),
            ]);
            return response()->json(['message' => 'Tahapan saat ini tidak ditemukan.'], 404);
        }

        // Tentukan tahapan berikutnya berdasarkan urutan
        $nextTahapan = $tahapans->first(function ($tahapan) use ($currentTahapan) {
            return $tahapan->pivot->tanggal_mulai > $currentTahapan->pivot->tanggal_mulai;
        });
        
        if (!$nextTahapan) {
            \Log::info('Tidak ada tahapan berikutnya.', ['current_tahapan' => $currentTahapan->toArray()]);
        }

        \Log::info('Tahapan saat ini:', ['currentTahapan' => $currentTahapan]);

        if ($action === 'tolak') {
            $currentValidasi->update(['status' => 'ditolak']);
            $pendaftaran->update(['status' => 'ditolak']);
            return response()->json(['message' => 'Validasi telah ditolak dan tidak dilanjutkan.']);
        }

        if ($action === 'setuju') {
            $currentValidasi->update(['status' => 'disetujui']);

            $nextValidasi = ValidasiPendaftaranMahasiswa::where('pendaftaran_id', $pendaftaranId)
                ->where('urutan', '>', $currentValidasi->urutan)
                ->orderBy('urutan')
                ->first();

            $totalRoles = ValidasiPendaftaranMahasiswa::where('pendaftaran_id', $pendaftaranId)
                ->distinct('role_id')
                ->count('role_id');

            if ($totalRoles === 1) {
                // Periksa apakah ini tahapan terakhir
                if (!$nextTahapan || !Str::startsWith(strtolower($nextTahapan->nama_tahapan), 'seleksi')) {
                    $pendaftaran->update(['status' => 'diterima']);
                    return response()->json(['message' => 'Validasi disetujui, status pendaftaran diterima.']);
                
                } else {
                    $pendaftaran->update(['status' => "lulus {$currentTahapan->nama_tahapan}"]);
                    return response()->json(['message' => "Validasi disetujui, status pendaftaran menjadi lulus {$currentTahapan->nama_tahapan}."]);
                }
            } else {
                if ($nextTahapan) {
                    if ($nextValidasi) {
                        $nextValidasi->update(['status' => 'diproses']);
                        $pendaftaran->update(['status' => 'diproses']);
                        return response()->json(['message' => "Validasi disetujui oleh role ini, dilanjutkan ke role berikutnya"]);
                    } else {
                        $pendaftaran->update(['status' => "lulus {$currentTahapan->nama_tahapan}"]);
                        return response()->json(['message' => "Validasi disetujui oleh semua role, status menjadi lulus {$currentTahapan->nama_tahapan}."]);
                    }
                } else {
                    if ($nextValidasi) {
                        $nextValidasi->update(['status' => 'diproses']);
                        $pendaftaran->update(['status' => 'diproses']);
                        return response()->json(['message' => 'Validasi disetujui oleh role ini, dilanjutkan ke role berikutnya. Status: diproses.']);
                    } else {
                        $pendaftaran->update(['status' => 'diterima']);
                        return response()->json(['message' => 'Validasi disetujui oleh semua role, status pendaftaran diterima.']);
                    }
                }
            }
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
}
