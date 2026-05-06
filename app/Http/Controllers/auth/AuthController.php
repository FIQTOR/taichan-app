<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\ResetToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function UpdateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->save();

        return redirect()->route('profile');
    }

    public function ForgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email']
        ], [
            'email.required' => ':attribute wajib di isi',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email belum pernah di daftarkan!');
        }

        $token = Str::random(30);
        $newToken = new ResetToken([
            'email' => $user->email,
            'token' => $token
        ]);
        $newToken->save();

        Mail::to($user->email)->send(new ResetPasswordMail($user, $token));
        return redirect()->back()->with('success', "Silahkan cek email ($user->email) anda!");
    }

    public function ResetPassword($token = '')
    {
        $vtoken = ResetToken::where('token', $token)->first();
        if (!$vtoken)
            session()->flash('error', 'Token sudah expired!');
        else
            session()->flash('email', $vtoken->email);

        return view('pages/auth/password/reset-password', [
            'title' => 'Ganti Sandi'
        ]);
    }

    public function ResetPasswordAction(Request $request)
    {

        $request->validate([
            'email' => ['required'],
            'password' => ['required', 'min:8'],
            'password_confirmation' => ['required', 'same:password'],
        ], [
            'email.required' => ':attribute wajib di isi',
            'password.required' => ':attribute wajib di isi',
            'password.min' => ':attribute minimal 8 karakter',
            'password_confirmation.required' => 'konfirmasi password wajib di isi',
            'password_confirmation.same' => 'konfirmasi password tidak sama',
        ]);

        $user = User::where('email', $request->email)->first();

        // Terakhir
    }

    public function Logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
