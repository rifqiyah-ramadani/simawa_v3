<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;
use App\Models\PersyaratanBeasiswa;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class KriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::all(); // Ambil semua data kriteria
        return response()->json(['kriteria' => $kriteria]);
    }

    /**
     * create persyaratan
     */
    public function create()
    {
        // Ambil daftar kolom dari tabel detail_user
        $columns = Schema::getColumnListing('detail_users');
    
        // Hapus field id, created_at, dan updated_at
        $filteredColumns = array_filter($columns, function ($column) {
            return !in_array($column, ['id', 'created_at', 'updated_at']);
        });
    
        return response()->json(['message' => 'Modal kriteria ditampilkan', 'fields' => array_values($filteredColumns)]);
    }
    
    /**
     * Store persyaratan
     */
    public function store(Request $request)
    {
        // Validasi input
        $validate = Validator::make($request->all(), [
            'nama_kriteria' => 'required|unique:kriterias,nama_kriteria',
            'tipe_input' => 'required|in:text,number,dropdown',
            'opsi_dropdown' => 'nullable|required_if:tipe_input,dropdown',
            'key_detail_user' => 'required|string'
        ], [
            'nama_kriteria.required' => '*Nama kriteria wajib diisi',
            'nama_kriteria.unique' => '*Nama kriteria sudah ada, silakan masukkan yang lain',
            'tipe_input.required' => '*Tipe input wajib dipilih',
            'opsi_dropdown.required_if' => '*Opsi dropdown wajib diisi jika tipe input adalah dropdown',
        ]);
    
        // Jika validasi gagal
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        }

        // Simpan data kriteria
        $kriteria = Kriteria::create([
            'nama_kriteria' => $request->nama_kriteria,
            'tipe_input' => $request->tipe_input,
            'opsi_dropdown' => $request->tipe_input === 'dropdown' 
                    ? json_encode(explode(',', $request->opsi_dropdown)) 
                    : null,
            'key_detail_user' => $request->key_detail_user,
        ]);

        return response()->json(['success' => "Berhasil menyimpan kriteria", 'data' => $kriteria]);
    }
}
