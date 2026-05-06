<footer class="p-7 border">
    <div class="flex flex-wrap gap-4 justify-between">
        <div class="h-24">
            <div class="h-full flex gap-4 items-center">
                <img src="{{ asset('imgs/icon.png') }}" alt="icon" width="100" height="100"
                    class="h-full rounded-full">
                <p class="text-4xl font-bold">KORARIA</p>
            </div>
        </div>
        <div class="flex flex-col md:flex-row gap-14">
            <ul>
                <li class="font-bold text-xl text-black">Links</li>
                <li><a href="{{ route('home') }}#" class="text-neutral-600 hover:opacity-70">
                        Beranda
                    </a>
                </li>
                <li><a href="{{ route('cart') }}" class="text-neutral-600 hover:opacity-70">
                        Keranjang
                    </a>
                </li>
                <li><a href="{{ route('favorite') }}" class="text-neutral-600 hover:opacity-70">
                        Favorit
                    </a>
                </li>
                <li><a href="{{ route('feedback') }}" class="text-neutral-600 hover:opacity-70">
                        Masukan
                    </a>
                </li>
            </ul>
            <ul>
                <li class="font-bold text-xl text-black">Bantuan dan Paduan</li>
                <li><a href="#" class="text-neutral-600 hover:opacity-70">
                        Syarat dan Ketentuan
                    </a>
                </li>
                <li><a href="#" class="text-neutral-600 hover:opacity-70">
                        Kebijakan Privasi
                    </a>
                </li>
                <li><a href="#" class="text-neutral-600 hover:opacity-70">
                        FAQ
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <span class="w-full flex justify-center text-neutral-700 pt-7">
        Copyright © 2023 FIQTOR All rights reserved
    </span>
</footer>
