<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\PasswordResetToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function forgot_password()
    {
        return view('auth.forgot-password');
    }
    public function login_proses(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $data = ['email' => $request->email, 'password' => $request->password];

        if (Auth::attempt($data)) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('login')->with('failed', 'Email atau Password Salah');
        }
    }
    public function forgot_password_proses(Request $request)
    {
        $customMessage = [
            'email.required' => 'Email harus diisi',
            'email.exists' => 'Email tidak terdaftar',
            'email.email' => 'Email harus valid',
        ];
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], $customMessage);

        $token = \Str::random(60);

        PasswordResetToken::updateOrCreate([
            'email' => $request->email,
        ], [
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        Mail::to($request->email)->send(new ResetPasswordMail($token));

        return redirect()->route('login')->with('success', 'Kami telah mengirimkan link reset password pada Email anda');
    }
    public function forgot_password_validate(Request $request, $token)
    {
        $resetToken = PasswordResetToken::where('token', $token)->first();

        if (!$resetToken) {
            return redirect()->route('login')->with('failed', 'Token tidak valid');
        }


        return view('auth.update-forgot-password', compact('resetToken'));
    }
    public function forgot_password_validate_process(Request $request, $token)
    {
        $request->validate([
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required|min:5'
        ]);

        $resetToken = PasswordResetToken::where('token', $token)->first();

        if (!$resetToken) {
            return redirect()->route('login')->with('failed', 'Token tidak valid');
        }

        $user = User::where('email', $resetToken->email)->first();

        if (!$user) {
            return redirect()->route('login')->with('failed', 'Email tidak terdaftar');
        }

        $user->update(['password' => Hash::make($request->password)]);
        $resetToken->delete();
        return redirect()->route('login')->with('success', 'Password berhasil diubah');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Kamu berhasil logout');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function register_proses(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5',
        ]);

        $data = ['name' => $request->name, 'email' => $request->email, 'password' => Hash::make($request->password)];

        User::create($data);

        return redirect()->route('login')->with('success', 'Kamu berhasil membuat akun');
    }
}
