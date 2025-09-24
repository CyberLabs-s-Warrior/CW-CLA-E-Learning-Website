<?php

namespace App\Providers;

use App\Http\Middleware\IsSuperadmin;
use App\Models\Contact;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Pakai template Bootstrap 5 untuk pagination
        Paginator::useBootstrapFive();

        // Alias middleware (kalau dipakai di routes)
        app('router')->aliasMiddleware('is_superadmin', IsSuperadmin::class);

        // Share data Contact ke komponen footer, cache 30 menit
        View::composer('components.footer', function ($view) {
            $contact = Cache::remember(
                'footer_contact_v2',
                now()->addMinutes(30),
                function () {
                    // Ambil record terbaru. Jika ingin semua kolom, tak perlu select()
                    return Contact::latest('updated_at')->first();
                }
            );

            $view->with('contact', $contact);
        });
    }
}
