<?php

namespace App\Providers;

use App\Notifications\QueueFailed;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $slackUrl = env('SLACK_ERROR_URL');
        if ($slackUrl) {
            Queue::failing(function (JobFailed $event) use ($slackUrl) {
                Notification::route('slack', $slackUrl)->notify(new QueueFailed($event));
            });
        }
    }
}
