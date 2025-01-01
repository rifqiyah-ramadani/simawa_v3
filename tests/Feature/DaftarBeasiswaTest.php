<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Permission;
use App\Models\DaftarBeasiswa;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DaftarBeasiswaTest extends TestCase
{
    
    protected function setUp(): void
    {
        parent::setUp();

        // Tambahkan permission ke database
        $permissions = [
            'read master_beasiswa/daftar_beasiswa',
            'create master_beasiswa/daftar_beasiswa',
            'update master_beasiswa/daftar_beasiswa',
            'delete master_beasiswa/daftar_beasiswa',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
    }
 
    /**
     * Test: Data daftar beasiswa dapat diambil dengan AJAX
     */
    public function test_ajax_index_returns_datatables_response()
    {
        // Buat user dengan izin akses
        $user = User::factory()->create();
        $user->givePermissionTo('read master_beasiswa/daftar_beasiswa');

        // Login dengan user tersebut
        $this->actingAs($user);

        // Buat beberapa data beasiswa
        DaftarBeasiswa::factory(2)->create();

        // Simulasikan permintaan AJAX ke endpoint
        $response = $this->getJson(route('daftar_beasiswa.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        // Pastikan respons berupa JSON dengan data beasiswa
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    /**
    * Test: Data beasiswa dapat disimpan dengan validasi yang benar
    */
    public function test_store_saves_data_successfully()
    {
        // Buat user dengan izin akses
        $user = User::factory()->create();
        $user->givePermissionTo('create master_beasiswa/daftar_beasiswa');

        // Login dengan user tersebut
        $this->actingAs($user);

        // Data yang akan dikirim
        $data = [
            'kode_beasiswa' => 'BEAS001',
            'nama_beasiswa' => 'Beasiswa Unggulan',
            'penyelenggara' => 'Kemendikbud',
        ];

        // Simulasikan POST request ke endpoint store
        $response = $this->postJson(route('daftar_beasiswa.store'), $data);

        // Pastikan respons sukses
        $response->assertStatus(200);
        $response->assertJson(['success' => 'Berhasil menyimpan data']);

        // Pastikan data tersimpan di database
        $this->assertDatabaseHas('daftar_beasiswas', $data);
    }

    /**
     * Test: Data beasiswa dapat diambil untuk diedit
     */
    public function test_edit_daftar_beasiswa()
    {
        // Buat user dengan izin akses
        $user = User::factory()->create();
        $user->givePermissionTo('update master_beasiswa/daftar_beasiswa');

        // Login dengan user tersebut
        $this->actingAs($user);

        // Buat data beasiswa
        $beasiswa = DaftarBeasiswa::factory()->create();

        // Simulasikan permintaan GET ke endpoint edit
        $response = $this->getJson(route('daftar_beasiswa.edit', $beasiswa->id));

        // Pastikan respons sukses
        $response->assertStatus(200);
        $response->assertJson(['result' => $beasiswa->toArray()]);
    }

    /**
     * Test: Data beasiswa dapat diperbarui dengan validasi yang benar
     */
    public function test_update_daftar_beasiswa_success()
    {
        // Buat user dengan izin akses
        $user = User::factory()->create();
        $user->givePermissionTo('update master_beasiswa/daftar_beasiswa');

        // Login dengan user tersebut
        $this->actingAs($user);

        // Buat data beasiswa
        $beasiswa = DaftarBeasiswa::factory()->create();

        // Data baru untuk update
        $data = [
            'kode_beasiswa' => 'BEAS002',
            'nama_beasiswa' => 'Beasiswa Prestasi',
            'penyelenggara' => 'Lembaga XYZ',
        ];

        // Simulasikan permintaan PUT ke endpoint update
        $response = $this->putJson(route('daftar_beasiswa.update', $beasiswa->id), $data);

        // Pastikan respons sukses
        $response->assertStatus(200);
        $response->assertJson(['success' => 'Berhasil memperbarui data']);

        // Pastikan data diperbarui di database
        $this->assertDatabaseHas('daftar_beasiswas', array_merge(['id' => $beasiswa->id], $data));
    }

    /**
     * Test: Data beasiswa dapat dihapus dengan benar
     */
    public function test_destroy_deletes_beasiswa_successfully()
    {
        // Buat user dengan izin akses
        $user = User::factory()->create();
        $user->givePermissionTo('delete master_beasiswa/daftar_beasiswa');

        // Login dengan user 
        $this->actingAs($user);

        // Buat data beasiswa
        $beasiswa = DaftarBeasiswa::factory()->create();

        // Simulasikan permintaan DELETE ke endpoint destroy
        $response = $this->deleteJson(route('daftar_beasiswa.destroy', $beasiswa->id));

        // respons sukses
        $response->assertStatus(200);

        // data di database sudah terhapus
        $this->assertDatabaseMissing('daftar_beasiswas', ['id' => $beasiswa->id]);
    }

}
