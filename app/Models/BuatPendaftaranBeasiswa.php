<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuatPendaftaranBeasiswa extends Model
{
    use HasFactory;

    protected $table = 'buat_pendaftaran_beasiswas';

    protected $fillable = [
        'daftar_beasiswas_id',
        'tahun',
        'tanggal_mulai',
        'tanggal_berakhir',
        'status',
    ];

    // Relasi ke model daftar_beasiswas
    public function beasiswa()
    {
        return $this->belongsTo(DaftarBeasiswa::class, 'daftar_beasiswas_id');
    }

    // Relasi belong to many dengan persyaratan beasiswa
    public function persyaratan()
    {
        return $this->belongsToMany(PersyaratanBeasiswa::class, 'persyaratan_pendaftaran_beasiswa', 'pendaftaran_id', 'persyaratan_id')
                    ->withTimestamps();
    }

    // Relasi belongs to many dengan berkas pendaftaran
    public function berkas()
    {
        return $this->belongsToMany(BerkasPendaftaran::class, 'berkas_pendaftaran_beasiswa', 'pendaftaran_id', 'berkas_id')
                    ->withTimestamps();
    }

    // Relasi one-to-many dengan ValidasiPendaftaranBeasiswa
    public function validasi()
    {
        return $this->hasMany(ValidasiPendaftaranBeasiswa::class, 'pendaftaran_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'validasi_pendaftaran_beasiswas', 'pendaftaran_id', 'role_id')
                    ->withPivot('urutan'); // Include urutan dari pivot table
    }

    public function pendaftaranBeasiswa()
    {
        return $this->hasMany(PendaftaranBeasiswa::class, 'buat_pendaftaran_beasiswa_id');
    }
}
