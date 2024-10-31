<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersyaratanBeasiswa extends Model
{
    use HasFactory;

    protected $table = 'persyaratan_beasiswas';

    protected $fillable = [
        'nama_persyaratan',
        'keterangan',
        'kriteria',
        'operator',
        'value',
    ];

    // Kalo data nyo dak mau masuk mungkin salah nyo disni
    public function pendaftaran()
    {
        return $this->belongsToMany(BuatPendaftaranBeasiswa::class, 'persyaratan_pendaftaran_beasiswa', 'pendaftaran_id', 'persyaratan_id')
                    ->withTimestamps();
    }
}
