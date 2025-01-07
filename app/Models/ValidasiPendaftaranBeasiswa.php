<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidasiPendaftaranBeasiswa extends Model
{
    use HasFactory;

    protected $table = 'validasi_pendaftaran_beasiswas';

    protected $fillable = [
        'buat_pendaftaran_id',
        // 'pendaftaran_id',
        'role_id',
        'urutan',
        // 'status',
    ];

    public function buatPendaftaran()
    {
        return $this->belongsTo(BuatPendaftaranBeasiswa::class, 'buat_pendaftaran_id');
    }

    // public function pendaftaran()
    // {
    //     return $this->belongsTo(PendaftaranBeasiswa::class, 'pendaftaran_id');
    // }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
