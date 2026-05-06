@extends('layouts/base')

@section('content')
    <main class="py-24 min-h-screen">
        <div class="sm:px-6 lg:px-8 flex justify-between flex-col md:flex-row gap-4 mx-4">
            <div class="flex flex-wrap gap-2 items-center w-fit">
                <h1 class="text-4xl font-bold">Data Meja</h1>
                <a href="{{ route('table.create') }}"
                    class="px-7 py-1 bg-neutral-100 rounded-md
                shadow-md hover:opacity-70 h-fit">
                    Tambah Meja Baru
                </a>
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
                                    <th class="font-light text-center px-4 py-2">Visibilitas</th>
                                    <th class="font-light text-center px-4 py-2">Nomor Meja</th>
                                    <th class="font-light text-center px-4 py-2">Token</th>
                                    <th class="font-light w-36 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <?php $i = 1; ?>
                                @foreach ($tables as $table)
                                    <tr class="{{ $i % 2 == 0 ? 'bg-neutral-100' : '' }}">
                                        <td class="text-center py-2">{{ $i }}</td>
                                        <td class="text-center py-2 capitalize">{{ $table->visibility }}</td>
                                        <td class="text-center py-2">{{ $table->table_number }}</td>
                                        <td class="text-center py-2">{{ $table->token }}</td>
                                        <td>
                                            <div class="py-2 flex items-center justify-center gap-4">
                                                <a href="{{ route('table.edit', $table->id) }}"
                                                    class="bg-neutral-200 rounded-full w-fit
                                                py-1 px-4 hover:opacity-70 flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"
                                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path
                                                            d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1">
                                                        </path>
                                                        <path
                                                            d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                                                        </path>
                                                        <path d="M16 5l3 3"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('table.destroy', $table->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        class="bg-red-400 rounded-full w-fit
                                                    py-1 px-4 hover:opacity-70 flex items-center gap-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 24 24" stroke-width="1"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
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
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        $('#search').on('keyup', function() {
            $value = $(this).val();
            if ($value != '')
                search_ajax($value);
        });

        function search_ajax($value) {
            var html = "";

            $.ajax({
                type: 'get',
                url: '/menu/data/search',
                data: {
                    'keyword': $value,
                },

                success: function(menus) {
                    console.log(menus);
                    if (menus == 0) {
                        html += `
                            <tr>
                                <td>Data tidak ditemukan</td>
                            </tr>`;
                    } else {
                        var i = 1;
                        let bgcolor, discount_price;
                        menus.forEach(function(menus) {
                            bgcolor = (i % 2 == 0) ? 'bg-neutral-100' : '';
                            discount_price = menus.price - (menus.price * (menus.discount / 100));
                            let discountpricehtml = '';

                            if (menus.discount != 0) {
                                discountpricehtml = `<span class="line-through text-red-300">
                                Rp` + (menus.price).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".") + `
                            </span>`
                            }

                            let imageUrl = `{{ asset('storage/' . ':picture') }}`.replace(
                                ':picture', menus.picture);
                            let editUrl = `{{ route('edit-menu', ['id' => ':menuId']) }}`.replace(
                                ':menuId', menus.id);
                            let deleteUrl = `{{ route('action.delete.menu', ['id' => ':menuId']) }}`
                                .replace(
                                    ':menuId', menus.id);

                            html += `
                            <tr class="` + bgcolor + `">
                                <td class="text-center py-2">` + i + `</td>
                                <td class="text-center py-2">
                                    <img src="` + imageUrl + `" alt="picture not found"
                                        width="75" class="rounded-md" />
                                </td>
                                <td class="text-center py-2 capitalize">` + menus.visibility + `</td>
                                <td class="text-center py-2">` + menus.title + `</td>
                                <td class="text-center py-2">` + (menus.description).slice(0, 25) + `</td>
                                <td class="text-center py-2 capitalize">` + menus.category + `</td>
                                <td class="text-center py-2 capitalize">` + menus.stock + `</td>
                                <td class="text-center py-2">
                                    <div class="flex flex-col items-center">
                                        <span>Rp` + discount_price.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".") + `</span>
                                        ` + discountpricehtml + `
                                    </div>
                                </td>
                                <td class="text-center py-2">` + menus.discount + `%</td>
                                <td class="text-center py-2">` + menus.sold + `</td>
                                <td class="text-center py-2">` + (menus.rating).toFixed(1).replace(
                                /\B(?=(\d{3})+(?!\d))/g, ".") + `</td>
                                <td class="text-center py-2">` + menus.favorite + `</td>
                                <td>
                                    <div class="py-2 flex items-center justify-center gap-4">
                                        <a href="` + editUrl + `"
                                            class="bg-neutral-200 rounded-full w-fit
                                                        py-1 px-4 hover:opacity-70 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                                stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1">
                                                </path>
                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                                                </path>
                                                <path d="M16 5l3 3"></path>
                                            </svg>
                                        </a>
                                        <form action="` + deleteUrl + `" method="post">
                                            @csrf
                                            <button
                                                class="bg-red-400 rounded-full w-fit
                                                            py-1 px-4 hover:opacity-70 flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                                    stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round"
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
