@extends('layouts/base')

@section('content')
    @include('components/user-role-popup')
    <main class="py-24 min-h-screen">
        <div class="sm:px-6 lg:px-8 flex justify-between flex-col md:flex-row gap-4 mx-4">
            <div class="flex flex-wrap gap-2 items-center w-fit">
                <h1 class="text-4xl font-bold">Data User</h1>
            </div>
            <div class="flex items-center">
                <input onkeyup="search_ajax(this.value)" type="text" name="search" id="search"
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
            <div class="flex flex-wrap gap-2 w-fit">
                <button onclick="search_ajax('user')"
                    class="px-7 py-1 bg-yellow-300 rounded-full
                shadow-md hover:opacity-70 h-fit">
                    User
                </button>
                <button onclick="search_ajax('staff')"
                    class="px-7 py-1 bg-yellow-300 rounded-full
                shadow-md hover:opacity-70 h-fit">
                    Staff
                </button>
                <button onclick="search_ajax('admin')"
                    class="px-7 py-1 bg-yellow-300 rounded-full
                shadow-md hover:opacity-70 h-fit">
                    Admin
                </button>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden rounded-xl">
                        <table border="1" class="min-w-full border">
                            <thead>
                                <tr class="bg-yellow-300 rounded-xl">
                                    <th class="font-light text-center w-14 px-4 py-2">No.</th>
                                    <th class="font-light text-center px-4 py-2">Gambar</th>
                                    <th class="font-light text-center px-4 py-2">Name</th>
                                    <th class="font-light text-center px-4 py-2">Email</th>
                                    <th class="font-light text-center px-6 py-2">Total purchased</th>
                                    <th class="font-light text-center px-6 py-2">Role</th>
                                    <th class="font-light text-center px-6 py-2">Created at</th>
                                    <th class="font-light w-36 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($users as $user)
                                    <tr class="{{ $i % 2 == 0 ? 'bg-neutral-100' : '' }}">
                                        <td class="text-center py-2">{{ $i }}</td>
                                        <td class="text-center py-2 flex justify-center">
                                            @if ($user->picture)
                                                <img src="{{ asset('storage/' . $user->picture) }}" alt=""
                                                    width="75" class="rounded-md" />
                                            @endif
                                        </td>
                                        <td class="text-center py-2">{{ $user->name }}</td>
                                        <td class="text-center py-2">{{ $user->email }}</td>
                                        <td class="text-center py-2">
                                            Rp{{ number_format($user->total_purchased, 0, '.', '.') }}</td>
                                        <td id="role-{{ strtolower(str_replace(' ', '-', $user->name)) }}"
                                            class="text-center py-2">{{ $user->role }}</td>
                                        <td class="text-center py-2">{{ $user->created_at }}</td>
                                        <td class="text-center py-2">
                                            <div class="flex justify-center gap-1">
                                                <button
                                                    onclick="handleRolePopup(`{{ $user->picture }}`, `{{ $user->name }}`, `{{ $user->email }}`, `{{ $user->role }}`)"
                                                    class="px-2 py-1 rounded-md bg-yellow-300 hover:opacity-70 flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"
                                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                        <path
                                                            d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                        <path d="M16 5l3 3" />
                                                    </svg>
                                                    Edit
                                                    Role</button>
                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function search_ajax($value) {
            var html = "";
            let routeHandle = `{{ route('user.find', ['keyword' => ':keyword']) }}`.replace(':keyword', $value);

            $.ajax({
                type: 'get',
                url: routeHandle,
                data: {},

                success: function(users) {
                    if (users == 0) {
                        html += `
                            <tr>
                                <td>Data tidak ditemukan</td>
                            </tr>`;
                    } else {
                        var i = 1;
                        let bgcolor, discount_price;
                        users.forEach(function(users) {
                            bgcolor = (i % 2 == 0) ? 'bg-neutral-100' : '';
                            let total_purchased = (users.total_purchased != undefined) ? (users
                                .total_purchased).toFixed(0).replace(
                                /\B(?=(\d{3})+(?!\d))/g, ".") : '0';
                            let bg_html = users.picture != undefined ? `<img src="` +
                                `{{ asset('storage/' . ':picture') }}`.replace(':picture',
                                    users.picture) + `" alt=""
                                                width="75" class="rounded-md" />` : '';
                            html += `
                                    <tr class="` + bgcolor + `">
                                        <td class="text-center py-2">` + i + `</td>
                                        <td class="text-center py-2 flex justify-center">
                                            ` + bg_html + `
                                        </td>
                                        <td class="text-center py-2">` + users.name + `</td>
                                        <td class="text-center py-2">` + users.email + `</td>
                                        <td class="text-center py-2">Rp` + total_purchased + `</td>
                                        <td id="role-` + users.name.toLowerCase().replace(/ /g, '-') +
                                `" class="text-center py-2">` + users.role + `</td>
                                        <td class="text-center py-2">` + users.created_at + `</td>
                                        <td class="text-center py-2">
                                            <div class="flex justify-center gap-1">
                                                <button
                                                    onclick="handleRolePopup('` + users.picture + `', '` + users.name +
                                `', '` + users.email + `', '` + users.role + `')"
                                                    class="px-2 py-1 rounded-md bg-yellow-300 hover:opacity-70 flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"
                                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                        <path
                                                            d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                        <path d="M16 5l3 3" />
                                                    </svg>
                                                    Edit
                                                    Role</button>
                                            </div>
                                        </td>
                                    </tr>`;
                            i++;

                        });
                    }

                    $('#tbody').html(html);
                }
            });
        }
    </script>
@endsection
