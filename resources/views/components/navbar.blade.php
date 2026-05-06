<nav class="fixed z-50 w-full h-14 flex items-center lg:mt-4 px-4 lg:px-7">
    <div class="absolute w-full h-full top-0 left-0 py-2 px-4 lg:hidden">
        <div class="w-full h-full bg-yellow-300 rounded-lg bg-opacity-70 backdrop-blur-sm"></div>
    </div>
    <button class="absolute left-7 hover:opacity-70 lg:hidden" onclick="handle()">
        <svg xmlns="http://www.w3.org/2000/svg" class="text-neutral-700" width="24" height="24" viewBox="0 0 24 24"
            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M4 6l16 0"></path>
            <path d="M4 12l16 0"></path>
            <path d="M4 18l12 0"></path>
        </svg>
    </button>
    <h1 class="absolute left-0 ml-14 text-xl font-bold italic text-white lg:z-10">
        KORARIA</h1>

    <div id="navBgMobile" onclick="handle()"
        class="absolute hidden lg:w-0 left-0 top-0 w-full h-screen bg-black opacity-50 -z-0"></div>
    <div id="navMobile"
        class="absolute w-full max-w-xs top-0 
        h-screen p-4 -left-full duration-200 bg-yellow-300 lg:rounded-lg lg:bg-opacity-70
        lg:relative lg:left-0 lg:max-w-none shadow-xl backdrop-blur-sm
        lg:py-1 lg:px-0 lg:flex lg:items-center lg:h-fit lg:justify-center">
        <button class="absolute left-5 top-5 lg:hidden" onclick="handle()">
            <svg xmlns="http://www.w3.org/2000/svg" class="text-white hover:opacity-70" width="24" height="24"
                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M3 5a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14z"></path>
                <path d="M9 9l6 6m0 -6l-6 6"></path>
            </svg>
        </button>
        <ul
            class="flex w-full flex-col gap-2 lg:gap-6 pt-14 lg:py-3 text-neutral-800 
            lg:flex-row lg:w-fit lg:items-center">
            <li class="flex w-full lg:w-fit">
                <a href="{{ route('home') }}#"
                    class="w-full px-4 py-2 bg-opacity-30 hover:bg-white 
                    hover:bg-opacity-30 rounded-lg lg:px-0 lg:py-0
                    lg:hover:bg-transparent lg:hover:opacity-70
                    @if ($title == 'Menu') bg-white lg:bg-transparent lg:text-white @endif">
                    Beranda
                </a>
            </li>
            <li class="flex w-full lg:w-fit">
                <a href="{{ route('favorite') }}"
                    class="w-full px-4 py-2 bg-opacity-30 hover:bg-white
                    hover:bg-opacity-30 rounded-lg lg:px-0 lg:py-0
                    lg:hover:bg-transparent lg:hover:opacity-70
                    @if ($title == 'Favorit') bg-white lg:bg-transparent lg:text-white @endif">
                    Favorit
                </a>
            </li>
            <li class="flex w-full lg:w-fit">
                <a href="{{ route('cart') }}"
                    class="w-full px-4 py-2 bg-opacity-30 hover:bg-white 
                    hover:bg-opacity-30 rounded-lg lg:px-0 lg:py-0
                    lg:hover:bg-transparent lg:hover:opacity-70
                    @if ($title == 'Keranjang') bg-white lg:bg-transparent lg:text-white @endif">
                    Keranjang
                </a>
            </li>
            <li class="flex w-full lg:w-fit">
                <a href="{{ route('invoice.show') }}"
                    class="w-full px-4 py-2 bg-opacity-30 hover:bg-white
                    hover:bg-opacity-30 rounded-lg lg:px-0 lg:py-0
                    lg:hover:bg-transparent lg:hover:opacity-70
                    @if ($title == 'Pesanan Saya') bg-white lg:bg-transparent lg:text-white @endif">
                    Pesanan Saya
                </a>
            </li>
            <li class="flex w-full lg:w-fit">
                <a href="{{ route('feedback') }}"
                    class="w-full px-4 py-2 bg-opacity-30 hover:bg-white
                    hover:bg-opacity-30 rounded-lg lg:px-0 lg:py-0
                    lg:hover:bg-transparent lg:hover:opacity-70
                    @if ($title == 'Masukan') bg-white lg:bg-transparent lg:text-white @endif">
                    Masukan
                </a>
            </li>
            @if (!Auth::check())
                <li class="flex justify-center lg:absolute lg:right-7">
                    <div class="flex gap-2 justify-center">
                        <a href="{{ route('login') }}"
                            class="px-7 border-2 border-white py-2 text-white 
                        font-bold rounded-lg hover:opacity-70">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-7 bg-white py-2 font-semibold text-neutral-700 rounded-lg hover:opacity-70">
                            Register
                        </a>
                    </div>
                </li>
            @else
                @if (Auth::user()->role != 'user')
                    <li class="flex w-full lg:w-fit lg:justify-self-end">
                        <a href="{{ route('dashboard') }}"
                            class="w-full px-4 py-2 bg-opacity-30 hover:bg-white
                            hover:bg-opacity-30 rounded-lg lg:px-0 lg:py-0
                            lg:hover:bg-transparent lg:hover:opacity-70
                            @if ($title == 'Dashboard') bg-white lg:bg-transparent lg:text-white @endif">
                            Dashboard
                        </a>
                    </li>
                @endif
            @endif
        </ul>
    </div>
    @if (Auth::check())
        <button onclick="$('#profile-window').toggle()"
            class="absolute top-3 right-7 lg:right-10 lg:top-2 bg-neutral-300 rounded-full w-8 h-8 lg:w-10 lg:h-10">
            @if (isset(Auth::user()->picture))
                <img src="{{ asset('storage/' . Auth::user()->picture) }}" alt="picture"
                    class="w-full h-full rounded-full border">
            @else
                <span class="uppercase font-bold text-white text-xl">{{ substr(Auth::user()->name, 0, 1) }}</span>
            @endif
        </button>
    @endif
