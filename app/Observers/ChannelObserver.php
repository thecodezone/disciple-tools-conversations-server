<?php

namespace App\Observers;

use App\Http\Webhooks\FacebookPage\HandleChannelSave;
use App\Models\Channel;

class ChannelObserver
{
    public function __construct(HandleChannelSave $storeFacebookPageToken)
    {
        $this->storeFacebookPageToken = $storeFacebookPageToken;
    }

    /**
     * Handle the Channel "created" event.
     */
    public function created(Channel $channel): void
    {
    }

    /**
     * Handle the Channel "updated" event.
     */
    public function updated(Channel $channel): void
    {
        //
    }

    /**
     * Handle the Channel "updated" event.
     */
    public function saved(Channel $channel): void
    {
        if ($channel->type->name === 'facebook-page-comment') {
            $this->storeFacebookPageToken->execute($channel, auth()->user());
        }
    }

    /**
     * Handle the Channel "deleted" event.
     */
    public function deleted(Channel $channel): void
    {
        //
    }

    /**
     * Handle the Channel "restored" event.
     */
    public function restored(Channel $channel): void
    {
        //
    }

    /**
     * Handle the Channel "force deleted" event.
     */
    public function forceDeleted(Channel $channel): void
    {
        //
    }
}
