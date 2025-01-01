<?php

namespace Database\Factories;

use App\Models\DaftarBeasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DaftarBeasiswa>
 */
class DaftarBeasiswaFactory extends Factory
{
    protected $model = DaftarBeasiswa::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */ 
    public function definition()
    {
        return [
            'kode_beasiswa' => $this->faker->unique()->bothify('BEAS###'),
            'nama_beasiswa' => $this->faker->sentence(3),
            'penyelenggara' => $this->faker->company,
        ];
    }
}
