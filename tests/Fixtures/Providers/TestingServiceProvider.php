<?php
namespace UniSharp\Buyable\Tests\Fixtures\Providers;

use Illuminate\Support\ServiceProvider;

class TestingServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(
            __DIR__.'/../database/migrations'
        );
    }
}
