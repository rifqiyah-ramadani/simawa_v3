<?php

namespace Database\Factories;

use App\Models\TahapanBeasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TahapanBeasiswa>
 */
class TahapanBeasiswaFactory extends Factory
{
    protected $model = TahapanBeasiswa::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */ 
    public function definition()
    {
        return [
            'nama_tahapan' => $this->faker->unique()->word,
        ];
    }
}
