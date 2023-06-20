<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use DateTime;

class Message extends Data {
    public function __construct(
        public string $channel,
        public int $channel_id,
        public string $service,
        public int $service_id,
        public string $provider,
        public int $provider_id,
        public int $webhook_id,
        public string $webhook_type,
        public string $message,
        public DateTime $receivedAt,
        public int $from_id,
        public string $from_name,
        public array $raw,
    ) {
    }
}
