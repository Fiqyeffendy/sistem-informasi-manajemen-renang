<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Form login muncul saat pengguna belum masuk, lalu diarahkan ke dashboard sesuai role.
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect($this->redirectToFor(Auth::user()->role));
        }

        return view('auth.login');
    }

    // Proses login memvalidasi kredensial, mengautentikasi user, dan mengarahkan ke dashboard yang sesuai.
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = (bool) $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Khusus siswa: blokir ketika akun belum aktif.
            if ($user->role === 'siswa' && $user->siswa && $user->siswa->status !== 'aktif') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Akun Anda sedang dalam proses verifikasi oleh Admin. Silakan tunggu.',
                ])->onlyInput('email');
            }

            // Regenerate session untuk keamanan setelah login.
            $request->session()->regenerate();

            return redirect()->intended($this->redirectToFor($user->role));
        }

        // Jika login gagal, kembali ke halaman login dengan error.
        return back()->withErrors([
            'email' => 'Email atau kata sandi salah.',
        ])->onlyInput('email');
    }

    // Logout mengakhiri sesi dan membersihkan token agar akun aman.
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }

    // Tentukan halaman tujuan setelah login berdasarkan role pengguna.
    protected function redirectToFor(?string $role): string
    {
        return match ($role) {
            'admin' => route('admin.dashboard'),
            'pelatih' => route('pelatih.dashboard'),
            'siswa' => route('siswa.dashboard'),
            default => route('auth.login'),
        };
    }
}
