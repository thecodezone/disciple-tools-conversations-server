<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\Instance;
use App\Models\ServiceToken;
use App\Models\ServiceType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ServiceFactory extends Factory
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
            'service_type_id' => ServiceType::inRandomOrder()->first()->id,
            'instance_id' => Instance::count() ? Instance::inRandomOrder()->first()->id : Instance::factory()->create()->id,
        ];
    }

    public function facebook()
    {
        return $this->state(function (array $attributes) {
            return [
                'service_type_id' => ServiceType::find(ServiceType::FACEBOOK)->id,
            ];
        });
    }

    public function hasFacebookPageComments()
    {
        return $this->facebook()
            ->for(
                ServiceToken::factory()->create()
            )
            ->has(
                Channel::factory()->facebookPageComments()->count(1)
            );
    }
}
