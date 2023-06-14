<?php

namespace App\Observers;

class InstanceObserver
{
    public function creating($instance): void
    {
        $instance->verification_token = bin2hex(random_bytes(32));
    }
}
