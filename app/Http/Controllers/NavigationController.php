<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Navigation;
use App\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NavigationController extends Controller
{
    public function __construct()
    {
        // Middleware untuk mengecek izin menggunakan Laravel Spatie
        $this->middleware('can:read konfigurasi/menu')->only('index');
        $this->middleware('can:create konfigurasi/menu')->only('store');
        $this->middleware('can:update konfigurasi/menu')->only('edit', 'update');
        $this->middleware('can:delete konfigurasi/menu')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $navigation = Navigation::with('subMenus')->get();

            return DataTables::of($navigation)
                ->addIndexColumn()
                ->addColumn('aksi', function($navigation){
                    return view('konfigurasi.tombol')->with('data',$navigation);
                })
                ->make(true);
        }
        $mainMenus = Navigation::whereNull('main_menu')->get();
        return view('konfigurasi.menu', compact('mainMenus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data main menu untuk dropdown di modal (hanya menu utama yang tidak memiliki parent/main_menu)
        $mainMenus = Navigation::whereNull('main_menu')->get();
        
        return response()->json(['mainMenus' => $mainMenus]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Validasi input data
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:navigations,name',
            'url' => 'required',
            'icon' => 'nullable|string',
            'main_menu' => 'nullable|exists:navigations,id', // Validasi main_menu jika ada
            'sort' => 'nullable|integer',
        ], [
            'name.required' => '*Nama menu wajib diisi',
            'name.unique' => '*Nama menu sudah ada, silakan masukkan yang lain',
            'url.required' => '*URL wajib diisi',
            'main_menu.exists' => '*Main menu yang dipilih tidak valid',
        ]); 

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        } else {
            // Simpan data navigasi
            $navigation = Navigation::create([
                'name' => $request->name,
                'url' => $request->url,
                'icon' => $request->icon ?? '',  // Default kosong jika tidak ada icon
                'main_menu' => $request->main_menu,  // Bisa null jika tidak sub-menu
                'sort' => $request->sort ?? 0,  // Default ke 0 jika tidak diisi
            ]);

            return response()->json(['success' => "Berhasil menyimpan menu navigasi"]);
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
        // Ambil data navigasi berdasarkan ID yang diberikan
        $navigation = Navigation::with('subMenus')->find($id);
        
        // Ambil semua main menus untuk digunakan dalam dropdown (kecuali menu yang sedang diedit agar tidak menjadi sub-menu dirinya sendiri)
        $mainMenus = Navigation::whereNull('main_menu')->where('id', '!=', $id)->get();

        // Kembalikan respons JSON dengan data navigasi dan main menus
        return response()->json([
            'result' => $navigation,
            'mainMenus' => $mainMenus
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:navigations,name,' . $id,
            'url' => 'required',
            'icon' => 'nullable|string',
            'main_menu' => 'nullable|exists:navigations,id', // Pastikan main_menu adalah ID dari navigations
            'sort' => 'nullable|integer',
        ], [
            'name.required' => '*Nama menu wajib diisi',
            'name.unique' => '*Nama menu sudah ada, silakan masukkan yang lain',
            'url.required' => '*URL wajib diisi',
        ]);
    
        // Jika validasi gagal
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        } else {
            $navigation = Navigation::findOrFail($id);
    
            // Update data menu atau subMenu
            $navigation->update([
                'name' => $request->name,
                'url' => $request->url,
                'icon' => $request->icon ?? '',  // Pastikan icon tidak null, beri string kosong jika tidak ada
                'main_menu' => $request->main_menu,  // Bisa menjadi null jika menu utama
                'sort' => $request->sort,
            ]);
    
            return response()->json(['success' => "Berhasil memperbarui menu"]);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Cari menu berdasarkan ID
        $navigation = Navigation::findOrFail($id);
    
        // Hapus sub-menus yang terkait jika ada (hanya jika ini adalah main menu)
        if ($navigation->subMenus()->count() > 0) {
            $navigation->subMenus()->delete(); // Hapus semua sub-menus
        }
    
        // Hapus menu utama atau sub-menu
        $navigation->delete();
    
        return response()->json(['success' => "Menu berhasil dihapus"]);
    }
    
}
