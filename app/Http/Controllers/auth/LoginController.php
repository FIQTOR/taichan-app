<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('pages/auth/login', [
            'title' => 'Login',
        ]);
    }

    public function Login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => ':attribute wajib di isi',
            'password.required' => ':attribute wajib di isi',
        ]);

        $user = User::where('email', $request->email)->first();
        $remember_me = $request->has('remember_me') ? true : false;

        if ($user) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember_me)) {
                $request->session()->regenerate();

                return redirect()->intended(route('home'));
            }
        }

        return redirect()->back()->with('error', 'Email atau password salah!');
    }
}
