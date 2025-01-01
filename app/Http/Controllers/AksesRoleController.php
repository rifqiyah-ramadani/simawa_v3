<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Navigation;
use App\Models\Permission; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AksesRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read konfigurasi/akses_role')->only('index');
        $this->middleware('can:create konfigurasi/akses_role')->only(['create', 'store']);
        $this->middleware('can:update konfigurasi/akses_role')->only(['edit', 'update']);
        $this->middleware('can:delete konfigurasi/akses_role')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil semua data roles di database
            $roles = Role::all();

            // Menggunakan DataTables untuk manipulasi data role
            return DataTables::of($roles)
                ->addIndexColumn()
                ->addColumn('permissions', function($roles) {
                    // Ambil semua permissions yang terkait dengan role
                    $permissions = $roles->permissions->pluck('name')->toArray();
                    return implode(', ', $permissions); // Gabungkan menjadi string
                })
                ->addColumn('aksi', function($roles){
                    // Tombol untuk aksi (Edit, Hapus, dll)
                    return view('konfigurasi.tombol_akses', ['data' => $roles]);
                })
                ->make(true);
        }

        $roles = Role::all();
        $permissions = Permission::all();
        // Kembalikan view untuk akses role
        return view('konfigurasi/akses_role', compact('roles', 'permissions'));
    } 

    public function edit($id)
    {
        try {
            // Ambil data role berdasarkan ID
            $role = Role::findById($id);

            // Ambil semua permission
            $permissions = Permission::all();

            // Ambil permissions yang dimiliki oleh role
            $rolePermissions = $role->permissions->pluck('name')->toArray();

            // Mengelompokkan permissions berdasarkan menu/submenu
            $permissionsGroupedByMenu = [];
            foreach ($permissions as $permission) {
                // Misalkan permission name dalam format 'create konfigurasi/role'
                [$action, $menu] = explode(' ', $permission->name, 2);

                // Kelompokkan berdasarkan menu/submenu
                if (!isset($permissionsGroupedByMenu[$menu])) {
                    $permissionsGroupedByMenu[$menu] = [];
                }

                // Tambahkan aksi ke menu
                if (in_array($permission->name, $rolePermissions)) {
                    $permissionsGroupedByMenu[$menu][] = $action;
                }
            }

            return response()->json([
                'role' => $role,
                'permissionsGroupedByMenu' => $permissionsGroupedByMenu,
                'permissions' => $permissions // Untuk referensi
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Method untuk menyimpan atau mengupdate permissions ke role
    public function update(Request $request, $id)
    {
        try {
            // Ambil data role berdasarkan ID
            $role = Role::findById($id);

            // Validasi request untuk memastikan permissions dikirim
            $request->validate([
                'permissions' => 'required|array',
            ]);

            // Menghapus semua permissions yang sebelumnya dimiliki oleh role
            $role->syncPermissions([]);

            // Ambil permissions baru yang dikirim dari form
            $permissionsGroupedByMenu = $request->input('permissions');

            // Loop setiap menu dan tambahkan permissions ke role
            foreach ($permissionsGroupedByMenu as $menu => $actions) {
                foreach ($actions as $action) {
                    // Nama permission sesuai dengan format yang ada di database
                    $permissionName = $action . ' ' . $menu;

                    // Cari permission berdasarkan nama dan tambahkan ke role
                    $permission = Permission::where('name', $permissionName)->first();
                    if ($permission) {
                        $role->givePermissionTo($permission);
                    }
                }
            }

            return response()->json([
                'message' => 'Permissions updated successfully!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating permissions',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
