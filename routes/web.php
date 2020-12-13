<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'verify' => true,
    'reset' => true,
]);

Route::get('/', 'HomeController@index')->name('home');

// Authenticated
Route::group(['middleware' => 'auth'], function () {

    // Admin
    Route::group(['middleware' => 'role:admin', 'namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');
        Route::resource('users', 'UserController');
        Route::post('users/find', 'UserController@searchByKeyword')->name('users.search');

        Route::resource('communities', 'CommunityController');
        Route::get('communities/member/{id}', 'CommunityController@ajaxMember')->name('communities.find_member');
        Route::put('communities/member/{id}', 'CommunityController@updateMemberRole')->name('communities.update_member');
        Route::delete('communities/member/{id}', 'CommunityController@deleteMember');
        Route::post('communities/member', 'CommunityController@addMember')->name('communities.add_member');
        Route::resource('events', 'CommunityEventController');
        Route::post('events/attendee/add', 'CommunityEventController@addAttendee')->name('events.add_attendee');
        Route::delete('events/attendee/remove', 'CommunityEventController@removeAttendee')->name('events.remove_attendee');
        Route::resource('proposals', 'CommunityProposalController')->except(['store', 'create', 'destroy']);

        Route::resource('stores', 'StoreController');
        Route::resource('products', 'ProductController');
        Route::get('products/{id}/images', 'ProductController@addImage')->name('products.add_image');
        Route::post('products/{id}/images', 'ProductController@uploadImage')->name('products.upload_image');
        Route::delete('products/{id}/images', 'ProductController@deleteImage')->name('products.delete_image');
        Route::resource('payments', 'PaymentController')->only(['index', 'show', 'update']);
    });

    // Seller
    Route::group(['middleware' => 'role:seller', 'namespace' => 'Seller', 'prefix' => 'seller', 'as' => 'seller.'], function () {
       Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    });

    // User
    Route::group(['middleware' => 'role:user'], function () {
        Route::group(['prefix' => 'account', 'namespace' => 'User', 'as' => 'user.'], function () {
            Route::get('orders', 'UserController@orders')->name('orders');
            Route::get('orders/{order}', 'UserController@show')->name('orders.show');
            Route::get('overview', 'UserController@overview')->name('overview');
            Route::get('community/propose', 'UserController@propose')->name('community.propose');
            Route::post('community', 'UserController@storeProposal')->name('community.propose.store');
        });
    });

    Route::get('cart', 'CartController@index')->name('cart');
    Route::post('cart/{product}', 'CartController@addItem')->name('cart.add_item');
    Route::get('cart/refresh', 'CartController@refresh')->name('cart.refresh');
    Route::put('cart/quantity', 'CartController@updateItem')->name('cart.update_item');
    Route::delete('cart', 'CartController@removeItem')->name('cart.delete_item');
    Route::get('checkout', 'CheckoutController@index')->name('checkout');
    Route::post('checkout/process', 'CheckoutController@process')->name('checkout.process');
    Route::get('checkout/success', 'CheckoutController@success')->name('checkout.success');
});

Route::get('/ajax/provinces', 'AjaxController@provinces')->name('ajax.provinces');
Route::get('/ajax/cities/{province}', 'AjaxController@cities')->name('ajax.cities');
Route::post('/ajax/shipping', 'AjaxController@shippingRate')->name('ajax.shipping');

Route::get('/category/{category}', 'ProductController@category')->name('category');
Route::get('/products', 'ProductController@index')->name('products');
Route::get('/{store}/{product}', 'HomeController@showProduct')->name('product.show');

