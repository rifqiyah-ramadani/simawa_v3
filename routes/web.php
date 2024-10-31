<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\DaftarBeasiswaController;
use App\Http\Controllers\PersyaratanBeasiswaController;
use App\Http\Controllers\BerkasPendaftaranController;
use App\Http\Controllers\TahapanBeasiswaController;
use App\Http\Controllers\BuatPendaftaranController;
use App\Http\Controllers\PendaftaranBeasiswaController;
use App\Http\Controllers\AksesRoleController;
use App\Http\Controllers\ValidasiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
    Route::resource('/konfigurasi/akses_role', AksesRoleController::class)->only(['index', 'edit', 'update']);


    // route kelola beasiswa
    Route::resource('master_beasiswa/daftar_beasiswa', DaftarBeasiswaController::class);
    Route::resource('master_beasiswa/persyaratan_beasiswa', PersyaratanBeasiswaController::class);
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
    // Route untuk usulan beasiswa secara umum
    Route::resource('/kelola_beasiswa/usulan_beasiswa', ValidasiController::class);
});
