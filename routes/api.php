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

Route::prefix('user')->name('user.')->group(function (){
    Route::post('login', \App\Http\Controllers\Api\V1\Auth\LoginController::class)->name('login');
    Route::get('logout', \App\Http\Controllers\Api\V1\Auth\LogoutController::class)->name('logout');
    Route::post('forgot-password', \App\Http\Controllers\Api\V1\Auth\ForgotPasswordController::class)->name('forgot-password');
    Route::post('reset-password-token', \App\Http\Controllers\Api\V1\Auth\ResetPasswordController::class)->name('reset-password');
});

Route::prefix('file')->name('file.')->group(function (){
    Route::post('file/upload', [\App\Http\Controllers\Api\V1\FileController::class , 'store'])->name('upload');
    Route::get('{file}', [\App\Http\Controllers\Api\V1\FileController::class , 'show'])->name('show');
});
