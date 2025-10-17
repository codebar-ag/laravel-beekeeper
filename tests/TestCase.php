<?php

namespace CodebarAg\LaravelBeekeeper\Tests;

use CodebarAg\LaravelBeekeeper\LaravelBeekeeperServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Saloon\Laravel\SaloonServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'CodebarAg\\LaravelBeekeeper\\Database\\Factories\\'.class_basename($modelName).'Factory',
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaravelBeekeeperServiceProvider::class,
            SaloonServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}
