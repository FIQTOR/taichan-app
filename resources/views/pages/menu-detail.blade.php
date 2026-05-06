@extends('layouts/base')

@section('content')
    @include('components/comment-popup')
    <main class="w-full max-w-md mx-auto min-w-screen py-14 md:py-24">
        <div class="w-full rounded-md border relative overflow-hidden"><span
                class="absolute top-0 right-0 bg-red-400 px-2 rounded-tr-md rounded-bl-md
text-white">
                @if ($menu->discount != 0)
                    <span class="absolute top-0 right-0 bg-red-400 px-2 rounded-tr-md rounded-bl-md
text-white">
                        {{ $menu->discount }}%
                    </span>
                @endif
            </span>
            <video src="{{ asset('storage/' . $menu->video) }}" autoplay muted loop class="rounded-md"></video>
            <div class="p-4 flex flex-col">
                <div class="flex justify-between">
                    <h6 class="font-bold">{{ $menu->title }}</h6>
                    <span class="flex gap-1 items-center text-neutral-400">
                        <div class="flex items-center">
                            <button class="hover:opacity-70 hover:text-red-300"
                                onclick="handleFavoriteAjax('{{ $menu->id }}')">
                                <svg id="love-{{ $menu->id }}" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="@if ($menu->myfavorite) fill-red-300 text-red-300 @endif">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572">
                                    </path>
                                </svg>
                            </button>
                        </div>
                        <span id="count-{{ $menu->id }}">{{ $menu->favorite }}</span>
                    </span>
                </div>
                <p class="text-neutral-700">{{ $menu->description }}</p>
                <div class="flex flex-col md:flex-row justify-between text-lg py-2">
                    @php
                        $discountprice = $menu->price - $menu->price * ($menu->discount / 100);
                    @endphp
                    <span>Rp{{ number_format($discountprice, 0, '.', '.') }}</span>
                    @if ($menu->discount != 0)
                        <span class="line-through text-red-300">
                            Rp{{ number_format($menu->price, 0, '.', '.') }}
                        </span>
                    @endif
                </div>
                <div class="flex flex-col md:flex-row justify-between text-lg">
                    <span>Terjual</span>
                    <span class="text-neutral-400">{{ $menu->sold }}</span>
                </div>
                <div class="flex flex-col md:flex-row justify-between text-lg">
                    <span class="flex gap-1">
                        <?php
                        $fillstar = floor($menu->rating);
                        $star = 5 - $fillstar;
                        ?>
                        @for ($a = 0; $a < $fillstar; $a++)
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-300" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z"
                                    stroke-width="0" fill="currentColor"></path>
                            </svg>
                        @endfor
                        @for ($a = 0; $a < $star; $a++)
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-neutral-200" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z"
                                    stroke-width="0" fill="currentColor"></path>
                            </svg>
                        @endfor
                    </span>
                    <span class="text-neutral-400">{{ number_format($menu->rating, 1) }}</span>
                </div>
                <a href="{{ route('menu') }}"
                    class="self-end bg-neutral-200 px-4 py-1 rounded-md
            hover:opacity-70">
                    Kembali
                </a>
            </div>
        </div>

        <div class="py-4 px-2">
            <h6 class="pb-1">Comment:</h6>
            <ul class="flex flex-col gap-4">
                @foreach ($comments as $comment)
                    <li class="p-4 rounded-md border flex flex-col">
                        <span class="font-medium text-lg">{{ substr($comment->name, 0, 3) }}****</span>
                        <span class="text-neutral-500">{{ $comment->created_at }}</span>
                        <div class="flex gap-1">
                            <?php
                            $cfillstar = floor($comment->rating);
                            $cstar = 5 - $cfillstar;
                            ?>
                            @for ($b = 0; $b < $cfillstar; $b++)
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-300" width="15"
                                    height="15" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z"
                                        stroke-width="0" fill="currentColor"></path>
                                </svg>
                            @endfor
                            @for ($c = 0; $c < $cstar; $c++)
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-neutral-200" width="15"
                                    height="15" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z"
                                        stroke-width="0" fill="currentColor"></path>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-neutral-600">{{ $comment->message }}</span>

                        @if ($comment->user_id == Auth::user()->uuid)
                            <div class="flex justify-end py-2 gap-2">
                                <button onclick="handleCommentPopup({{ $comment->menu_id }})"
                                    class="px-4 py-px bg-neutral-200 rounded-md hover:opacity-70">Ubah</button>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
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
    </script>
@endsection
