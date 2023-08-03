<?php

namespace App\Http\Webhooks\FacebookPage;

use App\Http\Webhooks\WebhookSettings;
use App\Models\Service;
use App\Sdks\FacebookSdk;
use Filament\Forms\Components\Select;

class PageSettings implements WebhookSettings
{
    /**
     * The Facebook SDK.
     *
     * @var \App\Sdks\FacebookSdk
     */
    protected $facebookSdk;

    public function __construct(FacebookSdk $facebookSdk)
    {
        $this->facebookSdk = $facebookSdk;
    }

    /**
     * Get the Filament settings repeater schema for this channel.
     *
     * @see https://filamentphp.com/docs/2.x/forms/fields#repeater
     * @param \App\Models\Service $service
     * @return array
     */
    public function fields(Service $service): array
    {
        $token = $service->token;
        $accounts = $this->facebookSdk->getAccounts($token);

        if (! count($accounts['data'])) {
            return [];
        }

        return [
            Select::make('facebook_page')
                ->options(collect($accounts['data'])->mapWithKeys(function ($account) {
                    return [json_encode($account) => $account['name']];
                })->toArray())
                ->required(),
        ];
    }
}
