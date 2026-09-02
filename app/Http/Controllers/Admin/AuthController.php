<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    /**
     * Maksimal percobaan login sebelum dikunci.
     */
    protected const MAX_ATTEMPTS = 5;

    /**
     * Durasi lockout dalam detik.
     */
    protected const LOCKOUT_SECONDS = 60;

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $throttleKey = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()->withErrors([
                'email' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.",
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials)) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            return redirect()->intended('admin');
        }

        RateLimiter::hit($throttleKey, self::LOCKOUT_SECONDS);

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    protected function throttleKey(Request $request): string
    {
        return 'login:'.strtolower((string) $request->input('email')).'|'.$request->ip();
    }
}
