<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CookiesController;


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

Route::get('/cookie/set', [CookiesController::class, 'setCookie'])->name('cookies.set');
Route::get('/cookie/get', [CookiesController::class, 'getCookie'])->name('cookies.get');
