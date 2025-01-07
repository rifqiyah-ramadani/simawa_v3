<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Navigation;
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

            // Buat roles atau ambil jika sudah ada
            $role_operator_kemahasiswaan = Role::firstOrCreate(['name' => 'Operator Kemahasiswaan', 'guard_name' => 'web']);
            $role_operator_fakultas = Role::firstOrCreate(['name' => 'Operator Fakultas', 'guard_name' => 'web']);
            $role_mahasiswa = Role::firstOrCreate(['name' => 'Mahasiswa', 'guard_name' => 'web']);

            // Struktur menu dan sub-menu beserta permissions untuk setiap role
            $menus = [
                'Konfigurasi' => [
                    'url' => 'konfigurasi',
                    'icon' => 'bi bi-gear-fill',
                    'permissions' => [
                        'role' => [
                            'Operator Kemahasiswaan' => ['read', 'create', 'update', 'delete'],
                        ],
                        'users' => [
                            'Operator Kemahasiswaan' => ['read', 'create', 'update', 'delete'],
                        ],
                        'menu' => [
                            'Operator Kemahasiswaan' => ['read', 'create', 'update', 'delete'],
                        ],
                        'permission' => [
                            'Operator Kemahasiswaan' => ['read', 'create', 'update', 'delete'],
                        ],
                        'akses_role' => [
                            'Operator Kemahasiswaan' => ['read', 'create', 'update', 'delete'],
                        ],
                    ]
                ],
                'Master Informasi' => [
                    'url' => 'master_informasi',
                    'icon' => 'bi bi-newspaper',
                    'permissions' => [
                        'berita' => [
                            'Operator Kemahasiswaan' => ['read', 'create', 'update', 'delete'],
                        ],
                        'pengumuman' => [
                            'Operator Kemahasiswaan' => ['read', 'create', 'update', 'delete'],
                        ],
                    ]
                ],
                'Master Beasiswa' => [
                    'url' => 'master_beasiswa',
                    'icon' => 'bi bi-clipboard-fill',
                    'permissions' => [
                        'daftar_beasiswa' => [
                            'Operator Kemahasiswaan' =>  ['read', 'create', 'update', 'delete'],
                        ],
                        'persyaratan_beasiswa' => [
                            'Operator Kemahasiswaan' =>  ['read', 'create', 'update', 'delete'],
                        ],
                        'berkas_pendaftaran' => [
                            'Operator Kemahasiswaan' =>  ['read', 'create', 'update', 'delete'],
                        ],
                        'tahapan_beasiswa' => [
                            'Operator Kemahasiswaan' =>  ['read', 'create', 'update', 'delete'],
                        ],
                    ]
                ],
                'Kelola Beasiswa' => [
                    'url' => 'kelola_beasiswa',
                    'icon' => 'bi bi-tools', 
                    'permissions' => [
                        'manajemen_pendaftaran' => [
                            'Operator Kemahasiswaan' =>  ['read', 'create', 'update', 'delete'],
                        ],
                        'usulan_beasiswa' => [
                            'Operator Kemahasiswaan' =>  ['read', 'create', 'update', 'delete'],
                            'Operator Fakultas' =>  ['read', 'create', 'update', 'delete'],
                        ],
                        'data_penerima' => [
                            'Operator Kemahasiswaan' =>  ['read', 'create', 'update', 'delete'],
                            'Operator Fakultas' =>  ['read', 'create', 'update', 'delete'],
                        ],
                    ]
                ],
                'Beasiswa' => [
                    'url' => 'beasiswa',
                    'icon' => 'bi bi-journal-bookmark-fill',
                    'permissions' => [
                        'pendaftaran_beasiswa' => [
                            'Mahasiswa' => ['read', 'create', 'update', 'delete'],
                        ],
                        'riwayat_usulan' => [
                            'Mahasiswa' => ['read'],
                        ],
                    ]
                ],
            ];

            // Iterasi untuk membuat menu, sub-menu, dan permissions
            foreach ($menus as $menuName => $menuData) {
                // Buat atau ambil menu utama
                $mainMenu = Navigation::firstOrCreate([
                    'name' => $menuName,
                    'url' => $menuData['url'],
                    'icon' => $menuData['icon'],
                    'main_menu' => null
                ]);

                // Tambahkan permission untuk menu utama (misalnya 'read konfigurasi')
                foreach ($menuData['permissions'] as $subMenu => $rolesPermissions) {
                    foreach ($rolesPermissions as $roleName => $actions) {
                        // Buat permission untuk akses utama menu (hanya 'read' saja)
                        $mainPermissionName = "read {$menuData['url']}";
                        $mainPermission = Permission::firstOrCreate([
                            'name' => $mainPermissionName,
                            'guard_name' => 'web',
                            'navigation_id' => $mainMenu->id
                        ]);

                        // Berikan permission 'read konfigurasi' kepada role yang sesuai
                        $role = Role::where('name', $roleName)->first();
                        if ($role) {
                            $role->givePermissionTo($mainPermission);
                        }
                    }
                }

                foreach ($menuData['permissions'] as $subMenu => $rolesPermissions) {
                    // Buat atau ambil sub-menu
                    $subMenuNavigation = Navigation::firstOrCreate([
                        'name' => ucfirst($subMenu),
                        'url' => "{$menuData['url']}/{$subMenu}",
                        'icon' => '',
                        'main_menu' => $mainMenu->id
                    ]);

                    foreach ($rolesPermissions as $roleName => $actions) {
                        foreach ($actions as $action) {
                            // Buat permission untuk setiap aksi pada sub-menu
                            $permissionName = "{$action} {$menuData['url']}/{$subMenu}";
                            $permission = Permission::firstOrCreate([
                                'name' => $permissionName,
                                'guard_name' => 'web',
                                'navigation_id' => $subMenuNavigation->id
                            ]);

                            // Berikan permission ini kepada role yang sesuai
                            $role = Role::where('name', $roleName)->first();
                            if ($role) {
                                $role->givePermissionTo($permission);
                            }
                        }
                    }
                }
            }

            // foreach ($menus as $menuName => $menuData) {
            //     // Buat atau ambil menu utama
            //     $mainMenu = Navigation::firstOrCreate([
            //         'name' => $menuName,
            //         'url' => $menuData['url'],
            //         'icon' => $menuData['icon'],
            //         'main_menu' => null
            //     ]);
            
            //     // Tambahkan permission untuk menu utama
            //     foreach ($menuData['permissions'] as $subMenu => $rolesPermissions) {
            //         foreach ($rolesPermissions as $roleName => $actions) {
            //             // Buat permission untuk semua aksi pada menu utama (bukan hanya 'read')
            //             foreach ($actions as $action) {
            //                 $mainPermissionName = "{$action} {$menuData['url']}";
            //                 $mainPermission = Permission::firstOrCreate([
            //                     'name' => $mainPermissionName,
            //                     'guard_name' => 'web',
            //                     'navigation_id' => $mainMenu->id
            //                 ]);
            
            //                 // Berikan permission kepada role yang sesuai
            //                 $role = Role::where('name', $roleName)->first();
            //                 if ($role) {
            //                     $role->givePermissionTo($mainPermission);
            //                 }
            //             }
            //         }
            //     }
            
            //     foreach ($menuData['permissions'] as $subMenu => $rolesPermissions) {
            //         // Buat atau ambil sub-menu
            //         $subMenuNavigation = Navigation::firstOrCreate([
            //             'name' => ucfirst($subMenu),
            //             'url' => "{$menuData['url']}/{$subMenu}",
            //             'icon' => '',
            //             'main_menu' => $mainMenu->id
            //         ]);
            
            //         foreach ($rolesPermissions as $roleName => $actions) {
            //             foreach ($actions as $action) {
            //                 // Buat permission untuk setiap aksi pada sub-menu
            //                 $permissionName = "{$action} {$menuData['url']}/{$subMenu}";
            //                 $permission = Permission::firstOrCreate([
            //                     'name' => $permissionName,
            //                     'guard_name' => 'web',
            //                     'navigation_id' => $subMenuNavigation->id
            //                 ]);
            
            //                 // Berikan permission ini kepada role yang sesuai
            //                 $role = Role::where('name', $roleName)->first();
            //                 if ($role) {
            //                     $role->givePermissionTo($permission);
            //                 }
            //             }
            //         }
            //     }
            // }            

            // Assign roles ke users
            $operator_kemahasiswaan->assignRole($role_operator_kemahasiswaan);
            $operator_fakultas->assignRole($role_operator_fakultas);
            $mahasiswa->assignRole($role_mahasiswa);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error('Seeder failed: ' . $th->getMessage());
            throw $th;
        }
    }
}
