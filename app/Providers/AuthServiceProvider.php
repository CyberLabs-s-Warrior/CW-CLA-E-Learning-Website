<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Langsung lolos semua permission jika superadmin
        Gate::before(function (User $user, $ability) {
            return $user->is_superadmin ? true : null;
        });
    }
}
