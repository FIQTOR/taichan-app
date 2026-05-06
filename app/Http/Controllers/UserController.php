<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isNull;
use function PHPUnit\Framework\returnSelf;

class UserController extends Controller
{
  public function profile()
  {
    $user = User::find(Auth::user()->uuid);
    return view('pages/profile', [
      'title' => 'Profil Saya',
      'user' => $user
    ]);
  }
  public function update(Request $request)
  {
    $user = User::find(Auth::user()->uuid);
    $user['name'] = $request->name;

    $user->save();

    return response()->json(['status' => 'success']);
  }

  public function updatePicture(Request $request)
  {
    $user = User::find(Auth::user()->uuid);

    if (isset($user->picture) || !is_null($user->picture)) {
      Storage::delete($user->picture);
    }
    $user->picture = $request->file('picture')->store('user-picture');
    $user->save();

    return response()->json(['status' => 'success']);
  }

  public function checkPicture(Request $request)
  {
    if (!$request->picture) {
      return response()->json(['status' => 'empty']);
    }
    // Ambil dimensi gambar yang diunggah
    $imageDimensions = getimagesize($request->file('picture'));

    // Cek apakah panjang dan lebar gambar sama (1:1)
    if ($imageDimensions[0] !== $imageDimensions[1]) {
      return response()->json(['status' => 'failed', 'message' => 'Image resolution 1:1']);
    }

    return response()->json(['status' => 'success']);
  }

  public function removePicture(Request $request)
  {
    $user = User::find(Auth::user()->uuid);
    if (isset($user->picture)) {
      Storage::delete($user->picture);
      $user->picture = NULL;
    } else {
      return response()->json(['status' => 'failed']);
    }
    $user->save();

    return response()->json(['status' => 'success']);
  }

  public function nameFinder($name)
  {
    if (strlen($name) <= 3) {
      return response()->json(['status' => 'failed']);
    }

    $user = User::where('name', $name)->first();

    if ($user && $user->name != Auth::user()->name) {
      return response()->json(['status' => 'found']);
    } else {
      return response()->json(['status' => 'not found']);
    }
  }

  public function show()
  {
    $users = User::all();

    return view('pages/admin/user-data', [
      'title' => 'Data User',
      'users' => $users
    ]);
  }

  public function find($keyword)
  {
    $users = User::where('name', 'like', '%' . $keyword . '%')
      ->orWhere('email', 'like', '%' . $keyword . '%')
      ->orWhere('role', 'like', '%' . $keyword . '%')->get();

    return response()->json($users);
  }

  public function roleUpdate(Request $request)
  {
    $user = User::where('name', $request->name)->first();
    if ($user->uuid != Auth::user()->uuid) {
      $user->role = $request->role;
      $user->save();
    }

    return response()->json(['status' => 'success', 'role' => $user->role, 'name' => $user->name]);
  }
}
