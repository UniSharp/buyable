<?php
namespace UniSharp\Buyable\Providers;

use UniSharp\Buyable\Models\Spec;
use UniSharp\Buyable\Models\Buyable;
use Illuminate\Support\ServiceProvider;
use UniSharp\Buyable\Contracts\ProductUnitContract;
use UniSharp\Buyable\Contracts\BuyableModelContract;

class BuyableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(
            __DIR__.'/../../database/migrations'
        );
        $this->app->bind(ProductUnitContract::class, Spec::class);
        $this->app->bind(BuyableModelContract::class, Buyable::class);
    }
}
