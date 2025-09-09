<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Http\Middleware\IsSuperadmin;
use App\Models\Contact;  

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        app('router')->aliasMiddleware('is_superadmin', IsSuperadmin::class);

        View::composer('components.footer', function ($view) {
            $contact = Cache::remember(
                'footer_contact',
                now()->addMinutes(30),  
                function () {
                    return Contact::query()
                        ->select('email','telepon','alamat','latitude','longitude','link_maps','updated_at')
                        ->latest('updated_at')
                        ->first();
                }
            );

            $view->with('contact', $contact);
        });
    }
}
