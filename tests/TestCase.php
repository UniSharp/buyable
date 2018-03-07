<?php
namespace UniSharp\Buyable\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use UniSharp\Buyable\Providers\BuyableServiceProvider;
use UniSharp\Buyable\Tests\Fixtures\Providers\TestingServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'test');
        $app['config']->set('database.connections.test', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }


    protected function getPackageProviders($app)
    {
        return [
            BuyableServiceProvider::class,
            TestingServiceProvider::class,
        ];
    }
}
