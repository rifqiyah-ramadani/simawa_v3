<?php

namespace App\Http\Controllers;

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
    
            // Ambil data validasi yang sesuai dengan role user dan status yang relevan
            $validasiQuery = ValidasiPendaftaranMahasiswa::with(['pendaftaran.buatPendaftaranBeasiswa.beasiswa'])
                ->where('role_id', $role->id)
                ->whereIn('status', ['menunggu', 'diproses', 'disetujui', 'ditolak'])  // Filter status 'menunggu' dan 'diproses' untuk semua role
                ->orderBy('urutan');  // Urutkan sesuai urutan untuk memastikan tampilan yang terstruktur
    
            // Jalankan query untuk mendapatkan data validasi
            $validasi = $validasiQuery->get();
    
            // Mapping data untuk menambahkan nama beasiswa dan informasi lainnya
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
        $namaBeasiswa = $pendaftaran->pendaftaran->buatPendaftaranBeasiswa->beasiswa->nama_beasiswa  ?? 'Tidak diketahui';
    
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
                'tanggal_mulai' => $tahapan->pivot->tanggal_mulai,
                'tanggal_akhir' => $tahapan->pivot->tanggal_akhir,
            ];
        });
    
        return view('beasiswa.detail', compact('pendaftaran', 'berkasUploadMahasiswa', 'namaBeasiswa', 'tahapans'));
    }
    
    /**
     * Fungsi untuk status validasi berjenjang
     */
    public function lanjutkanValidasi(Request $request)
    {
        // Validasi input untuk memastikan bahwa action dan pendaftaranId benar
        $request->validate([
            'action' => 'required|in:setuju,tolak',
            'pendaftaranId' => 'required|exists:pendaftaran_beasiswas,id',
        ]);
    
        $action = $request->action;
        $pendaftaranId = $request->pendaftaranId;
    
        // Ambil user yang sedang login dan periksa role-nya
        $user = auth()->user();
        $roleId = $user->roles()->first()?->id;
    
        if (!$roleId) {
            return response()->json(['message' => 'Role user tidak ditemukan.'], 422);
        }
    
        // Cari validasi berdasarkan ID `pendaftaranId` dan `role_id` user saat ini
        $currentValidasi = ValidasiPendaftaranMahasiswa::where('pendaftaran_id', $pendaftaranId)
            ->where('role_id', $roleId)
            ->whereIn('status', ['diproses', 'menunggu'])
            ->firstOrFail();
    
        // Jika memilih untuk menyetujui
        if ($action === 'setuju') {
            // Set status menjadi 'disetujui' untuk validasi saat ini
            $currentValidasi->update(['status' => 'disetujui']);
    
            // Hitung jumlah total role untuk menentukan apakah hanya satu role yang terlibat
            $totalRoles = ValidasiPendaftaranMahasiswa::where('pendaftaran_id', $pendaftaranId)->distinct('role_id')->count('role_id');
    
            if ($totalRoles === 1) {
                // Jika hanya satu role validasi, set status langsung ke 'lulus seleksi administrasi' dan hentikan di sini
                PendaftaranBeasiswa::where('id', $pendaftaranId)->update(['status' => 'lulus seleksi administrasi']);
                return response()->json(['message' => 'Validasi berhasil disetujui dan status langsung diperbarui ke lulus seleksi administrasi.']);
            } 
    
            // Jika ada lebih dari satu role, lanjutkan ke role berikutnya jika ada
            $nextValidasi = ValidasiPendaftaranMahasiswa::where('pendaftaran_id', $pendaftaranId)
                ->where('urutan', '>', $currentValidasi->urutan)
                ->orderBy('urutan')
                ->first();
    
            if ($nextValidasi) {
                // Jika ada validasi berikutnya, set statusnya menjadi 'diproses'
                $nextValidasi->update(['status' => 'diproses']);
                // Perbarui status di `PendaftaranBeasiswa` menjadi 'diproses'
                PendaftaranBeasiswa::where('id', $pendaftaranId)->update(['status' => 'diproses']);
            } else {
                // Jika tidak ada validasi berikutnya, set status final
                $this->updateFinalPendaftaranStatus($pendaftaranId);
            }
    
            return response()->json(['message' => 'Validasi berhasil disetujui dan dilanjutkan ke role berikutnya.']);
        }

        // Jika memilih untuk menolak
        if ($action === 'tolak') {
            // Set status menjadi 'ditolak' dan perbarui pendaftaran
            $currentValidasi->update(['status' => 'ditolak']);
            PendaftaranBeasiswa::where('id', $pendaftaranId)->update(['status' => 'ditolak']);

            //  // Jika ada lebih dari satu role, lanjutkan ke role berikutnya jika ada
             $nextValidasi = ValidasiPendaftaranMahasiswa::where('pendaftaran_id', $pendaftaranId)
             ->where('urutan', '>', $currentValidasi->urutan)
             ->orderBy('urutan')
             ->first();

            if ($nextValidasi) {
            //     // Jika ada validasi berikutnya, set statusnya menjadi 'ditolak'
                $nextValidasi->update(['status' => 'ditolak']);
            //     // Perbarui status di `PendaftaranBeasiswa` menjadi 'ditolak'
            //     PendaftaranBeasiswa::where('id', $pendaftaranId)->update(['status' => 'ditolak']);
            }
        
            return response()->json(['message' => 'Validasi telah ditolak dan tidak dilanjutkan.']);
        }
    }
    
    
    /**
     * Update status final berdasarkan tahapan terakhir jika semua validasi selesai.
     */
    private function updateFinalPendaftaranStatus($pendaftaranId)
    {
        // Mencari data pendaftaran berdasarkan ID yang diberikan atau gagal jika tidak ditemukan
        $pendaftaran = PendaftaranBeasiswa::findOrFail($pendaftaranId);
    
        // Memeriksa status pendaftaran saat ini dan memperbarui ke tahap berikutnya
        switch ($pendaftaran->status) {
            case 'diproses':
                // Jika status saat ini adalah 'diproses', ubah menjadi 'lulus seleksi administrasi'
                $pendaftaran->status = 'lulus seleksi administrasi';
                break;
            case 'lulus seleksi administrasi':
                // Jika status saat ini adalah 'lulus seleksi administrasi', ubah menjadi 'lulus seleksi wawancara'
                $pendaftaran->status = 'lulus seleksi wawancara';
                break;
            case 'lulus seleksi wawancara':
                // Jika status saat ini adalah 'lulus seleksi wawancara', ubah menjadi 'lulus seleksi tertulis'
                $pendaftaran->status = 'lulus seleksi tertulis';
                break;
            case 'lulus seleksi tertulis':
                // Jika status saat ini adalah 'lulus seleksi tertulis', ubah menjadi 'lulus semua tahapan' (status akhir)
                $pendaftaran->status = 'lulus semua tahapan';
                break;
        }
    
        // Menyimpan status pendaftaran yang telah diperbarui ke database
        $pendaftaran->save();
    }
}
