<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountControl;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
    // Route::post('login', 'AuthController@login');
    // Route::post('logout', 'AuthController@logout');
    // Route::post('refresh', 'AuthController@refresh');
    // Route::post('me', 'AuthController@me');

    //dari jwt
    Route::post('login', [AccountControl::class, 'login'])->name('login');
    Route::post('logout', [AccountControl::class, 'logout'])->name('logout');
    //Route::post('refresh', [AccountControl::class, 'refresh'])->name('refresh');
    Route::post('me', [AccountControl::class, 'me'])->name('me');

    //tambahan
    Route::post('register', [AccountControl::class, 'register'])->name('register');
    Route::post('profile', [AccountControl::class, 'profile'])->name('profile');
    Route::post('forgot-password', [AccountControl::class, 'forgot_password'])->name('forgot.password');
    Route::post('reset-password', [AccountControl::class, 'reset_password'])->name('reset.password');
    Route::post('verify-email', [AccountControl::class, 'verify_email'])->name('verify.email');
    Route::delete('delete-account/{id}', [AccountControl::class, 'delete_account'])->name('delete.account');
});