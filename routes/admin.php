<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Slider_AdminController;
use App\Http\Controllers\Admin\Testimonial_AdminController;
use App\Http\Controllers\Admin\Category_AdminController;
use App\Http\Controllers\Admin\Post_AdminController;
use App\Http\Controllers\Admin\PostCategory_AdminController;
use App\Http\Controllers\Admin\Product_AdminController;
use App\Http\Controllers\Admin\Order_AdminController;
use App\Http\Controllers\Admin\OrderSetting_AdminController;
use App\Http\Controllers\Admin\Video_AdminController;
use App\Http\Controllers\Admin\Customer_AdminController;
use App\Http\Controllers\Admin\Chat_AdminController;
use App\Http\Controllers\Admin\Mplant\AdminMplantController;
use App\Http\Controllers\Admin\Order\AdminOrderController;
use App\Http\Controllers\Admin\Payment\AdminPaymentController;
use App\Http\Controllers\Admin\Plant\AdminPlantController;
use App\Http\Controllers\Admin\Razorpay\AdminRazorpayController;
use App\Http\Controllers\Admin\Shipping\AdminShippingController;
use App\Http\Controllers\Admin\SubCategory\AdminSubCategoryController;
use App\Http\Controllers\Admin\Webinar_AdminController;


Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {

    // Route::prefix('admin')->group(function(){

    Route::get('/', function () {
        return redirect()->route('order.index');
    })->name('admin.dashboard');

    // =========== Slider ==========
    Route::resource('slider', Slider_AdminController::class);

    // =========== Testimonial ==========
    Route::resource('testimonial', Testimonial_AdminController::class);

    // =========== Product ==========
    Route::resource('product', Product_AdminController::class);

    // =========== Order ==========
    Route::resource('order', Order_AdminController::class);

    // =========== Customer ==========
    Route::resource('customer', Customer_AdminController::class);

    // =========== Order Settings==========
    Route::resource('order_setting', OrderSetting_AdminController::class);

    // =========== Product Category ==========
    Route::resource('category', Category_AdminController::class);

    // =========== Post ==========
    Route::resource('post', Post_AdminController::class);

    // =========== Post Category ==========
    Route::resource('post-category', PostCategory_AdminController::class);

    // =========== Video ==========
    Route::resource('video', Video_AdminController::class);

    // =========== Webinar ==========
    Route::resource('webinar', Webinar_AdminController::class);


    // =========== Chat ==========
    Route::get('/chat', function () {
        return view('admin.chat.chat');
    })->name('admin.chat');
    Route::post('/total-msg-count', [Chat_AdminController::class, 'totalMsgCount'])->name('admin.totalMsgCount');
    Route::post('/get-user-details', [Chat_AdminController::class, 'getUserDetails'])->name('admin.getUserDetails');
    Route::post('/send-message', [Chat_AdminController::class, 'sendMessage'])->name('admin.sendMessage');
    Route::post('/load-messages', [Chat_AdminController::class, 'loadMessages'])->name('admin.loadMessages');
    Route::post('/get-chat-list', [Chat_AdminController::class, 'getChatUsers'])->name('admin.getChatList');

    Route::controller(AdminPlantController::class)->group(function () {
        Route::get('/plant', 'index')->name('admin.plant.index');
        Route::get('/plant/create', 'create')->name('admin.plant.create');
        Route::get('/plant/edit/{id}', 'edit');
        Route::post('/plant/update', 'update')->name('admin.plant.update');
        Route::post('/plant/save', 'save')->name('admin.plant.save');
        Route::post('/plant/status', 'status')->name('admin.plant.status');
        Route::post('/plant/delete', 'delete')->name('admin.plant.delete');
    });

    Route::controller(AdminSubCategoryController::class)->group(function () {
        Route::get('/sub-category', 'index')->name('admin.sub-category.index');
        Route::get('/sub-category/create', 'create')->name('admin.sub-category.create');
        Route::get('/sub-category/edit/{id}', 'edit');
        Route::post('/sub-category/update', 'update')->name('admin.sub-category.update');
        Route::post('/sub-category/save', 'save')->name('admin.sub-category.save');
        Route::post('/sub-category/status', 'status')->name('admin.sub-category.status');
        Route::post('/sub-category/delete', 'delete')->name('admin.sub-category.delete');
        Route::get('/sub-category/{category}', 'data');
    });
    Route::controller(AdminMplantController::class)->group(function () {
        Route::get('/mplant/index', 'index')->name('admin.mplant.index');
        Route::get('/mplant/create', 'create')->name('admin.mplant.create');
        Route::post('/mplant/save', 'save')->name('admin.mplant.save');
        Route::get('/mplant/edit/{id}', 'edit');
        Route::post('/mplant/update', 'update')->name('admin.mplant.update');
        Route::post('/mplant/status', 'status')->name('admin.mplant.status');
        Route::post('/mplant/delete', 'delete')->name('admin.mplant.delete');
    });
    Route::controller(AdminShippingController::class)->group(function () {
        Route::get('/shipping/index', 'index')->name('admin.shipping.index');
        Route::get('/shipping/create', 'create')->name('admin.shipping.create');
        Route::post('/shipping/save', 'save')->name('admin.shipping.save');
        Route::get('/shipping/edit/{id}', 'edit');
        Route::post('/shipping/update', 'update')->name('admin.shipping.update');
        Route::post('/shipping/status', 'status')->name('admin.shipping.status');
        Route::post('/shipping/delete', 'delete')->name('admin.shipping.delete');
    });
    Route::controller(AdminRazorpayController::class)->group(function () {
        Route::get('/razorpay', 'refund');
    });
    Route::controller(AdminOrderController::class)->group(function () {
        Route::get('/morder', 'index')->name('admin.order.index');
    });
    Route::controller(AdminPaymentController::class)->group(function () {
        Route::get('/payment/{id}', 'index')->name('admin.payment.index');
    });
});
