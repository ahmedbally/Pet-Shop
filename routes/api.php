<?php

use Illuminate\Http\Request;
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
    Route::post('login', \App\Http\Controllers\Auth\LoginController::class);
    Route::get('logout', \App\Http\Controllers\Auth\LogoutController::class);
    Route::post('forgot-password', \App\Http\Controllers\Auth\ForgotPasswordController::class);
    Route::post('reset-password-token', \App\Http\Controllers\Auth\ResetPasswordController::class);
});

Route::prefix('file')->name('file.')->group(function (){
    Route::post('file/upload', [\App\Http\Controllers\FileController::class , 'store'])->name('upload');
    Route::get('{file}', [\App\Http\Controllers\FileController::class , 'show'])->name('show');
});
