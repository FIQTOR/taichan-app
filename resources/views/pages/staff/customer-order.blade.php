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
                        <span>ID Pesanan</span>
                        <span>{{ $invoice->token }}</span>
                    </div>
                    <div class="flex justify-between text-neutral-500">
                        <span>Nomor Meja</span>
                        <span>{{ $invoice->table_number }}</span>
                    </div>
                    <div class="flex justify-between text-neutral-500">
                        <span>Total pembayaran</span>
                        <span>Rp{{ number_format($invoice->total_price, 0, '.', '.') }}</span>
                    </div>

                    <div class="py-4">
                        <span class="font-semibold text-xl">Rincian</span>
                        <table class="min-w-full">
                            <thead class="border-b-2">
                                <tr>
                                    <th class="font-light text-center w-14">No.</th>
                                    <th class="font-light text-center">Nama</th>
                                    <th class="font-light text-center">Jumlah</th>
                                    <th class="font-light text-center">Harga Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($invoice->menus as $menu)
                                    <tr class="{{ $i % 2 == 0 ? 'bg-neutral-100' : '' }}">
                                        <td class="text-center">{{ $i }}</td>
                                        <td class="text-center">{{ $menu->title }}</td>
                                        <td class="text-center">{{ $menu->count }}</td>
                                        @php
                                            $total = $menu->price * $menu->count;
                                        @endphp
                                        <td class="text-center">Rp{{ number_format($total, 0, '.', '.') }}</td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <form action="{{ route('invoice.customer.order.complete', $invoice->token) }}"
                        class="flex justify-end py-2">
                        @csrf
                        <button class="px-4 py-px bg-neutral-200 rounded-md hover:opacity-70"
                            onclick="confirm('apakah yakin ingin menyelesaikan pesanan?')">Pesanan Selesai</button>
                    </form>
                </li>
            @empty
                <div class="w-full min-h-screen flex items-center justify-center">
                    <h1>Customer order is empty</h1>
                </div>
            @endforelse
        </ul>
    </main>
@endsection
