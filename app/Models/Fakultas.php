<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;

    protected $table = 'fakultas';

    protected $fillable = [
        'nama_fakultas', 
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'fakultas_id');
    }

    public function pendaftaranBeasiswas()
    {
        return $this->hasMany(PendaftaranBeasiswa::class, 'fakultas_id');
    }

}
