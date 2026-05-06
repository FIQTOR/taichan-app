@extends('layouts/base')

@section('content')
    <main class="w-full max-w-md mx-auto min-h-screen flex justify-center items-center py-32 px-4">
        <div class="w-full rounded-xl shadow-2xl border flex flex-col gap-2 p-4 relative text-neutral-600">
            <div class="absolute self-center -translate-y-16 bg-yellow-300 rounded-full p-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto text-white" width="75" height="75"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path
                        d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z">
                    </path>
                    <path d="M15 9h.01"></path>
                </svg>
            </div>
            <h1 class="font-bold text-4xl mx-auto mt-14 mb-7 text-neutral-500">Ganti Sandi</h1>
            @if (session('error'))
                <p class="text-red-500">{{ session('error') }}</p>
            @else
                <form action="{{ route('reset.password.action') }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    <input type="text" name="email" id="email" hidden readonly value="{{ session('email') }}">

                    @if (session('success'))
                        <p class="text-green-500">{{ session('success') }}</p>
                    @endif

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
                        Ubah Password</button>
                </form>
            @endif
        </div>
    </main>
@endsection
