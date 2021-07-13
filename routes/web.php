<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\LoginController;
// use LaravelLocalizationRedirectFilter;
// use LaravelLocalizationRoutes;
// use LaravelLocalizationViewPath;
use Carbon\Traits\Localization;

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

Route::get('/', function () {
    return view('welcome');
});
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {



    Route::get('/login/{service}', [LoginController::class, 'face']);
    Route::get('/login/{service}/callback', [LoginController::class, 'callback']);



    // Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');

    Auth::routes(['verify' => true]);

    // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    // Auth::routes();

    // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});