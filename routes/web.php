<?php

Route::get('/', 'HomeController@index')->name('home');
Route::get('/product/{slug}', 'HomeController@single')->name('product');
Route::get('/category/{slug}', 'CategoryController@index')->name('category');
Route::get('/store/{slug}', 'StoreController@index')->name('store');

Route::prefix('/cart')->name('cart.')->group(function(){
    Route::get('/', 'CartController@index')->name('index');
    Route::post('/add', 'CartController@add')->name('add');
    Route::get('/remove/{slug}', 'CartController@remove')->name('remove');
    Route::get('/cancel', 'CartController@cancel')->name('cancel');
});

Route::prefix('/checkout')->name('checkout.')->group(function(){
    Route::get('/', 'CheckoutController@index')->name('index');
    Route::post('/proccess', 'CheckoutController@proccess')->name('proccess');
    Route::get('/thanks', 'CheckoutController@thanks')->name('thanks');
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('/my_orders', 'UserOrderController@index')->name('my.orders');

    Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function() { 
        Route::resource('stores', 'StoreController');
        Route::resource('products', 'ProductController');
        Route::resource('categories', 'CategoryController');

        Route::get('orders/my', 'OrdersController@index')->name('orders.my');

        Route::post('photos/remove', 'ProductPhotoController@removePhoto')->name('photo.remove');
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');