<?php

namespace Database\Seeders;

use App\Http\Webhooks\FacebookPage;
use App\Http\Webhooks\FacebookPageMessenger;
use App\Models\ChannelType;
use Illuminate\Database\Seeder;

class ChannelTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $webhookClients = collect(config('webhook-client.configs'));

        foreach ($webhookClients as $client) {
            ChannelType::updateOrCreate(
                [
                    'name' => $client['name'],
                ],
                [
                    'label' => $client['label'],
                ]
            );
        }

        $channels = ChannelType::whereNotIn('name', $webhookClients->pluck('name'))->get();
        $channels->each(function ($channel) {
            $channel->delete();
        });
    }
}
