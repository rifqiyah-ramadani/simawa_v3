<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as RoleSpatie;

class Role extends RoleSpatie
{
    use HasFactory;

    // Relasi one-to-many dengan ValidasiPendaftaranBeasiswa
    public function validasiPendaftaran()
    {
        return $this->hasMany(ValidasiPendaftaranMahasiswa::class, 'role_id');
    }
}
