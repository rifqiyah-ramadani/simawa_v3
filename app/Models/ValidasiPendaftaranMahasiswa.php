<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidasiPendaftaranMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'validasi_pendaftaran_mahasiswas';

    protected $fillable = ['pendaftaran_id', 'role_id', 'status', 'urutan'];

    public function pendaftaran()
    {
        return $this->belongsTo(PendaftaranBeasiswa::class, 'pendaftaran_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
