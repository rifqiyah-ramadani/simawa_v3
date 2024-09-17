<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Navigation;

class NavigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $konfigurasi = Navigation::create([
            'name' => 'Konfigurasi',
            'url' => 'konfigurasi',
            'icon' => 'bi bi-gear-fill',
            'main_menu' => null,
        ]);
        $konfigurasi->subMenus()->create([
            'name' => 'Roles',
            'url' => 'konfigurasi/role',
            'icon' => '',
        ]);
        $konfigurasi->subMenus()->create([
            'name' => 'Permission',
            'url' => 'konfigurasi/permission',
            'icon' => '',
        ]);
        $konfigurasi->subMenus()->create([
            'name' => 'Users',
            'url' => 'konfigurasi/users',
            'icon' => '',
        ]);
        $konfigurasi->subMenus()->create([
            'name' => 'Menu',
            'url' => 'konfigurasi/menu',
            'icon' => '',
        ]);
        $konfigurasi->subMenus()->create([
            'name' => 'Akses Role',
            'url' => 'konfigurasi/akses_role',
            'icon' => '',
        ]);

        
        // kelola_kegiatan
        $rekam = Navigation::create([
            'name' => 'Rekam Kegiatan',
            'url' => 'rekam_kegiatan',
            'icon' => 'bi bi-box-seam-fill',
            'main_menu' => null,
        ]);
        $rekam->subMenus()->create([
            'name' => 'Kategori Kegiatan',
            'url' => 'rekam_kegiatan/kategori_kegiatan',
            'icon' => '',
        ]);
        $rekam->subMenus()->create([
            'name' => 'Jenis Kegiatan',
            'url' => 'rekam_kegiatan/jenis_kegiatan',
            'icon' => '',
        ]);
        $rekam->subMenus()->create([
            'name' => 'Jenis Tahapan',
            'url' => 'rekam_kegiatan/jenis_tahapan',
            'icon' => '',
        ]);
        $rekam->subMenus()->create([
            'name' => 'Buat Kegiatan',
            'url' => 'rekam_kegiatan/buat_kegiatan',
            'icon' => '',
        ]);

        // tambah menu
        $rekam = Navigation::create([
            'name' => 'Kelola Beasiswa',
            'url' => 'kelola_beasiswa',
            'icon' => 'bi bi-clipboard-fill',
            'main_menu' => null,
        ]);
        $rekam->subMenus()->create([
            'name' => 'Data Beasiswa',
            'url' => 'kelola_beasiswa/data_beasiswa',
            'icon' => '',
        ]);
        $rekam->subMenus()->create([
            'name' => 'Daftar Beasiswa',
            'url' => 'kelola_beasiswa/daftar_beasiswa',
            'icon' => '',
        ]);
        $rekam->subMenus()->create([
            'name' => 'Persyaratan Beasiswa',
            'url' => 'kelola_beasiswa/persyaratan_beasiswa',
            'icon' => '',
        ]);
        $rekam->subMenus()->create([
            'name' => 'Berkas Pendaftaran',
            'url' => 'kelola_beasiswa/berkas_pendaftaran',
            'icon' => '',
        ]);
        $rekam->subMenus()->create([
            'name' => 'Buat Pendaftaran Beasiswa',
            'url' => 'kelola_beasiswa/buat_pendaftaran_beasiswa',
            'icon' => '',
        ]);
        $rekam->subMenus()->create([
            'name' => 'Usulan Beasiswa',
            'url' => 'kelola_beasiswa/usulan_beasiswa',
            'icon' => '',
        ]);
        $rekam->subMenus()->create([
            'name' => 'Surat',
            'url' => 'kelola_beasiswa/surat',
            'icon' => '',
        ]);

         // tambah menu
        $beasiswa = Navigation::create([
            'name' => 'Beasiswa',
            'url' => 'beasiswa',
            'icon' => 'bi bi-clipboard-fill',
            'main_menu' => null,
        ]);
        $beasiswa->subMenus()->create([
            'name' => 'Pendaftaran Beasiswa',
            'url' => 'beasiswa/pendaftaran_beasiswa',
            'icon' => '',
        ]);
    }
}
