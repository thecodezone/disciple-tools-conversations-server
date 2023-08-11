<?php

namespace Database\Factories;

use App\Models\ChannelType;
use App\Models\Service;
use App\Models\ServiceToken;
use App\Models\ServiceType;
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
            'channel_type_id' => ChannelType::inRandomOrder()->first()->name,
            'settings' => ''
        ];
    }

    public function forChannelType(string $channelTypeName): ChannelFactory
    {
        return $this->state(function (array $attributes) use ($channelTypeName) {
            return array_merge($attributes, [
                'channel_type_id' => ChannelType::where('name', $channelTypeName)->first()->name,
            ]);
        });
    }

    public function facebookPageMessages(): ChannelFactory
    {
        return $this->forChannelType('facebook-page-messages');
    }

    public function facebookPageComments(): ChannelFactory
    {
        return $this->forChannelType('facebook-page-comments');
    }

}
