<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'fakultas_id' => null, // Isi sesuai kebutuhan jika fakultas_id wajib
            'username' => $this->faker->userName, // Menggantikan email
            'name' => $this->faker->name,
            'nip' => $this->faker->unique()->randomNumber(8),
            'usertype' => 'admin', // Sesuaikan usertype default Anda
            'password' => bcrypt('password'), // Kata sandi default
            'remember_token' => Str::random(10),
        ];
    }
}
