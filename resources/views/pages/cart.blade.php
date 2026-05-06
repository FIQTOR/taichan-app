@extends('layouts/base')

@section('content')
    @include('components/order-popup')
    @php
        $total_price = 0;
    @endphp
    <main class="w-full max-w-md mx-auto min-h-screen py-20 px-4">
        @if (!empty($menus))
            <ul class="flex flex-col gap-4">
                @foreach ($menus as $menu)
                    <li class="w-full p-4 border rounded-xl">
                        <div class="flex gap-4">
                            <div class="flex w-28 flex-col gap-2">
                                <img src="{{ asset('storage/' . $menu->picture) }}" alt="menu image" width="100"
                                    class="rounded-md w-full">
                                <button onclick="handleCart({{ $menu->id }})"
                                    class="bg-yellow-300 rounded-md w-full py-1
                        hover:opacity-70">Ubah</button>
                            </div>
                            <div class="flex-col justify-between w-full h-full">
                                <div class="flex justify-between w-full mb-4">
                                    <h6 class="text-lg font-semibold">{{ $menu->title }}</h6>

                                    <span class="flex gap-1 items-center text-neutral-400">
                                        <div class="flex items-center">
                                            <button class="hover:opacity-70 hover:text-red-300"
                                                onclick="handleFavoriteAjax('{{ $menu->id }}')">
                                                <svg id="love-{{ $menu->id }}" xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="@if ($menu->myfavorite) fill-red-300 text-red-300 @endif">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path
                                                        d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                        <span id="count-{{ $menu->id }}">{{ $menu->favorite }}</span>
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Harga satuan</span>
                                    <div class="flex gap-1 items-center">
                                        @php
                                            $discount_price = $menu->price - $menu->price * ($menu->discount / 100);
                                        @endphp
                                        <span>Rp{{ number_format($discount_price, 0, '.', '.') }}</span>
                                        @if ($menu->discount != 0)
                                            <span class="line-through text-red-300">
                                                Rp{{ number_format($menu->price, 0, '.', '.') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex justify-between">
                                    <span>Jumlah</span>
                                    <span>{{ $menu->count }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Harga</span>
                                    @php
                                        $_price = $discount_price * $menu->count;
                                        $total_price += $_price;
                                    @endphp
                                    <span>Rp{{ number_format($_price, 0, '.', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
                <li id="subtotal" class="w-full p-4 bg-yellow-50 border rounded-xl">
                    <h6 class="text-xl font-semibold">Rincian</h6>
                    @if (!is_null($table_number))
                        <div class="flex justify-between">
                            <span>Nomor Meja</span>
                            <span id="table_number">{{ $table_number }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>Rp{{ number_format($total_price, 0, '.', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Metode Pembayaran</span>
                        <select id="payment_method" name="payment_method" class="w-1/2 max-w-[150px] rounded-md px-2 py-1">
                            <option value="cash">Cash</option>
                        </select>
                    </div>
                    @if (!is_null($table_number))
                        <div class="flex justify-end mt-4">
                            <button onclick="handleConfirm()" class="px-4 py-1 bg-yellow-300 rounded-md hover:opacity-70">
                                Pesan Sekarang</button>
                        </div>
                    @else
                        <div class="flex justify-end mt-4">
                            <button id="cameraButton" class="px-4 py-1 bg-yellow-300 rounded-md hover:opacity-70">
                                Scan Meja Kamu</button>
                        </div>
                    @endif
                </li>
            </ul>
        @else
            <div class="w-full min-h-screen flex items-center justify-center">
                <h1>Your cart is empty</h1>
            </div>
        @endif
        <video id="video" autoplay></video>
    </main>

    <div id="confirm-window" class="fixed w-full h-screen top-0 left-0 hidden justify-center pt-20 z-50 px-4">
        <div class="absolute w-full h-full top-0 bg-black bg-opacity-50" onclick="handleConfirm()"></div>
        <div class="w-full h-fit max-w-md  p-7 border-b-8 border-yellow-300 bg-white border rounded-xl z-10">
            <p>Apakah anda yakin ingin pesan sekarang?</p>
            <div class="flex justify-end items-center gap-4">
                <button onclick="handelPaymentAjax()"
                    class="border rounded-md w-24 py-1
                hover:opacity-70">Ya</button>
                <button onclick="handleConfirm()"
                    class="bg-yellow-300 rounded-md text-neutral-700 hover:opacity-70
            w-24 py-1">Batal</button>
            </div>
        </div>
    </div>

    @php
        $jsonData = json_encode($menus);
    @endphp
    <script>
        function handleFavoriteAjax(id) {
            let routeHandle = `{{ route('action.toggle.favorite', ['id' => ':menuId']) }}`.replace(':menuId', id);

            var html = '';

            $.ajax({
                type: 'post',
                url: routeHandle,
                data: {
                    '_token': '{{ csrf_token() }}'
                },

                success: function(res) {

                    if (res.status == 'added') {
                        $('#love-' + id).addClass('fill-red-300');
                        $('#love-' + id).addClass('text-red-300');
                    } else if (res.status == 'deleted') {
                        $('#love-' + id).removeClass('fill-red-300');
                        $('#love-' + id).removeClass('text-red-300');
                    } else if (res.status == 'failed auth!') {
                        window.location.href = `{{ route('login') }}`;
                    }
                    $('#count-' + id).html(res.favoritecount);
                }
            });
        }

        function handleConfirm() {
            $('#confirm-window').toggleClass("hidden");
            $('#confirm-window').toggleClass("flex");
        }
    </script>

    @if (!is_null($table_number))
        <script>
            function handelPaymentAjax() {
                const menus = '{!! $jsonData !!}';
                let payment_method = $('#payment_method').val();


                $.ajax({
                    type: 'post',
                    url: `{{ route('invoice.create') }}`,
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'menus': menus,
                        'total_price': {{ $total_price }},
                        'table_number': {{ $table_number }},
                        'payment_method': payment_method,
                    },

                    success: function(res) {
                        if (res.status == 'success') {
                            let routeHandle = `{{ route('invoice', ['token' => ':token']) }}`.replace(':token',
                                res
                                .token);
                            window.location.href = routeHandle;
                        } else if (res.status == 'failed') {
                            $('#confirm-window').toggleClass("hidden");
                            $('#confirm-window').toggleClass("flex");
                            alert('Operasi gagal, 3 invoice yang belum di bayar, silahkan selesaikan pembayaran!');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Handle errors
                        console.error('Error:', textStatus, errorThrown);
                    }
                });
            }
        </script>
    @else
        <script>
            const startButton = document.getElementById('cameraButton');
            const videoElement = document.getElementById('video');

            // Fungsi untuk mendapatkan izin dan membuka kamera
            const openCamera = async () => {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({
                        video: true
                    });
                    video.srcObject = stream;
                } catch (error) {
                    console.error('Error accessing the camera:', error);
                }
            };

            // Event listener untuk memanggil fungsi membuka kamera
            startButton.addEventListener('click', openCamera);
        </script>
    @endif
@endsection
