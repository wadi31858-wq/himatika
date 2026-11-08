<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            if (Auth::user()->is_active) {
                return redirect()->route('admin.dashboard');
            } else {
                Auth::logout();
            }
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt login only for active accounts
        if (Auth::attempt(array_merge($credentials, ['is_active' => true]), $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            ActivityLog::record(
                'login',
                'Admin ' . Auth::user()->name . ' berhasil masuk ke sistem.',
                Auth::user()
            );

            return redirect()->intended(route('admin.dashboard'))->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        return back()->withErrors(['email' => 'Kredensial yang diberikan tidak cocok dengan data kami atau akun dinonaktifkan.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            ActivityLog::record(
                'logout',
                'Admin ' . Auth::user()->name . ' keluar dari sistem.',
                Auth::user()
            );
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }
}
