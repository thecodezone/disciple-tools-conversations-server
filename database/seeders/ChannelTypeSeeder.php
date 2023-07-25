<?php

namespace Database\Seeders;

use App\Channels\DefaultChannel;
use App\Channels\FacebookPage;
use App\Models\ChannelType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChannelTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChannelType::updateOrCreate(
            [
                'id' => 1,
                'slug' => 'facebook-page',
                'name' => 'Facebook Page',
                'classname' => FacebookPage::class
            ]
        );

        ChannelType::updateOrCreate(
            [
                'id' => 2,
                'slug' => 'facebook-messenger',
                'name' => 'Facebook Messenger',
                'classname' => DefaultChannel::class
            ]
        );
    }
}
