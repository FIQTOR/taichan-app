<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/home', function () {
    return redirect()->to(route('menu'));
});

Route::get('/', function () {
    return redirect()->to(route('menu'));
})->name('home');

Route::get('/favorite', function () {
    return view('pages/favorite', ['title' => 'Favorit']);
})->middleware('auth')->name('favorite');

Route::get('/dashboard', function () {
    return view('pages/dashboard', [
        'title' => 'Dashboard'
    ]);
})->middleware('auth', 'isstaff')->name('dashboard');

Route::get('/history', function () {
    return view('pages/history', ['title' => 'Histori']);
})->middleware('auth')->name('history');

// Auth
Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.action');

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'register'])->middleware('guest')->name('register.action');

//  Auth - Reset Password
Route::get('/forgot-password', function () {
    return view('pages/auth/password/forgot-password', ['title' => 'Lupakan Sandi']);
})->name('forgot.password');
Route::post('/forgot-password', [AuthController::class, 'forgotpassword'])->name('forgot.password.action');

Route::get('/reset-password/{token}', [AuthController::class, 'resetpassword'])->name('reset.password');
Route::post('/reset-password', [AuthController::class, 'resetpasswordaction'])->name('reset.password.action');

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::controller(UserController::class)->group(function () {
    Route::get('/profile', 'profile')->middleware('auth')->name('user.profile');
    Route::put('/profile/update', 'update')->middleware('auth')->name('user.update');
    Route::post('/profile/check-picture', 'checkPicture')->middleware('auth')->name('user.picture.check');
    Route::post('/profile/update-picture', 'updatePicture')->middleware('auth')->name('user.picture.update');
    Route::post('/profile/remove-picture', 'removePicture')->middleware('auth')->name('user.picture.remove');
    Route::get('/profile/name-finder/{name}', 'nameFinder')->name('user.namefinder');
    Route::get('/admin/profile/data', 'show')->middleware('auth', 'isadmin')->name('user.data');
    Route::get('/admin/profile/data/find/{keyword}', 'find')->middleware('auth', 'isadmin')->name('user.find');
    Route::put('/admin/profile/data/role/update', 'roleUpdate')->middleware('auth', 'isadmin')->name('user.role.update');
});

// Feedback group
Route::controller(FeedbackController::class)->group(function () {
    Route::get('/feedback', 'index')->middleware('auth')->name('feedback');
    Route::post('/feedback', 'create')->middleware('auth')->name('action.create.feedback');
    Route::get('/feedback/data', 'dataFeedback')->middleware('auth', 'isstaff')->name('feedback-data');
    Route::post('/feedback/data/delete', 'destroy')->middleware('auth', 'isstaff')->name('action.delete.feedback-data');
    Route::get('/feedback/data/search', 'search')->name('action.search.feedback');
});

// Favorite group
Route::controller(FavoriteController::class)->group(function () {
    Route::get('/favorite', 'index')->middleware('auth')->name('favorite');
    Route::post('/favorite/handle/{id}', 'toggle')->name('action.toggle.favorite');
    // Route::get('/feedback/data/search', 'search')->name('action.search.feedback');
});

// Menu group
Route::controller(MenuController::class)->group(function () {
    Route::get('/menu', 'index')->name('menu');
    Route::get('/menu/detail/{id}', 'detail')->name('menu.detail');
    Route::get('/menu/search', 'search')->name('menu.search');
    Route::get('/menu/data', 'data')->middleware('auth', 'isstaff')->name('menu-data');
    Route::get('/menu/add', 'addMenu')->middleware('auth', 'isstaff')->name('add-menu');
    Route::post('/menu/add', 'create')->middleware('auth', 'isstaff')->name('action.create.menu');
    Route::get('/menu/edit/{id}', 'editMenu')->middleware('auth', 'isstaff')->name('edit-menu');
    Route::post('/menu/edit/{id}', 'edit')->middleware('auth', 'isstaff')->name('action.edit.menu');
    Route::post('/menu/data/delete/{id}', 'destroy')->middleware('auth', 'isstaff')->name('action.delete.menu');
    Route::get('/menu/get/{id}', 'get')->name('menu.get');
});

// Cart group
Route::controller(CartController::class)->group(function () {
    Route::get('/cart', 'index')->middleware('auth')->name('cart');
    Route::get('/cart/{id}', 'index')->middleware('auth')->name('cart.table');
    Route::post('/cart/set', 'set')->middleware('auth')->name('cart.set');
    Route::post('/cart/edit', 'edit')->middleware('auth')->name('cart.edit');
    Route::post('/cart/get/{id}', 'get')->middleware('auth')->name('cart.get');
});

// Invoice group
Route::controller(InvoiceController::class)->group(function () {
    Route::get('/invoice/{token}', 'index')->middleware('auth')->name('invoice');
    Route::get('/myinvoice', 'show')->middleware('auth')->name('invoice.show');
    Route::post('/invoice/create', 'store')->middleware('auth')->name('invoice.create');
    Route::delete('/invoice/{token}', 'destroy')->middleware('auth')->name('invoice.destroy');
    Route::get('/staff/invoice/cash-confirmation-finder', 'searchCashConfirmation')->middleware('auth', 'isstaff')->name('invoice.cash.search');
    Route::post('/staff/invoice/cash-confirmation-finder', 'searchCashConfirmationPost')->middleware('auth', 'isstaff')->name('invoice.cash.search.post');
    Route::get('/staff/invoice/cash-confirmation/{token}', 'cashConfirmation')->middleware('auth', 'isstaff')->name('invoice.cash.confirm');
    Route::post('/staff/invoice/cash-confirmation/{token}', 'cashConfirmationPost')->middleware('auth', 'isstaff')->name('invoice.cash.confirm.post');
    Route::get('/staff/customer-order', 'showCustomerOrder')->middleware('auth', 'isstaff')->name('invoice.customer.order');
    Route::get('/staff/customer-order/complete/{token}', 'completeCustomerOrder')->middleware('auth', 'isstaff')->name('invoice.customer.order.complete');
});

// Table group
Route::controller(TableController::class)->group(function () {
    Route::get('/admin/table-data', 'index')->middleware('auth', 'isstaff')->name('table.data');
    Route::get('/admin/table-data/create', 'create')->middleware('auth', 'isstaff')->name('table.create');
    Route::post('/admin/table-data/create', 'store')->middleware('auth', 'isstaff')->name('table.store');
    Route::get('/admin/table-data/edit/{id}', 'edit')->middleware('auth', 'isstaff')->name('table.edit');
    Route::post('/admin/table-data/edit/{id}', 'update')->middleware('auth', 'isstaff')->name('table.update');
    Route::delete('/admin/table-data/delete/{id}', 'destroy')->middleware('auth', 'isstaff')->name('table.destroy');
});

// Comment group
Route::controller(CommentController::class)->group(function () {
    Route::post('/comment/create', 'store')->middleware('auth')->name('comment.store');
    Route::get('/comment/get/{id}', 'get')->middleware('auth')->name('comment.get');
    Route::put('/comment/update/{id}', 'edit')->middleware('auth')->name('comment.edit');
    Route::delete('/comment/delete/{id}', 'destroy')->middleware('auth')->name('comment.destroy');
});


// try {
//     $menu;
// } catch (\Exception $e) {
//     return response()->json(['status' => 'failed', 'log' => $e->getMessage()]);
// }