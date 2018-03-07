<?php
namespace UniSharp\Buyable\Providers;

use Illuminate\Support\ServiceProvider;

class BuyableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(
            __DIR__.'/../../database/migrations'
        );
    }
}
