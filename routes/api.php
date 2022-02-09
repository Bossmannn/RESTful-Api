<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VendorsController;
use App\Http\Controllers\AssetsController;
use App\Http\Controllers\AssetsAssignmentController;

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

//Auth::routes();

Route::group([
    'middleware' => 'api',
    'prefix' => 'v1'
    
], function ($router) {
    //User Routes
    Route::post('/login', [UsersController::class, 'login'])->name('api.login');
    Route::post('/register', [UsersController::class, 'register'])->name('api.register');
    Route::post('/refresh', [UsersController::class, 'refresh'])->name('api.refresh');
    Route::post('/logout', [UsersController::class, 'logout'])->name('api.logout');
    Route::get('/profile', [UsersController::class, 'profile'])->name('user.profile');
    Route::get('/show/{id}', [UsersController::class, 'show'])->name('api.show');  
    Route::put('/update/{id}', [UsersController::class, 'update'])->name('api.update');  
    Route::delete('/destroy/{id}', [UsersController::class, 'destroy'])->name('api.delete');    

    //Vendor Routes
    Route::get('/vendor', [VendorsController::class, 'index'])->name('vendor.index');
    Route::get('/vendor/{id}', [VendorsController::class, 'show'])->name('vendor.show');
    Route::post('/vendor', [VendorsController::class, 'store'])->name('vendor.create');
    Route::put('/vendor/{id}', [VendorsController::class, 'update'])->name('vendor.update');
    Route::delete('/vendor/{id}', [VendorsController::class, 'destroy'])->name('vendor.destroy');

    //Asset Routes
    Route::get('/assets', [AssetsController::class, 'index'])->name('asset.index');
    Route::get('/assets/{id}', [AssetsController::class, 'show'])->name('asset.show');
    Route::post('/assets', [AssetsController::class, 'store'])->name('asset.create');
    Route::put('/assets/{id}', [AssetsController::class, 'update'])->name('asset.update');
    Route::delete('/assets/{id}', [AssetsController::class, 'destroy'])->name('asset.destroy');

    //Asset Assignment Routes
    Route::get('/assignment', [AssetsAssignmentController::class, 'index'])->name('assignment.index');
    Route::get('/assignment/{id}', [AssetsAssignmentController::class, 'show'])->name('assignment.show');
    Route::post('/assignment', [AssetsAssignmentController::class, 'store'])->name('assignment.create');
    Route::put('/assignment/{id}', [AssetsAssignmentController::class, 'update'])->name('assignment.update');
    Route::delete('/assignment/{id}', [AssetsAssignmentController::class, 'destroy'])->name('assignment.destroy');
    
});
