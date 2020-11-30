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

        Route::resource('stores', 'StoreController');
        Route::resource('products', 'ProductController');
        Route::get('products/{id}/images', 'ProductController@addImage')->name('products.add_image');
        Route::post('products/{id}/images', 'ProductController@uploadImage')->name('products.upload_image');
        Route::delete('products/{id}/images', 'ProductController@deleteImage')->name('products.delete_image');
    });

    // Seller
    Route::group(['middleware' => 'role:seller', 'namespace' => 'Seller', 'prefix' => 'seller', 'as' => 'seller.'], function () {
       Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    });

    // User
    Route::group(['middleware' => 'role:user', 'namespace' => 'User', 'prefix' => 'account', 'as' => 'user.'], function () {
        Route::get('orders', 'UserController@orders')->name('orders');
        Route::get('overview', 'UserController@overview')->name('overview');
    });
});

Route::get('/category/{category}', 'ProductController@category')->name('category');
Route::get('/products', 'ProductController@index')->name('products');
Route::get('/{store}/{product}', 'HomeController@showProduct')->name('product.show');

