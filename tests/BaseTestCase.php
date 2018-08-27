<?php

namespace Stylers\EmailChange\Tests;

use Illuminate\Support\Facades\Config;
use Orchestra\Testbench\TestCase;
use Stylers\EmailChange\ServiceProvider as EmailChangeServiceProvider;
use Stylers\EmailChange\Tests\ServiceProvider as EmailChangeTestServiceProvider;

class BaseTestCase extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->setUpMigrations();
        $this->withFactories(__DIR__ . '/database/factories');
    }

    protected function getPackageProviders($app)
    {
        return [
            EmailChangeTestServiceProvider::class,
            EmailChangeServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        /** @var Config $app['config'] */
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function setUpMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->artisan('migrate', ['--database' => 'testing']);
    }
}