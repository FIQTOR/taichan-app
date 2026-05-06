<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Menu;
use App\Models\Table;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index($id = 0)
    {
        $table = Table::where('token', $id)->first();
        $table_number = null;
        if (!$table) {
            $table_number = null;
        } else {
            $table_number = $table->table_number;
        }
        $carts = session()->get('carts');
        $menus = [];

        if ($carts && is_array($carts)) {
            foreach ($carts as $cart) {
                if (isset($cart['id'])) {
                    $menu = Menu::find($cart['id']);

                    if (!$menu) {
                        $carts = collect($carts)->reject(function ($item) use ($cart) {
                            return $item['id'] == $cart['id'];
                        })->toArray();
                        session()->put('carts', $carts);
                    } else {
                        $menu->count = $cart['count'];
                        $favorite = Favorite::where('menu_id', $menu->id)->first();
                        $menu->myfavorite = false;

                        if ($favorite)
                            $menu->myfavorite = true;

                        if ($menu->stock == 'habis') {
                            $carts = collect($carts)->reject(function ($item) use ($menu) {
                                return $item['id'] == $menu['id'];
                            })->toArray();
                            session()->put('carts', $carts);
                        } else {
                            $menus[] = $menu;
                        }
                    }
                }
            }
        }

        return view('pages/cart', [
            'title' => 'Keranjang',
            'menus' => $menus,
            'table_number' => $table_number
        ]);
    }

    public function set(Request $request)
    {
        $carts = session()->get('carts');
        $menus = collect($carts)->where('id', $request->id)->first();
        if (!is_null($menus) && collect($menus)->isNotEmpty()) {
            if ($request->count != 0) {
                $carts = collect($carts)->reject(function ($item) use ($menus) {
                    return $item['id'] == $menus['id'];
                })->toArray();
                session()->put('carts', $carts);

                session()->push('carts', [
                    'id' => $request->id,
                    'count' => $request->count,
                ]);
            } else {
                $carts = collect($carts)->reject(function ($item) use ($menus) {
                    return $item['id'] == $menus['id'];
                })->toArray();
                session()->put('carts', $carts);
            }
        } else {
            session()->push('carts', [
                'id' => $request->id,
                'count' => $request->count,
            ]);
        }
        session()->save();

        return response()->json(['status' => 'Cart added succesfully']);
    }

    public function edit(Request $request)
    {
        $carts = session()->get('carts');

        foreach ($carts as $cart) {
            if ($cart['id'] == $request->id) {
                $cart['count'] = $request->count;
            }
        }

        session()->put('carts', $carts);

        return redirect()->route('cart');
    }

    public function get($id)
    {
        $menu = Menu::find($id);
        $carts = session()->get('carts');
        $cart = collect($carts)->where('id', $id)->first();
        $menu->count = 0;
        if ($cart) {
            $menu->count = $cart['count'];
        }
        return response()->json([
            'cart' => $menu
        ]);
    }
}
