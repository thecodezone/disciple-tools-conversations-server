<?php

namespace App\Channels;

use Illuminate\Http\Response;

interface Channel {
    public function settingsFields(): array;
    public static function register(): void;
    public function connected(\App\Models\Channel $channel): bool;

    public function verifyRequest(\App\Models\Channel $channel, \Illuminate\Http\Request $request): bool;

    public function handleChallengeRequest(\App\Models\Channel $channel, \Illuminate\Http\Request $request): Response;
}
