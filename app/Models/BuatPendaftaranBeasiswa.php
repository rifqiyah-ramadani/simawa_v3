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
        'jenis_beasiswa',
        'tahun',
        'tanggal_mulai',
        'tanggal_berakhir',
        'status',
        'flyer',
        'link_pendaftaran',
        'mulai_berlaku',
        'akhir_berlaku',
    ];

    // Relasi ke model daftar_beasiswas
    // banyak pendaftaran beasiswa dapat terkait dengan satu beasiswa
    public function beasiswa()
    {
        return $this->belongsTo(DaftarBeasiswa::class, 'daftar_beasiswas_id');
    }

    // Relasi many-to-many dengan PersyaratanBeasiswa
    public function persyaratan()
    {
        return $this->belongsToMany(PersyaratanBeasiswa::class, 'persyaratan_pendaftaran_beasiswa', 'pendaftaran_id', 'persyaratan_id')
                    ->withTimestamps();
    }

    // Relasi many-to-many dengan BerkasPendaftaran
    public function berkasPendaftarans()
    {
        return $this->belongsToMany(BerkasPendaftaran::class, 'berkas_pendaftaran_beasiswa', 'pendaftaran_id', 'berkas_id')
                    ->withTimestamps();
    }

    // Relasi one-to-many dengan ValidasiPendaftaranBeasiswa
    public function validasi()
    {
        return $this->hasMany(ValidasiPendaftaranBeasiswa::class, 'buat_pendaftaran_id');
    }

    // Relasi many-to-many dengan Role (pivot table dengan urutan)
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'validasi_pendaftaran_beasiswas', 'buat_pendaftaran_id', 'role_id')
                    ->withPivot('urutan'); // Include urutan dari pivot table
    }

    // Relasi many-to-many dengan TahapanBeasiswa
    public function tahapan()
    {
        return $this->belongsToMany(TahapanBeasiswa::class, 'pendaftaran_tahapan_beasiswa','pendaftaran_beasiswa_id', 'tahapan_beasiswa_id')
                    ->withPivot('tanggal_mulai', 'tanggal_akhir')
                    ->withTimestamps();
    } 

    // Relasi one-to-many dengan PendaftaranBeasiswa
    public function pendaftaranBeasiswa()
    {
        return $this->hasMany(PendaftaranBeasiswa::class, 'buat_pendaftaran_beasiswa_id');
    }
}
