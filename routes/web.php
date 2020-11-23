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
    });

    // Seller
    Route::group(['middleware' => 'role:seller', 'namespace' => 'Seller', 'prefix' => 'seller', 'as' => 'seller.'], function () {
       Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    });

    // User
    Route::group(['middleware' => 'role:user', 'namespace' => 'User', 'prefix' => 'my', 'as' => 'user.'], function () {
        Route::get('orders', 'UserController@orders')->name('orders');
    });
});
