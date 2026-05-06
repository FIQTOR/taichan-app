<ul class="list grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 py-4 gap-2 relative">
  @foreach ($menus as $menu)
      <li class="w-full border rounded-md flex flex-col overflow-hidden relative">
          @if ($menu->stock == 'habis')
              <span
                  class="absolute w-full h-full rounded-md bg-white bg-opacity-90 
              flex justify-center items-center text-xl font-bold text-red-500 z-10">
                  Tidak tersedia
              </span>
          @endif
          @if ($menu->discount != 0)
              <span
                  class="absolute top-0 right-0 bg-red-400 px-2 rounded-tr-md rounded-bl-md
                  text-white">
                  {{ $menu->discount }}%
              </span>
          @endif
          <div class="h-full flex flex-col justify-between">
              <div>
                  <div class="w-full h-28 md:h-40 overflow-hidden relative rounded-md">
                      <img src="{{ asset('storage/' . $menu->picture) }}" alt="picture"
                          class="absolute w-full">
                  </div>
                  <div class="text-sm px-2 md:px-4 py-1 md:py-4">
                      <div class="flex justify-between">
                          <h6 class="font-bold text-base">{{ $menu->title }}</h6>
                          <span class="flex gap-1 items-center text-neutral-400">
                              <div class="flex items-center">
                                  <button class="hover:opacity-70 hover:text-red-300"
                                      onclick="handleFavoriteAjax('{{ $menu->id }}')">
                                      <svg id="love-{{ $menu->id }}" xmlns="http://www.w3.org/2000/svg"
                                          width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                          stroke="currentColor" fill="none" stroke-linecap="round"
                                          stroke-linejoin="round"
                                          class="@if ($menu->myfavorite) fill-red-300 text-red-300 @endif">
                                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                          <path
                                              d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572">
                                          </path>
                                      </svg>
                                  </button>
                              </div>
                              <span id="count-{{ $menu->id }}">{{ $menu->favorite }}</span>
                          </span>
                      </div>
                      <p class="text-neutral-700">{{ $menu->description }}</p>
                  </div>
              </div>
              <div class="text-sm px-2 md:px-4 py-1 md:py-4">
                  <div class="flex flex-col md:flex-row justify-between text-base">
                      @php
                          $discount_price = $menu->price - $menu->price * ($menu->discount / 100);
                      @endphp
                      <span>
                          Rp{{ number_format($discount_price, 0, '.', '.') }}
                      </span>
                      @if ($menu->discount != 0)
                          <span class="line-through text-red-300">
                              Rp{{ number_format($menu->price, 0, '.', '.') }}
                          </span>
                      @endif
                  </div>
                  <div class="flex flex-col md:flex-row justify-between text-base">
                      <span>Terjual</span>
                      <span class="text-neutral-400">{{ $menu->sold }}</span>
                  </div>
                  <div class="flex flex-col md:flex-row justify-between text-base">
                      <span class="flex gap-1">
                          <?php
                          $fillstar = floor($menu->rating);
                          $star = 5 - $fillstar;
                          ?>
                          @for ($a = 0; $a < $fillstar; $a++)
                              <svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-300" width="24"
                                  height="24" viewBox="0 0 24 24" stroke-width="2"
                                  stroke="currentColor" fill="none" stroke-linecap="round"
                                  stroke-linejoin="round">
                                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                  <path
                                      d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z"
                                      stroke-width="0" fill="currentColor"></path>
                              </svg>
                          @endfor
                          @for ($a = 0; $a < $star; $a++)
                              <svg xmlns="http://www.w3.org/2000/svg" class="text-neutral-200"
                                  width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                  stroke="currentColor" fill="none" stroke-linecap="round"
                                  stroke-linejoin="round">
                                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                  <path
                                      d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z"
                                      stroke-width="0" fill="currentColor"></path>
                              </svg>
                          @endfor
                      </span>
                      <span class="text-neutral-400">{{ number_format($menu->rating, 1, '.', ',') }}</span>
                  </div>
                  @if ($menu->stock == 'tersedia')
                      <div class="flex justify-between py-2">
                          <a href="{{ route('menu.detail', $menu->id) }}"
                              class="self-end bg-neutral-200 px-4 py-1 rounded-md
                                      hover:opacity-70">
                              Detail
                          </a>
                          <button onclick="handleCart({{ $menu->id }})"
                              class="self-end bg-yellow-300 px-4 py-1 rounded-md
                                  hover:opacity-70">
                              Pesan
                          </button>
                      </div>
                  @endif
              </div>
          </div>
      </li>
  @endforeach