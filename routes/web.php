<?php

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home.index');

Route::group(['middleware' => ['guest']], function() {
    /**
     * Register Routes
     */
    Route::get('/register', 'App\Http\Controllers\Auth\RegisterController@show')->name('register.show');
    Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@register')->name('register.perform');

    /**
     * Login Routes
     */
    Route::get('/login', 'App\Http\Controllers\Auth\LoginController@show')->name('login.show');
    Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login')->name('login.perform');

});

Route::group(['middleware' => ['auth']], function() {
    /**
     * Logout Routes
     */
    Route::get('/logout', 'App\Http\Controllers\Auth\LogoutController@perform');

    Route::resources([
        'positions' => \App\Http\Controllers\Admin\PositionController::class,
        'employees' => \App\Http\Controllers\Admin\EmployeeController::class,
    ]);
});
