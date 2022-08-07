<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//
// Public
//
Route::group([
    'namespace' => 'App\Http\Controllers\Pages',
], function () {

    Route::get('/news', 'PagesController@index')->name('api.news');

    Route::group([
        'namespace' => 'Api',
    ], function () {

    });
});

//
// Home
//
Route::group([
    'namespace' => 'App\Http\Controllers\Home',
    'middleware' => ['auth:sanctum'],
    'prefix' => 'home'
], function () {

    // user
    Route::group([
        'namespace' => 'Users',
        'prefix' => 'users'
    ], function () {

        Route::post('/change-password', 'UserController@updatePassword')
            ->name('api.home.users.changePassword');

        Route::group([
            'namespace' => 'Api'
        ], function () {

            Route::post('/show/{id?}', 'UserController@show')
                ->name('api.home.users.show');
        });
    });

    // images
    Route::group([
        'namespace' => 'Images',
        'prefix' => 'images'
    ], function () {

        Route::group([
            'namespace' => 'Api'
        ], function () {

            Route::post('/news/{news}', 'ImageController@news')
                ->name('api.home.images.news');
            Route::put('/reorder/{from}/{to}', 'ImageController@reorder')
                ->name('api.home.images.reorder');
            Route::delete('/{image}', 'ImageController@destroy')
                ->name('api.home.images.destroy');
        });
    });

    // news
    Route::group([
        'namespace' => 'News',
    ], function () {
        Route::apiResource('news', 'NewsController', ['as' => 'api.home']);
    });
    Route::group([
        'namespace' => 'News',
        'prefix' => 'news'
    ], function () {

        Route::group([
            'namespace' => 'Api'
        ], function () {

        });
    });

});

//
// Admin
//
Route::group([
    'namespace' => 'App\Http\Controllers\Admin',
    'middleware' => ['auth:sanctum', 'isAdmin'],
    'prefix' => 'admin'
], function () {
    // news
    Route::group([
        'namespace' => 'News',
        'prefix' => 'news'
    ], function () {

        Route::get('/', 'NewsController@index')->name('api.admin.news');
        Route::group([
            'namespace' => 'Api'
        ], function () {
            Route::put('/active/{news}', 'NewsController@toggleActivation')
                ->name('api.admin.news.toggleActivation');
        });
    });

    // users
    Route::group([
        'namespace' => 'Users',
        'prefix' => 'users'
    ], function () {
        Route::get('/', 'UserController@index');
    });
});

//
// Auth
//
Route::group([
    'prefix' => 'auth',
    'namespace' => 'App\Http\Controllers\Auth'
], function () {
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');
    Route::post('/logout', 'AuthController@logout')->middleware('auth:sanctum');
    Route::post('/forgot-your-password', 'AuthController@forgotYourPassword');
    Route::post('/reset-password', 'AuthController@resetPassword');
});

//
// 404
//
Route::any('{path}', function () {
    return response()->json([
        'message' => 'Route not found'
    ], 404);
})->where('path', '.*');
