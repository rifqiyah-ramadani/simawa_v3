<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Informasi;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data berita 
        $berita = Informasi::where('kategori_informasi', 'berita')
            ->select(['id', 'judul', 'content', 'image', 'publish_date'])
            ->latest('publish_date')
            ->paginate(3);// Contoh: ambil 3 berita terbaru

        // Ambil data pengumuman
        $pengumuman = Informasi::where('kategori_informasi', 'pengumuman')
                ->select(['id', 'judul', 'file', 'publish_date'])
                ->latest('publish_date')
                ->paginate(3); // Contoh: ambil 3 pengumuman terbaru

        // Tangani permintaan AJAX
        if ($request->ajax()) {
            $type = $request->input('type'); // Parameter 'type' untuk membedakan jenis data

            if ($type === 'berita') {
                return view('partials.berita-partial', compact('berita'))->render();
            }

            if ($type === 'pengumuman') {
                return view('partials.pengumuman-partial', compact('pengumuman'))->render();
            }
        }
        // Kirim data ke blade welcome
        return view('welcome', compact('berita', 'pengumuman'));
    }

    public function show($id)
    {
        // Ambil data berita berdasarkan ID
        $berita = Informasi::findOrFail($id);
        // dd($berita->content);
        $berita->content = nl2br(e($berita->content));

       // Ambil recent post (berita terbaru, selain berita yang sedang dibuka)
        $recentPosts = Informasi::where('kategori_informasi', 'berita')
        ->where('id', '!=', $id) // Kecualikan berita yang sedang dibuka
        ->select(['id', 'judul', 'image', 'publish_date'])
        ->latest('publish_date')
        ->take(3) // Ambil 3 berita terbaru
        ->get();

        // Kirimkan data ke view
        return view('welcome-detail/detail_berita', compact('berita', 'recentPosts'));
    }

    public function search(Request $request)
    {
        try {
            // Validasi input search
            $request->validate([
                'query' => 'required|string|min:3',
            ]);
    
            // Ambil query dari input user
            $query = $request->input('query');
    
            // Cari berita berdasarkan judul
            $recentPosts = Informasi::where('kategori_informasi', 'berita')
                ->where('judul', 'LIKE', '%' . $query . '%')
                ->select(['id', 'judul', 'image', 'publish_date'])
                ->latest('publish_date')
                ->take(3)
                ->get();
    
            // Cek apakah query berjalan dengan benar
            if ($recentPosts->isEmpty()) {
                return response()->json([
                    'html' => '<p>No recent posts found.</p>',
                ]);
            }
    
            // Render partial view untuk Recent Post
            return response()->json([
                'html' => view('partials.recent_posts', compact('recentPosts'))->render(),
            ]);
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error($e->getMessage());
            return response()->json([
                'error' => 'Something went wrong on the server.',
            ], 500);
        }
    }
}
