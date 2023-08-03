<?php

namespace App\Http\Webhooks;

use App\Models\Service;

class DefaultSettings implements WebhookSettings
{
    /**
     * Get the Filament settings repeater schema for this channel.
     *
     * @see https://filamentphp.com/docs/2.x/forms/fields#repeater
     * @param \App\Models\Service $service
     * @return array
     */
    public function fields(Service $service): array
    {
        return [];
    }
}
