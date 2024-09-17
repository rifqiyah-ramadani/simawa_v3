<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\DaftarBeasiswaController;
use App\Http\Controllers\PersyaratanBeasiswaController;
use App\Http\Controllers\BerkasPendaftaranController;
use App\Http\Controllers\BuatPendaftaranController;
use App\Http\Controllers\PendaftaranBeasiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    // route konfigurasi
    Route::resource('konfigurasi/role', RoleController::class);
    Route::resource('konfigurasi/users', UserRoleController::class);
    Route::resource('konfigurasi/permission', PermissionController::class);
    Route::resource('konfigurasi/menu', NavigationController::class);

    // route kelola beasiswa
    Route::resource('kelola_beasiswa/daftar_beasiswa', DaftarBeasiswaController::class);
    Route::resource('kelola_beasiswa/persyaratan_beasiswa', PersyaratanBeasiswaController::class);
    Route::resource('kelola_beasiswa/berkas_pendaftaran', BerkasPendaftaranController::class);
    Route::resource('kelola_beasiswa/buat_pendaftaran_beasiswa', BuatPendaftaranController::class);

    //Route mahasiswa beasiswa
    Route::resource('beasiswa/pendaftaran_beasiswa', PendaftaranBeasiswaController::class);
    // Route untuk mendapatkan persyaratan
    Route::get('/pendaftaran-beasiswa/persyaratan/{id}', [PendaftaranBeasiswaController::class, 'getPersyaratan']);
    // Route untuk menampilkan halaman daftar
    Route::get('/pendaftaran-beasiswa/daftar/{id}', [PendaftaranBeasiswaController::class, 'daftar']);
    Route::post('/pendaftaran-beasiswa/{pendaftaranId}', [PendaftaranBeasiswaController::class, 'store'])->name('pendaftaran_beasiswa.store');

    // Route::get('/pendaftaran_beasiswa/riwayat', [PendaftaranBeasiswaController::class, 'riwayat'])->name('pendaftaran_beasiswa.riwayat');

});
