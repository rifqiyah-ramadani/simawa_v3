<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersyaratanBeasiswa;
use App\Models\Kriteria;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PersyaratanBeasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read master_beasiswa/persyaratan_beasiswa')->only('index');
        $this->middleware('can:create master_beasiswa/persyaratan_beasiswa')->only(['create', 'store']);
        $this->middleware('can:update master_beasiswa/persyaratan_beasiswa')->only(['edit', 'update']);
        $this->middleware('can:delete master_beasiswa/persyaratan_beasiswa')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Muat data persyaratan dengan relasi ke tabel kriteria
            $persyaratanBeasiswa = PersyaratanBeasiswa::with('kriteria')->get()->map(function ($item) {
                $item->value = $item->value ? json_decode($item->value, true) : null; // Decode JSON ke array
                return $item;
            });
            return DataTables::of($persyaratanBeasiswa)
                ->addIndexColumn()
                ->addColumn('kriteria', function ($persyaratanBeasiswa) {
                    return $persyaratanBeasiswa->kriteria?->nama_kriteria ?? '-';
                })
                ->addColumn('aksi', function($persyaratanBeasiswa){
                    return view('konfigurasi.tombol')->with('data',$persyaratanBeasiswa);
                })
                ->make(true);
        }

        // Jika bukan permintaan AJAX, kembalikan data kriteria untuk dropdown
        $kriteria = Kriteria::all();
    
        return view('kelola_beasiswa.persyaratan_beasiswa', compact('kriteria'));
    } 

    /**
     * create persyaratan
     */
    public function create()
    {
        $kriteria = Kriteria::all()->map(function ($item) {
            $item->opsi_dropdown = $item->tipe_input === 'dropdown' && $item->opsi_dropdown
                ? json_decode($item->opsi_dropdown, true) // Decode JSON ke array
                : []; // Pastikan selalu array, bahkan jika null
            return $item;
        });
        return response()->json(['kriteria' => $kriteria]);
    }

    /**
     * Store persyaratan
     */
    public function store(Request $request)
    {
        // Validasi dengan cek unik
        $validate = Validator::make($request->all(),[
            'nama_persyaratan' => 'required|unique:persyaratan_beasiswas,nama_persyaratan',
            'type' => 'required|in:tanpa_kriteria,dengan_kriteria',
            'kriteria' => 'nullable|required_if:type,dengan_kriteria|exists:kriterias,id',
            'operator' => 'nullable|required_if:type,dengan_kriteria|in:>=,<=,=,<,>,!=',
            'value' => [
                'nullable',
                'required_if:type,dengan_kriteria',
                function ($attribute, $value, $fail) use ($request) {
                    $kriteria = Kriteria::find($request->kriteria);
                    if ($kriteria && $kriteria->tipe_input === 'dropdown' && !is_array($value)) {
                        $fail("The {$attribute} field must be an array.");
                    } elseif ($kriteria && $kriteria->tipe_input !== 'dropdown' && is_array($value)) {
                        $fail("The {$attribute} field must not be an array.");
                    }
                 },
            ],
        ],[
            // pesan error
            'nama_persyaratan.required' => '*Nama persyaratan wajib diisi',
            'nama_persyaratan.unique' => '*Nama persyaratan sudah ada, silakan gunakan nama lain',
            'type.required' => '*Tipe persyaratan wajib diisi',
            'type.in' => '*Tipe persyaratan tidak valid',
            'kriteria.required_if' => '*Kriteria wajib diisi jika menggunakan tipe dengan kriteria',
            'kriteria.exists' => '*Kriteria yang dipilih tidak ditemukan',
            'operator.required_if' => '*Operator wajib diisi jika menggunakan tipe dengan kriteria',
            'operator.in' => '*Operator tidak valid',
            'value.required_if' => '*Value wajib diisi jika menggunakan tipe dengan kriteria',
            ]
        );

        // Jika validasi gagal
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        }

        // Simpan data persyaratan
        $persyaratan = PersyaratanBeasiswa::create([
            'nama_persyaratan' => $request->nama_persyaratan,
            'keterangan' => $request->keterangan,
            'type' => $request->type, // Ambil langsung dari request
            'kriteria_id' => $request->type === 'dengan_kriteria' ? $request->kriteria : null,
            'operator' => $request->type === 'dengan_kriteria' ? $request->operator : null,
            'value' => $request->type === 'dengan_kriteria' && $request->value ? json_encode($request->value) : null,
        ]);

        return response()->json([
            'success' => "Berhasil menyimpan data persyaratan",
            'data' => $persyaratan,
        ]);
    }

    /**
     * Edit persyaratan
     */
    public function edit($id)
    {
        $persyaratan = PersyaratanBeasiswa::with('kriteria')->find($id);

        if (!$persyaratan) {
            return response()->json(['error' => 'Data tidak ditemukan.'], 404);
        }
    
        // Dekode JSON value agar dapat digunakan di frontend
        $persyaratan->value = $persyaratan->value ? json_decode($persyaratan->value, true) : null;
    
        // Ambil data kriteria
        $kriteria = Kriteria::all()->map(function ($item) {
            $item->opsi_dropdown = $item->tipe_input === 'dropdown' && $item->opsi_dropdown
                ? json_decode($item->opsi_dropdown, true) // Decode JSON ke array
                : []; // Pastikan selalu array, bahkan jika null
            return $item;
        });
    
        return response()->json(['persyaratan' => $persyaratan, 'kriteria' => $kriteria]);
    }

    /**
     * Update persyaratan
     */
    public function update(Request $request, $id)
    {
         $persyaratan = PersyaratanBeasiswa::find($id);

        if (!$persyaratan) {
            return response()->json(['error' => 'Data tidak ditemukan.'], 404);
        }

        $validate = Validator::make($request->all(), [
            'nama_persyaratan' => 'required|unique:persyaratan_beasiswas,nama_persyaratan,' . $id,
            'type' => 'required|in:tanpa_kriteria,dengan_kriteria',
            'kriteria' => 'nullable|required_if:type,dengan_kriteria|exists:kriterias,id',
            'operator' => 'nullable|required_if:type,dengan_kriteria|in:>=,<=,=,<,>,!=',
            'value' => [
                'nullable',
                'required_if:type,dengan_kriteria',
                function ($attribute, $value, $fail) use ($request) {
                    $kriteria = Kriteria::find($request->kriteria);
                    if ($kriteria && $kriteria->tipe_input === 'dropdown' && !is_array($value)) {
                        $fail("The {$attribute} field must be an array.");
                    } elseif ($kriteria && $kriteria->tipe_input !== 'dropdown' && is_array($value)) {
                        $fail("The {$attribute} field must not be an array.");
                    }
                },
            ],
        ],[
            'nama_persyaratan.required' => '*Nama persyaratan wajib diisi',
            'nama_persyaratan.unique' => '*Nama persyaratan sudah ada, silakan gunakan nama lain',
            'type.required' => '*Tipe persyaratan wajib diisi',
            'type.in' => '*Tipe persyaratan tidak valid',
            'kriteria.required_if' => '*Kriteria wajib diisi jika menggunakan tipe dengan kriteria',
            'kriteria.exists' => '*Kriteria yang dipilih tidak ditemukan',
            'operator.required_if' => '*Operator wajib diisi jika menggunakan tipe dengan kriteria',
            'operator.in' => '*Operator tidak valid',
            'value.required_if' => '*Value wajib diisi jika menggunakan tipe dengan kriteria',
            ]
        );

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors(),
                'message' => 'Validasi gagal. Periksa kembali input yang Anda masukkan.',
            ], 422);
        }

        // Update data persyaratan
        $persyaratan->update([
            'nama_persyaratan' => $request->nama_persyaratan,
            'keterangan' => $request->keterangan,
            'type' => $request->type,
            'kriteria_id' => $request->type === 'dengan_kriteria' ? $request->kriteria : null,
            'operator' => $request->type === 'dengan_kriteria' ? $request->operator : null,
            'value' => $request->type === 'dengan_kriteria' && $request->value ? json_encode($request->value) : null,
        ]);

        return response()->json(['success' => "Data persyaratan berhasil diperbarui.", 'data' => $persyaratan]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        PersyaratanBeasiswa::where('id', $id)->delete();
    }
}
