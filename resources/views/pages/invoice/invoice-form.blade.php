@php
    use App\Models\Menu;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('js/global.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    @vite('resources/css/app.css')
    <title>@yield('title', $title) - {{ config('app.name') }}</title>
</head>

<body>
    @include('components/comment-popup')
    <main class="w-[800px] mx-auto px-4 py-24">
        <div class="rounded-xl w-full h-full p-7 border shadow-xl bg-neutral-50"">
            <div class="flex justify-between">
                <h1 class="font-bold text-5xl font-serif">INVOICE</h1>
                @if ($invoice->already_paid)
                    <span class="py-px px-2 h-fit bg-green-400 rounded-full text-white">Sudah bayar</span>
                @else
                    <span class="py-px px-2 h-fit bg-red-400 rounded-full text-white">Belum bayar</span>
                @endif
            </div>
            <div class="flex justify-between">
                <span>Waktu Pemesanan</span>
                <span>{{ $invoice->created_at }}</span>
            </div>
            <div class="flex justify-between">
                <span>Status</span>
                @if ($invoice->status == 'menunggu pembayaran')
                    <span class="text-red-400">{{ $invoice->status }}</span>
                @elseif ($invoice->status == 'sedang disiapkan')
                    <span class="text-yellow-400">{{ $invoice->status }}</span>
                @else
                    <span class="text-green-400">{{ $invoice->status }}</span>
                @endif
            </div>
            <div class="flex justify-between">
                <span>ID Pemesanan</span>
                <span>{{ $invoice->token }}</span>
            </div>
            <div class="flex justify-between">
                <span>Metode Pembayaran</span>
                <span class="capitalize">{{ $invoice->payment_method }}</span>
            </div>
            <div class="flex justify-between">
                <span>Total Pembayaran</span>
                <span class="text-xl font-bold">Rp{{ number_format($invoice->total_price, 0, '.', '.') }}</span>
            </div>

            <div class="w-full flex justify-center items-center">
                <div class="flex flex-col items-center bg-white py-2 px-7 rounded-md">
                    <span class="text-4xl font-bold py-4">QR CODE</span>
                    {{ QrCode::size(200)->generate(URL::to('/invoice/confirm/' . $invoice->token)) }}
                    <div class="flex py-2 justify-between gap-7">
                        <span>{{ $invoice->token }}</span>
                        <button class="px-2 py-px bg-neutral-200 rounded-full hover:opacity-70"
                            onclick="copyText('{{ $invoice->token }}')">salin</button>
                    </div>
                    <p>Bayar ke kasir</p>
                </div>
            </div>

            <div class="py-4">
                <span class="font-semibold text-xl">Rincian</span>
                <table class="min-w-full">
                    <thead class="border-b-2">
                        <tr>
                            <th class="font-light text-center w-14">No.</th>
                            <th class="font-light text-center">Nama</th>
                            <th class="font-light text-center">Harga satuan</th>
                            <th class="font-light text-center">Jumlah</th>
                            <th class="font-light text-center">Harga Total</th>
                            @if ($invoice->status == 'selesai')
                                <th class="font-light text-center">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($invoice->menus as $menu)
                            <tr class="{{ $i % 2 == 0 ? 'bg-yellow-50' : '' }}">
                                <td class="text-center">{{ $i }}</td>
                                <td class="text-center">{{ $menu->title }}</td>
                                <td class="text-center">Rp{{ number_format($menu->price, 0, '.', '.') }}</td>
                                <td class="text-center">{{ $menu->count }}</td>
                                @php
                                    $total = $menu->price * $menu->count;
                                @endphp
                                <td class="text-center">Rp{{ number_format($total, 0, '.', '.') }}</td>
                                <td class="flex justify-center py-1">
                                    @if ($invoice->status == 'selesai' && Menu::find($menu->id))
                                        @if (Menu::find($menu->id)->visibility != 'private')
                                            <button onclick="handleCommentPopup({{ $menu->id }})"
                                                class="px-4 py-px bg-neutral-200 rounded-full hover:opacity-70 flex items-center gap-2">Rate
                                                <svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-300"
                                                    width="20" height="20" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path
                                                        d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z"
                                                        stroke-width="0" fill="currentColor"></path>
                                                </svg>
                                            </button>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="flex justify-end gap-4">
                @if (!$invoice->already_paid)
                    <form action="{{ route('invoice.destroy', $invoice->token) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="px-4 py-px bg-neutral-200 rounded-md hover:opacity-70">Batalkan
                            Pesanan</button>
                    </form>
                @endif
                <a href="{{ route('invoice.show') }}" class="px-4 py-px bg-neutral-200 rounded-md hover:opacity-70">
                    Kembali
                </a>
            </div>
        </div>
    </main>
</body>