</nav>

@if (Auth::check())
    <div hidden id="profile-window"
        class="fixed top-14 lg:top-20 right-7 p-4 rounded-md bg-yellow-400 bg-opacity-60 z-50 text-neutral-700">
        <div class="flex gap-2 items-center pb-4">
            <div class="bg-neutral-300 rounded-full w-10 h-10 flex justify-center items-center">
                @if (isset(Auth::user()->picture))
                    <img src="{{ asset('storage/' . Auth::user()->picture) }}" alt="picture"
                        class="w-full h-full rounded-full border">
                @else
                    <span class="uppercase font-bold text-white text-xl">{{ substr(Auth::user()->name, 0, 1) }}</span>
                @endif
            </div>
            <div>
                <p class="font-bold">{{ Auth::user()->name }}</p>
                <p>{{ Auth::user()->email }}</p>
            </div>
        </div>
        <hr>
        <div class="pt-4 flex flex-col gap-1">
            <a href="{{ route('user.profile') }}"
                class="flex items-center gap-2 py-1 px-2 hover:bg-white hover:bg-opacity-20 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                </svg>
                Profile
            </a>
            <button onclick="handleLogout()"
                class="flex items-center gap-2 py-1 px-2 hover:bg-white hover:bg-opacity-20 rounded-md"><svg
                    xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" />
                    <path d="M15 12h-12l3 -3" />
                    <path d="M6 15l-3 -3" />
                </svg>
                Logout
            </button>
        </div>
    </div>
@endif

<div id="logout-window" class="fixed w-full h-screen hidden justify-center pt-20 z-50 px-4">
    <div class="absolute w-full h-full top-0 bg-black bg-opacity-50" onclick="handleLogout()"></div>
    <div class="w-full h-fit max-w-lg  p-7 border-b-8 border-yellow-300 bg-white border rounded-xl z-10">
        <p>Apakah anda yakin ingin keluar?</p>
        <div class="flex justify-end items-center gap-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="border rounded-lg w-24 py-1
                hover:opacity-70">Ya</button>
            </form>
            <button onclick="handleLogout()"
                class="bg-yellow-300 rounded-lg text-neutral-700 hover:opacity-70
            w-24 py-1">Batal</button>
        </div>
    </div>
</div>

<script>
    let navShow = false;

    function handle() {
        navShow = !navShow;
        if (navShow) {
            document.getElementById('navMobile').classList.add('left-0');
            document.getElementById('navMobile').classList.remove('-left-full');
            // document.getElementById('navBgMobile').classList.remove('hidden');
            $('#navBgMobile').show();
        } else {
            document.getElementById('navMobile').classList.add('-left-full');
            document.getElementById('navMobile').classList.remove('left-0');
            // document.getElementById('navBgMobile').classList.add('hidden');
            $('#navBgMobile').hide();
        }
    }

    function handleLogout() {
        $('#logout-window').toggleClass("hidden");
        $('#logout-window').toggleClass("flex");
    }
</script>
