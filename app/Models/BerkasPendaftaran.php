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

    // Relasi many-to-many dengan BuatPendaftaranBeasiswa
    public function buatPendaftaranBeasiswas()
    {
        return $this->belongsToMany(
            BuatPendaftaranBeasiswa::class, 
            'berkas_pendaftaran_beasiswa', 
            'berkas_id', 
            'pendaftaran_id'
        )->withTimestamps();
    }

    // Relasi ke FileUpload (lebih spesifik)
    public function fileUploads()
    {
        return $this->hasMany(FileUpload::class, 'berkas_pendaftaran_id');
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
