<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * Model yang terkait dengan factory ini.
     *
     * @var string
     */
    protected $model = Role::class;

    /**
     * Definisikan data default untuk model.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word, // Field 'name' dengan data unik
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
