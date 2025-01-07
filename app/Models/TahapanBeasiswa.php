<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahapanBeasiswa extends Model
{
    use HasFactory;

    protected $table = 'tahapan_beasiswas';

    protected $fillable = [
        'nama_tahapan',
    ];

    // Relasi many-to-many dengan BuatPendaftaranBeasiswa
    public function buatpendaftaranBeasiswa()
    {
        return $this->belongsToMany(BuatPendaftaranBeasiswa::class, 'pendaftaran_tahapan_beasiswa')
                    ->withPivot('tanggal_mulai', 'tanggal_akhir')
                    ->withTimestamps();
    }

}
