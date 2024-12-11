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

    // Relasi satu ke satu ke model `Interview`
    public function interview()
    {
        return $this->hasOne(Interview::class, 'pendaftaran_id');
    }

    /**
     * Relasi ke model DataPenerima
     * 
     * Menghubungkan PendaftaranBeasiswa dengan penerima beasiswa
     */
    public function dataPenerima()
    {
        return $this->hasOne(DataPenerima::class, 'pendaftaran_beasiswa_id');
    }

    public function statusBeasiswa()
    {
        return $this->hasOneThrough(
            PendaftaranBeasiswa::class,
            User::class,
            'id', // Foreign key di tabel `users`
            'user_id', // Foreign key di tabel `pendaftaran_beasiswa`
            'user_id', // Local key di tabel `detail_user`
            'id' // Local key di tabel `users`
        )->select('status'); // Ambil hanya kolom `status`
    }
} 
