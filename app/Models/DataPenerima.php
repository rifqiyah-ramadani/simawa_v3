<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPenerima extends Model
{
    use HasFactory; 

    protected $table = 'data_penerimas';

    protected $fillable = [
        'pendaftaran_beasiswa_id',
        'siakad_mhpspt_id',
        'biaya_hidup',
        'biaya_ukt',
        'status_penerima',
        'start_semester',
        'end_semester',
    ];

    /**
     * Relasi ke model PendaftaranBeasiswa
     * 
     * Menghubungkan Data Penerima dengan informasi Mahasiswa yang mendaftar
     */
    public function pendaftaranBeasiswa()
    {
        return $this->belongsTo(PendaftaranBeasiswa::class, 'pendaftaran_beasiswa_id');
    }
}
