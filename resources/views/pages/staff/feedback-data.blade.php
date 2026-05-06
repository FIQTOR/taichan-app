@extends('layouts/base')

@section('content')
    <main class="py-24 px-7 min-h-screen">
        <div class="flex justify-between">
            <h1 class="text-4xl font-bold">Data Masukan</h1>
            <div class="flex gap-2">
                <div class="flex items-center">
                    <input type="text" name="search" id="search"
                        class="border rounded-l-full py-1 px-2
                        border-r-0 focus:outline-yellow-300 w-full">
                    <button class="bg-yellow-300 rounded-r-full py-1 pl-2 pr-3 hover:opacity-70">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                            <path d="M21 21l-6 -6"></path>
                        </svg>
                    </button>
                </div>

                <button onclick="search_ajax('saran/kritk')"
                    class="px-7 py-1 bg-yellow-300 rounded-full
                shadow-md hover:opacity-70 h-fit">
                    saran/kritik
                </button>
                <button onclick="search_ajax('berbagi pengalaman')"
                    class="px-7 py-1 bg-yellow-300 rounded-full
                shadow-md hover:opacity-70 h-fit">
                    pengalaman
                </button>
                <button onclick="search_ajax('pertanyaan')"
                    class="px-7 py-1 bg-yellow-300 rounded-full
                shadow-md hover:opacity-70 h-fit">
                    pertanyaan
                </button>
            </div>
        </div>
        <ul class="grid grid-cols-1 md:grid-cols-2 my-4 gap-7" id="feedback-box">
            @foreach ($feedbacks as $feedback)
                <li class="p-4 border rounded-xl shadow-xl text-neutral-500 relative min-h-[200px]">
                    <form action="{{ route('action.delete.feedback-data') }}" method="post">
                        @csrf
                        <input type="text" name="uuid" readonly hidden value="{{ $feedback->uuid }}">
                        <button
                            class="cursor-pointer hover:opacity-70 absolute p-2 
                        rounded-full bg-yellow-300 -right-4 -top-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M4 7l16 0"></path>
                                <path d="M10 11l0 6"></path>
                                <path d="M14 11l0 6"></path>
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                            </svg>
                        </button>
                    </form>
                    <div class="flex justify-between">
                        <h2 class="font-semibold text-neutral-800">
                            {{ $feedback->fullname }}
                        </h2>
                        <span class="px-4 py-px bg-neutral-100 rounded-full">
                            {{ $feedback->type }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <div class="flex gap-2 flex-col md:flex-row">
                            <div class="w-6 rounded-full overflow-hidden relative hover:duration-300 cursor-pointer"
                                onclick="handleContact(this)">
                                <div class="absolute p-1 bg-yellow-300 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path
                                            d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2">
                                        </path>
                                    </svg>
                                </div>
                                <span class="pl-7 py-2 pr-2 bg-neutral-200 rounded-full">
                                    {{ $feedback->phonenumber }}
                                </span>
                            </div>
                            <div class="w-6 rounded-full overflow-hidden relative hover:duration-300 cursor-pointer"
                                onclick="handleContact(this)">
                                <div class="absolute p-1 bg-yellow-300 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path
                                            d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z">
                                        </path>
                                        <path d="M3 7l9 6l9 -6"></path>
                                    </svg>
                                </div>
                                <span class="pl-7 py-2 pr-2 bg-neutral-200 rounded-full">
                                    {{ $feedback->email }}
                                </span>
                            </div>
                        </div>
                        <span class="mx-4 absolute right-0">
                            {{ $feedback->created_at }}
                        </span>
                    </div>
                    <p>
                        {{ $feedback->message }}</p>
                </li>
            @endforeach
        </ul>
    </main>

    <script>
        let oldElement;

        function handleContact(e) {
            if (oldElement) {
                oldElement.classList.remove('w-full');
                oldElement.classList.add('w-6');
            }
            oldElement = e;
            oldElement.classList.remove('w-6');
            oldElement.classList.add('w-full');
        }
        $('#search').on('keyup', function() {
            $value = $(this).val();
            if ($value != '')
                search_ajax($value);
        });

        function search_ajax($value) {
            var html = "";

            $.ajax({
                type: 'get',
                url: '/feedback/data/search',
                data: {
                    'keyword': $value,
                },

                success: function(feedbacks) {
                    console.log(feedbacks);
                    if (feedbacks == 0) {
                        html += `data tidak ada`;
                    }
                    feedbacks.forEach(function(feedbacks) {
                        html += `
                <li class="p-4 border rounded-xl shadow-xl text-neutral-500 relative min-h-[200px]">
                    <form action="{{ route('action.delete.feedback-data') }}" method="post">
                        @csrf
                        <input type="text" name="uuid" readonly hidden value="` + feedbacks.uuid + `">
                        <button
                            class="cursor-pointer hover:opacity-70 absolute p-2 
                        rounded-full bg-yellow-300 -right-4 -top-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M4 7l16 0"></path>
                                <path d="M10 11l0 6"></path>
                                <path d="M14 11l0 6"></path>
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                            </svg>
                        </button>
                    </form>
                    <div class="flex justify-between">
                        <h2 class="font-semibold text-neutral-800">
                            ` + feedbacks.fullname + `
                        </h2>
                        <span class="px-4 py-px bg-neutral-100 rounded-full">
                            ` + feedbacks.type + `
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <div class="flex gap-2 flex-col md:flex-row">
                            <div class="w-6 rounded-full overflow-hidden relative hover:duration-300 cursor-pointer"
                                onclick="handleContact(this)">
                                <div class="absolute p-1 bg-yellow-300 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path
                                            d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2">
                                        </path>
                                    </svg>
                                </div>
                                <span class="pl-7 py-2 pr-2 bg-neutral-200 rounded-full">
                                    ` + feedbacks.phonenumber + `
                                </span>
                            </div>
                            <div class="w-6 rounded-full overflow-hidden relative hover:duration-300 cursor-pointer"
                                onclick="handleContact(this)">
                                <div class="absolute p-1 bg-yellow-300 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path
                                            d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z">
                                        </path>
                                        <path d="M3 7l9 6l9 -6"></path>
                                    </svg>
                                </div>
                                <span class="pl-7 py-2 pr-2 bg-neutral-200 rounded-full">
                                    ` + feedbacks.email + `
                                </span>
                            </div>
                        </div>
                        <span class="mx-4 absolute right-0">
                            ` + feedbacks.created_at + `
                        </span>
                    </div>
                    <p>` + feedbacks.message + `</p>
                </li>`;

                    });

                    $('#feedback-box').html(html);
                }
            });
        }
    </script>
@endsection
