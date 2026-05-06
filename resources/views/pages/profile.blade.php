@extends('layouts/base')

@section('content')
    <main class="w-full max-w-md mx-auto min-h-screen py-20 px-4">
        <section class="rounded-md border p-4 flex flex-col gap-2">
            <form id="profile-form" action="#" method="POST" class="flex flex-col gap-2">
                @csrf
                @method('PUT')
                <div class="flex items-center flex-col gap-2">
                    <div class="bg-neutral-300 rounded-full w-36 h-36 flex justify-center items-center relative">
                        @if (isset(Auth::user()->picture))
                            <img src="{{ asset('storage/' . $user->picture) }}" alt="picture"
                                class="w-full h-full rounded-full border">
                        @else
                            <span
                                class="uppercase font-bold text-white text-7xl">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        @endif

                        <button onclick="event.preventDefault();
                 $('#menu-edit-window').toggle();"
                            class="absolute -left-5 bottom-5 border bg-black bg-opacity-60 px-2 py-px rounded-md text-white flex items-center hover:opacity-70">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil"
                                width="20" height="20" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                <path d="M13.5 6.5l4 4" />
                            </svg>
                            Edit</button>
                        <div id="menu-edit-window" hidden
                            class="absolute -bottom-12 -translate-x-24 bg-black bg-opacity-60 rounded-md py-2 text-white">
                            <button
                                onclick="event.preventDefault(); $('#picture-window-form').addClass('flex'); $('#picture-window-form').removeClass('hidden');"
                                class="w-full text-left px-2 hover:bg-yellow-300 hover:bg-opacity-60">Upload a
                                photo...</button>
                            <button onclick="removePictureAjax(event)"
                                class="w-full text-left px-2 hover:bg-yellow-300 hover:bg-opacity-60"">Remove
                                photo</button>
                        </div>
                    </div>
                    <span class="text-sm text-red-400" id="picture-msg"></span>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="name">Nama lengkap:</label>
                    <input class="px-2 py-1 rounded-md border text-neutral-600" type="text" id="name" name="name"
                        value="{{ $user->name }}" onchange="handleNameChecking(this.value)">
                    <span id="name-msg" class="text-red-400 text-sm flex items-center gap-1"></span>
                </div>
                <div class="flex flex-col gap-1">
                    <span>Email:</span>
                    <span class="px-2 py-1 rounded-md border text-neutral-600" type="text" id="name"
                        name="name">{{ $user->email }}</span>
                </div>
                <button onclick="handleUpdateProfile(event)"
                    class="px-2 py-1 bg-neutral-300 rounded-md hover:opacity-70">Simpan</button>
            </form>
            <hr>
            <h3 class="text-xl font-bold">Pencapaian</h3>
            <div class="flex justify-between">
                <span>Total pembelian</span>
                <span>Rp{{ number_format($user->total_purchased, 0, '.', '.') }}</span>
            </div>
        </section>
    </main>

    <div id="picture-window-form"
        class="fixed w-full h-full bg-black bg-opacity-60 top-0 left-0 z-50 hidden justify-center items-center">
        <div class="w-full max-w-md p-3 bg-white rounded-md relative">
            <button onclick="$('#picture-window-form').addClass('hidden'); $('#picture-window-form').removeClass('flex');"
                class="bg-red-400 text-white rounded-bl-md rounded-tr-md p-2 absolute top-0 right-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M18 6l-12 12" />
                    <path d="M6 6l12 12" />
                </svg>
            </button>
            <form id="picture-form" action="#" class="flex flex-col gap-2">
                @csrf
                <img id="preview-picture" src="" alt="" class="rounded-full">
                <input onchange="handlePreviewImage(this)" type="file" name="picture" id="picture">
                <span class="text-sm text-red-400" id="picture-input-msg"></span>
                <button onclick="handleImagePost(event)" hidden id="picture-form-submit"
                    class="bg-neutral-300 rounded-md hover:opacity-70 py-1">Simpan
                    foto profil</button>
            </form>
        </div>
    </div>

    <script>
        function removePictureAjax(e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: `{{ route('user.picture.remove') }}`,
                data: {
                    '_token': '{{ csrf_token() }}'
                },

                success: function(res) {
                    if (res.status == 'success') {
                        location.reload();
                    } else {
                        $('#picture-msg').html('Gambar sudah kosong!');
                        $('#picture-msg').removeClass('text-green-400');
                        $('#picture-msg').addClass('text-red-400');
                    }
                }
            });
        }

        function handlePreviewImage(element) {
            var formData = new FormData(document.getElementById('picture-form'));

            $.ajax({
                type: 'post',
                url: `{{ route('user.picture.check') }}`,
                data: formData,
                contentType: false, // To send as FormData
                processData: false, // To prevent jQuery from processing the data

                success: function(res) {
                    if (res.status != 'empty') {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('#preview-picture').attr('src', e.target.result);
                            $('#preview-picture').show();
                        }
                        reader.readAsDataURL(element.files[0]);
                    }
                    if (res.status == 'failed') {
                        $('#picture-input-msg').html('Resolusi gambar harus 1:1 (persegi)');
                        $('#picture-form-submit').hide();
                    } else if (res.status == 'empty') {
                        $('#picture-input-msg').html('Pilih gambar terlebih dahulu');
                        $('#picture-form-submit').hide();
                        $('#preview-picture').hide();
                    } else {
                        $('#picture-input-msg').html('');
                        $('#picture-form-submit').show();
                    }
                }
            });
        }

        function handleImagePost(e) {
            e.preventDefault();
            var formData = new FormData(document.getElementById('picture-form'));
            $.ajax({
                type: 'post',
                url: `{{ route('user.picture.update') }}`,
                data: formData,
                contentType: false, // To send as FormData
                processData: false, // To prevent jQuery from processing the data

                success: function(res) {
                    location.reload();
                }
            });
        }

        let nameAvailable = false;

        function handleNameChecking(name) {
            let routeHandle = `{{ route('user.namefinder', ['name' => ':name']) }}`.replace(':name', name);
            $.ajax({
                type: 'get',
                url: routeHandle,
                data: {},

                success: function(res) {
                    if (res.status == 'found') {
                        $('#name-msg').html('Nama tidak tersedia');
                        $('#name-msg').removeClass('text-green-400');
                        $('#name-msg').addClass('text-red-400');
                        nameAvailable = false;
                    } else if (res.status == 'failed') {
                        $('#name-msg').html('Nama minimal 3 karakter');
                        $('#name-msg').removeClass('text-green-400');
                        $('#name-msg').addClass('text-red-400');
                        nameAvailable = false;
                    } else {
                        $('#name-msg').html('Nama tersedia');
                        $('#name-msg').removeClass('text-red-400');
                        $('#name-msg').addClass('text-green-400');
                        nameAvailable = true;
                    }
                }
            });
        }

        function handleUpdateProfile(e) {
            e.preventDefault();
            if (nameAvailable) {
                var formData = new FormData(document.getElementById('profile-form'));
                $.ajax({
                    type: 'post',
                    url: `{{ route('user.update') }}`,
                    data: formData,
                    contentType: false, // To send as FormData
                    processData: false, // To prevent jQuery from processing the data

                    success: function(res) {
                        console.log(res);
                        if (res.status == 'success') {
                            location.reload();
                        }
                    }
                });
            }
        }
    </script>
@endsection
