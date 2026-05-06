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
            <h4 class="text-2xl font-bold text-neutral-700">List Menu :</h4>
            <div class="list">
                @include('partials.pagination_menu', $menus)
            </div>
            </ul>
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
                url: "{{ route('menu.search') }}",
                data: {
                    'keyword': $value,
                },

                success: function(res) {
                    $('.list').html(res)
                }
            });
        }
    </script>
@endsection
