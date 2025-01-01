<?php

namespace Database\Factories;

use App\Models\Kriteria;
use App\Models\PersyaratanBeasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PersyaratanBeasiswa>
 */
class PersyaratanBeasiswaFactory extends Factory
{ 
    protected $model = PersyaratanBeasiswa::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $kriteria = Kriteria::inRandomOrder()->first();
        $type = $this->faker->randomElement(['tanpa_kriteria', 'dengan_kriteria']);

        return [
            'nama_persyaratan' => $this->faker->unique()->words(2, true),
            'keterangan' => $this->faker->sentence(),
            'type' => $type,
            'kriteria_id' => $type === 'dengan_kriteria' ? $kriteria->id : null,
            'operator' => $type === 'dengan_kriteria' ? $this->faker->randomElement(['>=', '<=', '=', '<', '>', '!=']) : null,
            'value' => $type === 'dengan_kriteria' && $kriteria->tipe_input === 'dropdown' 
                ? json_encode($this->faker->words(3)) 
                : ($type === 'dengan_kriteria' ? $this->faker->randomNumber(2) : null),
        ];
    }
}
