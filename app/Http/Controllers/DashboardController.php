<?php

namespace App\Http\Controllers;

use App\Models\DataPenerima;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\PendaftaranBeasiswa;
use App\Models\ValidasiPendaftaranMahasiswa;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Logika dashboard berdasarkan role
        if ($user->hasRole('Super Admin')) {
            return $this->dashboardSuperAdmin();
        }

        if ($user->hasRole('Operator Kemahasiswaan')) {
            return $this->dashboardOperatorKemahasiswaan();
        }

        if ($user->hasRole('Operator Fakultas')) {
            return $this->dashboardOperatorFakultas();
        }

        if ($user->hasRole('Mahasiswa')) {
            return $this->dashboardMahasiswa();
        }

        abort(403, 'Anda tidak memiliki akses ke dashboard.');
    }

    private function dashboardSuperAdmin()
    {
         // Ambil data pengguna yang sedang login beserta rolenya
        $user = auth()->user();
        $roles = $user->getRoleNames(); // Mengambil role menggunakan Spatie

        // Kirim data ke tampilan dashboard mahasiswa
        return view('dashboard.super_admin', compact('user', 'roles'));
    }

    private function dashboardOperatorKemahasiswaan()
    {
        // Ambil data pengguna yang sedang login beserta rolenya
        $user = auth()->user();
        $roles = $user->getRoleNames(); // Mengambil semua role menggunakan Spatie

        // Ambil role pertama pengguna
        $role = $user->roles->first();

        // Logika untuk menghitung jumlah usulan beasiswa yang perlu divalidasi
        $jumlahUsulan = ValidasiPendaftaranMahasiswa::with(['pendaftaran.validasi'])
            ->where('role_id', $role->id)
            ->whereIn('status', ['menunggu', 'diproses']) // Hanya hitung data yang belum selesai
            ->where(function ($query) {
                $query->where('urutan', 1) // Hanya data untuk role pertama
                    ->orWhereHas('pendaftaran.validasi', function ($subQuery) {
                        // Memastikan data muncul di role berikutnya hanya jika role sebelumnya sudah disetujui
                        $subQuery->where('status', 'disetujui');
                    });
            })
            ->where(function ($query) {
                // Memastikan giliran validasi saat ini sesuai dengan role user
                $query->whereNotExists(function ($subQuery) {
                    $subQuery->select('id')
                        ->from('validasi_pendaftaran_mahasiswas as vp')
                        ->whereRaw('vp.pendaftaran_id = validasi_pendaftaran_mahasiswas.pendaftaran_id')
                        ->whereRaw('vp.urutan < validasi_pendaftaran_mahasiswas.urutan')
                        ->where('vp.status', '!=', 'disetujui');
                });
            })
            ->count(); // Menghitung jumlah data yang valid
            
            // Jika role lebih dari satu dan role pertama belum menyetujui, set jumlah usulan menjadi 0
            if ($roles->count() > 1 && !$this->rolePertamaDisetujui($role)) {
                $jumlahUsulan = 0;
            }

        // Logika untuk menghitung jumlah beasiswa yang disetujui
        $jumlahTervalidasi = ValidasiPendaftaranMahasiswa::with(['pendaftaran.validasi'])
            ->where('role_id', $role->id)
            ->where('status', 'disetujui') // Hanya data dengan status disetujui
            ->count();

        // Hitung jumlah data penerima dengan status "Sedang Menerima"
        $jumlahPenerima = DataPenerima::where('status_penerima', 'Sedang Menerima')->count();

        // Ambil data untuk grafik jumlah penerima beasiswa per tahun
        $chartData = DB::table('data_penerimas')
        ->join('pendaftaran_beasiswas', 'data_penerimas.pendaftaran_beasiswa_id', '=', 'pendaftaran_beasiswas.id')
        ->join('buat_pendaftaran_beasiswas', 'pendaftaran_beasiswas.buat_pendaftaran_beasiswa_id', '=', 'buat_pendaftaran_beasiswas.id')
        ->select(
            'buat_pendaftaran_beasiswas.tahun',
            DB::raw('COUNT(data_penerimas.id) as jumlah') // Hitung jumlah penerima per tahun
        )
        ->groupBy('buat_pendaftaran_beasiswas.tahun')
        ->orderBy('buat_pendaftaran_beasiswas.tahun', 'asc') // Urutkan berdasarkan tahun
        ->get();    

        // Pisahkan label dan data
        $chartLabels = $chartData->pluck('tahun')->toArray();
        $chartData = $chartData->pluck('jumlah')->toArray();

        // Kirim data ke tampilan dashboard
        return view('dashboard.operator_kemahasiswaan', compact('user', 'roles', 'jumlahUsulan', 'jumlahTervalidasi', 'jumlahPenerima', 'chartData', 'chartLabels'));
    }
    
    /**
     * Periksa apakah role pertama sudah menyetujui.
     *
     * @param Role $role
     * @return bool
     */
    private function rolePertamaDisetujui($role)
    {
        return ValidasiPendaftaranMahasiswa::where('role_id', $role->id)
            ->where('urutan', 1)
            ->where('status', 'disetujui')
            ->exists();
    }
        
    private function dashboardOperatorFakultas()
    {
        // Ambil data pengguna yang sedang login beserta rolenya
        $user = auth()->user();
        $roles = $user->getRoleNames(); // Mengambil semua role menggunakan Spatie

        // Ambil role pertama pengguna
        $role = $user->roles->first();

        // Logika untuk menghitung jumlah usulan beasiswa yang perlu divalidasi
        $jumlahUsulan = ValidasiPendaftaranMahasiswa::with(['pendaftaran.validasi'])
            ->where('role_id', $role->id)
            ->whereIn('status', ['menunggu', 'diproses']) // Hanya hitung data yang belum selesai
            ->where(function ($query) {
                $query->where('urutan', 1) // Hanya data untuk role pertama
                    ->orWhereHas('pendaftaran.validasi', function ($subQuery) {
                        // Memastikan data muncul di role berikutnya hanya jika role sebelumnya sudah disetujui
                        $subQuery->where('status', 'disetujui');
                    });
            })
            ->where(function ($query) {
                // Memastikan giliran validasi saat ini sesuai dengan role user
                $query->whereNotExists(function ($subQuery) {
                    $subQuery->select('id')
                        ->from('validasi_pendaftaran_mahasiswas as vp')
                        ->whereRaw('vp.pendaftaran_id = validasi_pendaftaran_mahasiswas.pendaftaran_id')
                        ->whereRaw('vp.urutan < validasi_pendaftaran_mahasiswas.urutan')
                        ->where('vp.status', '!=', 'disetujui');
                });
            })
            ->count(); // Menghitung jumlah data yang valid

        // Logika untuk menghitung jumlah beasiswa yang disetujui
        $jumlahTervalidasi = ValidasiPendaftaranMahasiswa::with(['pendaftaran.validasi'])
            ->where('role_id', $role->id)
            ->where('status', 'disetujui') // Hanya data dengan status disetujui
            ->count();

        // Jika role lebih dari satu dan role pertama belum menyetujui, set jumlah usulan menjadi 0
        if ($roles->count() > 1 && !$this->rolePertamaDisetujui($role)) {
            $jumlahUsulan = 0;
        }

        // Hitung jumlah data penerima dengan status "Sedang Menerima"
        $jumlahPenerima = DataPenerima::where('status_penerima', 'Sedang Menerima')->count();
        // Logika data untuk operator kemahasiswaan
        return view('dashboard.operator_fakultas', compact('user', 'roles', 'jumlahUsulan', 'jumlahTervalidasi', 'jumlahPenerima'));
    }

    private function dashboardMahasiswa()
    {
        // Ambil data pengguna yang sedang login beserta rolenya
        $user = auth()->user();
        $roles = $user->getRoleNames(); // Mengambil role menggunakan Spatie

        // Kirim data ke tampilan dashboard mahasiswa
        return view('dashboard.mahasiswa', compact('user', 'roles'));
    }
}
