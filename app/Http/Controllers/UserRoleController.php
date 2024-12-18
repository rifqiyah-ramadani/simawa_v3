<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User; 
use App\Models\Fakultas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read konfigurasi/users')->only('index');
        $this->middleware('can:create konfigurasi/users')->only(['create', 'store']);
        $this->middleware('can:update konfigurasi/users')->only(['edit', 'update']);
        $this->middleware('can:delete konfigurasi/users')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('roles')->get();
            // Log::info(json_encode($users)); 
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('roles', function($user){
                    return $user->roles->pluck('name')->implode(', ');
                })
                ->addColumn('aksi', function($user){
                    return view('konfigurasi.tombol')->with('data', $user);
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        $roles = Role::all(); // Ambil semua roles
        $fakultas = Fakultas::all();
        return view('konfigurasi.users', compact('roles','fakultas')); // Pass roles ke view utama
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all(); // Ambil semua role dari database
        $fakultas = Fakultas::all();
        return view('konfigurasi.users', compact('roles', 'fakultas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Validasi dengan cek unik
         $validate = Validator::make($request->all(), [
            'username' => 'required|unique:users,username',
            'name' => 'required',
            'nip' => 'nullable',
            'usertype' => 'required',
            'roles' => 'required|array',
            'fakultas_id' => 'required_if:roles,Operator Fakultas|exists:fakultas,id', // Validasi fakultas_id
        ], [
            'username.required' => '*Username wajib diisi',
            'username.unique' => '*Username sudah ada, silakan masukkan yang lain',
            'name.required' => '*Nama wajib diisi',
            'nip.nullable' => '*NIP tidak wajib diisi',
            'usertype.required' => '*Jenis pengguna (usertype) wajib diisi',
            'roles.required' => '*Role wajib dipilih',
            'fakultas_id.required_if' => '*Fakultas wajib dipilih untuk role Operator Fakultas',
            'fakultas_id.exists' => '*Fakultas tidak valid',
        ]);
    
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        } else {
            // Set password default
            $defaultPassword = bcrypt('password'); // Password default adalah "password"
    
            $users = User::create([
                'username' => $request->username,
                'name' => $request->name,
                'nip' => $request->nip, // Menyimpan NIP sebagai null jika tidak diisi
                'usertype' => $request->usertype,
                'password' => $defaultPassword, // Password otomatis

                'fakultas_id' => $request->roles && in_array('Operator Fakultas', $request->roles) ? $request->fakultas_id : null,
            ]);    
            
            // Assign role ke user yang baru dibuat
            $users->syncRoles($request->roles);

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
    public function edit(string $id)
    {
        // Ambil data user beserta roles-nya dan fakultas
        $users = User::with(['roles', 'fakultas'])->findOrFail($id);
        $roles = Role::all(); // Ambil semua roles yang tersedia
        $fakultas = Fakultas::all(); // Ambil semua fakultas

        // Mengembalikan data user, roles, dan fakultas untuk diisi dalam form
        return response()->json([
            'user' => $users,
            'roles' => $users->roles->pluck('name'), // Mengambil nama role yang dimiliki user
            'allRoles' => $roles->pluck('name'), // Semua nama role yang tersedia
            'fakultas_id' => $users->fakultas_id, // Mengambil fakultas_id jika ada
            'allFakultas' => $fakultas, // Semua fakultas
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi data yang masuk
        $validate = Validator::make($request->all(), [
            'username' => 'required|unique:users,username,' . $id,
            'name' => 'required',
            'nip' => 'nullable',
            'usertype' => 'required',
            'roles' => 'required|array',
            'fakultas_id' => 'required_if:roles,Operator Fakultas|exists:fakultas,id', // Validasi fakultas_id
        ], [
            'username.required' => '*Username wajib diisi',
            'username.unique' => '*Username sudah ada, silakan masukkan yang lain',
            'name.required' => '*Nama wajib diisi',
            'fakultas_id.required_if' => '*Fakultas wajib dipilih jika role adalah Operator Fakultas',
            'fakultas_id.exists' => '*Fakultas tidak valid',
        ]);
    
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        }
    
        $users = User::findOrFail($id);
    
        // Update data user
        $users->update([
            'username' => $request->username,
            'name' => $request->name,
            'nip' => $request->nip,
            'usertype' => $request->usertype,
            'password' => $request->password ? bcrypt($request->password) : $users->password,
            'fakultas_id' => in_array('Operator Fakultas', $request->roles) ? $request->fakultas_id : null,
        ]);
    
        // Sinkronisasi roles
        $users->syncRoles($request->roles);
    
        return response()->json(['success' => "Berhasil memperbarui data"]);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Temukan user berdasarkan ID
        $users = User::findOrFail($id);

        // Hapus user beserta relasi role-nya
        $users->delete();
    }
}
