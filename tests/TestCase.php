<?php

namespace Tests;

use Database\Seeders\DevelopmentSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase, DatabaseMigrations;

    /**
     * Seed the database
     */
    protected function setUp(): void {
        parent::setUp();
        $this->seed();
    }
}
