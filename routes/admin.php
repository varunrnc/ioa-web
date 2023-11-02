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
use App\Http\Controllers\Admin\Coupon\AdminCouponController;
use App\Http\Controllers\Admin\Mplant\AdminMplantController;
use App\Http\Controllers\Admin\Mplant\Category\AdminMplantCategoryController;
use App\Http\Controllers\Admin\Mplant\SubCategory\AdminMplantSubCategoryController;
use App\Http\Controllers\Admin\Nursery\AdminNurserySliderController;
use App\Http\Controllers\Admin\Order\AdminOrderController;
use App\Http\Controllers\Admin\Payment\AdminPaymentController;
use App\Http\Controllers\Admin\Plant\AdminPlantController;
use App\Http\Controllers\Admin\Razorpay\AdminRazorpayController;
use App\Http\Controllers\Admin\Shipping\AdminShippingController;
use App\Http\Controllers\Admin\Slider\AdminSliderController;
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
    Route::controller(AdminMplantCategoryController::class)->group(function () {
        Route::get('/mplant/category', 'index')->name('admin.mplant.category.index');
        Route::get('/mplant/category/create', 'create')->name('admin.mplant.category.create');
        Route::post('/mplant/category/save', 'save')->name('admin.mplant.category.save');
        Route::get('/mplant/category/edit/{id}', 'edit')->name('admin.mplant.category.edit');
        Route::post('/mplant/category/update', 'update')->name('admin.mplant.category.update');
        Route::post('/mplant/category/status', 'status')->name('admin.mplant.category.status');
        Route::post('/mplant/category/delete', 'delete')->name('admin.mplant.category.delete');
    });
    Route::controller(AdminMplantSubCategoryController::class)->group(function () {
        Route::get('/mplant/sub-category', 'index')->name('admin.mplant.subcategory.index');
        Route::get('/mplant/sub-category/create', 'create')->name('admin.mplant.subcategory.create');
        Route::post('/mplant/sub-category/save', 'save')->name('admin.mplant.subcategory.save');
        Route::get('/mplant/sub-category/edit{id}', 'edit')->name('admin.mplant.subcategory.edit');
        Route::post('/mplant/sub-category/update', 'update')->name('admin.mplant.subcategory.update');
        Route::post('/mplant/sub-category/status', 'status')->name('admin.mplant.subcategory.status');
        Route::post('/mplant/sub-category/delete', 'delete')->name('admin.mplant.subcategory.delete');
    });
    Route::controller(AdminMplantController::class)->group(function () {
        Route::get('/mplant/index', 'index')->name('admin.mplant.index');
        Route::get('/mplant/create', 'create')->name('admin.mplant.create');
        Route::post('/mplant/save', 'save')->name('admin.mplant.save');
        Route::get('/mplant/edit/{id}', 'edit');
        Route::get('/mplant/category/{category}', 'category')->name('admin.mplant.category');
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
        Route::get('/morder/{id}', 'byId');
    });
    Route::controller(AdminPaymentController::class)->group(function () {
        Route::get('/payment/{id}', 'index');
    });
    Route::controller(AdminSliderController::class)->group(function () {
        Route::get('/mslider', 'index')->name('admin.mslider.index');
        Route::get('/mslider/create', 'create')->name('admin.mslider.create');
        Route::post('/mslider/save', 'save')->name('admin.mslider.save');
        Route::get('/mslider/edit/{id}', 'edit')->name('admin.mslider.edit');;
        Route::post('/mslider/update', 'update')->name('admin.mslider.update');
        Route::post('/mslider/status', 'status')->name('admin.mslider.status');
        Route::post('/mslider/reorder', 'reorder')->name('admin.mslider.reorder');
        Route::post('/mslider/delete', 'delete')->name('admin.mslider.delete');
    });
    Route::controller(AdminNurserySliderController::class)->group(function () {
        Route::get('/nursery/slider', 'index')->name('admin.nursery.slider.index');
        Route::get('/nursery/slider/create', 'create')->name('admin.nursery.slider.create');
        Route::post('/nursery/slider/save', 'save')->name('admin.nursery.slider.save');
        Route::get('/nursery/slider/edit/{id}', 'edit')->name('admin.nursery.slider.edit');;
        Route::post('/nursery/slider/update', 'update')->name('admin.nursery.slider.update');
        Route::post('/nursery/slider/status', 'status')->name('admin.nursery.slider.status');
        Route::post('/nursery/slider/reorder', 'reorder')->name('admin.nursery.slider.reorder');
        Route::post('/nursery/slider/delete', 'delete')->name('admin.nursery.slider.delete');
    });
    Route::controller(AdminCouponController::class)->group(function () {
        Route::get('/coupon', 'index')->name('admin.coupon.index');
        Route::get('/coupon/create', 'create')->name('admin.coupon.create');
        Route::post('/coupon/save', 'save')->name('admin.coupon.save');
        Route::get('/coupon/edit/{id}', 'edit')->name('admin.coupon.edit');;
        Route::post('/coupon/update', 'update')->name('admin.coupon.update');
        Route::post('/coupon/status', 'status')->name('admin.coupon.status');
        Route::get('/coupon/generate', 'generate')->name('admin.coupon.generate');
        Route::post('/coupon/delete', 'delete')->name('admin.coupon.delete');
    });
});
