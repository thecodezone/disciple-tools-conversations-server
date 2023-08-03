<?php

namespace App\Jobs;

use App\Data\MessageWebhook;
use App\Http\Webhooks\Driver;
use App\Sdks\DtSdk;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private DtSdk $dtSdk;

    /**
     * Create a new job instance.
     */
    public function __construct(DtSdk $dtSdk)
    {
        $this->dtSdk = $dtSdk;
    }

    /**
     * Execute the job.
     */
    public function handle(Driver $channel, MessageWebhook $webhook): void
    {
        $this->dtSdk->sendWebhook($channel->instance, $webhook);
    }
}
