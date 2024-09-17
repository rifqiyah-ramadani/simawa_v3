<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Log;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default_user_value = [
            'password' => Hash::make('password'), 
            'remember_token' => Str::random(10),
        ];

        DB::beginTransaction();
        try {
            $super_admin = User::create(array_merge([
                'username' => '0001234567',
                'name' => 'Reza',
                'usertype' => 'pegawai',
            ], $default_user_value));
    
            $operator_kemahasiswaan = User::create(array_merge([
                'username' => '0007654321',
                'name' => 'Farhan',
                'usertype' => 'pegawai',
            ], $default_user_value));

            $operator_fakultas = User::create(array_merge([
                'username' => '0001112223',
                'name' => 'Nanda Saputra',
                'usertype' => 'staff',
            ], $default_user_value));
    
            $mahasiswa = User::create(array_merge([
                'username' => 'F1E120005',
                'name' => 'Rifqiyah Ramadani',
                'usertype' => 'mahasiswa',
            ], $default_user_value));
    
            $reviewer = User::create(array_merge([
                'username' => '0102030405',
                'name' => 'Rizqa Raaiqa',
                'usertype' => 'dosen',
            ], $default_user_value));
    
            // Periksa apakah role sudah ada sebelum membuatnya
            // Buat role atau ambil jika sudah ada
            $role_super_admin = Role::firstOrCreate(['name' => 'Super Admin'], ['guard_name' => 'web']);
            $role_operator_kemahasiswaan = Role::firstOrCreate(['name' => 'Operator Kemahasiswaan'], ['guard_name' => 'web']);
            $role_operator_fakultas = Role::firstOrCreate(['name' => 'Operator Fakultas'], ['guard_name' => 'web']);
            $role_mahasiswa = Role::firstOrCreate(['name' => 'Mahasiswa'], ['guard_name' => 'web']);
            $role_reviewer = Role::firstOrCreate(['name' => 'Reviewer'], ['guard_name' => 'web']);

            // Permissions untuk Super Admin
            $super_admin_permissions = [
                'read konfigurasi/role',
                'create konfigurasi/role',
                'update konfigurasi/role',
                'delete konfigurasi/role',
                'create konfigurasi/permission',
                'read konfigurasi/permission',
                'update konfigurasi/permission',
                'delete konfigurasi/permission',
                'create konfigurasi/users',
                'read konfigurasi/users',
                'update konfigurasi/users',
                'delete konfigurasi/users',
                'create konfigurasi/menu',
                'read konfigurasi/menu',
                'update konfigurasi/menu',
                'delete konfigurasi/menu',
                'create konfigurasi/akses_role',
                'read konfigurasi/akses_role',
                'update konfigurasi/akses_role',
                'delete konfigurasi/akses_role',
                'read konfigurasi',

                'create rekam_kegiatan/kategori_kegiatan',
                'read rekam_kegiatan/kategori_kegiatan',
                'update rekam_kegiatan/kategori_kegiatan',
                'delete rekam_kegiatan/kategori_kegiatan',

                'create rekam_kegiatan/jenis_kegiatan',
                'read rekam_kegiatan/jenis_kegiatan',
                'update rekam_kegiatan/jenis_kegiatan',
                'delete rekam_kegiatan/jenis_kegiatan',

                'create rekam_kegiatan/jenis_tahapan',
                'read rekam_kegiatan/jenis_tahapan',
                'update rekam_kegiatan/jenis_tahapan',
                'delete rekam_kegiatan/jenis_tahapan',

                'create rekam_kegiatan/buat_kegiatan',
                'read rekam_kegiatan/buat_kegiatan',
                'update rekam_kegiatan/buat_kegiatan',
                'delete rekam_kegiatan/buat_kegiatan',

                'read rekam_kegiatan',

                'create kelola_beasiswa/data_beasiswa',
                'read kelola_beasiswa/data_beasiswa',
                'update kelola_beasiswa/data_beasiswa',
                'delete kelola_beasiswa/data_beasiswa',
                'create kelola_beasiswa/daftar_beasiswa',
                'read kelola_beasiswa/daftar_beasiswa',
                'update kelola_beasiswa/daftar_beasiswa',
                'delete kelola_beasiswa/daftar_beasiswa',
                'create kelola_beasiswa/persyaratan_beasiswa',
                'read kelola_beasiswa/persyaratan_beasiswa',
                'update kelola_beasiswa/persyaratan_beasiswa',
                'delete kelola_beasiswa/persyaratan_beasiswa',
                'create kelola_beasiswa/berkas_pendaftaran',
                'read kelola_beasiswa/berkas_pendaftaran',
                'update kelola_beasiswa/berkas_pendaftaran',
                'delete kelola_beasiswa/berkas_pendaftaran',
                'create kelola_beasiswa/buat_pendaftaran_beasiswa',
                'read kelola_beasiswa/buat_pendaftaran_beasiswa',
                'update kelola_beasiswa/buat_pendaftaran_beasiswa',
                'delete kelola_beasiswa/buat_pendaftaran_beasiswa',
                'create kelola_beasiswa/usulan_beasiswa',
                'read kelola_beasiswa/usulan_beasiswa',
                'update kelola_beasiswa/usulan_beasiswa',
                'delete kelola_beasiswa/usulan_beasiswa',
                'read kelola_beasiswa'
            ];

            // Permissions untuk Operator Kemahasiswaan
            $operator_permissions = [
                'create rekam_kegiatan/kategori_kegiatan',
                'read rekam_kegiatan/kategori_kegiatan',
                'update rekam_kegiatan/kategori_kegiatan',
                'delete rekam_kegiatan/kategori_kegiatan',

                'create rekam_kegiatan/jenis_kegiatan',
                'read rekam_kegiatan/jenis_kegiatan',
                'update rekam_kegiatan/jenis_kegiatan',
                'delete rekam_kegiatan/jenis_kegiatan',

                'create rekam_kegiatan/jenis_tahapan',
                'read rekam_kegiatan/jenis_tahapan',
                'update rekam_kegiatan/jenis_tahapan',
                'delete rekam_kegiatan/jenis_tahapan',

                'create rekam_kegiatan/buat_kegiatan',
                'read rekam_kegiatan/buat_kegiatan',
                'update rekam_kegiatan/buat_kegiatan',
                'delete rekam_kegiatan/buat_kegiatan',

                'read rekam_kegiatan',
                
                'create kelola_beasiswa/data_beasiswa',
                'read kelola_beasiswa/data_beasiswa',
                'update kelola_beasiswa/data_beasiswa',
                'delete kelola_beasiswa/data_beasiswa',
                'create kelola_beasiswa/daftar_beasiswa',
                'read kelola_beasiswa/daftar_beasiswa',
                'update kelola_beasiswa/daftar_beasiswa',
                'delete kelola_beasiswa/daftar_beasiswa',
                'create kelola_beasiswa/persyaratan_beasiswa',
                'read kelola_beasiswa/persyaratan_beasiswa',
                'update kelola_beasiswa/persyaratan_beasiswa',
                'delete kelola_beasiswa/persyaratan_beasiswa',
                'create kelola_beasiswa/berkas_pendaftaran',
                'read kelola_beasiswa/berkas_pendaftaran',
                'update kelola_beasiswa/berkas_pendaftaran',
                'delete kelola_beasiswa/berkas_pendaftaran',
                'create kelola_beasiswa/buat_pendaftaran_beasiswa',
                'read kelola_beasiswa/buat_pendaftaran_beasiswa',
                'update kelola_beasiswa/buat_pendaftaran_beasiswa',
                'delete kelola_beasiswa/buat_pendaftaran_beasiswa',
                'create kelola_beasiswa/usulan_beasiswa',
                'read kelola_beasiswa/usulan_beasiswa',
                'update kelola_beasiswa/usulan_beasiswa',
                'delete kelola_beasiswa/usulan_beasiswa',
                'read kelola_beasiswa'
            ];

            // Permissions untuk Operator Fakultas
            $operator_fakultas_permissions = [
                'create kelola_beasiswa/data_beasiswa',
                'read kelola_beasiswa/data_beasiswa',
                'update kelola_beasiswa/data_beasiswa',
                'delete kelola_beasiswa/data_beasiswa',
                'create kelola_beasiswa/daftar_beasiswa',
                'read kelola_beasiswa/daftar_beasiswa',
                'update kelola_beasiswa/daftar_beasiswa',
                'delete kelola_beasiswa/daftar_beasiswa',
                'create kelola_beasiswa/usulan_beasiswa',
                'read kelola_beasiswa/usulan_beasiswa',
                'update kelola_beasiswa/usulan_beasiswa',
                'delete kelola_beasiswa/usulan_beasiswa',
                'read kelola_beasiswa'
            ];

            // Permissions untuk Mahasiswa
            $mahasiswa_permissions = [
                'create beasiswa/pendaftaran_beasiswa',
                'read beasiswa/pendaftaran_beasiswa',
                'read beasiswa'
            ];

            // Buat permissions di database jika belum ada
            $all_permissions = array_merge(
                $super_admin_permissions,
                $operator_permissions,
                $operator_fakultas_permissions,
                $mahasiswa_permissions
            );

            foreach ($all_permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
            }

            // Berikan permissions ke masing-masing role
            $role_super_admin->givePermissionTo($super_admin_permissions);
            $role_operator_kemahasiswaan->givePermissionTo($operator_permissions);
            $role_operator_fakultas->givePermissionTo($operator_fakultas_permissions);
            $role_mahasiswa->givePermissionTo($mahasiswa_permissions);

            // Assign roles to users
            $super_admin->assignRole('Super Admin');
            $operator_kemahasiswaan->assignRole('Operator Kemahasiswaan');
            $operator_fakultas->assignRole('Operator Fakultas');
            $mahasiswa->assignRole('Mahasiswa');
            $reviewer->assignRole('Reviewer');

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error('Seeder failed: ' . $th->getMessage());
            throw $th; // Optional: Re-throw to get the exact error when running the seeder
        }
    }
}
