<?php

namespace App\Providers;

use App\Notifications\QueueFailed;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
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
        Queue::before(function (JobProcessing $event) {
            activity('queue')
                ->causedBy($event->job->payload()['data']['user_id'])
                ->log('Job processing: ' . $event->job->resolveName());
        });

        Queue::failing(function (JobFailed $event) {
            $slackUrl = env('SLACK_ERROR_URL');
            if ($slackUrl) {
                Notification::route('slack', $slackUrl)->notify(new QueueFailed($event));
            }

            activity('queue')
                ->causedBy($event->job->payload()['data']['user_id'])
                ->log('Job failed: ' . $event->job->resolveName() . ' at ' . $event->exception->getFile() . ':' . $event->exception->getLine());
        });

        Queue::after(function (JobProcessed $event) {
            activity('queue')
                ->causedBy($event->job->payload()['data']['user_id'])
                ->log('Job processed: ' . $event->job->resolveName());
        });
    }
}
