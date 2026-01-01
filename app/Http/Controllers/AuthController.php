<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // --- TAMPILAN HALAMAN (VIEW) ---
    // Semua dipanggil langsung tanpa 'auth.' karena file ada di resources/views/

    public function showLogin() 
    {
        return view('pages/login'); 
    }

    public function showRegister() 
    {
        return view('pages/register'); 
    }

    public function showForgot() 
    {
        return view('pages/forgot_pw'); 
    }

    public function showReset(Request $request, $token)
    {
        return view('pages/reset_pw', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    // --- LOGIKA LOGIN, REGISTER, LOGOUT ---

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->with('error', 'Email atau password salah!')->withInput();
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // --- LOGIKA LUPA & RESET PASSWORD ---

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan dalam sistem kami.']);
        }

        // Simulasi: Mengarahkan user ke halaman input password baru
        return redirect()->route('password.reset', ['token' => 'dummy-token', 'email' => $request->email])
                         ->with('status', 'Instruksi reset password telah dikirim (Simulasi).');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login kembali.');
        }

        return back()->withErrors(['email' => 'Terjadi kesalahan, silakan coba lagi.']);
    }
}