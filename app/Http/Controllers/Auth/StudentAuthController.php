<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAuthController extends Controller
{
    /**
     * Tampilkan halaman login/register untuk Student.
     * Dilengkapi logika protektif:
     * - Jika sudah login sebagai admin/instructor → arahkan ke dashboard admin.
     * - Jika sudah login sebagai student & belum verified → logout paksa + tampilkan form login dengan pesan.
     * - Jika sudah login sebagai student & verified → arahkan ke pendataan/dashboard.
     * - Jika belum login → tampilkan form login/register.
     */
    public function showLoginRegisterForm(Request $request)
    {
        // Jika ada sesi login yang masih aktif
        if (Auth::check()) {
            $user = $request->user();

            // Admin/Instructor diarahkan ke panel admin
            if ($user->hasRole('superadmin') || $user->hasRole('admin') || $user->hasRole('instructor')) {
                return redirect()->intended(route('admin.dashboard.index'));
            }

            // Student: jika belum verified (kasus akun lama), logout paksa lalu tampilkan form login
            if ($user->hasRole('student') && ! $user->hasVerifiedEmail()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return view('guest.login.index')->withErrors([
                    'email' => 'Email Anda belum terverifikasi. Silakan cek inbox dan klik tautan verifikasi yang kami kirim.',
                ]);
            }

            // Student verified → arahkan ke pendataan (jika profil belum diisi) atau ke dashboard
            if ($user->hasRole('student') && $user->hasVerifiedEmail()) {
                $target = $user->profile ? 'dashboard.index' : 'pendataan.index';
                return redirect()->intended(route($target));
            }

            // Fallback: peran lain → beranda
            return redirect('/');
        }

        // Belum login → tampilkan halaman login/register
        return view('guest.login.index');
    }

    /**
     * Fallback agar form lama yang masih POST ke /register tetap masuk ke alur pending:
     * - Tidak membuat user langsung.
     * - Tidak memicu event Registered bawaan.
     * Jika tidak diperlukan, Anda bisa ganti dengan abort(404).
     */
    public function register(Request $request)
    {
        return app(\App\Http\Controllers\Auth\PendingVerificationController::class)
            ->storePending($request);

        // Atau:
        // abort(404);
    }

    /**
     * Proses login khusus Student.
     * - Pastikan email terdaftar dengan role student.
     * - Jika password cocok namun email belum verified (akun lama sebelum alur pending), logout dan beri pesan.
     * - Jika verified → arahkan ke dashboard.
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required'],
        ]);

        // Batasi hanya akun dengan role student yang dapat login via form ini
        $studentUser = User::query()
            ->where('email', $data['email'])
            ->whereHas('roles', fn($q) => $q->where('name', 'student'))
            ->first();

        if (! $studentUser) {
            return back()
                ->withErrors(['email' => 'Akun ini tidak memiliki akses.'])
                ->onlyInput('email');
        }

        // Autentikasi kredensial
        if (! Auth::attempt(
            ['email' => $data['email'], 'password' => $data['password']],
            $request->boolean('remember')
        )) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        // Alur pending: seharusnya akun student sudah verified saat dibuat dari EmailVerification.
        // Jika belum verified (akun lama), jangan arahkan ke verification.notice.
        if (! $request->user()->hasVerifiedEmail()) {
            $pendingExists = EmailVerification::where('email', $data['email'])->exists();

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => $pendingExists
                    ? 'Email Anda belum terverifikasi. Silakan buka tautan verifikasi yang kami kirim ke email Anda.'
                    : 'Email Anda belum terverifikasi. Silakan lakukan pendaftaran ulang agar kami kirim tautan verifikasi.',
            ])->onlyInput('email');
        }

        return redirect()
            ->route('dashboard.index')
            ->with('status', 'Login berhasil. Selamat datang kembali!');
    }

    /**
     * Logout user dari sesi saat ini.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Kembali ke halaman login student
        return redirect()->route('login')->with('status', 'Anda berhasil keluar.');
    }
}
