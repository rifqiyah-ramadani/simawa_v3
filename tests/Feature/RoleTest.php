<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Role;
use App\Models\User;

class RoleTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase; // Membersihkan database setelah setiap tes

    /**
     * Setup database dengan data awal sebelum setiap tes.
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Buat data role untuk pengujian
        Role::factory()->count(1)->create();
    }

    /**
     * Test: Memastikan halaman index dapat diakses.
     */
    public function test_index_accessed()
    {
        $this->withoutMiddleware(); // Nonaktifkan middleware selama pengujian
    
        $user = User::factory()->create(); // Buat pengguna dummy
        $this->actingAs($user); // Login sebagai pengguna dummy

        $response = $this->get('/konfigurasi/role');
        $response->assertStatus(200); // Memastikan respons sukses
        $response->assertViewIs('konfigurasi.role'); // Memastikan view yang benar
    }

    /**
     * Test: Memastikan data roles dikembalikan dalam format JSON.
     */
    public function test_roles_data_can_be_fetched_with_ajax()
    {
        $response = $this->getJson('/konfigurasi/role', ['X-Requested-With' => 'XMLHttpRequest']);
        $response->assertStatus(200); // Memastikan respons sukses
        $response->assertJsonStructure([ // Memastikan struktur JSON benar
            'data' => [
                '*' => ['id', 'name', 'created_at', 'updated_at']
            ]
        ]);
    }

    /**
     * Test: Pastikan middleware "can:read konfigurasi/role" bekerja.
     */
    public function test_access_is_restricted_without_permission()
    {
        $this->withoutMiddleware('can:read konfigurasi/role');

        $response = $this->get('/konfigurasi/role');
        $response->assertStatus(403); // Memastikan akses ditolak
    }

    // public function testCanShowRolePage()
    // {
    //     $user = User::role('Operator Kemahasiswaan')->get()->random();
    //     $this->actingAs($user);
    //     $this->get('/roles')
    //     ->assertOk();
    // }

    // public function testCannotShowRolePage()
    // {
    //     $user = User::role('Mahasiswa')->get()->random();
    //     $this->actingAs($user)
    //     ->get('roles')
    //     ->assertStatus(403);
    // }

    // public function testCannotShowRoleNotLogin()
    // {
    //     $this->get('roles')
    //     ->assertRedirect('login')
    //     ->assertStatus(302);
    // }

    // public function testCanCreateRole()
    // {
    //     $user = User::role('Operator Kemahasiswaan')->get()->random();
    //     $this->actingAs($user);
    //     $this->get('/roles/create')
    //     ->assertOk();
    // }

    // public function testCannotCreateRole()
    // {
    //     $user = User::role('Mahasiswa')->get()->random();
    //     $this->actingAs($user);
    //     $this->get('/roles/create')
    //     ->assertStatus(403);
    // }

}
