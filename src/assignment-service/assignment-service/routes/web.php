<?php

use App\Http\Controllers\AssignmentController;
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

// Route::resource('assignment', AssignmentController::class);
Route::post('/assignment', [AssignmentController::class, 'store']);
Route::get('/assignment/{id}', [AssignmentController::class, 'show']);
Route::delete('/assignment/{id}', [AssignmentController::class, 'destroy']);
Route::patch('/assignment/{id}', [AssignmentController::class, 'update']);





