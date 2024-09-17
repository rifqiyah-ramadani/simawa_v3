<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarBeasiswa extends Model
{
    use HasFactory;

    protected $table = 'daftar_beasiswas';

    protected $fillable = [
        'kode_beasiswa',
        'nama_beasiswa',
    ];
}
