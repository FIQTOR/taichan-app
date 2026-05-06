@extends('layouts/base')

@section('content')
    <main class="py-32">
        <section class="px-7">
            <h4 class="text-4xl font-bold">Histori:</h4>
            <ul class="grid grid-cols-2 md:grid-cols-3 gap-4 py-4">
                @for ($i = 0; $i < 10; $i++)
                    <li class="w-full border rounded-md relative">
                        {{-- Uncomment jika produk habis --}}
                        {{-- <span 
                            class="absolute w-full h-full rounded-md bg-neutral-100 bg-opacity-90 
                            flex justify-center items-center text-xl font-bold text-red-500 z-10">
                            Habis
                        </span> --}}
                        <div class="p-4 flex flex-col text-neutral-700">
                            <div class="flex justify-between items-center py-2">
                                <h6 class="font-bold text-xl">Sate Taichan</h6>
                                <span class="py-px px-2 bg-red-400 rounded-full text-white">Dibatalkan</span>
                                {{-- <span class="py-px px-2 bg-green-400 rounded-full text-white">Selesai</span> --}}
                            </div>
                            <div class="flex justify-between">
                                <span>ID Pemesanan</span>
                                <span>{{ rand(1000000000, 99999999999) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Tanggal Pesan</span>
                                <span>10/11/2023</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Total Harga</span>
                                <div class="flex flex-col items-end">
                                    <span>Rp200.000</span>
                                    <span class="line-through text-red-300 text-sm">Rp400.000</span>
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <span>Pesanan</span>
                                <div class="flex flex-wrap w-1/2 justify-end text-neutral-500">
                                    @for ($a = 0; $a < 3; $a++)
                                        <span>Sate Taichan,</span>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </li>
                @endfor
            </ul>
        </section>
    </main>
@endsection
