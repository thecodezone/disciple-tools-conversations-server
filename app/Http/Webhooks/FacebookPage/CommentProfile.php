<?php

namespace App\Http\Webhooks\FacebookPage;

use App\Data\MessageWebhook;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\WebhookClient\WebhookProfile\WebhookProfile;

class CommentProfile implements WebhookProfile
{
    public array $verbs = [
        'add' => MessageWebhook::VERB_ADD,
        'edited' => MessageWebhook::VERB_EDIT,
        'edit' => MessageWebhook::VERB_EDIT,
        'delete' => MessageWebhook::VERB_DELETE,
        'remove' => MessageWebhook::VERB_DELETE,
    ];

    /**
     * Should the webhook be processed?
     *
     * @param \App\Models\Channel $channel
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function shouldProcess(Request $request): bool
    {
        $entries = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        if (! Arr::has($entries, '0')) {
            return false;
        }

        $entries = $this->filterEntries(collect($entries));

        if (! $entries->count()) {
            return false;
        }

        return true;
    }

    /**
     * Filtering entries to include only entries we want to process.
     *
     * @param \Illuminate\Support\Collection $collection
     * @return \Illuminate\Support\Collection
     */
    public function filterEntries(Collection $collection): Collection
    {
        return $collection->map(function ($entry) {
            $entry['changes'] = $this->filterChanges(collect($entry['changes']));
            return $entry;
        })->filter(function ($entry) {
            if ($entry['object'] !== 'page') {
                return false;
            }
            if (is_array(Arr::get($entry, 'changes'))) {
                return false;
            }

            if (! $entry['changes']->count()) {
                return false;
            }

            return true;
        });
    }

    /**
     * Filtering changes to include only changes we want to process.
     *
     * @param \Illuminate\Support\Collection $collection
     * @return \Illuminate\Support\Collection
     */
    public function filterChanges(Collection $collection): Collection
    {
        return $collection->filter(function ($change) {
            return $change['field'] === 'feed'
                && Arr::get($change, 'value.item') === 'comment'
                && in_array(Arr::get($change, 'value.verb'), array_keys($this->verbs));
        });
    }
}
