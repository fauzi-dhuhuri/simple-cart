<?php

namespace Tests;

use FauziDhuhuri\SimpleCart\CartServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [CartServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        // $app['config']->set('database.default', 'testing');
        // $app['config']->set('database.connections.testing', [
        //     'driver' => 'sqlite',
        //     'database' => ':memory:',
        //     'prefix' => '',
        // ]);
        $app['config']->set('cart.storage.driver', 'session');

    }

    // protected function defineDatabaseMigrations(): void
    // {
    //     // Ini akan memuat semua migration dari folder package-mu
    //     $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    // }
}
