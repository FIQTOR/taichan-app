<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Http\Requests\StoreFavoriteRequest;
use App\Http\Requests\UpdateFavoriteRequest;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $favorites = Favorite::where('user_id', Auth::user()->uuid)->get();

        $menus = $favorites->pluck('menu')->where('visibility', 'public');

        return view('pages/favorite', [
            'title' => 'Favorit',
            'menus' => $menus
        ]);
    }

    public function toggle($id = 0)
    {
        if (!Auth::check())
            return response()->json(['status' => 'failed auth!']);

        $favorite = Favorite::where('menu_id', $id)->where('user_id', Auth::user()->uuid)->first();

        if ($favorite) {
            return $this->remove($favorite);
        } else {
            return $this->add($id);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function add($id = 0)
    {
        $menu = Menu::find($id);

        if (!$menu)
            return response()->json(['status' => 'failed added!']);

        $newFavorite = new Favorite([
            'user_id' => Auth::user()->uuid,
            'menu_id' => $id
        ]);
        $newFavorite->save();

        $menu['favorite'] += 1;
        $menu->save();

        return response()->json(['status' => 'added', 'favoritecount' => $menu->favorite]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function remove(Favorite $favorite)
    {
        $menu = Menu::find($favorite['menu_id']);

        $favorite->forceDelete();

        if ($menu) {
            $menu['favorite'] -= 1;
            $menu->save();
        }

        return response()->json([
            'status' => 'deleted',
            'favoritecount' => $menu->favorite
        ]);
    }
}
