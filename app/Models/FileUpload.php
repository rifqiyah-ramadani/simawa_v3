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
        'file_path',
    ];

    // Relasi ke model Pendaftaran
    public function pendaftaranBeasiswa()
    {
        return $this->belongsTo(PendaftaranBeasiswa::class);
    }
}
