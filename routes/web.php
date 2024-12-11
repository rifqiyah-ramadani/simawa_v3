<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\ValidasiController;
use App\Http\Controllers\AksesRoleController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DataPenerimaController;
use App\Http\Controllers\RiwayatUsulanController;
use App\Http\Controllers\DaftarBeasiswaController;
use App\Http\Controllers\BuatPendaftaranController;
use App\Http\Controllers\TahapanBeasiswaController;
use App\Http\Controllers\BerkasPendaftaranController;
use App\Http\Controllers\PendaftaranBeasiswaController;
use App\Http\Controllers\PersyaratanBeasiswaController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/berita/{id}', [WelcomeController::class, 'show'])->name('berita.show');
Route::get('/search', [WelcomeController::class, 'search'])->name('search');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    // route konfigurasi
    Route::resource('konfigurasi/role', RoleController::class);
    Route::resource('konfigurasi/users', UserRoleController::class);
    Route::resource('konfigurasi/menu', NavigationController::class);
    Route::resource('konfigurasi/permission', PermissionController::class);

    // Group routes with a prefix and middleware if needed (optional)
    Route::prefix('/konfigurasi/akses_role')->name('akses_role.')->group(function () {
        // Tampilkan daftar roles dan permissions
        Route::get('/', [AksesRoleController::class, 'index'])->name('index');
    
        // Tampilkan form edit permissions untuk role tertentu
        Route::get('/{id}/edit', [AksesRoleController::class, 'edit'])->name('edit');
    
        // Update permissions untuk role tertentu
        Route::put('/{id}', [AksesRoleController::class, 'update'])->name('update');
    
        // Berikan role kepada user tertentu
        Route::post('/assign/{userId}', [AksesRoleController::class, 'assignRole'])->name('assign');
    
        // Hapus role dari user tertentu
        Route::delete('/remove/{userId}', [AksesRoleController::class, 'removeRole'])->name('remove');
    });

    // Rute dengan kategori sebagai parameter
    Route::prefix('master_informasi')->group(function () {
        Route::get('/berita', [InformasiController::class, 'indexBerita'])->name('berita.index');
        Route::get('/pengumuman', [InformasiController::class, 'indexPengumuman'])->name('pengumuman.index');
        
        Route::get('/{kategori}/create', [InformasiController::class, 'create'])->name('informasi.create');
        Route::post('/{kategori}/store', [InformasiController::class, 'store'])->name('informasi.store');
        Route::get('/{kategori}/{id}/edit', [InformasiController::class, 'edit'])
        ->where(['kategori' => 'berita|pengumuman', 'id' => '[0-9]+'])
        ->name('informasi.edit');
        Route::put('/{kategori}/{id}', [InformasiController::class, 'update'])
            ->where(['kategori' => 'berita|pengumuman', 'id' => '[0-9]+'])
            ->name('informasi.update');
        Route::delete('/{kategori}/{id}', [InformasiController::class, 'destroy'])
            ->where(['kategori' => 'berita|pengumuman', 'id' => '[0-9]+'])
            ->name('informasi.destroy');
    });

    // route kelola beasiswa
    Route::resource('master_beasiswa/daftar_beasiswa', DaftarBeasiswaController::class);

    Route::resource('master_beasiswa/persyaratan_beasiswa', PersyaratanBeasiswaController::class);
    // Route::get('master_beasiswa/persyaratan_beasiswa', [KriteriaController::class, 'index'])->name('kriteria.index');
    Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
    Route::get('/kriteria/create', [KriteriaController::class, 'create'])->name('kriteria.create');
    Route::post('/kriteria', [KriteriaController::class, 'store'])->name('kriteria.store');
    Route::put('/kriteria/{id}', [KriteriaController::class, 'update'])->name('kriteria.update');
    Route::delete('/kriteria/{id}', [KriteriaController::class, 'destroy'])->name('kriteria.destroy');


    Route::resource('master_beasiswa/berkas_pendaftaran', BerkasPendaftaranController::class);
    Route::resource('master_beasiswa/tahapan_beasiswa', TahapanBeasiswaController::class);

    Route::resource('kelola_beasiswa/manajemen_pendaftaran', BuatPendaftaranController::class);
    
    //Route mahasiswa beasiswa
    Route::get('beasiswa/pendaftaran_beasiswa/filter', [PendaftaranBeasiswaController::class, 'filter'])->name('filter.pendaftaran');
    
    Route::resource('beasiswa/pendaftaran_beasiswa', PendaftaranBeasiswaController::class);
    // Route untuk mendapatkan persyaratan
    Route::get('/pendaftaran-beasiswa/persyaratan/{id}', [PendaftaranBeasiswaController::class, 'getPersyaratan']);
    // Route untuk menampilkan halaman daftar
    Route::get('/pendaftaran-beasiswa/daftar/{id}', [PendaftaranBeasiswaController::class, 'daftar']);
    Route::post('/pendaftaran-beasiswa/{pendaftaranId}', [PendaftaranBeasiswaController::class, 'store'])->name('pendaftaran_beasiswa.store');
    Route::get('/pendaftaran-beasiswa/beasiswa_eksternal/{id}', [PendaftaranBeasiswaController::class, 'daftar'])->name('pendaftaran_beasiswa.beasiswa_eksternal');

    // Route untuk melihat detail pendaftaran beasiswa
    Route::get('/beasiswa/{id}/detail', [ValidasiController::class, 'show'])->name('beasiswa.detail'); 
    
    // Route untuk aksi validasi setuju atau tolak
    Route::post('/kelola_beasiswa/lanjutkan-validasi', [ValidasiController::class, 'lanjutkanValidasi'])->name('beasiswa.lanjutkanValidasi');
    Route::post('/beasiswa/store-interview/{id}', [ValidasiController::class, 'storeInterview'])->name('beasiswa.storeInterview');

    // Route untuk usulan beasiswa secara umum
    Route::resource('/kelola_beasiswa/usulan_beasiswa', ValidasiController::class);

    // Route untuk riwayat usulan mahasiswa
    Route::get('beasiswa/riwayat_usulan', [RiwayatUsulanController::class, 'index'])->name('riwayat_usulan.index');
    Route::get('/beasiswa/detail_riwayat/{id}', [RiwayatUsulanController::class, 'show'])->name('riwayat_usulan.show');

    // Route untuk data penerima beasiswa secara umum
    Route::resource('/kelola_beasiswa/data_penerima', DataPenerimaController::class);
    Route::get('data_penerima/export', [DataPenerimaController::class, 'export'])->name('data_penerima.export');
});
