<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'          => fake()->name(),
            'email'         => fake()->unique()->safeEmail(),
            'password'      => bcrypt('123'),
            'nik'           => date('Ymd').rand(000,999),
            'alamat'        => fake()->address(),
            'tlp'           => fake()->phoneNumber(),
            'role'          => rand(0,1),
            'tglLahir'      => fake()->date('Y-m-d','now'),
            'is_active'     => 1,
            'is_member'     => 0,
            'is_admin'      => 1,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    // public function unverified(): static
    // {
    //     // return $this->state(fn (array $attributes) => [
    //     //     'email_verified_at' => null,
    //     // ]);
    // }
}
