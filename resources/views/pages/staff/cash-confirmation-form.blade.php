@extends('layouts/base')

@section('content')
    <main class="w-full max-w-md mx-auto min-h-screen flex justify-center items-center py-32 px-4">
        <div class="w-full rounded-xl shadow-2xl border flex flex-col gap-2 p-4 relative text-neutral-600">
            <div class="absolute self-center -translate-y-16 bg-yellow-300 rounded-full p-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto text-white" width="75" height="75"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 19h-6a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v4.5" />
                    <path d="M3 10h18" />
                    <path d="M16 19h6" />
                    <path d="M19 16l3 3l-3 3" />
                    <path d="M7.005 15h.005" />
                    <path d="M11 15h2" />
                </svg>
            </div>
            <h1 class="font-bold text-4xl mx-auto mt-14 mb-7 text-neutral-500 text-center">CASH CONFIRMATION
            </h1>
            <form action="{{ route('invoice.cash.search.post') }}" method="POST" class="flex flex-col gap-2">
                @csrf

                @if (session('error'))
                    <p class="text-red-500">{{ session('error') }}</p>
                @endif
                @if (session('success'))
                    <p class="text-green-500">{{ session('success') }}</p>
                @endif

                <div id="video-camera-overlay">

                </div>
                <div class="flex flex-col gap-1">
                    <label for="token">ID INVOICE</label>
                    <input type="number" name="token" id="token"
                        class="px-2 py-1 rounded-md outline outline-1
                        @error('token') outline-red-600 @else outline-neutral-500 @enderror
                        focus:outline-yellow-300 focus:outline-2"
                        value="{{ old('token') }}">
                    @error('token')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <button class="bg-yellow-300 py-1 text-neutral-700 rounded-md hover:opacity-70">
                    Cek ID Invoice</button>
                <button onclick="openCamera(event);"
                    class="bg-yellow-300 py-1 text-neutral-700 rounded-md hover:opacity-70">
                    Scan QR Invoice</button>
            </form>
        </div>
    </main>

    <script>
        const startButton = document.getElementById('cameraButton');

        // Fungsi untuk mendapatkan izin dan membuka kamera
        const openCamera = async (event) => {
            event.preventDefault();
            $('#video-camera-overlay').html('<video id="video" autoplay class="rounded-md"></video>');
            const videoElement = document.getElementById('video');

            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    video: true
                });
                video.srcObject = stream;
            } catch (error) {
                console.error('Error accessing the camera:', error);
            }
        };
    </script>
@endsection
