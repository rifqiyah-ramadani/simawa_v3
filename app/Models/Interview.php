<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'pendaftaran_id', 'tanggal_mulai', 'tanggal_akhir', 'jam_wawancara', 'lokasi', 'pewawancara_ids'
    ];

    protected $casts = [
        'pewawancara_ids' => 'array',
    ];

    // Relasi ke model `PendaftaranBeasiswa`
    public function pendaftaran()
    {
        return $this->belongsTo(PendaftaranBeasiswa::class, 'pendaftaran_id');
    }

    // Relasi untuk mengakses nama pewawancara
    public function getPewawancaraNamesAttribute()
    {
        // Mengambil data user berdasarkan ID di pewawancara_ids
        return User::whereIn('id', $this->pewawancara_ids)->pluck('name')->toArray();
    }
}
