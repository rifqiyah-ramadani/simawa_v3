<?php

namespace App\Exports;

use App\Models\DataPenerima;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings; // Import interface

class DataPenerimaExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $fakultas; // Properti untuk menyimpan filter fakultas

    public function __construct($fakultas = null)
    {
        $this->fakultas = $fakultas; // Menyimpan filter fakultas
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Query data berdasarkan fakultas jika parameter diberikan
        $query = DataPenerima::with([
            'pendaftaranBeasiswa.buatPendaftaranBeasiswa.beasiswa', // Relasi ke beasiswa
            'pendaftaranBeasiswa.fileUploads.berkasPendaftaran' // Relasi ke file uploads
        ]);

        // Filter berdasarkan fakultas
        if ($this->fakultas) {
            $query->whereHas('pendaftaranBeasiswa', function ($q) {
                $q->where('fakultas', $this->fakultas);
            });
        }

        return $query->get()->map(function ($item) {
            return [
                'nama_mahasiswa' => $item->pendaftaranBeasiswa->nama_lengkap ?? '-',
                'nim' => $item->pendaftaranBeasiswa->nim ?? '-',
                'fakultas' => $item->pendaftaranBeasiswa->fakultas ?? '-',
                'jurusan' => $item->pendaftaranBeasiswa->jurusan ?? '-',
                'semester' => $item->pendaftaranBeasiswa->semester ?? '-',
                'telepon' => $item->pendaftaranBeasiswa->telepon ?? '-',
                'nama_beasiswa' => $item->pendaftaranBeasiswa->buatPendaftaranBeasiswa->beasiswa->nama_beasiswa ?? '-',
                'mulai_berlaku' => $item->pendaftaranBeasiswa->buatPendaftaranBeasiswa->mulai_berlaku ?? '-',
                'akhir_berlaku' => $item->pendaftaranBeasiswa->buatPendaftaranBeasiswa->akhir_berlaku ?? '-',
                'biaya_hidup' => $item->pendaftaranBeasiswa->biaya_hidup ?? '-',
                'biaya_ukt' => $item->pendaftaranBeasiswa->biaya_ukt ?? '-',
                'status_penerima' => $item->status_penerima ?? '-',
                'start_semester' => $item->start_semester ?? '-',
                'end_semester' => $item->end_semester ?? '-',
                'file_uploads' => $item->pendaftaranBeasiswa->fileUploads->pluck('file_path')->implode(', ') ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Mahasiswa',
            'NIM',
            'Fakultas',
            'Jurusan',
            'Semester',
            'Telepon',
            'Nama Beasiswa',
            'Mulai Berlaku',
            'Akhir Berlaku',
            'Status Penerima',
            'Biaya Hidup',
            'Biaya UKT',
            'Start Semester',
            'End Semester',
            'File Uploads',
        ];
    }
}
