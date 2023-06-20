<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class Webhook extends Data {
    public function __construct(
        public string $channel,
        public int $channel_id,
        public string $service,
        public int $service_id,
        public string $provider,
        public int $provider_id,
        #[DataCollectionOf(Message::class)]
        public array $messages,
        public array $raw,
    ) {
    }
}
