<div id="comment-popup" class="hidden fixed w-full h-screen left-0 top-0 bg-black bg-opacity-50 z-50 items-center">
    <div class="relative mx-auto w-full max-w-sm bg-white h-fit rounded-xl shadow-xl">
        <button
            onclick="
          $('#comment-popup').addClass('hidden');
          $('#comment-popup').removeClass('flex');"
            class="absolute right-0 bg-red-500 rounded-bl-lg rounded-tr-lg p-1 hover:bg-red-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M18 6l-12 12" />
                <path d="M6 6l12 12" />
            </svg>
        </button>
        <form id="comment-popup-form" action="#" class="h-full flex flex-col justify-between">
            @csrf
            <input id="cid" type="number" name="id" hidden readonly value="0">
            <div class="p-1">
                <img id="comment-img" src="" alt="Menu Picture" class="rounded-t-lg">
                <div class="p-4">
                    <p id="comment-popup-title" class="font-bold text-lg">Title</p>
                    <p id="comment-popup-description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nihil,
                        cumque.</p>
                    <div id="comment-popup-price" class="flex flex-col md:flex-row justify-between py-2">
                        <span>
                            Rp50.000
                        </span>
                        <span class="line-through text-red-300">
                            Rp100.000
                        </span>
                    </div>
                </div>
            </div>
            <div class="px-4">
                <label for="rating">Rate</label>
                <input name="rating" type="number" min="1" max="5" id="rating" hidden readonly>
                <div class="flex gap-2">
                    @for ($z = 0; $z < 5; $z++)
                        <button onclick="handleRate({{ $z + 1 }}, event)">
                            <svg xmlns="http://www.w3.org/2000/svg" id="star{{ $z + 1 }}"
                                class="text-neutral-200" width="24" height="24" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z"
                                    stroke-width="0" fill="currentColor"></path>
                            </svg>
                        </button>
                    @endfor
                </div>
            </div>
            <div class="flex flex-col px-4">
                <label for="message">Message</label>
                <textarea name="message" id="message" cols="30" rows="3"
                    class="px-2 py-1 rounded-md outline outline-1 outline-neutral-500
        focus:outline-yellow-300 focus:outline-2"></textarea>
            </div>
            <div class="w-full px-14 p-4">
                <button onclick="setCommentAjax(event)"
                    class="w-full bg-yellow-400 rounded-full py-1 hover:opacity-70">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function handleCommentPopup(id) {
        let routeHandle = `{{ route('menu.get', ['id' => ':menuId']) }}`.replace(':menuId', id);

        $.ajax({
            type: 'get',
            url: routeHandle,
            data: {},

            success: function(res) {
                $('#cid').val(id);

                $('#comment-img').attr('src', `{{ asset('storage') }}/` + res.menu.picture);

                let discount_price = res.menu.price - res.menu.price * (res.menu.discount / 100);
                $('#comment-popup-title').html(res.menu.title);
                $('#comment-popup-description').html(res.menu.description);

                let dprice = (discount_price).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                let price = (res.menu.price).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                menuPrice = discount_price;

                let html = `<span>
                      Rp` + dprice + `
                  </span>`;
                if (res.menu.discount != 0) {
                    html += `<span class="line-through text-red-300">
                          Rp` + price + `
                      </span>`;
                }

                $('#comment-popup-price').html(html);

                $('#comment-popup').addClass('flex');
                $('#comment-popup').removeClass('hidden');

            }
        });
    }

    function handleRate(value, event) {
        event.preventDefault();
        $('#rating').val(value);

        for (let i = 0; i < 5; i++) {
            $('#star' + (i + 1)).removeClass('text-neutral-200');
            $('#star' + (i + 1)).removeClass('text-yellow-300');
            if (i < value) {
                $('#star' + (i + 1)).addClass('text-yellow-300');
            } else {
                $('#star' + (i + 1)).addClass('text-neutral-200');
            }
        }
    }

    function setCommentAjax(e) {
        e.preventDefault();

        var formData = new FormData(document.getElementById('comment-popup-form'));

        $.ajax({
            type: 'post',
            url: `{{ route('comment.store') }}`,
            data: formData,
            contentType: false, // To send as FormData
            processData: false, // To prevent jQuery from processing the data

            success: function(res) {
                $('#comment-popup').addClass('hidden');
                $('#comment-popup').removeClass('flex');

                window.location.href = `{{ route('menu.detail', ['id' => ':id']) }}`.replace(':id', res
                    .menu_id);
            }
        });
    }
</script>
