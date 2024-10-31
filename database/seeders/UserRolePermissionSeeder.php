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
            // Buat user
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
            $role_super_admin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
            $role_operator_kemahasiswaan = Role::firstOrCreate(['name' => 'Operator Kemahasiswaan', 'guard_name' => 'web']);
            $role_operator_fakultas = Role::firstOrCreate(['name' => 'Operator Fakultas', 'guard_name' => 'web']);
            $role_mahasiswa = Role::firstOrCreate(['name' => 'Mahasiswa', 'guard_name' => 'web']);
            $role_reviewer = Role::firstOrCreate(['name' => 'Reviewer', 'guard_name' => 'web']);

            // Permissions untuk Super Admin
            $super_admin_permissions = [
                'read konfigurasi',
                'read konfigurasi/role',
                'create konfigurasi/role',
                'update konfigurasi/role',
                'delete konfigurasi/role',
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

                'read master_beasiswa',
                'create master_beasiswa/daftar_beasiswa',
                'read master_beasiswa/daftar_beasiswa',
                'update master_beasiswa/daftar_beasiswa',
                'delete master_beasiswa/daftar_beasiswa',
                'create master_beasiswa/persyaratan_beasiswa',
                'read master_beasiswa/persyaratan_beasiswa',
                'update master_beasiswa/persyaratan_beasiswa',
                'delete master_beasiswa/persyaratan_beasiswa',
                'create master_beasiswa/berkas_pendaftaran',
                'read master_beasiswa/berkas_pendaftaran',
                'update master_beasiswa/berkas_pendaftaran',
                'delete master_beasiswa/berkas_pendaftaran',
                'create master_beasiswa/tahapan_beasiswa',
                'read master_beasiswa/tahapan_beasiswa',
                'update master_beasiswa/tahapan_beasiswa',
                'delete master_beasiswa/tahapan_beasiswa',

                'read kelola_beasiswa',
                'create kelola_beasiswa/manajemen_pendaftaran',
                'read kelola_beasiswa/manajemen_pendaftaran',
                'update kelola_beasiswa/manajemen_pendaftaran',
                'delete kelola_beasiswa/manajemen_pendaftaran',
                'create kelola_beasiswa/usulan_beasiswa',
                'read kelola_beasiswa/usulan_beasiswa',
                'update kelola_beasiswa/usulan_beasiswa',
                'delete kelola_beasiswa/usulan_beasiswa',
                'create kelola_beasiswa/data_beasiswa',
                'read kelola_beasiswa/data_beasiswa',
                'update kelola_beasiswa/data_beasiswa',
                'delete kelola_beasiswa/data_beasiswa',
            ];

            // Permissions untuk Operator Kemahasiswaan
            $operator_permissions = [
                'read master_beasiswa',
                'create master_beasiswa/daftar_beasiswa',
                'read master_beasiswa/daftar_beasiswa',
                'update master_beasiswa/daftar_beasiswa',
                'delete master_beasiswa/daftar_beasiswa',
                'create master_beasiswa/persyaratan_beasiswa',
                'read master_beasiswa/persyaratan_beasiswa',
                'update master_beasiswa/persyaratan_beasiswa',
                'delete master_beasiswa/persyaratan_beasiswa',
                'create master_beasiswa/berkas_pendaftaran',
                'read master_beasiswa/berkas_pendaftaran',
                'update master_beasiswa/berkas_pendaftaran',
                'delete master_beasiswa/berkas_pendaftaran',
                'create master_beasiswa/tahapan_beasiswa',
                'read master_beasiswa/tahapan_beasiswa',
                'update master_beasiswa/tahapan_beasiswa',
                'delete master_beasiswa/tahapan_beasiswa',
                
                'read kelola_beasiswa',
                'create kelola_beasiswa/manajemen_pendaftaran',
                'read kelola_beasiswa/manajemen_pendaftaran',
                'update kelola_beasiswa/manajemen_pendaftaran',
                'delete kelola_beasiswa/manajemen_pendaftaran',
                'create kelola_beasiswa/usulan_beasiswa',
                'read kelola_beasiswa/usulan_beasiswa',
                'update kelola_beasiswa/usulan_beasiswa',
                'delete kelola_beasiswa/usulan_beasiswa',
                'create kelola_beasiswa/data_beasiswa',
                'read kelola_beasiswa/data_beasiswa',
                'update kelola_beasiswa/data_beasiswa',
                'delete kelola_beasiswa/data_beasiswa',
            ];

            // Permissions untuk Operator Fakultas
            $operator_fakultas_permissions = [
                'create kelola_beasiswa/data_beasiswa',
                'read kelola_beasiswa/data_beasiswa',
                'update kelola_beasiswa/data_beasiswa',
                'delete kelola_beasiswa/data_beasiswa',

                'read kelola_beasiswa',
                'create kelola_beasiswa/usulan_beasiswa',
                'read kelola_beasiswa/usulan_beasiswa',
                'update kelola_beasiswa/usulan_beasiswa',
                'delete kelola_beasiswa/usulan_beasiswa',
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
            $role_super_admin->syncPermissions($super_admin_permissions);
            $role_operator_kemahasiswaan->syncPermissions($operator_permissions);
            $role_operator_fakultas->syncPermissions($operator_fakultas_permissions);
            $role_mahasiswa->syncPermissions($mahasiswa_permissions);

            DB::commit();

            // Assign roles to users
            $super_admin->assignRole('Super Admin');
            $operator_kemahasiswaan->assignRole('Operator Kemahasiswaan');
            $operator_fakultas->assignRole('Operator Fakultas');
            $mahasiswa->assignRole('Mahasiswa');
            $reviewer->assignRole('Reviewer');

            // DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error('Seeder failed: ' . $th->getMessage());
            throw $th; // Optional: Re-throw to get the exact error when running the seeder
        }
    }
}
