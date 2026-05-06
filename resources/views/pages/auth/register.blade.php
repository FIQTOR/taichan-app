@extends('layouts/base')

@section('content')
    <main class="w-full max-w-md mx-auto min-h-screen flex justify-center items-center py-32 px-4">
        <div class="w-full rounded-xl shadow-2xl border flex flex-col gap-2 p-4 relative text-neutral-600">
            <div class="absolute self-center -translate-y-16 bg-yellow-300 rounded-full p-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto text-white" width="75" height="75"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                </svg>
            </div>
            <h1 class="font-bold text-4xl mx-auto mt-14 mb-7 text-neutral-500">D A F T A R</h1>
            <form action="{{ route('register.action') }}" method="POST" class="flex flex-col gap-2">
                @csrf

                @if (session('error'))
                    <p class="text-red-500">{{ session('error') }}</p>
                @endif
                @if (session('success'))
                    <p class="text-green-500">{{ session('success') }}</p>
                @endif

                <div class="flex flex-col gap-1">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="name" id="name"
                        class="px-2 py-1 rounded-md outline outline-1 
                        @error('name') outline-red-600 @else outline-neutral-500 @enderror
                        focus:outline-yellow-300 focus:outline-2"
                        value="{{ old('name') }}">
                    @error('name')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col gap-1">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email"
                        class="px-2 py-1 rounded-md outline outline-1
                        @error('email') outline-red-600 @else outline-neutral-500 @enderror
                        focus:outline-yellow-300 focus:outline-2"
                        value="{{ old('email') }}">
                    @error('email')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col gap-1">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password"
                        class="px-2 py-1 rounded-md outline outline-1
                        @error('password') outline-red-600 @else outline-neutral-500 @enderror
                        focus:outline-yellow-300 focus:outline-2">
                    @error('password')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col gap-1">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="px-2 py-1 rounded-md outline outline-1
                        @error('password_confirmation') outline-red-600 @else outline-neutral-500 @enderror
                        focus:outline-yellow-300 focus:outline-2">
                    @error('password_confirmation')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <button class="bg-yellow-300 py-1 text-neutral-700 rounded-md hover:opacity-70">
                    Daftar</button>
            </form>
            <span>Sudah mempunyai akun? <a href="{{ route('login') }}"
                    class="text-blue-400 hover:opacity-70">masuk</a></span>
        </div>
    </main>
@endsection
