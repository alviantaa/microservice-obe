<?php

use App\Http\Controllers\JoinClassController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseClassControllerv2;
use App\Http\Controllers\CourseClassController;
use App\Http\Controllers\CourseClassControllerStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Student Role
// Route::group(['middleware' => ['roles:student']], function () {
// 	Route::post('/course-class/{id}/add-student', [CourseClassController::class, 'addStudentToClass']);
//     Route::get('/course-class/{id}/view-students', [CourseClassController::class, 'viewStudentInClass']);
//     Route::get('/course', [CourseController::class, 'index']);
//     Route::get('/course/{id}', [CourseController::class, 'show']);
//     Route::get('/course-class', [CourseClassController::class, 'index']);
//     Route::get('/course-class/{id}', [CourseClassController::class, 'show']);
// });

// Teacher & Mimin Role
// Route::group(['middleware' => ['roles:teacher']], function () {
// 	Route::post('/course-class/{id}/add-student', [CourseClassController::class, 'addStudentToClass']);
//     Route::get('/course-class/{id}/view-students', [CourseClassController::class, 'viewStudentInClass']);
//     Route::get('/course', [CourseController::class, 'index']);
//     Route::get('/course/{id}', [CourseController::class, 'show']);
//     Route::post('/course', [CourseController::class, 'store']);
//     Route::patch('/course/{id}', [CourseController::class, 'update']);
//     Route::delete('/course/{id}', [CourseController::class, 'destroy']);
//     Route::get('/course-class', [CourseClassController::class, 'index']);
//     Route::get('/course-class/{id}', [CourseClassController::class, 'show']);
//     Route::post('/course-class', [CourseClassController::class, 'store']);
//     Route::patch('/course-class/{id}', [CourseClassController::class, 'update']);
//     Route::delete('/course-class/{id}', [CourseClassController::class, 'destroy']);
// });

Route::apiResource('course', CourseController::class);
Route::apiResource('course-class', CourseClassController::class);

Route::post('/course-class/{id}/add-student', [CourseClassController::class, 'addStudentToClass']);
Route::get('/course-class/{id}/view-students', [CourseClassController::class, 'viewStudentInClass']);