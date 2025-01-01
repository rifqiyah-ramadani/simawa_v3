<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\DatabaseTransactions;
// use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test: User dapat login dengan username dan password valid
     */
    public function test_user_can_login_with_valid_credentials()
    {
        // Buat user dengan factory
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('password'), // Enkripsi password
        ]);
    
        // Simulate POST request
        $response = $this->post(route('login'), [
            'username' => 'testuser',
            'password' => 'password',
        ]);
    
        // Assert login berhasil
        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/dashboard'); // Sesuaikan dengan rute Anda
    }
    
    /**
     * Test: User gagal login dengan username dan password tidak valid
     */
    public function test_user_cannot_login_with_invalid_credentials()
    {
        // Buat user dengan data yang valid menggunakan factory
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('password'),
        ]);

        // Buatkan permintaan POST ke rute login dengan username dan password tidak valid
        $response = $this->post(route('login'), [
            'username' => 'testuser',
            'password' => 'wrongpassword', // Password yang salah
        ]);

        // Pastikan user tidak diautentikasi
        $this->assertGuest();

        // Periksa apakah user mendapatkan pesan error atau diarahkan kembali ke halaman login
        $response->assertSessionHasErrors(['username']); // Sesuaikan dengan validasi di aplikasi Anda
    }

    /**
     * Test: User dapat logout setelah login
     */
    public function test_user_can_logout()
    {
        // Buat user dan login
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('password'),
        ]);

        // Login terlebih dahulu
        $this->actingAs($user);

        // Buatkan permintaan POST ke rute logout
        $response = $this->post(route('logout'));

        // User keluar dari sesi login
        $this->assertGuest();

        // Periksa apakah user diarahkan ke halaman homepage setelah logout
        $response->assertRedirect('/'); 
    }
}
