<?php

namespace App\Services;

use Illuminate\Foundation\Application;

/**
 * Handles service driver creation
 */
class ServiceFactory {
    public $app;

    public function __construct(Application $app) {
        $this->app = $app;
    }

    public function namespace(string $type): string {
        $driver = config('services.drivers.' . $type);

        if (!$driver) {
            throw new \Exception('Service driver not found');
        }

        return $driver;
    }

    /**
     * Make a service driver from a type;
     *
     * @param string $type
     * @return Service
     */
    public function make(string $type): Service {
        $namespace = $this->namespace($type);
        return $this->app->make($namespace);
    }
}
