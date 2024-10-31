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
        // return view('profile.edit', [
        //     'user' => $request->user(),
        // ]);

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
    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    //     $request->user()->fill($request->validated());

    //     if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }

    //     $request->user()->save();

    //     return Redirect::route('profile.edit')->with('status', 'profile-updated');
    // }

    /**
     * Delete the user's account.
     */
    // public function destroy(Request $request): RedirectResponse
    // {
    //     $request->validateWithBag('userDeletion', [
    //         'password' => ['required', 'current_password'],
    //     ]);

    //     $user = $request->user();

    //     Auth::logout();

    //     $user->delete();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return Redirect::to('/');
    // }
}
