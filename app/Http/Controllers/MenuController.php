<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

use function Laravel\Prompts\error;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $menus = Menu::where('visibility', 'public')->get();

        foreach ($menus as $menu) {
            $menu->myfavorite = false;
            if (Auth::check()) {
                $favorite = Favorite::where('menu_id', $menu->id)->where('user_id', Auth::user()->uuid)->first();

                if ($favorite)
                    $menu->myfavorite = true;
            }
        }

        return view('pages/menu', [
            'title' => 'Menu',
            'menus' => $menus
        ]);
    }

    public function detail($id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return error(404);
        }
        if ($menu->visibility == 'private') {
            return error(404);
        }
        $comments = Comment::where('menu_id', $id)
            ->orderByRaw("user_id = '" . Auth::user()->uuid . "' DESC")
            ->orderBy('user_id', 'asc')
            ->get();

        if (count($comments) != 0) {
            foreach ($comments as $comment) {
                $comment->name = User::find($comment->user_id)->name;
            }
        }

        if (!$menu)
            return redirect()->to(route('menu'));

        $favorite = Favorite::where('menu_id', $menu->id)->first();
        $menu->myfavorite = false;

        if ($favorite)
            $menu->myfavorite = true;

        return view('pages/menu-detail', [
            'title' => 'Detail Menu',
            'menu' => $menu,
            'comments' => $comments
        ]);
    }

    public function addMenu()
    {
        return view('pages/staff/add-menu', [
            'title' => 'Tambah Menu Baru'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            'title' => ['required', 'min:3'],
            'description' => ['required'],
            'price' => ['required'],
            'discount' => ['required'],
            'picture' => ['required', 'mimes:jpeg,png'],
            'video' => ['required', 'mimes:mp4'],
        ], [
            'title.required' => 'judul wajib diisi',
            'title.min' => 'judul minimal 3 karakter',
            'description.required' => 'deskripsi wajib diisi',
            'discount.required' => 'diskon wajib diisi',
            'price.required' => 'harga wajib diisi',
            'picture.required' => 'foto wajib diisi',
            'picture.image' => 'foto harus beformat jpeg, png',
            'video.required' => 'harga wajib diisi',
            'video.video' => 'video harus berformat mp4',
        ]);

        $newMenu = new Menu([
            'visibility' => $request->visibility,
            'stock' => $request->stock,
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'price' => $request->price,
            'discount' => $request->discount,
            'picture' => $request->file('picture')->store('menu-pictures'),
            'video' => $request->file('video')->store('menu-videos'),
        ]);
        $newMenu->save();

        return back()->with('success', 'Berhasil menambahkan menu baru');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function data()
    {
        $menus = Menu::all();

        return view('pages/staff/data', [
            'title' => 'Data Menu',
            'menus' => $menus
        ]);
    }

    public function editMenu($id = 0)
    {
        $menu = Menu::find($id);

        if (!$menu)
            return redirect()->to(route('menu-data'));

        return view('pages/staff/edit-menu', [
            'title' => 'Edit Menu',
            'menu' => $menu
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id = 0)
    {
        $request->validate([
            'title' => ['required', 'min:3'],
            'description' => ['required'],
            'discount' => ['required'],
            'price' => ['required'],
            'picture' => ['mimes:jpeg,png'],
            'video' => ['mimes:mp4'],
        ], [
            'title.required' => 'judul wajib diisi',
            'title.min' => 'judul minimal 3 karakter',
            'description.required' => 'deskripsi wajib diisi',
            'discount.required' => 'diskon wajib diisi',
            'price.required' => 'harga wajib diisi',
            'picture.image' => 'foto harus beformat jpeg, png',
            'video.video' => 'video harus berformat mp4',
        ]);

        $menu = Menu::find($id);

        if (!$menu)
            return redirect()->to(route('data'));

        $menu['visibility'] = $request->visibility;
        $menu['stock'] = $request->stock;
        $menu['title'] = $request->title;
        $menu['description'] = $request->description;
        $menu['category'] = $request->category;
        $menu['discount'] = $request->discount;
        $menu['price'] = $request->price;

        if (!is_null($request->picture)) {
            Storage::delete($menu->picture);
            $menu['picture'] = $request->file('picture')->store('menu-pictures');
        }
        if (!is_null($request->video)) {
            Storage::delete($menu->video);
            $menu['video'] = $request->file('video')->store('menu-videos');
        }

        $menu->save();

        return redirect()->to(route('menu-data'))->with('success', 'Berhasil memperbarui menu baru');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id = 0)
    {
        $menu = Menu::find($id);
        if (!$menu)
            return back()->with('error', 'Operasi Gagal!');

        Storage::delete($menu->picture);
        Storage::delete($menu->video);

        $menu->forceDelete();

        return back()->with('success', 'Berhasil menghapus menu!');
    }

    public function search(Request $request)
    {
        $keyword = $request->query('keyword');
        $menus = Menu::when($keyword, function ($query, $keyword) {
            return $query->where(function ($query) use ($keyword) {
                $query->orWhere('title', 'like', '%' . $keyword . '%')
                    ->orWhere('stock', 'like', '%' . $keyword . '%')
                    ->orWhere('category', 'like', '%' . $keyword . '%')
                    ->where('visibility', 'public');
            });
        })->get();

        foreach ($menus as $menu) {
            $menu->myfavorite = false;
            if (Auth::check()) {
                $favorite = Favorite::where('menu_id', $menu->id)->where('user_id', Auth::user()->uuid)->first();

                if ($favorite)
                    $menu->myfavorite = true;
            }
        }

        return view('partials.pagination_menu', compact(['menus']));
    }

    public function get($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json(['status' => 'failed']);
        }

        return response()->json(['status' => 'success', 'menu' => $menu]);
    }
}
