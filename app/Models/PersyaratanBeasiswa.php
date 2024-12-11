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
        'type',
        'kriteria_id',
        'operator',
        'value',
    ];

    protected $casts = [
        'value' => 'array', // Otomatis mengonversi JSON ke array saat diakses
    ];

    // Relasi dengan kriteria
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

    // Kalo data nyo dak mau masuk mungkin salah nyo disni
    public function pendaftaran()
    {
        return $this->belongsToMany(BuatPendaftaranBeasiswa::class, 'persyaratan_pendaftaran_beasiswa', 'pendaftaran_id', 'persyaratan_id')
                    ->withTimestamps();
    }
}
