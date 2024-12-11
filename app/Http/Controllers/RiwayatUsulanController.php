<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PendaftaranBeasiswa;
use Illuminate\Support\Facades\Log;
use App\Models\BuatPendaftaranBeasiswa;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RiwayatUsulanController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read beasiswa/riwayat_usulan')->only('index');
    }

    /**
    * Menampilkan halaman riwayat usulan beasiswa untuk mahasiswa yang sedang login.
    */
    // public function index(Request $request)
    // {
    //     $user = auth()->user();
    
    //     // Ambil data pendaftaran beasiswa dengan relasi yang sesuai
    //     $pendaftaranBeasiswa = PendaftaranBeasiswa::with('buatPendaftaranBeasiswa.beasiswa', 'buatPendaftaranBeasiswa.tahapan')
    //                                 ->where('user_id', $user->id)
    //                                 ->orderBy('created_at', 'desc')
    //                                 ->get();
    
    //     // Cek apakah permintaan adalah AJAX (untuk DataTables)
    //     if ($request->ajax()) {
    //         $data = $pendaftaranBeasiswa->map(function ($item) {
    //             $currentDate = now();
    //             $statusTampilan = $item->status; // Default ke status dari database
    
    //             // Tentukan status tampilan sesuai dengan logika di fungsi show
    //             foreach ($item->buatPendaftaranBeasiswa->tahapan as $tahapan) {
    //                 $tahapanMulai = \Carbon\Carbon::parse($tahapan->pivot->tanggal_mulai);
    //                 $tahapanBerakhir = \Carbon\Carbon::parse($tahapan->pivot->tanggal_akhir)->endOfDay();
    
    //                 // Cek apakah tahapan ini sedang berlangsung
    //                 if ($currentDate->between($tahapanMulai, $tahapanBerakhir)) {
    //                     $currentTahapan = $tahapan->nama_tahapan;
    
    //                     // Logika untuk menentukan status tampilan
    //                     if (!str_contains(strtolower($currentTahapan), 'pengumuman')) {
    //                         // Jika belum tahapan pengumuman, gunakan status asli dari database
    //                         $statusTampilan = 'diproses';
    //                     } elseif (str_contains(strtolower($currentTahapan), 'pengumuman')) {
    //                         // Jika di tahapan pengumuman dan status masih menunggu atau diproses, tampilkan status asli dari database
    //                         if (in_array($item->status, ['menunggu', 'diproses'])) {
    //                             $statusTampilan = $item->status;
    //                         } else {
    //                             // Jika di tahapan pengumuman dan status sudah bukan menunggu/diproses, sesuaikan dengan tahapan pengumuman yang sedang berlangsung
    //                             switch ($currentTahapan) {
    //                                 case 'Pengumuman seleksi administrasi':
    //                                     $statusTampilan = 'lulus seleksi administrasi';
    //                                     break;
    //                                 case 'Pengumuman Seleksi Wawancara':
    //                                     $statusTampilan = 'lulus seleksi wawancara';
    //                                     break;
    //                                 case 'Pengumuman Seleksi Tertulis':
    //                                     $statusTampilan = 'lulus seleksi tertulis';
    //                                     break;
    //                                 case 'Pengumuman Akhir':
    //                                     $statusTampilan = 'lulus semua tahapan';
    //                                     break;
    //                             }
    //                         }
    //                     }
    //                     break; // Hentikan loop jika sudah menemukan tahapan saat ini
    //                 }
    //             }
    
    //             return [
    //                 'id' => $item->id,
    //                 'nama_beasiswa' => $item->buatPendaftaranBeasiswa->beasiswa->nama_beasiswa ?? '-',
    //                 'nama_lengkap' => $item->nama_lengkap,
    //                 'nim' => $item->nim,
    //                 'fakultas' => $item->fakultas,
    //                 'jurusan' => $item->jurusan,
    //                 'status' => $statusTampilan, // Gunakan status tampilan
    //             ];
    //         });
    
    //         return DataTables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('aksi', function ($data) {
    //                 return view('beasiswa.tombol_riwayat', compact('data'));
    //             })
    //             ->make(true);
    //     }
    
    //     // Kembalikan view jika bukan permintaan AJAX
    //     return view('beasiswa.riwayat_usulan', compact('pendaftaranBeasiswa'));
    // }  
    public function index(Request $request) 
    {
        $user = auth()->user();

        // Ambil data pendaftaran beasiswa dengan relasi yang sesuai
        $pendaftaranBeasiswa = PendaftaranBeasiswa::with('buatPendaftaranBeasiswa.beasiswa', 'buatPendaftaranBeasiswa.tahapan')
                                    ->where('user_id', $user->id)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        // Cek apakah permintaan adalah AJAX (untuk DataTables)
        if ($request->ajax()) {
            $data = $pendaftaranBeasiswa->map(function ($item) {
                $currentDate = now();
                
                // Jika status database adalah "ditolak", langsung set tampilan ke "ditolak" tanpa memproses tahapan lainnya
                if ($item->status === 'ditolak') {
                    return [
                        'id' => $item->id,
                        'nama_beasiswa' => $item->buatPendaftaranBeasiswa->beasiswa->nama_beasiswa ?? '-',
                        'nama_lengkap' => $item->nama_lengkap,
                        'nim' => $item->nim,
                        'fakultas' => $item->fakultas,
                        'jurusan' => $item->jurusan,
                        'status' => 'ditolak', // Langsung set status tampilan ke "ditolak"
                    ];
                }

                return [
                    'id' => $item->id,
                    'nama_beasiswa' => $item->buatPendaftaranBeasiswa->beasiswa->nama_beasiswa ?? '-',
                    'nama_lengkap' => $item->nama_lengkap,
                    'nim' => $item->nim,
                    'fakultas' => $item->fakultas,
                    'jurusan' => $item->jurusan,
                    'status' => $item->status, // Gunakan status tampilan
                ];
            });

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($data) {
                    return view('beasiswa.tombol_riwayat', compact('data'));
                })
                ->make(true);
        }

        // Kembalikan view jika bukan permintaan AJAX
        return view('beasiswa.riwayat_usulan', compact('pendaftaranBeasiswa'));
    }
  
    public function show($id)
    {
        // Ambil data pendaftaran berdasarkan ID, termasuk relasi buatPendaftaranBeasiswa dan beasiswa
        $pendaftaran = PendaftaranBeasiswa::with([
            'buatPendaftaranBeasiswa.tahapan',
            'buatPendaftaranBeasiswa.beasiswa',
            'fileUploads.berkasPendaftaran',
            'interview'
        ])->findOrFail($id);

        // Ambil nama beasiswa dari data relasi
        $namaBeasiswa = $pendaftaran->buatPendaftaranBeasiswa->beasiswa->nama_beasiswa ?? 'Tidak diketahui';

        // Ambil data tahapan beasiswa untuk ditampilkan dalam tabs
        $tahapans = $pendaftaran->buatPendaftaranBeasiswa->tahapan->map(function ($tahapan) {
            return [
                'nama_tahapan' => $tahapan->nama_tahapan,
                'tanggal_mulai' => $tahapan->pivot->tanggal_mulai ? Carbon::parse($tahapan->pivot->tanggal_mulai)->format('Y-m-d') : null,
                'tanggal_akhir' => $tahapan->pivot->tanggal_akhir ? Carbon::parse($tahapan->pivot->tanggal_akhir)->format('Y-m-d') : null,
            ];
        });

        if ($pendaftaran->status === 'diterima') {
        $statusUsulanAwal = 'diterima';
        } elseif ($pendaftaran->status === 'ditolak') {
            $statusUsulanAwal = 'ditolak';
        } elseif ($pendaftaran->status === 'lulus seleksi administrasi' || $pendaftaran->pendaftaran->status === 'lulus seleksi wawancara') {
            $statusUsulanAwal = 'lulus seleksi administrasi';
        } else {
            $statusUsulanAwal = $pendaftaran->status;
        }
 
        // Ambil status langsung dari data pendaftaran
        $statusTampilan = $pendaftaran->status;

        // Ambil berkas yang diunggah oleh mahasiswa dan tampilkan dengan informasi file
        $berkasUploadMahasiswa = $pendaftaran->fileUploads->map(function ($fileUpload) {
            return [
                'nama_file' => $fileUpload->berkasPendaftaran->nama_file ?? 'Tidak diketahui',
                'file_path' => basename($fileUpload->file_path),
                'lihat_path' => asset('storage/' . $fileUpload->file_path),
            ];
        });

        // Ambil data wawancara yang sudah diisi
        $wawancara = null;
        if ($pendaftaran->interview) {
            // Ambil ID pewawancara
            $pewawancaraIds = $pendaftaran->interview->pewawancara_ids;

            // Dapatkan nama pewawancara dari model User, berdasarkan pewawancara_ids
            $pewawancaraNames = User::whereIn('id', $pewawancaraIds)->pluck('name')->toArray();

            // Isi array wawancara dengan data lengkap termasuk nama pewawancara
            $wawancara = [
                'tanggal_mulai' => $pendaftaran->interview->tanggal_mulai,
                'tanggal_akhir' => $pendaftaran->interview->tanggal_akhir,
                'jam_wawancara' => $pendaftaran->interview->jam_wawancara,
                'lokasi' => $pendaftaran->interview->lokasi,
                'pewawancara_ids' => $pewawancaraNames,  // Menggunakan nama pewawancara
            ];
        }

        return view('beasiswa.detail_riwayat', compact(
            'pendaftaran', 
            'berkasUploadMahasiswa', 
            'namaBeasiswa', 
            'statusTampilan', 
            'tahapans',
            'statusUsulanAwal',
            'wawancara' 
        ));
    }
    
    
        // public function show($id)
    // {
    //     // Ambil data pendaftaran berdasarkan ID, termasuk relasi buatPendaftaranBeasiswa dan beasiswa
    //     $pendaftaranBeasiswa = PendaftaranBeasiswa::with([
    //         'buatPendaftaranBeasiswa.tahapan', // Relasi tahapan
    //         'buatPendaftaranBeasiswa.beasiswa', // Relasi buatPendaftaranBeasiswa
    //         'fileUploads.berkasPendaftaran' // File uploads mahasiswa
    //     ])->findOrFail($id);
    
    //     $namaBeasiswa = $pendaftaranBeasiswa->buatPendaftaranBeasiswa->beasiswa->nama_beasiswa ?? 'Tidak diketahui';
    
    //     $currentDate = now()->format('Y-m-d');
    //     $currentTahapan = null;
    //     $nextTahapan = null;
    //     $isLastStage = false;
    
    //     $tahapans = $pendaftaranBeasiswa->buatPendaftaranBeasiswa->tahapan;
    //     $statusTampilan = $pendaftaranBeasiswa->status; // Status default dari database
    
    //     foreach ($tahapans as $index => $tahapan) {
    //         $tahapanMulai = \Carbon\Carbon::parse($tahapan->pivot->tanggal_mulai);
    //         $tahapanBerakhir = \Carbon\Carbon::parse($tahapan->pivot->tanggal_akhir)->endOfDay();
        
    //         // Cek apakah tanggal saat ini ada dalam rentang tahapan ini
    //         if (now()->between($tahapanMulai, $tahapanBerakhir)) {
    //             $currentTahapan = $tahapan->nama_tahapan;
    //             $isLastStage = ($index === $tahapans->count() - 1);
    //             $nextTahapan = $tahapans->get($index + 1) ?? null;
        
    //             // Tentukan status tampilan hanya jika status di database sudah divalidasi
    //             if ($pendaftaranBeasiswa->status !== 'menunggu') { // Pastikan status sudah divalidasi
    //                 if ($currentTahapan === 'Pengumuman seleksi administrasi') {
    //                     $statusTampilan = 'lulus seleksi administrasi';
    //                 } elseif ($currentTahapan === 'Pengumuman Seleksi Wawancara') {
    //                     $statusTampilan = 'lulus seleksi wawancara';
    //                 } elseif ($currentTahapan === 'Pengumuman Seleksi Tertulis') {
    //                     $statusTampilan = 'lulus seleksi tertulis';
    //                 } elseif ($currentTahapan === 'Pengumuman Akhir') {
    //                     $statusTampilan = 'lulus semua tahapan';
    //                 }
    //             }
    //             break; // Hentikan loop jika menemukan tahapan yang sesuai
    //         }
    //     }
    
    //     // Filter hanya berkas yang diunggah oleh mahasiswa
    //     $berkasUploadMahasiswa = $pendaftaranBeasiswa->fileUploads->map(function ($fileUpload) {
    //         return [
    //             'nama_file' => $fileUpload->berkasPendaftaran->nama_file ?? 'Tidak diketahui',
    //             'file_path' => basename($fileUpload->file_path),
    //             'lihat_path' => asset('storage/' . $fileUpload->file_path),
    //         ];
    //     });
    
    //     return view('beasiswa.detail_riwayat', compact(
    //         'pendaftaranBeasiswa', 
    //         'berkasUploadMahasiswa', 
    //         'namaBeasiswa', 
    //         'currentTahapan', 
    //         'nextTahapan', 
    //         'statusTampilan'
    //     ));
    // }
}    
