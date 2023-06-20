<?php

namespace Database\Factories;

use App\Models\ChannelType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Channel>
 */
class ChannelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'channel_type_id' => ChannelType::inRandomOrder()->first()->id,
            'settings' => ''
        ];
    }

    public function facebookPage(): ChannelFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'channel_type_id' => ChannelType::where('name', 'Facebook Page')->first()->id,
                'settings' => json_encode([
                    'facebook_page' => 1,
                ]),
            ];
        });
    }
}
