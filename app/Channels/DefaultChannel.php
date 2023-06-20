<?php

namespace App\Channels;

class DefaultChannel implements Channel {
    public function settingsFields(): array {
        return [];
    }

    public static function register(): void {
        // Do Nothing
    }

    public function connected( \App\Models\Channel $channel ): bool {
        return true;
    }
}
