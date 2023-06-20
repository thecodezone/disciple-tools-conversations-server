<?php

namespace App\Observers;

class InstanceObserver
{
    public function creating($instance): void
    {
        $instance->verification_token = bin2hex(random_bytes(32));

    }

    public function created($instance): void
    {
        $instance->users()->attach(auth()->user()->id ?? 1);
    }
}
