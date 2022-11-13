<?php

declare(strict_types=1);

namespace App\Providers;

use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();
        Horizon::night();
    }

    protected function authorization(): void
    {
        Horizon::auth(fn() => true);
    }

    protected function gate(): void
    {
        Horizon::auth(fn() => true);
    }
}
