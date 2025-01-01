<?php

namespace Tests\Unit;

use App\Models\DaftarBeasiswa;
use Illuminate\Support\Facades\Validator;
use Mockery;
use Tests\TestCase;

class DaftarBeasiswaMockTest extends TestCase
{
    public function test_store_beasiswa_success()
    {
        $this->withoutMiddleware();
    
        $data = [
            'kode_beasiswa' => 'BEAS001',
            'nama_beasiswa' => 'Beasiswa Unggulan',
            'penyelenggara' => 'Kemendikbud',
        ];
    
        Validator::shouldReceive('make')
            ->once()
            ->with($data, Mockery::any(), Mockery::any())
            ->andReturn((object) ['fails' => fn() => false]);
    
        $mock = Mockery::mock('alias:App\Models\DaftarBeasiswa');
        $mock->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn((object) $data);
    
        $response = $this->postJson(route('daftar_beasiswa.store'), $data);
    
        $response->assertStatus(200);
        $response->assertJson([
            'success' => 'Berhasil menyimpan data',
        ]);
    }
    
    
    
    

    // public function test_store_beasiswa_validation_fails()
    // {
    //     $data = [
    //         'kode_beasiswa' => '',
    //         'nama_beasiswa' => '',
    //         'penyelenggara' => '',
    //     ];
    
    //     // Mock Validator to simulate validation failure
    //     Validator::shouldReceive('make')
    //         ->once()
    //         ->with($data, Mockery::any(), Mockery::any())
    //         ->andReturn((object)[
    //             'fails' => fn() => true,
    //         ]);
    
    //     $validator = Validator::make($data, []);
    
    //     $this->assertTrue($validator->fails());
    // }
    

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
