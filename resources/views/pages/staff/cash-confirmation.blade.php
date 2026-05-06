@extends('layouts/base')

@section('content')
    <main class="w-full max-w-md mx-auto min-h-screen flex justify-center items-center py-32 px-4">
        <div class="w-full rounded-xl shadow-2xl border flex flex-col gap-2 p-4 relative text-neutral-600">
            <div class="absolute self-center -translate-y-16 bg-yellow-300 rounded-full p-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto text-white" width="75" height="75"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M7 9m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                    <path d="M14 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M17 9v-2a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v6a2 2 0 0 0 2 2h2" />
                </svg>
            </div>
            <h1 class="font-bold text-4xl mx-auto mt-14 mb-7 text-neutral-500 text-center">KONFIRMASI PEMBAYARAN CASH</h1>
            <form action="{{ route('invoice.cash.confirm.post', $invoice->token) }}" method="POST"
                class="flex flex-col gap-2">
                @csrf

                @if (session('error'))
                    <p class="text-red-500">{{ session('error') }}</p>
                @endif
                @if (session('success'))
                    <p class="text-green-500">{{ session('success') }}</p>
                @endif

                <div class="flex justify-between">
                    <span>ID Invoice</span>
                    <span>{{ $invoice->token }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Nama</span>
                    <span>{{ $user->name }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Email</span>
                    <span>{{ $user->email }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Waktu Pemesanan Dibuat</span>
                    <span>{{ $invoice->created_at }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Nomor Meja</span>
                    <span>{{ $invoice->table_number }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Total tagihan</span>
                    <span>Rp{{ number_format($invoice->total_price, 0, '.', '.') }}</span>
                </div>

                <button onclick="confirm('Apakah yakin ingin mengkonfirmasi?')"
                    class="bg-yellow-300 py-1 text-neutral-700 rounded-md hover:opacity-70">
                    Konfirmasi Invoice</button>
            </form>
        </div>
    </main>
@endsection
