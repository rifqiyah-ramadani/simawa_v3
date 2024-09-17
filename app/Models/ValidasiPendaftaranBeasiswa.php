<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidasiPendaftaranBeasiswa extends Model
{
    use HasFactory;

    protected $table = 'validasi_pendaftaran_beasiswas';

    protected $fillable = [
        'pendaftaran_id',
        'role_id',
        'urutan',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(BuatPendaftaranBeasiswa::class, 'pendaftaran_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
