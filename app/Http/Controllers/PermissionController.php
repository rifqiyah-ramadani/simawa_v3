<?php

namespace App\Http\Controllers;

use App\Models\Navigation;
use App\Models\Permission; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $permissions = Permission::with('navigation')->get();

            return DataTables::of($permissions)
                ->addIndexColumn()
                ->addColumn('navigation_name', function($permissions) {
                    // Menampilkan nama navigasi yang terkait dengan permission
                    return $permissions->navigation ? $permissions->navigation->name : 'Tidak ada';
                })
                ->addColumn('aksi', function($permissions) {
                    // Tombol aksi (edit, hapus) bisa disesuaikan di sini
                    return view('konfigurasi.tombol', ['data' => $permissions]);
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        $navigations = Navigation::all(); // Ambil semua data navigasi
        return view('konfigurasi.permission', compact('navigations')); // Pass navigasi ke view utama
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $navigations = Navigation::all(); // Ambil semua role dari database
        return view('konfigurasi.permission', compact('navigations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input data
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:permissions,name',
            'guard_name' => 'required|string|max:255',
            'navigation_id' => 'nullable|exists:navigations,id', 
        ], [
            'name.required' => '*Nama permission wajib diisi',
            'name.unique' => '*Nama permission sudah ada, silakan masukkan yang lain',
            'navigation_id.exists' => '*Navigation menu yang dipilih tidak valid',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        } else {
            // Simpan data navigasi
            $permissions = Permission::create([
                'name' => $request->name,
                'guard_name' => $request->guard_name ?? '',  
                'navigation_id' => $request->navigation_id,  
            ]);

            return response()->json(['success' => "Berhasil menyimpan permission"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Temukan permission berdasarkan ID
        $permissions = Permission::findOrFail($id);
        // Ambil semua data navigasi untuk dropdown di form edit
        $navigations = Navigation::all();

        return response()->json([
            'permission' => $permissions,
            'navigations' => $navigations,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         // Validasi input data
         $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:permissions,name,' . $id,
            'guard_name' => 'required|string|max:255',
            'navigation_id' => 'nullable|exists:navigations,id', 
        ], [
            'name.required' => '*Nama permission wajib diisi',
            'name.unique' => '*Nama permission sudah ada, silakan masukkan yang lain',
            'navigation_id.exists' => '*Navigation menu yang dipilih tidak valid',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        } else {
            // Cari permission berdasarkan ID
            $permissions = Permission::findOrFail($id);
    
            // Update data permission
            $permissions->update([
                'name' => $request->name,
                'guard_name' => $request->guard_name,
                'navigation_id' => $request->navigation_id, // Opsional, bisa null
            ]);

            // $users->syncRoles($request->roles);
    
            return response()->json(['success' => "Berhasil memperbarui data"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Permission::where('id', $id)->delete();
    }
}
