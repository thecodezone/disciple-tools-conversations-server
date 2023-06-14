<?php

namespace App\Observers;

class ServiceObserver
{
    public function saving($instance): void {
        if (!config('services.drivers.' . $instance->type)) {
            throw new \Exception('Service table row type does not match any service driver. Set one in config/services.php');
        }
    }
}
