<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Http\Middleware\IsSuperadmin;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        app('router')->aliasMiddleware('is_superadmin', IsSuperadmin::class);
    }
}
