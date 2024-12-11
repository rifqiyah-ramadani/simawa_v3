<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriterias';

    protected $fillable = [
        'nama_kriteria',
        'tipe_input',
        'opsi_dropdown',
        'key_detail_user',
    ];

    // Relasi dengan persyaratan
    public function persyaratan()
    {
        return $this->hasMany(Persyaratan::class);
    }
}
