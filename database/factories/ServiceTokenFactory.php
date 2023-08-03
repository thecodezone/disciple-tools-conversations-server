<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceToken>
 */
class ServiceTokenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'service' => $this->faker->words(1, true),
            'user_id' => \App\Models\User::factory(),
            'service_id' => \App\Models\Service::factory(),
            'token' => $this->faker->sha256,
            'expires_at' => $this->faker->dateTimeBetween('now', '+1 year'),
        ];
    }
}
