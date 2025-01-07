<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Permission;
use App\Models\TahapanBeasiswa;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TahapanTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Tambahkan permission ke database
        $permissions = [
            'read master_beasiswa/tahapan_beasiswa',
            'create master_beasiswa/tahapan_beasiswa',
            'update master_beasiswa/tahapan_beasiswa',
            'delete master_beasiswa/tahapan_beasiswa',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
    }

        /**
     * Test: Data tahapan beasiswa dapat diambil dengan AJAX
     */
    public function test_ajax_index_returns_datatables_response()
    {
        // Buat user dengan izin akses
        $user = User::factory()->create();
        $user->givePermissionTo('read master_beasiswa/tahapan_beasiswa');

        // Login dengan user tersebut
        $this->actingAs($user);

        // Buat beberapa data beasiswa
        TahapanBeasiswa::factory(2)->create();

        // Simulasikan permintaan AJAX ke endpoint
        $response = $this->getJson(route('tahapan_beasiswa.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        // Pastikan respons berupa JSON dengan data beasiswa
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

        /**
    * Test: Tahapan beasiswa dapat disimpan dengan validasi yang benar
    */
    public function test_store_saves_data_successfully()
    {
        // Buat user dengan izin akses
        $user = User::factory()->create();
        $user->givePermissionTo('create master_beasiswa/tahapan_beasiswa');

        // Login dengan user tersebut
        $this->actingAs($user);

        // Data yang akan dikirim
        $data = [
            'nama_tahapan' => 'Seleksi Administrasi',
        ];

        // Simulasikan POST request ke endpoint store
        $response = $this->postJson(route('tahapan_beasiswa.store'), $data);

        // Pastikan respons sukses
        $response->assertStatus(200);
        $response->assertJson(['success' => 'Berhasil menyimpan data']);

        // Pastikan data tersimpan di database
        $this->assertDatabaseHas('tahapan_beasiswas', $data);
    }

    /**
     * Test: Tahapan beasiswa dapat diambil untuk diedit
     */
    public function test_edit_tahapan_beasiswa()
    {
        // Buat user dengan izin akses
        $user = User::factory()->create();
        $user->givePermissionTo('update master_beasiswa/tahapan_beasiswa');

        // Login dengan user tersebut
        $this->actingAs($user);

        // Buat data beasiswa
        $beasiswa = TahapanBeasiswa::factory()->create();

        // Simulasikan permintaan GET ke endpoint edit
        $response = $this->getJson(route('tahapan_beasiswa.edit', $beasiswa->id));

        // Pastikan respons sukses
        $response->assertStatus(200);
        $response->assertJson(['result' => $beasiswa->toArray()]);
    }

       /**
     * Test: Tahapan beasiswa dapat diperbarui dengan validasi yang benar
     */
    public function test_update_tahapan_beasiswa_success()
    {
        // Buat user dengan izin akses
        $user = User::factory()->create();
        $user->givePermissionTo('update master_beasiswa/tahapan_beasiswa');

        // Login dengan user tersebut
        $this->actingAs($user);

        // Buat tahapan beasiswa
        $beasiswa = TahapanBeasiswa::factory()->create();

        // Data baru untuk update
        $data = [
            'nama_tahapan' => 'Seleksi Wawancara',
        ];

        // Simulasikan permintaan PUT ke endpoint update
        $response = $this->putJson(route('tahapan_beasiswa.update', $beasiswa->id), $data);

        // Pastikan respons sukses
        $response->assertStatus(200);
        $response->assertJson(['success' => 'Berhasil memperbarui data']);

        // Pastikan data diperbarui di database
        $this->assertDatabaseHas('tahapan_beasiswas', array_merge(['id' => $beasiswa->id], $data));
    }

    /**
     * Test: Tahapan beasiswa dapat dihapus dengan benar
     */
    public function test_destroy_tahapan_beasiswa_successfully()
    {
        // Buat user dengan izin akses
        $user = User::factory()->create();
        $user->givePermissionTo('delete master_beasiswa/tahapan_beasiswa');

        // Login dengan user 
        $this->actingAs($user);

        // Buat data beasiswa
        $beasiswa = TahapanBeasiswa::factory()->create();

        // Simulasikan permintaan DELETE ke endpoint destroy
        $response = $this->deleteJson(route('tahapan_beasiswa.destroy', $beasiswa->id));

        // respons sukses
        $response->assertStatus(200);

        // data di database sudah terhapus
        $this->assertDatabaseMissing('tahapan_beasiswas', ['id' => $beasiswa->id]);
    }

}
