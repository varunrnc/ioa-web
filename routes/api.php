<?php

use App\Http\Controllers\Api\Address\ApiAddressController;
use App\Http\Controllers\Api\Address_ApiController;
use App\Http\Controllers\Api\Auth_ApiController;
use App\Http\Controllers\Api\Cart\ApiCartController;
use App\Http\Controllers\Api\Category_ApiController;
use App\Http\Controllers\Api\Mix_ApiController;
use App\Http\Controllers\Api\Order\ApiOrderController;
use App\Http\Controllers\Api\Order_ApiController;
use App\Http\Controllers\Api\Plant\ApiPlantController;
use App\Http\Controllers\Api\Product_ApiController;
use App\Http\Controllers\Api\Razorpay\ApiRazorpayController;
use App\Http\Controllers\Api\SubCategory\ApiSubCategoryController;
use App\Http\Controllers\Api\User_ApiController;
use App\Http\Controllers\Api\Video_ApiController;
use App\Http\Controllers\Api\Webinar_ApiController;
use App\Http\Controllers\Api\Wishlist\ApiWishlistController;
use Illuminate\Support\Facades\Route;

// Authenticated Routes
Route::middleware('auth:sanctum')->group(function () {

    // User details
    Route::apiResource('userdetails', User_ApiController::class);

    // Products
    Route::apiResource('product', Product_ApiController::class);

    // Orders
    Route::apiResource('order', Order_ApiController::class);

    // Category
    Route::apiResource('category', Category_ApiController::class);

    // Address
    Route::apiResource('address', Address_ApiController::class);

    // Video
    Route::apiResource('video', Video_ApiController::class);

    // Video
    Route::apiResource('webinar', Webinar_ApiController::class);


    // // Payment
    // Route::apiResource('payment', PaymentController::class);


    // Mix Controller
    Route::apiResource('getdata', Mix_ApiController::class);
    Route::apiResource('setdata', Mix_ApiController::class);

    // Plants
    Route::controller(ApiPlantController::class)->group(function () {
        Route::get('/plant', 'data');
        Route::get('/plant/category', 'category');
        Route::get('/plant/by/category', 'byCategory');
    });
    // Wishlist
    Route::controller(ApiWishlistController::class)->group(function () {
        Route::get('/wishlist', 'data');
        Route::post('/wishlist/crud', 'crud');
    });
    Route::controller(ApiCartController::class)->group(function () {
        Route::get('/cart', 'data');
        Route::get('/cart/count', 'count');
        Route::post('/cart/add', 'add');
        Route::post('/cart/qty', 'qtyUpdate');
        Route::post('/cart/remove', 'remove');
        Route::post('/cart/delete', 'delete');
    });

    Route::controller(ApiAddressController::class)->group(function () {
        Route::get('/maddress', 'data');
        Route::get('/maddress/active', 'getActive');
        Route::post('/maddress/active', 'setActive');
        Route::post('/maddress/save', 'save');
        Route::post('/maddress/update', 'update');
        Route::post('/maddress/delete', 'delete');
    });
    Route::controller(ApiRazorpayController::class)->group(function () {
        Route::get('/razorpay/orderid', 'genOrderId');
        Route::post('/razorpay/payment', 'payment');
    });
    Route::controller(ApiOrderController::class)->group(function () {
        Route::get('/order', 'data');
    });
});

// Register & Login Api
Route::controller(Auth_ApiController::class)->group(function () {
    Route::post('/login', 'login');
    Route::middleware('auth:sanctum')->post('/verify/otp', 'verify_otp');
    Route::middleware('auth:sanctum')->post('/logout', 'logout');
});
Route::controller(ApiSubCategoryController::class)->group(function () {
    Route::get('/sub-category', 'data');
});
