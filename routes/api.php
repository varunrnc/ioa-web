<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth_ApiController;
use App\Http\Controllers\Api\User_ApiController;
use App\Http\Controllers\Api\Product_ApiController;
use App\Http\Controllers\Api\Category_ApiController;
use App\Http\Controllers\Api\Address_ApiController;
use App\Http\Controllers\Api\Order_ApiController;
use App\Http\Controllers\Api\Video_ApiController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Api\Mix_ApiController;
use App\Http\Controllers\Api\Plant\ApiPlantController;
use App\Http\Controllers\Api\Webinar_ApiController;

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
});

// Register & Login Api
Route::controller(Auth_ApiController::class)->group(function () {
    Route::post('/login', 'login');
    Route::middleware('auth:sanctum')->post('/verify/otp', 'verify_otp');
    Route::middleware('auth:sanctum')->post('/logout', 'logout');
});

Route::controller(ApiPlantController::class)->group(function () {
    Route::get('/plant', 'data');
    // Route::get('/plant/category', 'category');
    Route::get('/plant/category', 'byCategory');
});
