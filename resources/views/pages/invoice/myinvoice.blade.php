@extends('layouts/base')

@section('content')
    <main class="w-full max-w-md mx-auto min-h-screen py-20 px-4">
        <ul class="flex flex-col gap-4">
            @forelse ($invoices as $invoice)
                <li class="w-full p-4 border rounded-xl">
                    <div class="flex justify-between items-center">
                        <p class="text-black font-bold text-lg">Pembayaran</p>
                        @if ($invoice->already_paid)
                            <span class="py-px px-2 h-fit bg-green-400 rounded-full text-white">Sudah bayar</span>
                        @else
                            <span class="py-px px-2 h-fit bg-red-400 rounded-full text-white">Belum bayar</span>
                        @endif
                    </div>
                    <div class="flex justify-between text-neutral-500">
                        <span>Dibuat</span>
                        <span>{{ $invoice->created_at }}</span>
                    </div>
                    <div class="flex justify-between text-neutral-500">
                        <span>Status</span>
                        @if ($invoice->status == 'menunggu pembayaran')
                            <span class="text-red-500">{{ $invoice->status }}</span>
                        @elseif ($invoice->status == 'sedang disiapkan')
                            <span class="text-yellow-500">{{ $invoice->status }}</span>
                        @else
                            <span class="text-green-500">{{ $invoice->status }}</span>
                        @endif
                    </div>
                    <div class="flex justify-between text-neutral-500">
                        <span>ID Pesanan</span>
                        <span>{{ $invoice->token }}</span>
                    </div>
                    <div class="flex justify-between text-neutral-500">
                        <span>Total pembayaran</span>
                        <span>Rp{{ number_format($invoice->total_price, 0, '.', '.') }}</span>
                    </div>
                    <div class="flex justify-end py-2 gap-2">
                        @if ($invoice->already_paid)
                            <a href="{{ route('invoice', $invoice->token) }}"
                                class="px-4 py-px bg-neutral-200 rounded-md hover:opacity-70">Lihat invoice</a>
                        @else
                            <a href="{{ route('invoice', $invoice->token) }}"
                                class="px-4 py-px bg-neutral-200 rounded-md hover:opacity-70">Bayar sekarang</a>
                        @endif
                    </div>
                </li>
            @empty
                <div class="w-full min-h-screen flex items-center justify-center">
                    <h1>Your invoice is empty</h1>
                </div>
            @endforelse
        </ul>
    </main>
@endsection
