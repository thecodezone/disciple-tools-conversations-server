<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class MessageWebhook extends Data {
    /**
     * All support message verb constants,
     */
    const VERB_ADD = 'add';
    const VERB_EDIT = 'edit';
    const VERB_DELETE = 'delete';

    /**
     * All constants as an array
     * @var array|string[]
     */
    public array $verbs = [
        self::VERB_ADD,
        self::VERB_EDIT,
        self::VERB_DELETE,
    ];

    public function __construct(
        public string $channel,
        public string $service,
        public string $provider,
        public int $post_url,
        public string $post_type,
        public int $message_id,
        public string $message,
        public string $verb,
        public string $from_name,
        public string $link,
        #[DataCollectionOf(Attachment::class)]
        public int $channel_id,
        public int $service_id,
        public int $provider_id,
        public int $post_id,
        public int $from_id,
        public \DateTime $posted_at,
    ) {
    }
}
