<?php

namespace Database\Factories;

use App\Models\Kriteria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kriteria>
 */
class KriteriaFactory extends Factory
{
    protected $model = Kriteria::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $tipeInput = $this->faker->randomElement(['text', 'number', 'dropdown']);
        $opsiDropdown = $tipeInput === 'dropdown' 
            ? json_encode($this->faker->words(3)) 
            : null;

        return [
            'nama_kriteria' => $this->faker->unique()->words(2, true),
            'tipe_input' => $tipeInput,
            'opsi_dropdown' => $opsiDropdown,
            'key_detail_user' => $this->faker->randomElement(['ipk', 'jenjang_pendidikan', 'semester']),
        ];
    }

}
