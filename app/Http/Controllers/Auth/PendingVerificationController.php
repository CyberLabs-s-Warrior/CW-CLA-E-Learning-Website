<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyPendingMail;
use App\Models\EmailVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash, Mail, URL, DB};
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class PendingVerificationController extends Controller
{
    /**
     * Simpan pendaftar ke tabel pending lalu kirim email verifikasi.
     */
    public function storePending(Request $request)
    {
        $data = $request->validate([
            'name'                  => ['required','string','max:255'],
            'username'              => ['required','string','min:3','max:30','alpha_dash'],
            'email'                 => ['required','string','lowercase','email','max:255'],
            'phone'                 => ['nullable','string','max:20'],
            'password'              => ['required','confirmed','min:6'],
        ]);

        // Normalisasi phone (opsional)
        $normalizedPhone = isset($data['phone'])
            ? preg_replace('/\s+/', '', preg_replace('/(?!^\+)[^\d]/', '', $data['phone']))
            : null;

        // Cegah duplikasi (users)
        if (
            User::where('email', $data['email'])->exists() ||
            User::where('username', $data['username'])->exists()
        ) {
            throw ValidationException::withMessages([
                'email' => 'Email atau username sudah terdaftar. Silakan login.',
            ]);
        }

        // Cegah duplikasi (pending)
        if (
            EmailVerification::where('email', $data['email'])->exists() ||
            EmailVerification::where('username', $data['username'])->exists()
        ) {
            throw ValidationException::withMessages([
                'email' => 'Email atau username sedang menunggu verifikasi. Silakan cek inbox Anda.',
            ]);
        }

        // Simpan pending
        $rawToken  = Str::random(64);
        $tokenHash = hash('sha256', $rawToken);

        EmailVerification::create([
            'name'          => $data['name'],
            'username'      => $data['username'],
            'email'         => $data['email'],
            'phone'         => $normalizedPhone,
            'password_hash' => Hash::make($data['password']),
            'token'         => $tokenHash,
            'expires_at'    => now()->addDay(), // 24 jam
        ]);

        // Signed URL verifikasi
        $url = URL::temporarySignedRoute(
            'pending.verify',
            now()->addDay(),
            ['token' => $rawToken]
        );

        // Kirim email
        Mail::to($data['email'])->send(new VerifyPendingMail($url));

        return redirect()
            ->route('login')
            ->with('status','Tautan verifikasi telah dikirim ke email Anda. Silakan cek email untuk melanjutkan.');
    }

    /**
     * Verifikasi link: buat user (users) dari pending, verifikasi, lalu login.
     */
    public function verify(Request $request)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'Tautan verifikasi tidak valid atau sudah kedaluwarsa.');
        }

        $rawToken  = $request->query('token');
        $tokenHash = hash('sha256', $rawToken);

        $pending = EmailVerification::where('token', $tokenHash)->first();

        if (! $pending || $pending->expires_at->isPast()) {
            abort(403, 'Token tidak valid atau kedaluwarsa.');
        }

        // Safety: kalau user sudah ada (balapan proses lain), hapus pending & arahkan login
        if (
            User::where('email', $pending->email)->exists() ||
            User::where('username', $pending->username)->exists()
        ) {
            $pending->delete();
            return redirect()->route('login')->withErrors([
                'email' => 'Email atau username sudah dipakai. Silakan login.',
            ]);
        }

        // Buat user dari pending (atomic)
        DB::transaction(function () use ($pending, &$user) {
            $user = User::create([
                'name'              => $pending->name,
                'username'          => $pending->username,
                'email'             => $pending->email,
                'phone'             => $pending->phone,
                'password'          => $pending->password_hash,
                'email_verified_at' => now(),
            ]);

            // Assign role default student (jika ada Spatie)
            if (method_exists($user, 'assignRole')) {
                $user->assignRole('student');
            }

            // Hapus data pending
            $pending->delete();
        });

        // Auto-login
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('dashboard.index')
            ->with('status','Verifikasi berhasil. Selamat datang!');
    }

    /**
     * (Opsional) Kirim ulang tautan verifikasi selama pending masih berlaku.
     */
    public function resend(Request $request)
    {
        $data = $request->validate([
            'email' => ['required','email'],
        ]);

        $pending = EmailVerification::where('email', $data['email'])->first();

        if (! $pending) {
            return back()->withErrors([
                'email' => 'Tidak ada pendaftaran menunggu untuk email tersebut.',
            ]);
        }

        if ($pending->expires_at->isPast()) {
            $pending->delete();
            return back()->withErrors([
                'email' => 'Token kedaluwarsa. Silakan daftar ulang.',
            ]);
        }

        // Generate token baru
        $rawToken = Str::random(64);
        $pending->update([
            'token'      => hash('sha256', $rawToken),
            'expires_at' => now()->addDay(),
        ]);

        $url = URL::temporarySignedRoute(
            'pending.verify',
            now()->addDay(),
            ['token' => $rawToken]
        );

        Mail::to($pending->email)->send(new VerifyPendingMail($url));

        return back()->with('status','Tautan verifikasi baru telah dikirim.');
    }
}
