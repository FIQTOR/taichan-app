@extends('layouts/base')

@section('content')
    @include('components/order-popup')
    <header class="h-screen md:h-[500px] relative overflow-hidden flex flex-col md:flex-row">
        <div class="absolute w-80 h-80 -top-20 -right-20 rounded-full bg-yellow-300 blur-3xl -z-[1]"></div>
        <div class="absolute w-52 h-52 bottom-20 -left-20 rounded-full bg-yellow-200 blur-3xl -z-[1]"></div>
        <div class="absolute w-72 h-72 -top-10 right-[50%] rounded-full bg-yellow-100 blur-3xl -z-[1]"></div>
        <div class="w-full md:w-1/2 flex flex-col justify-center pl-7 md:pl-14 pt-14 md:pt-0 z-[1]">
            <h1
                class="text-7xl font-bold italic text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-yellow-800">
                KORARIA</h1>
            <p class="text-2xl font-medium">Restoran terbaik di indonesia</p>
            <p class="text-xl text-neutral-700">Cepetan cobain makanan yang <br> ada di restoran kami bikin nagih loh!</p>
            <a href="#list-menu"
                class="px-4 py-2 bg-yellow-300 rounded-md w-fit my-3 flex items-center gap-4 shadow-md hover:opacity-70"><svg
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="1"
                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 5l0 14" />
                    <path d="M16 15l-4 4" />
                    <path d="M8 15l4 4" />
                </svg> Cari Menu Sekarang</a>
        </div>
        <div class="w-full md:w-1/2 flex items-center justify-center">
            <img src="{{ asset('imgs/nasi-goreng.png') }}" alt="nasi goreng">
        </div>
    </header>
    <main class="py-7">
        <section class="w-full flex justify-center py-7 px-4">
            <div class="flex flex-col gap-4">
                <div class="flex items-center">
                    <input type="text" name="search" id="search"
                        class="border rounded-l-md py-1 px-2
                        border-r-0 focus:outline-yellow-300 w-full"
                        onkeyup="search_ajax(this.value)">
                    <button class="bg-yellow-300 rounded-r-md py-1 pl-2 pr-3 hover:opacity-70">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                            <path d="M21 21l-6 -6"></path>
                        </svg>
                    </button>
                </div>
                <ul class="flex flex-wrap justify-center gap-2">
                    <li class="flex">
                        <button onclick="search_ajax('sate')"
                            class="px-7 py-1 bg-yellow-300 rounded-md
                        shadow-md hover:opacity-70">
                            Sate
                        </button>
                    </li>
                    <li class="flex">
                        <button onclick="search_ajax('minuman')"
                            class="px-7 py-1 bg-yellow-300 rounded-md
                        shadow-md hover:opacity-70">
                            Minuman
                        </button>
                    </li>
                    <li class="flex">
                        <button onclick="search_ajax('paket')"
                            class="px-7 py-1 bg-yellow-300 rounded-md
                        shadow-md hover:opacity-70">
                            Paket
                        </button>
                    </li>
                    <li class="flex">
                        <button onclick="search_ajax('promo')"
                            class="px-7 py-1 bg-yellow-300 rounded-md
                        shadow-md hover:opacity-70">
                            Promo
                        </button>
                    </li>
                </ul>
            </div>
        </section>
        <section id="list-menu" class="px-2 md:px-7">
            <h4 class="text-2xl font-bold text-neutral-700">List Menu Favorit:</h4>
            <ul id="list-div" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 py-4 gap-2">
                @php
                    $no = 0;
                @endphp
                @foreach ($menus as $menu)
                    <li class="w-full border rounded-md flex flex-col overflow-hidden relative">
                        @if ($menu->stock == 'habis')
                            <span
                                class="absolute w-full h-full rounded-md bg-white bg-opacity-90 
                        flex justify-center items-center text-xl font-bold text-red-500 z-10">
                                Tidak tersedia
                            </span>
                        @endif
                        @if ($menu->discount != 0)
                            <span
                                class="absolute top-0 right-0 bg-red-400 px-2 rounded-tr-md rounded-bl-md
                            text-white">
                                {{ $menu->discount }}%
                            </span>
                        @endif
                        <div class="h-full flex flex-col justify-between">
                            <div>
                                <div class="w-full h-28 md:h-40 overflow-hidden relative rounded-md">
                                    <img src="{{ asset('storage/' . $menu->picture) }}" alt="picture"
                                        class="absolute w-full">
                                </div>
                                <div class="text-sm px-2 md:px-4 py-1 md:py-4">
                                    <div class="flex justify-between">
                                        <h6 class="font-bold text-base">{{ $menu->title }}</h6>
                                        <span class="flex gap-1 items-center text-neutral-400">
                                            <div class="flex items-center">
                                                <button class="hover:opacity-70 hover:text-red-300"
                                                    onclick="handleFavoriteAjax('{{ $menu->id }}')">
                                                    <svg id="love-{{ $menu->id }}" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round" class="fill-red-300 text-red-300">
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
                                    <p class="text-neutral-700">{{ $menu->description }}</p>
                                </div>
                            </div>
                            <div class="text-sm px-2 md:px-4 py-1 md:py-4">
                                <div class="flex flex-col md:flex-row justify-between text-base">
                                    @php
                                        $discount_price = $menu->price - $menu->price * ($menu->discount / 100);
                                    @endphp
                                    <span>
                                        Rp{{ number_format($discount_price, 0, '.', '.') }}
                                    </span>
                                    @if ($menu->discount != 0)
                                        <span class="line-through text-red-300">
                                            Rp{{ number_format($menu->price, 0, '.', '.') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="flex flex-col md:flex-row justify-between text-base">
                                    <span>Terjual</span>
                                    <span class="text-neutral-400">{{ $menu->sold }}</span>
                                </div>
                                <div class="flex flex-col md:flex-row justify-between text-base">
                                    <span class="flex gap-1">
                                        <?php
                                        $fillstar = floor($menu->rating);
                                        $star = 5 - $fillstar;
                                        ?>
                                        @for ($a = 0; $a < $fillstar; $a++)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-300"
                                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path
                                                    d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z"
                                                    stroke-width="0" fill="currentColor"></path>
                                            </svg>
                                        @endfor
                                        @for ($a = 0; $a < $star; $a++)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="text-neutral-200"
                                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path
                                                    d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z"
                                                    stroke-width="0" fill="currentColor"></path>
                                            </svg>
                                        @endfor
                                    </span>
                                    <span class="text-neutral-400">{{ number_format($menu->rating, 1, '.', ',') }}</span>
                                </div>
                                @if ($menu->stock == 'tersedia')
                                    <div class="flex justify-between py-2">
                                        <a href="{{ route('menu.detail', $menu->id) }}"
                                            class="self-end bg-neutral-200 px-4 py-1 rounded-md
                                                    hover:opacity-70">
                                            Detail
                                        </a>
                                        <button onclick="handleCart({{ $menu->id }})"
                                            class="self-end bg-yellow-300 px-4 py-1 rounded-md
                                                hover:opacity-70">
                                            Pesan
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </li>
                    @php
                        $no++;
                    @endphp
                @endforeach
            </ul>
        </section>
    </main>

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
                        console.log(res.status);
                        $('#love-' + id).addClass('fill-red-300');
                        $('#love-' + id).addClass('text-red-300');
                    } else if (res.status == 'deleted') {
                        $('#love-' + id).removeClass('fill-red-300');
                        $('#love-' + id).removeClass('text-red-300');
                    }
                    $('#count-' + id).html(res.favoritecount);
                }
            });
        }

        function search_ajax($value) {
            $.ajax({
                type: 'get',
                url: `{{ route('menu.search') }}`,
                data: {
                    'keyword': $value,
                },

                success: function(menus) {
                    let html = '';
                    if (menus == 0) {
                        html += `
                            <tr>
                                <td>Produk tidak ditemukan</td>
                            </tr>`;
                    } else {
                        menus.forEach(function(menus) {
                            if (menus.myfavorite) {
                                let discount_price = menus.price - menus.price * (menus.discount / 100);
                                let fillstar = Math.floor(menus.rating);
                                let star = 5 - fillstar;

                                let htmlStar = '';
                                for (let a = 0; a < fillstar; a++) {
                                    htmlStar += `<svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-300"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z"
                                        stroke-width="0" fill="currentColor"></path>
                                </svg>`;
                                }
                                for (let b = 0; b < star; b++) {
                                    htmlStar += `<svg xmlns="http://www.w3.org/2000/svg" class="text-neutral-200"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z"
                                        stroke-width="0" fill="currentColor"></path>
                                </svg>`;
                                }

                                html += `<li class="w-full border rounded-md flex flex-col overflow-hidden relative">
                                    ` + ((menus.stock == 'habis') ? `<span
                                            class="absolute w-full h-full rounded-md bg-white bg-opacity-90 
                                            flex justify-center items-center text-xl font-bold text-red-500 z-10">
                                            Tidak tersedia
                                        </span>` : ``) + ((menus.discount != 0) ? `
                                        <span
                                            class="absolute top-0 right-0 bg-red-400 px-2 rounded-tr-md rounded-bl-md
                                            text-white">
                                            ` + menus.discount + `%
                                        </span>` : ``) +
                                    `
                                    <div class="h-full flex flex-col justify-between">
                                        <div>
                                            <div class="w-full h-28 md:h-40 overflow-hidden relative rounded-md">
                                                <img src="` + `{{ asset('storage/' . ':picture') }}`.replace(
                                        ':picture', menus.picture) + `" alt="picture"
                                                    class="absolute w-full">
                                            </div>
                                            <div class="text-sm px-2 md:px-4 py-1 md:py-4">
                                                <div class="flex justify-between">
                                                    <h6 class="font-bold text-base">` + menus.title + `</h6>
                                                    <span class="flex gap-1 items-center text-neutral-400">
                                                        <div class="flex items-center">
                                                            <button class="hover:opacity-70 hover:text-red-300"
                                                                onclick="handleFavoriteAjax('` + menus.id + `')">
                                                                <svg id="love-` + menus.id + `" xmlns="http://www.w3.org/2000/svg"
                                                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    class="fill-red-300 text-red-300">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                    <path
                                                                        d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572">
                                                                    </path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <span id="count-` + menus.id + `">` + menus.favorite + `</span>
                                                    </span>
                                                </div>
                                                <p class="text-neutral-700">` + menus.description + `</p>
                                            </div>
                                        </div>
                                        <div class="text-sm px-2 md:px-4 py-1 md:py-4">
                                            <div class="flex flex-col md:flex-row justify-between text-base">
                                                <span>
                                                    Rp` + discount_price.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g,
                                        ".") + `
                                                </span>` + ((menus.discount != 0) ? `
                                                    <span class="line-through text-red-300">
                                                        Rp` + (menus.price).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g,
                                        ".") + `
                                                    </span>` : ``) + `
                                            </div>
                                            <div class="flex flex-col md:flex-row justify-between text-base">
                                                <span>Terjual</span>
                                                <span class="text-neutral-400">` + menus.sold + `</span>
                                            </div>
                                            <div class="flex flex-col md:flex-row justify-between text-base">
                                                <span class="flex gap-1">` + htmlStar + `
                                                </span>
                                                <span class="text-neutral-400">` + (menus.rating).toFixed(0).replace(
                                        /\B(?=(\d{3})+(?!\d))/g,
                                        ".") + `</span>
                                            </div>` + ((menus.stock == 'tersedia') ? `
                                                <div class="flex justify-between py-2">
                                                    <a href="` + `{{ route('menu.detail', ['id' => ':id']) }}`
                                        .replace(':id',
                                            menus.id) + `"
                                                        class="self-end bg-neutral-200 px-4 py-1 rounded-md
                                                                hover:opacity-70">
                                                        Detail
                                                    </a>
                                                    <button onclick="handleCart(` + menus.id + `)"
                                                        class="self-end bg-yellow-300 px-4 py-1 rounded-md
                                                            hover:opacity-70">
                                                        Pesan
                                                    </button>
                                                </div>` : ``) + `
                                        </div>
                                    </div>
                                </li>`;
                            }
                        });
                    }

                    $('#list-div').html(html);
                }
            });
        }
    </script>
@endsection
