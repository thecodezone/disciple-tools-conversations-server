<?php

namespace App\Services;

interface Service {
    /**
     * Get the name of the service driver.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get the type of the service driver.
     * Should correspond the service type
     * column in the services table and
     * config.services.drivers.
     *
     * @return string
     */
    public function getType(): string;

}
