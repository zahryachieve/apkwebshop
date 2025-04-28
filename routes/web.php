<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'login']);
Route::post('/postlogin', [AuthController::class, 'postlogin']);


Route::get('/register', function () {
    return view('register');
})->name('register');
Route::get('/get-cart', [CartController::class, 'getCart'])->middleware('auth');


Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/add-to-cart', [CartController::class, 'add'])->middleware('auth');

    Route::post('/add-to-cart', [CartController::class, 'store'])->middleware('auth');
Route::group(['middleware' => ['auth', 'checkRole:admin,user']], function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); // Tidak perlu '/' di depan 'dashboard'
    });
    Route::get('/datapesanan/index', [CartController::class, 'index']);
    Route::put('/cart/update/{id}', [CartController::class, 'update']);

    Route::get('/checkout', [CartController::class, 'checkout'])->middleware('auth');

        // Menampilkan halaman checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

    // Proses checkout
    Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');

    // Halaman sukses setelah checkout
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
});

Route::group(['middleware' => ['auth', 'checkRole:admin']], function () {
    // untuk halaman admin ajah disini
    Route::get('/datapesanan/admin', [CartController::class, 'indexadmin']);
    Route::delete('/cart/delete/{id}', [CartController::class, 'destroy']);

});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('/logout', [AuthController::class, 'logout']);

require __DIR__.'/auth.php';
