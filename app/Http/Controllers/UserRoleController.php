<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Role;
use App\Models\User; 
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
        return view('konfigurasi.users', compact('roles')); // Pass roles ke view utama
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all(); // Ambil semua role dari database
        return view('konfigurasi.users', compact('roles'));
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
        ], [
            'username.required' => '*Username wajib diisi',
            'username.unique' => '*Username sudah ada, silakan masukkan yang lain',
            'name.required' => '*Nama wajib diisi',
            'nip.nullable' => '*NIP tidak wajib diisi',
            'usertype.required' => '*Jenis pengguna (usertype) wajib diisi',
            'roles.required' => '*Role wajib dipilih',
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
        // Ambil data user beserta roles-nya berdasarkan ID
        $users = User::with('roles')->findOrFail($id);
        $roles = Role::all(); // Ambil semua roles yang tersedia

        // Mengembalikan data user dan roles untuk diisi dalam form
        return response()->json([
            'user' => $users,
            'roles' => $users->roles->pluck('name'), // Mengambil nama role yang dimiliki user
            'allRoles' => $roles->pluck('name'), // Mengambil semua nama role yang tersedia
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         // Validasi data yang masuk
        $validate = Validator::make($request->all(), [
            'username' => 'required|unique:users,username,' . $id, // Cek unik, kecuali untuk user ini sendiri
            'name' => 'required',
            'nip' => 'nullable',
            'usertype' => 'required',
            'roles' => 'required|array',
        ], [
            'username.required' => '*Username wajib diisi',
            'username.unique' => '*Username sudah ada, silakan masukkan yang lain',
            'name.required' => '*Nama wajib diisi',
            'nip.nullable' => '*NIP tidak wajib diisi',
            'usertype.required' => '*Jenis pengguna (usertype) wajib diisi',
            'roles.required' => '*Role wajib dipilih',
        ]);
    
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        } else {
            $users = User::findOrFail($id);
    
            // Update data user
            $users->update([
                'username' => $request->username,
                'name' => $request->name,
                'nip' => $request->nip,  // Menyimpan NIP sebagai null jika tidak diisi
                'usertype' => $request->usertype,
                'password' => $request->password ? bcrypt($request->password) : $users->password, // Jika password diisi, hash dan update
            ]);
    
            // Sinkronisasi roles dengan data yang baru
            $users->syncRoles($request->roles);
    
            return response()->json(['success' => "Berhasil memperbarui data"]);
        }
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
