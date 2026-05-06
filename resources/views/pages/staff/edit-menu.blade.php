@extends('layouts/base')

@section('content')
    <main class="w-full max-w-md mx-auto min-h-screen flex justify-center items-center py-32 px-4">
        <div class="w-full rounded-xl shadow-2xl border flex flex-col gap-2 p-4 relative text-neutral-600">
            <div class="absolute self-center -translate-y-16 bg-yellow-300 rounded-full p-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto text-white" width="75" height="75"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M4 10h16"></path>
                    <path d="M4 14h16"></path>
                    <path d="M9 18l3 3l3 -3"></path>
                    <path d="M9 6l3 -3l3 3"></path>
                </svg>
            </div>
            <h1 class="font-bold text-4xl mx-auto mt-14 mb-7 text-neutral-500">Edit Menu</h1>
            <form action="{{ route('action.edit.menu', $menu->id) }}" method="POST" class="flex flex-col gap-2"
                enctype="multipart/form-data">
                @csrf

                @if (session('error'))
                    <p class="text-red-500">{{ session('error') }}</p>
                @endif
                @if (session('success'))
                    <p class="text-green-500">{{ session('success') }}</p>
                @endif

                <div class="flex flex-col gap-1">
                    <label for="visibility">Visibilitas</label>
                    <select name="visibility" id="visibility"
                        class="px-2 py-1 rounded-md outline outline-1
                    focus:outline-yellow-300 focus:outline-2 outline-neutral-500">
                        <option value="public" @if ($menu['visibility'] == 'public') selected @endif>Publik</option>
                        <option value="private" @if ($menu['visibility'] == 'private') selected @endif>Privasi</option>
                    </select>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="category">Kategori</label>
                    <select name="category" id="category"
                        class="px-2 py-1 rounded-md outline outline-1
                    focus:outline-yellow-300 focus:outline-2 outline-neutral-500">
                        <option value="makanan" @if ($menu['category'] == 'makanan') selected @endif>Makanan</option>
                        <option value="minuman" @if ($menu['category'] == 'minuman') selected @endif>Minuman</option>
                        <option value="paket" @if ($menu['category'] == 'paket') selected @endif>Paket</option>
                    </select>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="title">Judul</label>
                    <input type="title" name="title" id="title"
                        class="px-2 py-1 rounded-md outline outline-1
                        focus:outline-yellow-300 focus:outline-2
                        @error('title') outline-red-600 @else outline-neutral-500 @enderror"
                        value="{{ $menu->title }}">
                    @error('title')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col gap-1">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" id="description" cols="30" rows="3"
                        class="px-2 py-1 rounded-md outline outline-1
                            focus:outline-yellow-300 focus:outline-2
                            @error('description') outline-red-600 @else outline-neutral-500 @enderror">{{ $menu->description }}</textarea>
                    @error('description')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col gap-1">
                    <div class="flex flex-col gap-2 w-full">
                        <div class="flex justify-between flex-wrap">
                            <span>Harga (IDR)</span>
                            <span class="flex items-center gap-2">Pakai Diskon
                                <input type="checkbox" id="discount-checkbox" {{ $menu->discount == 0 ? '' : 'checked' }}
                                    onchange="handleDiscountPrice(this.checked)"></span>
                        </div>
                        <input type="number" name="price" id="price"
                            class="px-2 py-1 rounded-md outline outline-1
                            focus:outline-yellow-300 focus:outline-2
                            @error('price') outline-red-600 @else outline-neutral-500 @enderror"
                            value="{{ $menu->price }}" onchange="handleExpectPrice()" step="1000" min="0">
                        @error('price')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="hidden justify-between gap-2" id="discount-input">
                        <div class="flex flex-col gap-2 w-1/2">
                            <label for="discount">Diskon</label>
                            <div class="flex gap-2 w-full">
                                <input type="number" name="discount" id="discount"
                                    class="px-2 py-1 rounded-md outline outline-1
                                    focus:outline-yellow-300 focus:outline-2 w-1/2
                                    @error('discount') outline-red-600 @else outline-neutral-500 @enderror"
                                    value="{{ $menu->discount }}" onchange="handleExpectPrice()">
                                <span class="text-xl">%</span>
                            </div>
                            @error('discount')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col gap-2 w-full">
                            <label for="expected">Ekspetasi Harga</label>
                            @php
                                $discount_price = $menu->price - $menu->price * ($menu->discount / 100);
                            @endphp
                            <input type="number" id="expected"
                                class="px-2 py-1 rounded-md outline outline-1 outline-neutral-500
                                focus:outline-yellow-300 focus:outline-2"
                                value="{{ $discount_price }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="stock">Stok Awal</label>
                    <select name="stock" id="stock"
                        class="px-2 py-1 rounded-md outline outline-1
                    focus:outline-yellow-300 focus:outline-2 outline-neutral-500">
                        <option value="tersedia" @if ($menu['stock'] == 'tersedia') selected @endif>Tersedia</option>
                        <option value="habis" @if ($menu['stock'] == 'habis') selected @endif>Habis</option>
                    </select>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="picture">Gambar</label>
                    <img id="previewPicture" src="{{ asset('storage/' . $menu->picture) }}" alt="picture not found!"
                        class="w-1/2 rounded-md">
                    <input type="file" name="picture" id="picture" onchange="handleInputPicture(this)"
                        class="rounded-md outline outline-1
                focus:outline-yellow-300 focus:outline-2
                @error('picture') outline-red-600 @else outline-neutral-500 @enderror">
                    @error('picture')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col gap-1">
                    <label for="video">Detail Video</label>
                    <video id="previewVideo" src="{{ asset('storage/' . $menu->video) }}" controls
                        class="w-1/2 rounded-md"></video>
                    <input type="file" name="video" id="video" onchange="handleInputVideo(this)"
                        class="rounded-md outline outline-1
                        focus:outline-yellow-300 focus:outline-2
                        @error('video') outline-red-600 @else outline-neutral-500 @enderror">
                    @error('video')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <button class="bg-yellow-300 py-1 text-neutral-700 rounded-md hover:opacity-70">
                    Perbarui Menu</button>
            </form>
            <a href="{{ route('menu-data') }}" class="text-blue-400 hover:opacity-70">Kembali Ke Data Menu</a>
        </div>
    </main>

    <script>
        handleDiscountPrice({{ $menu->discount == 0 ? false : true }});

        $('#discount').on('input', function() {
            if ($(this).val() > 100)
                $(this).val(100)
            else if ($(this).val() < 0)
                $(this).val(0)
        });

        $('#price').on('input', function() {
            if ($(this).val() < 0)
                $(this).val(0)
        });

        function handleDiscountPrice(value) {
            if (value) {
                $('#discount-input').addClass('flex');
                $('#discount-input').removeClass('hidden');
            } else {
                $('#discount-input').addClass('hidden');
                $('#discount-input').removeClass('flex');
            }
        }

        function handleExpectPrice() {
            let expectPrice = $('#price').val() - ($('#price').val() / 100 * $('#discount').val());
            $('#expected').val(expectPrice);
        }

        function handleInputPicture(element) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#previewPicture').attr('src', e.target.result);
            }

            reader.readAsDataURL(element.files[0]);
        }

        function handleInputVideo(element) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#previewVideo').attr('src', e.target.result);
            }

            reader.readAsDataURL(element.files[0]);
        }
    </script>
@endsection
