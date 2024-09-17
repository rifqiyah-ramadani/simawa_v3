<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasPendaftaran extends Model
{
    use HasFactory;

    protected $table = 'berkas_pendaftarans';

    protected $fillable = [
        'nama_file',
        'keterangan',
        'template_path',
    ];

    // Relasi belongs to many dengan buat pendaftaran
    public function pendaftaran()
    {
        return $this->belongsToMany(BuatPendaftaranBeasiswa::class, 'berkas_pendaftaran_beasiswa', 'pendaftaran_id', 'berkas_id')
                    ->withTimestamps();
    }

    /**
     * Mengakses URL dari file template jika ada.
     *
     * @return string|null
     */
    public function getTemplateUrlAttribute()
    {
        return $this->template_path ? asset($this->template_path) : null;
    }
}
