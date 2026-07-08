<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Halaman register menampilkan form pendaftaran dan mengarahkan pengguna yang sudah login.
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect($this->redirectToFor(Auth::user()->role));
        }

        return view('auth.register');
    }

    // Proses registrasi membuat akun baru dengan role siswa secara default.
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'siswa',
        ]);

        return redirect()->route('auth.login')->with('status', 'Akun berhasil dibuat. Silakan masuk dengan email dan kata sandi Anda.');
    }

    // Tentukan halaman tujuan saat pengguna sudah masuk.
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
