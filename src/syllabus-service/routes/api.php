<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SyllabusController;


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

Route::apiResource('syllabi', App\Http\Controllers\SyllabusController::class);
Route::apiResource('syllabus/llo', App\Http\Controllers\LessonLearningOutcome::class);
Route::apiResource('syllabus/ilo', App\Http\Controllers\IntendedLearningOutcome::class);
Route::apiResource('syllabus/clo', App\Http\Controllers\CourseLearningOutcome::class);
Route::apiResource('learning-plan', App\Http\Controllers\CourseLearningOutcome::class);
