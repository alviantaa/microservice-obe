<?php

use App\Http\Controllers\AccountControl;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('profiles/{id}', [AccountControl::class, 'get_profile'])->name('get.nim');

// Route::get('say-hello',function(){
//     $service = new HttpClientService();
//     $result = $service->getHelloString('Bob');

//     return response()->json($result);
// });