<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\BuatPendaftaranBeasiswa;
use App\Models\PendaftaranBeasiswa;
use App\Models\DetailUser;
use App\Models\BerkasPendaftaran;
use App\Models\ValidasiPendaftaranBeasiswa;
use App\Models\ValidasiPendaftaranMahasiswa;
use App\Models\FileUpload;
use App\Models\User;
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
        
        $buatPendaftaran = BuatPendaftaranBeasiswa::with('beasiswa')->get();

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

    public function filter(Request $request)
    {
        $status = $request->get('status');
        $currentDate = now();
    
        // Ambil pendaftaran beasiswa dengan query yang tepat
        $buatPendaftaran = BuatPendaftaranBeasiswa::with('beasiswa');
    
        if ($status == 'dibuka') {
            // Beasiswa yang sedang aktif
            $buatPendaftaran->where('tanggal_mulai', '<=', $currentDate)
                            ->where('tanggal_berakhir', '>=', $currentDate);
        } elseif ($status == 'ditutup') {
            // Beasiswa yang sudah berakhir atau belum dimulai
            $buatPendaftaran->where(function ($query) use ($currentDate) {
                $query->where('tanggal_berakhir', '<', $currentDate) // Sudah berakhir
                      ->orWhere('tanggal_mulai', '>', $currentDate); // Belum dimulai
            });
        }
    
        $buatPendaftaran = $buatPendaftaran->get();
    
        // Kembalikan view partial
        return view('beasiswa.pendaftaran_beasiswa_partial', compact('buatPendaftaran'))->render();
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

        // Ambil data pendaftaran beserta relasi terkait
        $buatPendaftaran = BuatPendaftaranBeasiswa::with('persyaratan', 'beasiswa', 'berkasPendaftarans')->findOrFail($pendaftaranId);
        
        // Cek jenis beasiswa (internal atau eksternal)
        if ($buatPendaftaran->jenis_beasiswa === 'eksternal') {
            // Logika untuk beasiswa eksternal
            return view('beasiswa.beasiswa_eksternal', compact('buatPendaftaran'));
        }

        // Hanya beasiswa internal yang sampai di bawah untuk pengecekan tambahan
        $tahunPendaftaran = \Carbon\Carbon::parse($buatPendaftaran->tahun);

        // Cek apakah mahasiswa sudah mendaftar pada beasiswa internal lain di tahun yang sama
        $existingPendaftaran = PendaftaranBeasiswa::where('user_id', $user->id)
            ->whereHas('buatPendaftaranBeasiswa', function ($query) use ($tahunPendaftaran) {
                $query->where('jenis_beasiswa', 'internal')
                    ->whereYear('tahun', $tahunPendaftaran);
            })
            ->exists();

        // Jika mahasiswa sudah terdaftar di beasiswa internal lain pada tahun yang sama
        if ($existingPendaftaran) {
            $alertMessage = "Anda sudah terdaftar pada beasiswa internal lain pada tahun $tahunPendaftaran. Anda tidak dapat mendaftar pada beasiswa ini.";
            $showForm = false;
        } else {
            // Cek apakah user sudah mengisi form pendaftaran sebelumnya
            $pendaftaranUser = $buatPendaftaran->pendaftaranBeasiswa()->where('user_id', $user->id)->first();

            // Ambil tahapan pendaftaran beasiswa dari tahapan yang sudah di-set
            $tahapanAdministrasi = $buatPendaftaran->tahapan()->where('nama_tahapan', 'Pendaftaran Beasiswa')->first();

            // Cek jika tahapan seleksi administrasi tidak ada
            if (!$tahapanAdministrasi) {
                return view('beasiswa.daftar')->withErrors('Tahapan pendaftaran beasiswa tidak ditemukan');
            }

            // Parse tanggal mulai dan berakhir sebagai objek Carbon
            $currentDate = now();
            $tahapanDimulai = \Carbon\Carbon::parse($tahapanAdministrasi->pivot->tanggal_mulai);
            $tahapanBerakhir = \Carbon\Carbon::parse($tahapanAdministrasi->pivot->tanggal_akhir)->endOfDay();

            // Kondisi untuk menentukan tampilan
            $showForm = false;
            $alertMessage = null;

            if ($pendaftaranUser) {
                // User sudah mengisi form pendaftaran sebelumnya
                $alertMessage = "Anda sudah mengisi form pendaftaran, harap menunggu informasi lebih lanjut.";
            } elseif ($currentDate->lt($tahapanDimulai)) {
                // Belum memasuki tahapan pendaftaran beasiswa
                $alertMessage = "Pendaftaran beasiswa belum dibuka. Anda dapat mengisi form pendaftaran setelah tanggal " . $tahapanDimulai->format('d M Y') . ".";
            } elseif ($currentDate->gt($tahapanBerakhir)) {
                // Tahapan pendaftaran beasiswa sudah berakhir
                $alertMessage = "Tahapan pendaftaran beasiswa sudah berakhir. Anda tidak bisa mengisi form pendaftaran lagi.";
            } else {
                // Tahapan pendaftaran beasiswa sedang berlangsung, tampilkan form
                $showForm = true;
            }
        }

        // Ambil semua persyaratan dari database
        $persyaratan = $buatPendaftaran->persyaratan;

        // Proses validasi persyaratan
        $hasilValidasi = $this->validasiPersyaratan($persyaratan, $detailUser);

        // Cek apakah semua persyaratan terpenuhi
        $semuaTerpenuhi = collect($hasilValidasi)->every(fn($p) => $p['status'] === true);

        // Ambil berkas yang terkait
        $berkasPendaftaran = $buatPendaftaran->berkasPendaftarans;
        $templatePath = $buatPendaftaran->template_path ? asset('storage/' . $buatPendaftaran->template_path) : null;

        // Kembalikan view dengan data pendaftaran, persyaratan, dan template_path
        return view('beasiswa.daftar', compact(
            'buatPendaftaran', 'hasilValidasi', 'semuaTerpenuhi', 
            'berkasPendaftaran', 'templatePath', 'alertMessage', 'showForm', 'persyaratan'
        ));
    }
 
    /**
     * Fungsi untuk memvalidasi persyaratan secara dinamis.
     */
    private function validasiPersyaratan($persyaratan, $detailUser)
    {
        $result = [];

        foreach ($persyaratan as $syarat) {
            $kriteria = $syarat->kriteria;
            if (!$kriteria) {
                $result[] = [
                    'nama' => $syarat->nama_persyaratan,
                    'status' => false,
                    'message' => "Kriteria '{$syarat->nama_persyaratan}' tidak ditemukan atau tidak terhubung dengan field yang valid.",
                ];
                continue;
            }

            $userValue = $detailUser->{$kriteria->key_detail_user} ?? null; // Ambil nilai user sesuai key_detail_user
            $operator = $syarat->operator;
            $value = $syarat->value ? json_decode($syarat->value, true) : null;    

            $isValid = false;

            // Validasi berdasarkan tipe input
            switch ($kriteria->tipe_input) {
                case 'dropdown':
                    // Jika tipe dropdown, cek apakah userValue ada dalam array value
                    if (is_array($value)) {
                        $isValid = in_array($userValue, $value);
                    } else {
                        $isValid = false;
                    }
                    break;
                case 'number':
                case 'text':
                    // Jika tipe number/text, bandingkan dengan operator
                    if ($operator) {
                        $isValid = $this->compareValues($userValue, $operator, $value);
                    }
                    break;    
                default:
                    $isValid = false;
            }

            $result[] = [
                'nama' => $syarat->nama_persyaratan,
                'status' => $isValid,  // true jika valid
                'message' => $isValid 
                    ? "Persyaratan terpenuhi" 
                    : "Persyaratan tidak terpenuhi: $syarat->nama_persyaratan",
            ];
        }

        return $result;
    }

    /**
     * Fungsi untuk membandingkan nilai berdasarkan operator.
     */
    private function compareValues($userValue, $operator, $value)
    {
        switch ($operator) {
            case '>=':
                return $userValue >= $value;
            case '<=':
                return $userValue <= $value;
            case '=':
                return $userValue == $value;
            case '>':
                return $userValue > $value;
            case '<':
                return $userValue < $value;
            case '!=':
                return $userValue != $value;
            default:
                return false;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request, $buatPendaftaranId)
    {
        // Validasi input mahasiswa
        $validate = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'nim' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'IPK' => 'required|numeric|between:0,4.00',
            'semester' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',
            'telepon' => 'required|string|max:20',
            'berkas.*' => 'required|file|mimes:pdf,jpeg,png|max:2048',
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }

        Log::info('Validasi berhasil');

         // Ambil data beasiswa dan tahun
         $existingPendaftaran = PendaftaranBeasiswa::where('user_id', auth()->id())
         ->where('buat_pendaftaran_beasiswa_id', $buatPendaftaranId)
         ->exists();
 
         // Cek jika mahasiswa sudah mendaftar di beasiswa ini
         if ($existingPendaftaran) {
             Log::info('Mahasiswa sudah mendaftar pada beasiswa ini.');
             return response()->json([
                 'success' => false,
                 'alertMessage' => "Anda sudah mengisi form pendaftaran, harap menunggu informasi lebih lanjut."
             ]);
         }

        $buatPendaftaran = BuatPendaftaranBeasiswa::findOrFail($buatPendaftaranId);
        $tahunPendaftaran = \Carbon\Carbon::parse($buatPendaftaran->tanggal_mulai)->year;

        // $user = auth()->user();

        // Cek jika sudah mendaftar di beasiswa internal lain pada tahun yang sama
        $existingPendaftaranTahunSama = PendaftaranBeasiswa::where('user_id', auth()->id())
        ->whereHas('buatPendaftaranBeasiswa', function ($query) use ($tahunPendaftaran, $buatPendaftaranId) {
            $query->where('jenis_beasiswa', 'internal')
                ->whereYear('tanggal_mulai', $tahunPendaftaran)
                ->where('id', '!=', $buatPendaftaranId);
        })
        ->exists();
        
        if ($existingPendaftaranTahunSama) {
            Log::info('Mahasiswa sudah terdaftar pada beasiswa internal lain.');
            return response()->json([
                'success' => false,
                'alertMessage' => "Anda sudah terdaftar pada beasiswa internal lain pada tahun $tahunPendaftaran. Anda tidak dapat mendaftar pada beasiswa ini."
            ]);
        
        }

        Log::info('Mahasiswa dapat mendaftar.');

        // Simpan pendaftaran mahasiswa
        try {
            $pendaftaran = PendaftaranBeasiswa::create([
                'nama_lengkap' => $request->nama_lengkap,
                'nim' => $request->nim,
                'fakultas' => $request->fakultas,
                'jurusan' => $request->jurusan,
                'alamat_lengkap' => $request->alamat_lengkap,
                'telepon' => $request->telepon,
                'IPK' => $request->IPK,
                'semester' => $request->semester,
                'user_id' => auth()->user()->id,
                'buat_pendaftaran_beasiswa_id' => $buatPendaftaranId,
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan pendaftaran', ['message' => $e->getMessage()]);
            return back()->with('error', 'Gagal menyimpan data.');
        }

        // Ambil data beasiswa dan berkas yang sedang dibuat
        $buatPendaftaran = BuatPendaftaranBeasiswa::with('berkasPendaftarans')->findOrFail($buatPendaftaranId);
        $berkasPendaftaran = $buatPendaftaran->berkasPendaftarans;
        // Simpan berkas yang diunggah
        try {
            foreach ($request->file('berkas') as $berkasId => $file) {
                // Temukan berkas sesuai koleksi pada database $berkasPendaftarans
                $berkasPendaftaran = $berkasPendaftaran->firstWhere('id', $berkasId);
            
                if ($berkasPendaftaran) {
                    $path = $file->store('file_uploads', 'public');
            
                    FileUpload::create([
                        'pendaftaran_beasiswas_id' => $pendaftaran->id,
                        'berkas_pendaftaran_id' => $berkasPendaftaran->id,
                        'file_path' => $path,
                    ]);
                }
            }
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan berkas.');
        }

        /// Ambil template validasi berdasarkan buat_pendaftaran_id
        $templateValidasi = ValidasiPendaftaranBeasiswa::where('buat_pendaftaran_id', $buatPendaftaranId)->get();

        // Buat validasi untuk mahasiswa berdasarkan template
        foreach ($templateValidasi as $validasi) {
            ValidasiPendaftaranMahasiswa::create([
                'pendaftaran_id' => $pendaftaran->id,
                'role_id' => $validasi->role_id,
                'urutan' => $validasi->urutan,
                'status' => 'menunggu',  // Status awal validasi
            ]);
        }

        // Jika berhasil menyimpan data
         return response()->json([
            'success' => "Berhasil menyimpan data",
            'alertMessage' => "Anda sudah mengisi form pendaftaran, harap menunggu informasi lebih lanjut pada menu riwayat usulan"
        ]);
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
