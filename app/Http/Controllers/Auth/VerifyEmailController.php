<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // Kalau sudah terverifikasi sebelumnya, langsung arahkan sesuai role
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectAfterVerification($request)->with('status', 'Email already verified.');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // Setelah verifikasi sukses, arahkan sesuai role & status profil
        return $this->redirectAfterVerification($request)->with('status', 'Email verified.');
    }

    protected function redirectAfterVerification(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Alur khusus student
        if ($user->hasRole('student')) {
            // Belum punya profil -> ke pendataan; kalau sudah -> ke dashboard student
            $target = $user->profile ? 'dashboard.index' : 'pendataan.index';
            return redirect()->route($target);
        }


    }
}
