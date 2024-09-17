<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('can:read konfigurasi/role')->only('index');
        $this->middleware('can:create konfigurasi/role')->only(['create', 'store']);
        $this->middleware('can:update konfigurasi/role')->only(['edit', 'update']);
        $this->middleware('can:delete konfigurasi/role')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // ambil semua data roles di database
            $roles = Role::all();
            return DataTables::of($roles)
                ->addIndexColumn()
                ->addColumn('aksi', function($roles){
                    return view('konfigurasi.tombol')->with('data',$roles);
                })
                ->make(true);
        }
    
        return view('konfigurasi.role');
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
            'name' => 'required|unique:roles,name',
            'guard_name' => 'required',
        ], [
            'name.required' => '*Role user wajib diisi',
            'name.unique' => '*Role user sudah ada, silakan masukkan yang lain',
            'guard_name.required' => '*Guard name wajib diisi',
        ]);
    
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        } else {
            $roles = [
                'name' => $request->name,
                'guard_name' => $request->guard_name,
            ];
            Role::create($roles);
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
        $roles = Role::where('id', $id)->first();
        return response()->json(['result' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi dengan cek unik, kecuali untuk data yang sedang diupdate
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $id,
            'guard_name' => 'required',
        ], [
            'name.required' => '*Role user wajib diisi',
            'name.unique' => '*Role user sudah ada, silakan masukkan yang lain',
            'guard_name.required' => 'Guard name wajib diisi',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        } else {
            $role = Role::find($id);
            $role->update([
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
        Role::where('id', $id)->delete();
    }
}
