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
        'nama_lengkap',
        'nim',
        'fakultas',
        'jurusan',
        'alamat_lengkap',
        'telepon',
    ];

    public function buatPendaftaranBeasiswa()
    {
        return $this->belongsTo(BuatPendaftaranBeasiswa::class, 'buat_pendaftaran_beasiswa_id');
    }

    // Relasi ke model FileUploads
    public function file()
    {
        return $this->hasMany(FileUpload::class);
    }
}
