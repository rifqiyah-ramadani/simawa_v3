<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read konfigurasi/permission')->only('index');
        $this->middleware('can:create konfigurasi/permission')->only(['create', 'store']);
        $this->middleware('can:update konfigurasi/permission')->only(['edit', 'update']);
        $this->middleware('can:delete konfigurasi/permission')->only('destroy');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // ambil semua data roles di database
            $permissions = Permission::all();
            return DataTables::of($permissions)
                ->addIndexColumn()
                ->addColumn('aksi', function($permissions){
                    return view('konfigurasi.tombol')->with('data',$permissions);
                })
                ->make(true);
        }
    
        return view('konfigurasi.permission');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return 'create page';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi dengan cek unik
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name',
            'guard_name' => 'required',
        ], [
            'name.required' => '*Permission wajib diisi',
            'name.unique' => '*Permission sudah ada, silakan masukkan yang lain',
            'guard_name.required' => '*Guard name wajib diisi',
        ]);
    
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        } else {
            $permissions = [
                'name' => $request->name,
                'guard_name' => $request->guard_name,
            ];
            Permission::create($permissions);
            return response()->json(['success' => "Berhasil menyimpan data"]);
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
        $permissions = Permission::where('id', $id)->first();
        return response()->json(['result' => $permissions]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi dengan cek unik, kecuali untuk data yang sedang diupdate
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name,' . $id,
            'guard_name' => 'required',
        ], [
            'name.required' => '*Permission wajib diisi',
            'name.unique' => '*Permission sudah ada, silakan masukkan yang lain',
            'guard_name.required' => '*Guard name wajib diisi',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        } else {
            $permissions = Permission::find($id);
            $permissions->update([
                'name' => $request->name,
                'guard_name' => $request->guard_name,
            ]);
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
