@extends('layouts/base')

@section('content')
    <main class="w-full max-w-3xl mx-auto min-h-screen pt-24 flex
    flex-col gap-2">
        <h1 class="text-4xl mx-auto font-serif">KONTAK KAMI</h1>
        <p class="text-xl text-center">Sampaikan kritik, saran, pertanyaan, bagi cerita / pengalaman Taichan Lovers.
            Masukan Anda sangat berarti untuk meningkatkan pelayanan kami.</p>
        <form action="{{ route('action.create.feedback') }}" method="POST" class="flex flex-col gap-4 py-14 text-neutral-500">
            @csrf

            <div class="flex flex-col gap-2">
                <label for="fullname">Nama (Wajib diisi)</label>
                <input type="text" name="fullname" id="fullname" value="{{ old('fullname') }}"
                    class="px-2 py-1 rounded-md outline outline-1 outline-neutral-500
                focus:outline-yellow-300 focus:outline-2">
                @error('fullname')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex flex-col">
                <label for="email">Email (Wajib diisi)</label>
                <input type="text" name="email" id="email" value="{{ old('email') }}"
                    class="px-2 py-1 rounded-md outline outline-1 outline-neutral-500
            focus:outline-yellow-300 focus:outline-2">
                @error('email')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex flex-col">
                <label for="phonenumber">Nomor Telepon</label>
                <input type="text" name="phonenumber" id="phonenumber" value="{{ old('phonenumber') }}"
                    class="px-2 py-1 rounded-md outline outline-1 outline-neutral-500
            focus:outline-yellow-300 focus:outline-2">
            </div>
            <div class="flex flex-col gap-2">
                <label for="type">Tentang (Pilih salah satu)</label>
                <select name="type" id="type"
                    class="px-2 py-1 rounded-md outline outline-1 outline-neutral-500
            focus:outline-yellow-300 focus:outline-2">
                    <option value="saran/kritik">Saran/Kritik</option>
                    <option value="berbagi pengalaman">Berbagi Pengalaman</option>
                    <option value="pertanyaan">Pertanyaan</option>
                </select>
            </div>
            <div class="flex flex-col gap-2">
                <label for="message">Pesan (Wajib diisi)</label>
                <textarea name="message" id="" cols="30" rows="10"
                    class="px-2 py-1 rounded-md outline outline-1 outline-neutral-500
            focus:outline-yellow-300 focus:outline-2">{{ old('message') }}</textarea>
                @error('message')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <button class="bg-yellow-300 w-fit px-7 py-1 text-neutral-700 rounded-md hover:opacity-70">Kirim</button>
        </form>
    </main>
@endsection
