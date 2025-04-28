<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function postlogin(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect('/dashboard')->with('success', 'Login sebagai Admin!');
        } else {
            return redirect('/')->with('success', 'Login Berhasil!');
        }
    }

    return redirect()->back()->with('error', 'Email atau Password Salah!');
}

public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed|min:6',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'user', // default role user
    ]);

    Auth::login($user);

    return redirect('/')->with('success', 'Pendaftaran berhasil!');
}   
    
   
public function logout()
{
    Auth::logout();
    return redirect('/login')->with('success', 'Logout berhasil!');
}

public function sendResetLink(Request $request)
{
    $request->validate(['email' => 'required|email']);
    
    $token = Str::random(64);

    DB::table('password_resets')->updateOrInsert(
        ['email' => $request->email],
        ['token' => $token, 'created_at' => Carbon::now()]
    );

    $link = url('/reset-password?token=' . $token . '&email=' . $request->email);

    try {
        // Kirim email ke pengguna
        Mail::send('emails.reset-password', ['link' => $link], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Password Reset Link');
        });

        // Return success response
        return response()->json(['success' => 'Email reset password berhasil dikirim. Silakan cek email Anda.'], 200);
    } catch (\Exception $e) {
        // Return error response
        return response()->json(['error' => 'Gagal mengirim email. Silakan coba lagi nanti.'], 500);
    }
}
public function showResetForm(Request $request)
{
    return view('auth.reset-password');
}

public function resetPassword(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
    ]);

    $reset = DB::table('password_resets')
        ->where('email', $request->email)
        ->where('token', $request->token)
        ->first();

    if (!$reset) {
        return back()->withErrors(['email' => 'Invalid token or email.']);
    }

    DB::table('users')->where('email', $request->email)->update([
        'password' => bcrypt($request->password),
    ]);

    DB::table('password_resets')->where('email', $request->email)->delete();

    // Redirect ke halaman login dengan pesan sukses
    return redirect('/login')->with('success', 'Password has been reset. Please log in with your new password.');
}



}