<?php

namespace App\Providers;

use App\Models\Channel;
use App\Models\Instance;
use App\Models\Service;
use App\Observers\ChannelObserver;
use App\Observers\InstanceObserver;
use App\Observers\ServiceObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SocialiteProviders\Facebook\FacebookExtendSocialite;
use SocialiteProviders\Manager\SocialiteWasCalled;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SocialiteWasCalled::class => [
            FacebookExtendSocialite::class . '@handle',
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Instance::observe(InstanceObserver::class);
        Service::observe(ServiceObserver::class);
        Channel::observe(ChannelObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
