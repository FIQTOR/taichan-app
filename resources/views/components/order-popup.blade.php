<div id="order-popup" class="hidden fixed w-full h-screen left-0 top-0 bg-black bg-opacity-50 z-50 items-center">
    <div class="relative mx-auto w-full max-w-sm bg-white h-fit rounded-xl shadow-xl">
        <button onclick="
      $('#order-popup').addClass('hidden');
      $('#order-popup').removeClass('flex');"
            class="absolute right-0 bg-red-500 rounded-bl-lg rounded-tr-lg p-1 hover:bg-red-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M18 6l-12 12" />
                <path d="M6 6l12 12" />
            </svg>
        </button>
        <form id="order-popup-form" action="#" class="h-full flex flex-col justify-between">
            @csrf
            <input id="id" type="number" name="id" hidden readonly value="0">
            <div class="p-1">
                <img id="order-img" src="" alt="Menu Picture" class="rounded-t-lg">
                <div class="p-4">
                    <p id="order-popup-title" class="font-bold text-lg">Title</p>
                    <p id="order-popup-description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nihil,
                        cumque.</p>
                    <div id="order-popup-price" class="flex flex-col md:flex-row justify-between py-2">
                        <span>
                            Rp50.000
                        </span>
                        <span class="line-through text-red-300">
                            Rp100.000
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span>Harga</span>
                        <span id="order-popup-totalprice" class="text-lg font-bold">Rp100.000</span>
                    </div>
                </div>
            </div>
            <div class="w-full px-14 my-4 p-4">
                <div class="flex justify-between bg-yellow-400 rounded-full shadow-md mb-4">
                    <button class="px-4 text-white" onclick="decrementCart(event)">-</button>
                    <input name="count" id="count" type="number" value="0" step="1"
                        class="w-10 text-center ml-4 bg-yellow-400" max="20" min="0">
                    <button class="bg-yellow-400 h-full p-1 rounded-r-full px-4 text-white"
                        onclick="incrementCart(event)">+</button>
                </div>
                <button onclick="setCartAjax(event)"
                    class="w-full bg-yellow-400 rounded-full py-1 hover:opacity-70">Simpan</button>
            </div>
        </form>
    </div>
</div>

@if (Auth::check())
    <script>
        let menuPrice = 0;

        function handleCart(id) {
            let routeHandle = `{{ route('cart.get', ['id' => ':menuId']) }}`.replace(':menuId', id);

            $.ajax({
                type: 'post',
                url: routeHandle,
                data: {
                    '_token': '{{ csrf_token() }}'
                },

                success: function(res) {

                    $('#id').val(id);

                    $('#order-img').attr('src', `{{ asset('storage') }}/` + res.cart.picture);

                    if (res.cart != null) {
                        $('#count').val(res.cart.count);
                        let discount_price = res.cart.price - res.cart.price * (res.cart.discount / 100);
                        $('#order-popup-title').html(res.cart.title);
                        $('#order-popup-description').html(res.cart.description);

                        let dprice = (discount_price).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        let price = (res.cart.price).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        menuPrice = discount_price;

                        let html = `<span>
                                Rp` + dprice + `
                            </span>`;
                        if (res.cart.discount != 0) {
                            html += `<span class="line-through text-red-300">
                                    Rp` + price + `
                                </span>`;
                        }

                        $('#order-popup-price').html(html);
                        handlePriceCountPopup();
                    } else {
                        $('#count').val(0);
                    }
                    $('#order-popup').addClass('flex');
                    $('#order-popup').removeClass('hidden');

                }
            });
        }

        function handlePriceCountPopup() {
            let total_price_menu = menuPrice * $('#count').val();
            $('#order-popup-totalprice').html('Rp' + (total_price_menu).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
        }
    </script>
@else
    <script>
        function handleCart(id, src) {
            window.location.href = `{{ route('login') }}`;
        }
    </script>
@endif
@php
    $table_number_condition = false;
    if (isset($table_number) || url()->current() == route('cart')) {
        $table_number_condition = true;
    }
@endphp
<script>
    function incrementCart(e) {
        e.preventDefault();
        document.getElementById('count').stepUp();
        handlePriceCountPopup();
    }

    function decrementCart(e) {
        e.preventDefault();
        document.getElementById('count').stepDown();
        handlePriceCountPopup();
    }

    // function handlePrice (price) {
    //     $
    // }

    $('#count').on('input', function() {
        if (this.value < 0)
            this.value = 0;
        else if (this.value > 20)
            this.value = 20
    });

    function setCartAjax(e) {
        e.preventDefault();
        if (`{{ $table_number_condition }}`) {
            $('#subtotal').remove();
        }
        var formData = new FormData(document.getElementById('order-popup-form'));

        $.ajax({
            type: 'post',
            url: `{{ route('cart.set') }}`,
            data: formData,
            contentType: false, // To send as FormData
            processData: false, // To prevent jQuery from processing the data

            success: function(res) {
                $('#order-popup').addClass('hidden');
                $('#order-popup').removeClass('flex');

                if (`{{ $table_number_condition }}`) {
                    location.reload();
                }
            }
        });
    }
</script>
