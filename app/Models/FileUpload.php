<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    use HasFactory;

    protected $table = 'file_uploads';

    protected $fillable = [
        'pendaftaran_beasiswas_id',
        'berkas_pendaftaran_id',
        'file_path',
    ];

    // Relasi ke PendaftaranBeasiswa
    public function pendaftaranBeasiswa()
    {
        return $this->belongsTo(PendaftaranBeasiswa::class, 'pendaftaran_beasiswas_id');
    }

    // Relasi ke BerkasPendaftaran
    public function berkasPendaftaran() 
    {
        return $this->belongsTo(BerkasPendaftaran::class, 'berkas_pendaftaran_id');
    }
}
