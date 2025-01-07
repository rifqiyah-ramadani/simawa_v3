<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\DetailUser;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = auth()->user();
    
        // Cek apakah detail_user sudah ada, jika tidak buat instance baru
        $detail = $user->detailUser ?? new \App\Models\DetailUser();

        return view('profile.edit', compact('user', 'detail'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = auth()->user();
    
        // Jika user adalah mahasiswa, lakukan validasi untuk field tambahan
        if ($user->usertype === 'mahasiswa') {
            $validatedData = $request->validate([
                'program_reguler' => 'nullable|string',
                'semester' => 'nullable|string',
                'IPK' => 'nullable|numeric|between:0,4.00',
                'Umur' => 'nullable|integer',
                'status_beasiswa' => 'nullable|string',
                'jurusan' => 'nullable|string|max:255',
            ]);
        } else {
            // Jika bukan mahasiswa, kosongkan data tambahan
            $validatedData = [];
        }
    
        // Update atau buat data detail user
        $user->detailUser()->updateOrCreate(
            ['user_id' => $user->id],
            $validatedData
        );
    
        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}
