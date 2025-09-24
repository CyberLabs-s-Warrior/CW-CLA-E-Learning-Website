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
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Bootstrap 5 untuk pagination bawaan Laravel
        Paginator::useBootstrapFive();

        // Alias middleware (jika dipakai)
        app('router')->aliasMiddleware('is_superadmin', IsSuperadmin::class);

        // Share data Contact khusus ke footer + cache 30 menit
        View::composer('components.footer', function ($view) {
            $contact = Cache::remember(
                'footer_contact',
                now()->addMinutes(30),
                function () {
                    return Contact::query()
                        ->select(
                            'email',
                            'telepon',
                            'alamat',
                            'latitude',
                            'longitude',
                            'link_maps',
                            // tambahkan kolom sosial ↓↓↓
                            'social_facebook',
                            'social_instagram',
                            'social_tiktok',
                            'social_x',
                            'updated_at'
                        )
                        ->latest('updated_at')
                        ->first();
        // Supply data kontak ke komponen footer (cached)
        View::composer('components.footer', function ($view) {
            $contact = Cache::remember(
                // gunakan key baru supaya tidak bentrok dengan cache lama
                'footer_contact_v2',
                now()->addMinutes(30),
                function () {
                    // Ambil satu record terbaru (tanpa select kolom) agar semua field termasuk sosial tersedia
                    return Contact::latest('updated_at')->first();
                }
            );

            $view->with('contact', $contact);
        });
    }
        }}}
