<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Master_WebController;
use App\Http\Controllers\Api\Order_ApiController;
use App\Http\Controllers\Api\Address_ApiController;
use App\Http\Controllers\Web\Auth_WebController;
use App\Http\Controllers\Web\Test\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Web 

Route::prefix('/')->controller(Master_WebController::class)->group(function () {

    Route::get('/', 'homePage')->name('home.page');
    Route::get('/contact', 'contactPage')->name('contact.page');
    Route::get('/about-us', 'aboutPage')->name('about.page');
    Route::get('/blog', 'blogPage')->name('blog.page');
    Route::get('/shop', 'shopPage')->name('shop.page');
    Route::get('/cart', 'cartPage')->name('cart.page');
});


//================== [Use Only For AJAX] =================
Route::middleware('auth')->prefix('ajax')->group(function () {

    // Order
    Route::prefix('/order')->controller(Order_ApiController::class)->group(function () {
        Route::post('/get', 'index')->name('order.get');
        Route::post('/post', 'store')->name('order.post');
    });

    // Address List
    Route::prefix('/address')->controller(Address_ApiController::class)->group(function () {
        Route::post('/get', 'index')->name('address.get');
        Route::post('/post', 'store')->name('address.post');
    });
});


// ========== Authentication Routes ============
Route::get('/register', function () {
    return view('web.register');
})->name('register.page');
Route::get('/login', function () {
    return view('web.login');
})->name('login.page');


// User Register & Login routes
Route::controller(Auth_WebController::class)->group(function () {
    Route::post('/register', 'register')->name('user.register');
    Route::post('/login', 'login')->name('user.login');
    Route::post('/logout', 'logout')->name('user.logout');
});

Route::controller(TestController::class)->group(function () {
    Route::get('/test', 'index');
});


require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
