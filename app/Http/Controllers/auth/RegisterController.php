<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('pages/auth/register', [
            'title' => 'Register',
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:5'],
            'email' => ['required', 'email:rfc,dns'],
            'password' => ['required', 'min:8'],
            'password_confirmation' => ['required', 'same:password'],
        ], [
            'name.required' => 'nama lengkap wajib di isi',
            'name.min' => 'nama lengkap minimal 5 karakter',
            'email.required' => ':attribute wajib di isi',
            'password.required' => ':attribute wajib di isi',
            'password.min' => ':attribute minimal 8 karakter',
            'password_confirmation.required' => 'konfirmasi password wajib di isi',
            'password_confirmation.same' => 'konfirmasi password tidak sama',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            return back()->with('error', 'Email sudah terdaftar!');
        }

        $newUser = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $newUser->save();

        return redirect()->to(route('login'))->with('success', 'Berhasil daftar silahkan login!');
    }
}
