<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranBeasiswa extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_beasiswas';

    protected $fillable = [
        'buat_pendaftaran_beasiswa_id',
        'user_id',
        'nama_lengkap',
        'nim',
        'fakultas',
        'jurusan',
        'alamat_lengkap',
        'telepon',
        'IPK',
        'semester',
        'status',
    ];

    // Relasi ke BuatPendaftaranBeasiswa
    public function buatPendaftaranBeasiswa()
    {
        return $this->belongsTo(BuatPendaftaranBeasiswa::class, 'buat_pendaftaran_beasiswa_id');
    }

    // Relasi ke ValidasiPendaftaranMahasiswa
    public function validasi()
    {
        return $this->hasMany(ValidasiPendaftaranMahasiswa::class, 'pendaftaran_id');
    }

    // Relasi ke FileUpload (lebih jelas)
    public function fileUploads() 
    {
        return $this->hasMany(FileUpload::class, 'pendaftaran_beasiswas_id');
    }

     // Relasi ke User
     public function user()
     {
         return $this->belongsTo(User::class);
     }
}
