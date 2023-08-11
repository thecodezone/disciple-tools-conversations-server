<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class InstanceFactory extends Factory
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
            'endpoint' => $this->faker->url,
        ];
    }

    public function hasFacebookPageComments(): static
    {
        return $this->has(
            \App\Models\Service::factory()
                ->hasFacebookPageComments()
        );
    }
}
