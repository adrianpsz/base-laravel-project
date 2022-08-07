<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

//
// Pages
//
Route::group([
    'namespace' => 'App\Http\Controllers\Pages'
], function () {
    Route::get('/', 'PagesController@index')->name('index');
    Route::get('/privacy', 'PagesController@privacy')->name('privacy');
    Route::get('/terms', 'PagesController@terms')->name('terms');
    Route::get('/contact', 'PagesController@contact')->name('contact');
    Route::get('/test', 'PagesController@test')->name('test');
    Route::get('/locale/{locale}', 'PagesController@locale')->name('locale');
    Route::get('/image/{name}', 'ImageController@show')->name('image');

    // ajax
    Route::group([
        'namespace' => 'Api',
        'middleware' => ['onlyAjax'],
        'prefix' => 'ajax',
    ], function () {

        Route::post('/index', 'ApiController@index')->name('ajax.index');
        Route::post('/contact', 'ApiController@contact')->name('ajax.contact');
    });
});

//
// Auth pages
//
Auth::routes();

//
// Home (Auth)
//
Route::group([
    'middleware' => ['auth'],
    'prefix' => 'home',
    'namespace' => 'App\Http\Controllers\Home'
], function () {

    // images
    Route::group([
        'namespace' => 'Images',
        'prefix' => 'images'
    ], function () {

        Route::group([
            'middleware' => ['onlyAjax'],
            'namespace' => 'Api',
            'prefix' => 'ajax',
        ], function () {

            Route::put('/reorder/{from}/{to}', 'ImageController@reorder')->name('home.images.ajax.reorder');
            Route::delete('/{image}', 'ImageController@destroy')->name('home.images.ajax.destroy');
        });
    });

    // news
    Route::group([
        'namespace' => 'News',
    ], function () {
        Route::resource('news', 'NewsController', ['as' => 'home']);
    });
    Route::group([
        'namespace' => 'News',
        'prefix' => 'news',
    ], function () {


    });

    // users
    Route::group([
        'namespace' => 'Users',
        'prefix' => 'users'
    ], function () {
        Route::get('/change-password', 'UserController@changePassword')
            ->name('home.users.changePassword');
        Route::post('/update-password', 'UserController@updatePassword')
            ->name('home.users.updatePassword');
    });

    // home
    Route::get('/', 'HomeController@index')->name('home');
});

//
// Admin pages
//
Route::group([
    'middleware' => ['auth', 'isAdmin'],
    'prefix' => 'admin',
    'namespace' => 'App\Http\Controllers\Admin'
], function () {

    // news
    Route::group([
        'namespace' => 'News',
        'prefix' => 'news'
    ], function () {
        Route::get('/', 'NewsController@index')->name('admin.news');

        Route::group([
            'middleware' => ['onlyAjax'],
            'namespace' => 'Api',
            'prefix' => 'ajax'
        ], function () {
            Route::put('/active/{news}', 'NewsController@toggleActivation')->name('admin.news.ajax.active');
        });
    });

    // users
    Route::group([
        'namespace' => 'Users',
        'prefix' => 'users'
    ], function () {
        Route::get('/', 'UserController@index')->name('admin.users');
    });

    // admin
    Route::get('/', 'AdminController@index')->name('admin');
});
