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

Route::prefix('user')
    ->name('user.')
    ->group(function () {
        Route::post('login', \App\Http\Controllers\Api\V1\Auth\LoginController::class)->name('login');
        Route::get('logout', \App\Http\Controllers\Api\V1\Auth\LogoutController::class)->name('logout');
        Route::post('forgot-password', \App\Http\Controllers\Api\V1\Auth\ForgotPasswordController::class)->name('forgot-password');
        Route::post('reset-password-token', \App\Http\Controllers\Api\V1\Auth\ResetPasswordController::class)->name('reset-password');
        Route::controller(\App\Http\Controllers\Api\V1\UserController::class)
            ->group(function () {
                Route::get('', 'show')->name('show');
                Route::post('create', 'store')->name('create');
                Route::put('edit', 'update')->name('edit');
                Route::delete('', 'destroy')->name('delete');
            });
    });

Route::controller(\App\Http\Controllers\Api\V1\FileController::class)
    ->prefix('file')
    ->name('file.')
    ->group(function () {
        Route::post('upload', 'store')->name('upload');
        Route::get('{file}', 'show')->name('show');
    });

Route::get('brands',[\App\Http\Controllers\Api\V1\BrandController::class, 'index'])->name('brands');
Route::controller(\App\Http\Controllers\Api\V1\BrandController::class)
    ->prefix('brand')
    ->name('brand.')
    ->group(function () {
        Route::post('create', 'store')->name('create');
        Route::get('{brand}', 'show')->name('show');
        Route::put('{brand}', 'update')->name('edit');
        Route::delete('{brand}', 'destroy')->name('delete');
    });

Route::get('categories',[\App\Http\Controllers\Api\V1\CategoryController::class, 'index'])->name('categories');
Route::controller(\App\Http\Controllers\Api\V1\CategoryController::class)
    ->prefix('category')
    ->name('category.')
    ->group(function () {
        Route::post('create', 'store')->name('create');
        Route::get('{category}', 'show')->name('show');
        Route::put('{category}', 'update')->name('edit');
        Route::delete('{category}', 'destroy')->name('delete');
    });

Route::get('products',[\App\Http\Controllers\Api\V1\ProductController::class, 'index'])->name('products');
Route::controller(\App\Http\Controllers\Api\V1\ProductController::class)
    ->prefix('product')
    ->name('product.')
    ->group(function () {
        Route::post('create', 'store')->name('create');
        Route::get('{product}', 'show')->name('show');
        Route::put('{product}', 'update')->name('edit');
        Route::delete('{product}', 'destroy')->name('delete');
    });
