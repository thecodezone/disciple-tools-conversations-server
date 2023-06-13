<?php

namespace App\Services;

/**
 * Handles Facebook Messenger connections
 */
class FacebookMessenger implements Service {

    /**
     * Get the name of the service driver.
     *
     * @return string
     */
    public function getName(): string {
        return 'Facebook Messenger';
    }

    /**
     * Get the type of the service driver.
     * Should correspond the service type
     * column in the services table and
     * config.services.drivers.
     *
     * @return string
     */
    public function getType(): string {
        return 'facebook_messenger';
    }
}
