<?php

// app/Http/Middleware/CheckUserProfileMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserProfileMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // hanya berlaku untuk role student
            if ($user->hasRole('student') && !$user->profile) {
                return redirect()->route('pendataan.index');
            }
        }

        return $next($request);
    }
}
